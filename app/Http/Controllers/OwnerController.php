<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyPropertySubmitted;
use App\Models\Property;
use App\Models\Report;
use App\Models\Setting;
use App\Models\Subscription;
use App\Services\DashboardStatistics;
use App\Services\OwnerSubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    public function __construct(private readonly OwnerSubscriptionService $subscriptions)
    {
    }

    public function dashboard(DashboardStatistics $stats)
    {
        $this->owner();
        $properties = auth()->user()->properties()->latest()->get();
        $reports = Report::with('property')->where('reporter_id', auth()->id())->latest()->paginate(10);
        $statistics = $stats->owner(auth()->id());
        $subscription = $this->subscriptions->activeFor(auth()->user());
        return view('owner.dashboard', compact('properties', 'reports', 'statistics', 'subscription'));
    }
    public function subscription()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'owner', 403);
        $user = auth()->user();
        $this->subscriptions->ensureBasicPlan($user);
        $subscription = $this->subscriptions->activeFor($user);
        $pendingSubscription = $user->subscriptions()->where('status', 'pending')->latest()->first();
        $propertyCount = $user->properties()->count();
        $pricePerProperty = $this->subscriptions->premiumPricePerProperty();

        return view('owner.subscription', compact('subscription', 'pendingSubscription', 'propertyCount', 'pricePerProperty'));
    }
    public function create()
    {
        $this->owner();
        $this->assertPropertyCapacity();
        return view('owner.form', ['property' => null]);
    }
    public function edit(Property $property)
    {
        $this->owner();
        abort_unless($property->user_id === auth()->id(), 403);
        return view('owner.form', compact('property'));
    }
    public function store(Request $r)
    {
        $this->owner();
        $d = $this->validated($r);
        $d = $this->prepare($r, $d);
        $d['user_id'] = auth()->id();
        $d['status'] = 'pending';
        $d['last_confirmed_at'] = now();
        $property = DB::transaction(function () use ($d): Property {
            $user = auth()->user()->newQuery()->lockForUpdate()->findOrFail(auth()->id());
            $subscription = $this->subscriptions->activeFor($user);
            abort_unless($subscription, 403);
            abort_if(
                $user->properties()->count() >= (int) $subscription->property_limit,
                403,
                __('owner-dashboard.property_limit_reached')
            );

            return Property::create($d);
        });
        NotifyPropertySubmitted::dispatch($property->id)->afterCommit();
        DashboardStatistics::forget(auth()->id());
        return redirect()->route('owner.dashboard')->with('success', __('تم إرسال الإعلان للمراجعة.'));
    }
    public function update(Request $r, Property $property)
    {
        $this->owner();
        abort_unless($property->user_id === auth()->id(), 403);
        $d = $this->prepare($r, $this->validated($r));
        $d['status'] = 'pending';
        $property->update($d);
        DashboardStatistics::forget(auth()->id());
        return redirect()->route('owner.dashboard')->with('success', __('تم تحديث الإعلان وإرساله للمراجعة.'));
    }
    public function confirm(Property $property)
    {
        $this->owner();
        abort_unless($property->user_id === auth()->id(), 403);
        $property->update(['last_confirmed_at' => now(), 'status' => 'published', 'published_at' => $property->published_at ?? now()]);
        DashboardStatistics::forget(auth()->id());
        return back()->with('success', __('تم تأكيد توفر العقار.'));
    }
    public function toggle(Property $property)
    {
        $this->owner();
        abort_unless($property->user_id === auth()->id(), 403);
        $property->update(['status' => $property->status === 'hidden' ? 'pending' : 'hidden']);
        DashboardStatistics::forget(auth()->id());
        return back();
    }
    public function subscribe(Request $r)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'owner', 403);
        $user = auth()->user();
        $this->subscriptions->ensureBasicPlan($user);
        abort_if($user->subscriptions()->where('status', 'pending')->exists(), 422, __('owner-dashboard.pending_request_exists'));

        $propertyCount = $user->properties()->count();
        $d = $r->validate([
            'property_limit' => ['required', 'integer', 'min:' . max(1, $propertyCount), 'max:1000'],
            'reference' => ['required', 'string', 'max:120'],
        ]);
        abort_if($user->properties()->count() > $d['property_limit'], 422, __('owner-dashboard.property_count_changed'));
        $amount = round($this->subscriptions->premiumPricePerProperty() * $d['property_limit'], 2);

        Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'property_limit' => $d['property_limit'],
            'amount' => $amount,
            'sham_cash_reference' => $d['reference'],
            'status' => 'pending',
        ]);
        DashboardStatistics::forget($user->id);
        return back()->with('success', __('تم إرسال طلب الاشتراك للمراجعة اليدوية.'));
    }
    public function storeComplaint(Request $r)
    {
        $this->owner();
        $d = $r->validate(['subject_type' => 'required|in:owner,tenant', 'subject_name' => 'required|string|max:150', 'subject_contact' => 'nullable|string|max:120', 'type' => 'required|in:behavior,fraud,harassment,other', 'details' => 'required|string|max:3000']);
        Report::create($d + ['reporter_id' => auth()->id(), 'status' => 'open']);
        DashboardStatistics::forget();
        return redirect()->route('owner.dashboard')->with('success', __('تم إرسال الشكوى إلى فريق الإدارة للمراجعة.'));
    }
    private function validated(Request $r): array
    {
        return $r->validate(['title' => 'required|string|max:140', 'description' => 'required|string|max:5000', 'city' => 'required|in:Damascus,Jaramana,Sahnaya', 'neighborhood' => 'required|string|max:100', 'address' => 'nullable|string|max:255', 'purpose' => 'required|in:rent,sale', 'category' => 'required|in:residential,commercial', 'price' => 'required|numeric|min:0', 'currency' => 'nullable|in:USD,SYP', 'bedrooms' => 'nullable|integer|min:0|max:20', 'bathrooms' => 'nullable|integer|min:0|max:20', 'floor' => 'nullable|integer|min:-2|max:100', 'area' => 'nullable|integer|min:1', 'furnished' => 'nullable|boolean', 'reward_available' => 'nullable|boolean', 'amenities' => 'nullable|string|max:1000', 'images' => 'nullable|array|max:12', 'images.*' => 'file|image|mimes:jpg,jpeg,png,webp|max:5120', 'video' => 'nullable|file|mimes:mp4,mov,webm|max:51200', 'video_url' => 'nullable|url|max:500']);
    }
    private function prepare(Request $r, array $d): array
    {
        $d['currency'] = $d['currency'] ?? Setting::value('default_currency', 'USD');
        $d['reward_available'] = $d['reward_available'] ?? (bool)Setting::value('default_reward_enabled', false);
        $d['amenities'] = collect(explode(',', (string)($d['amenities'] ?? '')))->map(fn($v) => trim($v))->filter()->values()->all();
        $media = [];
        foreach ($r->file('images', []) as $image) {
            $media[] = $image->store('properties/images', 'public');
        }
        $d['media'] = $media ?: ($r->route('property') ? ($r->route('property')->media ?? []) : []);
        if ($r->hasFile('video')) $d['video_url'] = $r->file('video')->store('properties/videos', 'public');
        return $d;
    }
    private function owner()
    {
        abort_unless(auth()->check() && in_array(auth()->user()->role, ['owner', 'admin']), 403);
    }

    private function assertPropertyCapacity(): void
    {
        $subscription = $this->subscriptions->activeFor(auth()->user());
        abort_unless($subscription, 403);
        abort_if(
            auth()->user()->properties()->count() >= (int) $subscription->property_limit,
            403,
            __('owner-dashboard.property_limit_reached')
        );
    }
}
