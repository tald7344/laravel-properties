<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OwnerSubscriptionService
{
    public function ensureBasicPlan(User $owner): Subscription
    {
        return DB::transaction(function () use ($owner): Subscription {
            $owner = User::query()->lockForUpdate()->findOrFail($owner->id);
            abort_unless($owner->role === 'owner', 403);

            $basicSubscription = $owner->subscriptions()->where('plan', 'basic')->oldest()->first();

            if ($basicSubscription) {
                return $basicSubscription;
            }

            $activeSubscription = $owner->activeSubscription();

            if ($activeSubscription) {
                return $activeSubscription;
            }

            return $owner->subscriptions()->create([
                'plan' => 'basic',
                'amount' => 0,
                'property_limit' => 1,
                'status' => 'approved',
                'starts_at' => now(),
                'ends_at' => now()->addMonths(2),
            ]);
        });
    }

    public function activeFor(User $owner): ?Subscription
    {
        $subscription = $owner->subscriptions()
            ->where('status', 'approved')
            ->where(function ($query): void {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where('ends_at', '>', now())
            ->latest('ends_at')
            ->first();

        if ($subscription && $subscription->property_limit === null) {
            $subscription->update([
                'plan' => $subscription->plan === 'basic' ? 'basic' : 'premium',
                'property_limit' => max(1, $owner->properties()->count()),
            ]);
        }

        return $subscription;
    }

    public function premiumPricePerProperty(): float
    {
        return (float) Setting::value('premium_monthly_price_per_property', 3);
    }
}
