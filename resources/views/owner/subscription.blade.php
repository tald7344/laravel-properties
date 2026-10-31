@extends('layouts.app')

@section('content')
    @php($currentPlan = $subscription?->plan)
    @php($premiumCapacity = max(1, $propertyCount))
    <main class="subscription-page bg-[#f3f6f8] bg-[image:radial-gradient(circle_at_top_right,rgba(138,115,255,0.09),transparent_28%),radial-gradient(circle_at_bottom_left,rgba(46,179,126,0.08),transparent_24%)] px-6 py-14 pb-[72px] max-[560px]:min-h-[calc(100vh-76px)] max-[560px]:bg-[#f2f5f8] max-[560px]:bg-[image:radial-gradient(ellipse_at_10%_12%,rgba(116,101,238,0.1),transparent_34%),radial-gradient(ellipse_at_92%_84%,rgba(72,196,166,0.11),transparent_33%)] max-[560px]:px-[14px] max-[560px]:pt-7 max-[560px]:pb-[42px]">
        <div class="subscription-shell mx-auto w-full max-w-[1040px] rounded-[32px] border border-white/90 bg-white/[0.92] px-[52px] pt-12 pb-10 shadow-[0_18px_54px_rgba(18,29,43,0.08)] max-[560px]:max-w-[1030px] max-[560px]:rounded-[30px] max-[560px]:border-white/[0.88] max-[560px]:bg-white/[0.94] max-[560px]:px-[54px] max-[560px]:pt-[46px] max-[560px]:pb-[38px] max-[560px]:shadow-[0_24px_70px_rgba(27,44,64,0.09)] max-[560px]:[&]:rounded-[22px] max-[560px]:[&]:px-5 max-[560px]:[&]:pt-[30px] max-[560px]:[&]:pb-[26px] max-[420px]:px-[14px] max-[420px]:pt-[25px] max-[420px]:pb-[22px]">
            <header class="subscription-heading mx-auto mb-[30px] max-w-[700px] text-center max-[560px]:max-w-[660px]">
                <span class="mb-0 inline-flex min-h-[30px] items-center justify-center rounded-full border border-[#dfe9f0] bg-[#f1f6fb] px-3 py-[6px] text-[10px] font-extrabold uppercase tracking-[0.12em] text-[#5f6d7d] max-[560px]:mb-3 inline-block bg-[var(--mint)] px-[9px] py-1 text-xs font-bold text-[var(--green)]">{{ __('owner-dashboard.workspace') }}</span>
                <h1 class="my-[14px] mb-2 text-[clamp(30px,3vw,46px)] leading-[1.18] text-[#131d2c] max-[560px]:m-0 max-[560px]:text-[clamp(26px,3.3vw,36px)] max-[560px]:leading-[1.35]">{{ __('owner-dashboard.subscription_title') }}</h1>
                <p class="m-0 text-sm leading-[1.8] text-[#778393] max-[560px]:mt-2 max-[560px]:text-[13px] max-[560px]:text-[#83909b]">{{ __('owner-dashboard.subscription_info') }}</p>
            </header>

            @if (! $subscription)
                <div class="subscription-alert subscription-alert--expired mx-auto mb-[22px] flex flex-wrap justify-center gap-x-[18px] gap-y-[5px] rounded-xl border border-[#f4d8d2] bg-[#fff8f6] px-[18px] py-[13px] text-center text-xs leading-[1.7] text-[#9c5046] max-[560px]:mb-6" role="status">
                    <strong>{{ __('owner-dashboard.subscription_expired') }}</strong>
                    <span>{{ __('owner-dashboard.owner_phone_hidden') }}</span>
                    <span>{{ __('owner-dashboard.listings_remain_visible') }}</span>
                </div>
            @else
                <div class="subscription-alert subscription-alert--active mx-auto mb-[22px] flex flex-wrap justify-center gap-x-[18px] gap-y-[5px] rounded-xl border border-[#cdeee4] bg-[#f2fbf8] px-[18px] py-[13px] text-center text-xs leading-[1.7] text-[#258d79] max-[560px]:mb-6" role="status">
                    <strong>{{ __('owner-dashboard.current_plan', ['plan' => __('owner-dashboard.plan_'.$subscription->plan), 'date' => $subscription->ends_at->format('Y-m-d H:i')]) }}</strong>
                    <span>{{ __('owner-dashboard.current_capacity', ['count' => $subscription->property_limit]) }}</span>
                </div>
            @endif

            @if ($pendingSubscription)
                <div id="subscription-pending" class="subscription-alert subscription-alert--pending mx-auto mb-[22px] flex flex-wrap justify-center gap-x-[18px] gap-y-[5px] rounded-xl border border-[#eadcf7] bg-[#fcf8ff] px-[18px] py-[13px] text-center text-xs leading-[1.7] text-[#7545a4] max-[560px]:mb-6" role="status">
                    {{ __('owner-dashboard.subscription_pending', ['amount' => number_format((float) $pendingSubscription->amount, 2)]) }}
                </div>
            @endif

            <section class="subscription-plans mx-auto grid max-w-[780px] grid-cols-2 items-stretch gap-6 max-[560px]:max-w-[420px] max-[560px]:grid-cols-1 max-[560px]:gap-4" aria-label="{{ __('owner-dashboard.available_plans') }}">
                <article class="subscription-card subscription-card--basic relative overflow-hidden rounded-[20px] border border-[#e8edf3] bg-white shadow-[0_10px_28px_rgba(24,35,49,0.06)] max-[560px]:rounded-2xl max-[560px]:border-[#e9edf2] max-[560px]:shadow-[0_7px_20px_rgba(30,42,59,0.07)]">
                    <div class="subscription-card__body flex min-h-full flex-col px-6 pt-7 pb-[22px] max-[560px]:px-6 max-[560px]:pt-[25px]">
                        <div class="subscription-card__title mb-[18px] text-center max-[560px]:mb-4">
                            <span class="subscription-card__eyebrow text-[10px] font-extrabold uppercase tracking-[0.08em] text-[#8b95a2] max-[560px]:font-bold max-[560px]:normal-case max-[560px]:tracking-normal max-[560px]:text-[#97a2af]">{{ __('owner-dashboard.plan_for_starters') }}</span>
                            <h2 class="mt-1 mb-0 text-[28px] leading-[1.25] text-[#121d2a] max-[560px]:mt-[3px] max-[560px]:text-xl max-[560px]:leading-[1.4] max-[560px]:text-[#202b3a]">{{ __('owner-dashboard.plan_basic') }}</h2>
                        </div>
                        <div class="subscription-price flex min-h-12 items-baseline justify-center gap-2">
                            <strong class="text-[32px] font-extrabold leading-none text-[#122131] max-[560px]:text-[#29364a]">{{ __('owner-dashboard.free_price') }}</strong>
                            <span class="text-[11px] text-[#8694a2]">{{ __('owner-dashboard.basic_duration') }}</span>
                        </div>
                        <p class="subscription-card__description my-4 mb-[18px] min-h-[52px] text-center text-xs leading-[1.8] text-[#748193] max-[560px]:my-3 max-[560px]:mb-[18px] max-[560px]:min-h-12 max-[560px]:text-[11px] max-[560px]:text-[#84909c]">{{ __('owner-dashboard.basic_summary') }}</p>
                        <ul class="subscription-features m-0 grid list-none gap-3 border-t border-[#edf1f6] px-0 pt-[18px] max-[560px]:gap-[13px] max-[560px]:border-[#edf0f3] max-[560px]:pt-4">
                            <li class="relative ps-6 text-xs leading-[1.7] text-[#3b4c5d] before:absolute before:start-0 before:text-[15px] before:font-extrabold before:text-[#5e5af3] before:content-['✓'] max-[560px]:ps-[23px] max-[560px]:text-[11px] max-[560px]:text-[#364252] max-[560px]:before:text-[#6149ed]">{{ __('owner-dashboard.basic_feature_duration') }}</li>
                            <li class="relative ps-6 text-xs leading-[1.7] text-[#3b4c5d] before:absolute before:start-0 before:text-[15px] before:font-extrabold before:text-[#5e5af3] before:content-['✓'] max-[560px]:ps-[23px] max-[560px]:text-[11px] max-[560px]:text-[#364252] max-[560px]:before:text-[#6149ed]">{{ __('owner-dashboard.basic_feature_capacity') }}</li>
                            <li class="relative ps-6 text-xs leading-[1.7] text-[#3b4c5d] before:absolute before:start-0 before:text-[15px] before:font-extrabold before:text-[#5e5af3] before:content-['✓'] max-[560px]:ps-[23px] max-[560px]:text-[11px] max-[560px]:text-[#364252] max-[560px]:before:text-[#6149ed]">{{ __('owner-dashboard.basic_feature_renter') }}</li>
                        </ul>
                        @if ($currentPlan === 'basic')
                            <div class="subscription-current mt-auto pt-[22px] text-center text-[10px] font-bold text-[#1a8f7c] max-[560px]:pt-[25px] max-[560px]:text-[#278e7b]">{{ __('owner-dashboard.current_plan_badge') }}</div>
                        @else
                            <div class="subscription-card__footnote mt-auto pt-[22px] text-center text-[10px] text-[#8391a1] max-[560px]:pt-[25px] max-[560px]:text-[#8a95a2]">{{ __('owner-dashboard.basic_once') }}</div>
                        @endif
                    </div>
                </article>

                <article class="subscription-card subscription-card--premium relative overflow-hidden rounded-[20px] border border-[#e5d8ff] bg-[image:linear-gradient(180deg,#fff_0%,#fffafc_100%)] shadow-[0_10px_28px_rgba(24,35,49,0.06)] before:absolute before:inset-x-0 before:top-0 before:h-[7px] before:bg-[image:linear-gradient(90deg,#7b61ff,#9a4dff_55%,#d23df1)] before:content-[''] max-[560px]:rounded-2xl max-[560px]:border-[#e7d8f8] max-[560px]:shadow-[0_7px_20px_rgba(30,42,59,0.07)] max-[560px]:before:bg-[#ad16ed]">
                    <div class="subscription-card__ribbon absolute end-[14px] top-[14px] rounded-full bg-[#f3eaff] px-[10px] py-[5px] text-[9px] font-extrabold uppercase tracking-[0.08em] text-[#7c43d1] max-[560px]:rounded-[99px] max-[560px]:bg-[#f4e3ff] max-[560px]:px-[10px] max-[560px]:py-1 max-[560px]:text-[#9410c7]">{{ __('owner-dashboard.plan_recommended') }}</div>
                    <div class="subscription-card__body flex min-h-full flex-col px-6 pt-9 pb-[22px] max-[560px]:px-6 max-[560px]:pt-[35px] max-[420px]:px-[18px]">
                        <div class="subscription-card__title mb-[18px] text-center max-[560px]:mb-4">
                            <span class="subscription-card__eyebrow text-[10px] font-extrabold uppercase tracking-[0.08em] text-[#8b95a2] max-[560px]:font-bold max-[560px]:normal-case max-[560px]:tracking-normal max-[560px]:text-[#97a2af]">{{ __('owner-dashboard.plan_for_growing') }}</span>
                            <h2 class="mt-1 mb-0 text-[28px] leading-[1.25] text-[#121d2a] max-[560px]:mt-[3px] max-[560px]:text-xl max-[560px]:leading-[1.4] max-[560px]:text-[#202b3a]">{{ __('owner-dashboard.plan_premium') }}</h2>
                        </div>
                        <div class="subscription-price flex min-h-12 items-baseline justify-center gap-2 max-[560px]:min-h-[46px] max-[560px]:gap-[7px]">
                            <strong class="text-[32px] font-extrabold leading-none text-[#6947dc] max-[560px]:font-bold max-[560px]:text-[#a80de5]"><span aria-hidden="true">$</span>{{ number_format($pricePerProperty, 2) }}</strong>
                            <span class="text-[11px] text-[#8694a2] max-[560px]:text-[#8b97a4]">{{ __('owner-dashboard.per_property_month') }}</span>
                        </div>
                        <p class="subscription-card__description my-4 mb-[18px] min-h-[52px] text-center text-xs leading-[1.8] text-[#748193] max-[560px]:my-3 max-[560px]:mb-[18px] max-[560px]:min-h-12 max-[560px]:text-[11px] max-[560px]:text-[#84909c]">{{ __('owner-dashboard.premium_summary') }}</p>

                        <form class="subscription-form flex flex-1 flex-col gap-[10px] border-t border-[#edf1f6] pt-4 max-[560px]:gap-[9px] max-[560px]:border-[#edf0f3] max-[560px]:pt-[14px]" method="post" action="{{ route('owner.subscribe') }}" data-price-per-property="{{ $pricePerProperty }}" @if ($pendingSubscription) aria-describedby="subscription-pending" @endif>
                            @csrf
                            <label class="text-[11px] font-bold text-[#4f5d70] max-[560px]:text-[10px] max-[560px]:text-[#566273]" for="property-capacity">{{ __('owner-dashboard.property_capacity') }}</label>
                            <input id="property-capacity" class="min-h-[42px] rounded-[10px] border border-[#dfe5ec] px-3 py-[9px] text-xs text-[#1a2432] focus:border-[#7d6df4] focus:outline-none focus:shadow-[0_0_0_3px_rgba(124,108,240,0.12)] max-[560px]:rounded-[9px] max-[560px]:border-[#e3e7ed] max-[560px]:px-[11px] w-full bg-white font-[inherit] text-[13px]" type="number" name="property_limit" min="{{ $premiumCapacity }}" max="1000" value="{{ $premiumCapacity }}" required data-property-capacity @disabled($pendingSubscription)>
                            <div class="subscription-total my-[3px] mb-[5px] flex items-center justify-between rounded-[10px] border border-[#f0e9ff] bg-[#faf6ff] px-3 py-[11px] text-[11px] text-[#5f6d7d] max-[560px]:my-[2px] max-[560px]:mb-[3px] max-[560px]:rounded-[9px] max-[560px]:bg-[#fbf5ff] max-[560px]:px-3 max-[560px]:py-[10px] max-[560px]:text-[#697687]" aria-live="polite">
                                <span>{{ __('owner-dashboard.monthly_total') }}</span>
                                <strong class="text-lg text-[#5f46d9] max-[560px]:text-base max-[560px]:text-[#9911cf]" data-premium-total>${{ number_format($pricePerProperty * $premiumCapacity, 2) }}</strong>
                            </div>
                            <label class="text-[11px] font-bold text-[#4f5d70] max-[560px]:text-[10px] max-[560px]:text-[#566273]" for="sham-cash-reference">{{ __('owner-dashboard.sham_cash_number') }}</label>
                            <input id="sham-cash-reference" class="min-h-[42px] rounded-[10px] border border-[#dfe5ec] px-3 py-[9px] text-xs text-[#1a2432] focus:border-[#7d6df4] focus:outline-none focus:shadow-[0_0_0_3px_rgba(124,108,240,0.12)] max-[560px]:rounded-[9px] max-[560px]:border-[#e3e7ed] max-[560px]:px-[11px] w-full bg-white font-[inherit] text-[13px]" name="reference" maxlength="120" required @disabled($pendingSubscription)>
                            <button class="subscription-submit mt-[2px] min-h-11 w-full cursor-pointer rounded-[10px] border border-[#5d4bd9] bg-[image:linear-gradient(135deg,#6254d8,#4e42c7)] text-xs font-bold text-white transition-[transform,box-shadow] duration-150 hover:not-disabled:-translate-y-px hover:not-disabled:shadow-[0_10px_18px_rgba(88,74,208,0.2)] disabled:cursor-not-allowed disabled:opacity-70 max-[560px]:mt-[3px] max-[560px]:min-h-[42px] max-[560px]:rounded-[9px] max-[560px]:border-[#a916e2] max-[560px]:bg-none max-[560px]:bg-[#a916e2] max-[560px]:disabled:opacity-[0.55] max-[560px]:hover:not-disabled:bg-[#9211c8] max-[560px]:hover:not-disabled:shadow-none" type="submit" @disabled($pendingSubscription)>
                                {{ $pendingSubscription ? __('owner-dashboard.awaiting_review') : __('owner-dashboard.submit_review') }}
                            </button>
                            <p class="subscription-form__note m-0 text-center text-[10px] leading-[1.6] text-[#8a96a3] max-[560px]:text-[9px] max-[560px]:text-[#939daa]">{{ __('owner-dashboard.payment_review_note') }}</p>
                        </form>
                    </div>
                </article>
            </section>

            @if ($subscription)
                <a class="subscription-back mx-auto mt-[26px] block w-fit text-xs font-bold text-[#4d42ce] max-[560px]:mt-[25px] max-[560px]:text-[#5b49d6]" href="{{ route('owner.dashboard') }}">{{ __('owner-dashboard.back_to_dashboard') }}</a>
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
