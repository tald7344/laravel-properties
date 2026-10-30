<?php

namespace App\Services;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\Report;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardStatistics
{
    public function admin(): array
    {
        return Cache::remember('dashboard:admin:stats', now()->addMinutes(5), function () {
            $months = collect(range(5, 0))->map(function (int $ago) {
                $start = now()->startOfMonth()->subMonths($ago);
                return ['label' => $start->translatedFormat('M'), 'count' => Property::where('status', 'published')->whereBetween('published_at', [$start, $start->copy()->endOfMonth()])->count()];
            });
            return ['properties' => Property::count(), 'published' => Property::where('status', 'published')->count(), 'pending' => Property::where('status', 'pending')->count(), 'suspended' => Property::where('status', 'suspended')->count(), 'owners' => User::where('role', 'owner')->count(), 'renters' => User::where('role', 'renter')->count(), 'admins' => User::where('role', 'admin')->count(), 'inquiries' => Inquiry::count(), 'open_reports' => Report::where('status', 'open')->count(), 'resolved_reports' => Report::where('status', 'resolved')->count(), 'confirmed_deals' => Inquiry::where('status', 'completed')->count(), 'pending_subscriptions' => Subscription::where('status', 'pending')->count(), 'active_subscriptions' => Subscription::where('status', 'approved')->where('ends_at', '>', now())->count(), 'expired_subscriptions' => Subscription::where('ends_at', '<=', now())->count(), 'rent_properties' => Property::where('purpose', 'rent')->count(), 'sale_properties' => Property::where('purpose', 'sale')->count(), 'monthly_properties' => $months->all()];
        });
    }
    
    public function owner(int $userId): array
    {
        return Cache::remember("dashboard:owner:{$userId}:stats", now()->addMinutes(5), fn() => ['properties' => Property::where('user_id', $userId)->count(), 'published' => Property::where('user_id', $userId)->where('status', 'published')->count(), 'pending' => Property::where('user_id', $userId)->where('status', 'pending')->count(), 'inquiries' => Inquiry::whereHas('property', fn($q) => $q->where('user_id', $userId))->count()]);
    }

    public static function forget(?int $userId = null): void
    {
        Cache::forget('dashboard:admin:stats');
        if ($userId) Cache::forget("dashboard:owner:{$userId}:stats");
    }
}
