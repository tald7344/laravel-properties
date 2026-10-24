<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\Report;
use App\Models\User;
use App\Services\DashboardStatistics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PropertyController extends Controller
{
    public function landing()
    {
        $top = Property::where('status', 'published')->latest('published_at')->take(6)->get();
        $offers = Property::where('status', 'published')->where('reward_available', true)->latest()->take(3)->get();
        $stats = Cache::remember('home:stats', now()->addMinutes(5), fn() => ['properties' => Property::where('status', 'published')->count(), 'owners' => User::where('role', 'owner')->count()]);
        return view('home', compact('top', 'offers', 'stats'));
    }
    public function index(Request $request)
    {
        $properties = $this->filteredProperties($request)->paginate(8)->withQueryString();
        $cities = Property::where('status', 'published')->select('city')->distinct()->orderBy('city')->pluck('city');
        $filters = $request->only(['neighborhood', 'purpose', 'city', 'category', 'min_price', 'max_price', 'min_area', 'max_area', 'bedrooms', 'bathrooms', 'floor', 'furnished', 'reward', 'sort']);
        return view('properties.index', compact('properties', 'cities', 'filters'));
    }

    public function search(Request $request)
    {
        $properties = $this->filteredProperties($request)->paginate(8)->withQueryString();

        return response()->json([
            'data' => $properties->getCollection()->map(fn (Property $property) => [
                'id' => $property->id,
                'url' => route('properties.show', $property),
                'image' => $property->imageUrl(),
                'title' => $property->title,
                'city' => $property->city,
                'neighborhood' => $property->neighborhood,
                'purpose' => $property->purpose,
                'price' => $property->price,
                'currency' => $property->currency,
                'bedrooms' => $property->bedrooms,
                'area' => $property->area,
                'furnished' => $property->furnished,
                'owner' => $property->owner?->name,
            ])->values(),
            'total' => $properties->total(),
            'current_page' => $properties->currentPage(),
            'last_page' => $properties->lastPage(),
        ]);
    }

    private function filteredProperties(Request $request)
    {
        $query = Property::with('owner')->where('status', 'published')
            ->when($request->input('city'), fn ($q, $value) => $q->where('city', $value))
            ->when($request->input('neighborhood'), fn ($q, $value) => $q->where(fn ($location) => $location
                ->where('neighborhood', 'like', '%' . $value . '%')
                ->orWhere('city', 'like', '%' . $value . '%')))
            ->when($request->input('purpose'), fn ($q, $value) => $q->where('purpose', $value))
            ->when($request->input('category'), fn ($q, $value) => $q->where('category', $value))
            ->when($request->filled('min_price'), fn ($q) => $q->where('price', '>=', $request->input('min_price')))
            ->when($request->filled('max_price'), fn ($q) => $q->where('price', '<=', $request->input('max_price')))
            ->when($request->filled('min_area'), fn ($q) => $q->where('area', '>=', $request->input('min_area')))
            ->when($request->filled('max_area'), fn ($q) => $q->where('area', '<=', $request->input('max_area')))
            ->when($request->filled('bedrooms'), fn ($q) => $q->where('bedrooms', '>=', $request->input('bedrooms')))
            ->when($request->filled('bathrooms'), fn ($q) => $q->where('bathrooms', '>=', $request->input('bathrooms')))
            ->when($request->filled('floor'), fn ($q) => $q->where('floor', $request->input('floor')))
            ->when($request->has('furnished'), fn ($q) => $q->where('furnished', $request->boolean('furnished')))
            ->when($request->has('reward'), fn ($q) => $q->where('reward_available', $request->boolean('reward')));

        return match ($request->input('sort', 'latest')) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            default => $query->latest('published_at'),
        };
    }
    public function show(Property $property)
    {
        abort_unless($property->status === 'published', 404);
        $property->load('owner');
        return view('properties.show', compact('property'));
    }
    public function contact(Request $r, Property $property)
    {
        $d = $r->validate(['phone' => ['required', 'string', 'min:8', 'max:30'], 'message' => ['nullable', 'string', 'max:1000']]);
        Inquiry::create(['property_id' => $property->id, 'user_id' => auth()->id(), 'phone' => $d['phone'], 'message' => $d['message'] ?? null]);
        DashboardStatistics::forget($property->user_id);
        return back()->with('success', __('تم تسجيل طلب التواصل. سيتواصل المالك معك مباشرة.'));
    }
    public function report(Request $r, Property $property)
    {
        $d = $r->validate(['type' => 'required|in:old,suspicious,impersonation,other', 'details' => 'nullable|string|max:1000']);
        Report::create(['property_id' => $property->id, 'reporter_id' => auth()->id(), 'type' => $d['type'], 'details' => $d['details'] ?? null]);
        DashboardStatistics::forget();
        return back()->with('success', __('شكرًا، وصل البلاغ وسيتم مراجعته.'));
    }
}
