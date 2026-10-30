<?php

namespace App\Http\Middleware;

use App\Services\OwnerSubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOwnerSubscription
{
    public function __construct(private readonly OwnerSubscriptionService $subscriptions)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_unless($user && in_array($user->role, ['owner', 'admin'], true), 403);

        if ($user->role === 'owner') {
            $this->subscriptions->ensureBasicPlan($user);

            if (! $this->subscriptions->activeFor($user)) {
                return redirect()->route('owner.subscription');
            }
        }

        return $next($request);
    }
}
