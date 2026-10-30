<?php

namespace App\Services;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class PropertiesService
{
    public function landing(): array
    {
        return [
            'top' => Property::where('status', 'published')->latest('published_at')->take(6)->get(),
            'offers' => Property::where('status', 'published')
                ->where('reward_available', true)
                ->latest()
                ->take(3)
                ->get(),
            'stats' => Cache::remember('home:stats', now()->addMinutes(5), fn () => [
                'properties' => Property::where('status', 'published')->count(),
                'owners' => User::where('role', 'owner')->count(),
            ]),
        ];
    }

    public function listing(array $filters): array
    {
        return [
            'properties' => $this->filteredProperties($filters)->paginate(8)->withQueryString(),
            'cities' => Property::where('status', 'published')
                ->select('city')
                ->distinct()
                ->orderBy('city')
                ->pluck('city'),
            'filters' => $filters,
        ];
    }

    public function search(array $filters): array
    {
        $properties = $this->filteredProperties($filters)->paginate(8)->withQueryString();

        return [
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
        ];
    }

    public function show(Property $property): Property
    {
        abort_unless($property->status === 'published', 404);

        return $property->load('owner');
    }

    public function contact(Property $property, ?int $userId, array $data): void
    {
        abort_unless($property->owner?->activeSubscription(), 403, __('property-details.owner_unavailable'));

        Inquiry::create([
            'property_id' => $property->id,
            'user_id' => $userId,
            'phone' => $data['phone'],
            'message' => $data['message'] ?? null,
        ]);

        DashboardStatistics::forget($property->user_id);
    }

    public function report(Property $property, ?int $userId, array $data): void
    {
        Report::create([
            'property_id' => $property->id,
            'reporter_id' => $userId,
            'type' => $data['type'],
            'details' => $data['details'] ?? null,
        ]);

        DashboardStatistics::forget();
    }

    private function filteredProperties(array $filters): Builder
    {
        $query = Property::with('owner')
            ->where('status', 'published')
            ->when($this->hasFilter($filters, 'city'), fn (Builder $query) => $query->where('city', $filters['city']))
            ->when($this->hasFilter($filters, 'neighborhood'), fn (Builder $query) => $query->where(
                fn (Builder $location) => $location
                    ->where('neighborhood', 'like', '%' . $filters['neighborhood'] . '%')
                    ->orWhere('city', 'like', '%' . $filters['neighborhood'] . '%')
            ))
            ->when($this->hasFilter($filters, 'purpose'), fn (Builder $query) => $query->where('purpose', $filters['purpose']))
            ->when($this->hasFilter($filters, 'category'), fn (Builder $query) => $query->where('category', $filters['category']))
            ->when($this->hasFilter($filters, 'min_price'), fn (Builder $query) => $query->where('price', '>=', $filters['min_price']))
            ->when($this->hasFilter($filters, 'max_price'), fn (Builder $query) => $query->where('price', '<=', $filters['max_price']))
            ->when($this->hasFilter($filters, 'min_area'), fn (Builder $query) => $query->where('area', '>=', $filters['min_area']))
            ->when($this->hasFilter($filters, 'max_area'), fn (Builder $query) => $query->where('area', '<=', $filters['max_area']))
            ->when($this->hasFilter($filters, 'bedrooms'), fn (Builder $query) => $query->where('bedrooms', '>=', $filters['bedrooms']))
            ->when($this->hasFilter($filters, 'bathrooms'), fn (Builder $query) => $query->where('bathrooms', '>=', $filters['bathrooms']))
            ->when($this->hasFilter($filters, 'floor'), fn (Builder $query) => $query->where('floor', $filters['floor']))
            ->when($this->hasFilter($filters, 'furnished'), fn (Builder $query) => $query->where('furnished', (bool) $filters['furnished']))
            ->when($this->hasFilter($filters, 'reward'), fn (Builder $query) => $query->where('reward_available', (bool) $filters['reward']));

        return match ($filters['sort'] ?? 'latest') {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            default => $query->latest('published_at'),
        };
    }

    private function hasFilter(array $filters, string $key): bool
    {
        return array_key_exists($key, $filters) && $filters[$key] !== null && $filters[$key] !== '';
    }
}