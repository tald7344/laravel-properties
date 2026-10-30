@extends('layouts.app')

@section('content')
    @php($currentPlan = $subscription?->plan)
    @php($premiumCapacity = max(1, $propertyCount))
    <main class="subscription-page">
        <div class="subscription-shell">
            <header class="subscription-heading">
                <span class="tag">{{ __('owner-dashboard.workspace') }}</span>
                <h1>{{ __('owner-dashboard.subscription_title') }}</h1>
                <p>{{ __('owner-dashboard.subscription_info') }}</p>
            </header>

            @if (! $subscription)
                <div class="subscription-alert subscription-alert--expired" role="status">
                    <strong>{{ __('owner-dashboard.subscription_expired') }}</strong>
                    <span>{{ __('owner-dashboard.owner_phone_hidden') }}</span>
                    <span>{{ __('owner-dashboard.listings_remain_visible') }}</span>
                </div>
            @else
                <div class="subscription-alert subscription-alert--active" role="status">
                    <strong>{{ __('owner-dashboard.current_plan', ['plan' => __('owner-dashboard.plan_'.$subscription->plan), 'date' => $subscription->ends_at->format('Y-m-d H:i')]) }}</strong>
                    <span>{{ __('owner-dashboard.current_capacity', ['count' => $subscription->property_limit]) }}</span>
                </div>
            @endif

            @if ($pendingSubscription)
                <div id="subscription-pending" class="subscription-alert subscription-alert--pending" role="status">
                    {{ __('owner-dashboard.subscription_pending', ['amount' => number_format((float) $pendingSubscription->amount, 2)]) }}
                </div>
            @endif

            <section class="subscription-plans" aria-label="{{ __('owner-dashboard.available_plans') }}">
                <article class="subscription-card subscription-card--basic">
                    <div class="subscription-card__body">
                        <div class="subscription-card__title">
                            <span class="subscription-card__eyebrow">{{ __('owner-dashboard.plan_for_starters') }}</span>
                            <h2>{{ __('owner-dashboard.plan_basic') }}</h2>
                        </div>
                        <div class="subscription-price">
                            <strong>{{ __('owner-dashboard.free_price') }}</strong>
                            <span>{{ __('owner-dashboard.basic_duration') }}</span>
                        </div>
                        <p class="subscription-card__description">{{ __('owner-dashboard.basic_summary') }}</p>
                        <ul class="subscription-features">
                            <li>{{ __('owner-dashboard.basic_feature_duration') }}</li>
                            <li>{{ __('owner-dashboard.basic_feature_capacity') }}</li>
                            <li>{{ __('owner-dashboard.basic_feature_renter') }}</li>
                        </ul>
                        @if ($currentPlan === 'basic')
                            <div class="subscription-current">{{ __('owner-dashboard.current_plan_badge') }}</div>
                        @else
                            <div class="subscription-card__footnote">{{ __('owner-dashboard.basic_once') }}</div>
                        @endif
                    </div>
                </article>

                <article class="subscription-card subscription-card--premium">
                    <div class="subscription-card__ribbon">{{ __('owner-dashboard.plan_recommended') }}</div>
                    <div class="subscription-card__body">
                        <div class="subscription-card__title">
                            <span class="subscription-card__eyebrow">{{ __('owner-dashboard.plan_for_growing') }}</span>
                            <h2>{{ __('owner-dashboard.plan_premium') }}</h2>
                        </div>
                        <div class="subscription-price">
                            <strong><span aria-hidden="true">$</span>{{ number_format($pricePerProperty, 2) }}</strong>
                            <span>{{ __('owner-dashboard.per_property_month') }}</span>
                        </div>
                        <p class="subscription-card__description">{{ __('owner-dashboard.premium_summary') }}</p>

                        <form class="subscription-form" method="post" action="{{ route('owner.subscribe') }}" data-price-per-property="{{ $pricePerProperty }}" @if ($pendingSubscription) aria-describedby="subscription-pending" @endif>
                            @csrf
                            <label for="property-capacity">{{ __('owner-dashboard.property_capacity') }}</label>
                            <input id="property-capacity" class="field" type="number" name="property_limit" min="{{ $premiumCapacity }}" max="1000" value="{{ $premiumCapacity }}" required data-property-capacity @disabled($pendingSubscription)>
                            <div class="subscription-total" aria-live="polite">
                                <span>{{ __('owner-dashboard.monthly_total') }}</span>
                                <strong data-premium-total>${{ number_format($pricePerProperty * $premiumCapacity, 2) }}</strong>
                            </div>
                            <label for="sham-cash-reference">{{ __('owner-dashboard.sham_cash_number') }}</label>
                            <input id="sham-cash-reference" class="field" name="reference" maxlength="120" required @disabled($pendingSubscription)>
                            <button class="subscription-submit" type="submit" @disabled($pendingSubscription)>
                                {{ $pendingSubscription ? __('owner-dashboard.awaiting_review') : __('owner-dashboard.submit_review') }}
                            </button>
                            <p class="subscription-form__note">{{ __('owner-dashboard.payment_review_note') }}</p>
                        </form>
                    </div>
                </article>
            </section>

            @if ($subscription)
                <a class="subscription-back" href="{{ route('owner.dashboard') }}">{{ __('owner-dashboard.back_to_dashboard') }}</a>
            @endif
        </div>
    </main>
    <script>
        const premiumForm = document.querySelector('[data-price-per-property]');
        const capacityInput = premiumForm?.querySelector('[data-property-capacity]');
        const totalLabel = premiumForm?.querySelector('[data-premium-total]');

        capacityInput?.addEventListener('input', () => {
            const capacity = Math.max(Number(capacityInput.value) || 0, Number(capacityInput.min));
            const amount = (capacity * Number(premiumForm.dataset.pricePerProperty)).toFixed(2);
            totalLabel.textContent = `$${amount}`;
        });
    </script>
@endsection
