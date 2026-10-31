@extends('layouts.app')

@section('content')
    <main class="owner-dashboard min-h-[calc(100vh-76px)] bg-[#f5f8f6] bg-[image:radial-gradient(ellipse_at_92%_0%,rgba(223,245,233,0.7),transparent_35%)] py-[42px] pb-16 max-[560px]:py-7 max-[560px]:pb-[42px]">
        <div class="owner-dashboard__container max-w-[1120px] mx-auto px-[22px]">
            <header class="owner-dashboard__heading mb-[26px] flex items-center justify-between gap-6 max-[560px]:mb-5 max-[560px]:items-start max-[560px]:flex-col max-[560px]:gap-4">
                <div>
                    <span class="inline-block rounded-full bg-[var(--mint)] px-[9px] py-1 text-xs font-bold text-[var(--green)]">{{ __('owner-dashboard.workspace') }}</span>
                    <h1 class="my-[10px] mb-[3px] text-[clamp(25px,3vw,34px)] leading-[1.4] text-[var(--ink)]">{{ __('owner-dashboard.greeting', ['name' => auth()->user()->name]) }}</h1>
                    <p class="m-0 text-sm text-[var(--muted)]">{{ __('owner-dashboard.intro') }}</p>
                </div>
                <div class="owner-dashboard__heading-actions flex items-center gap-3 max-[560px]:w-full max-[560px]:flex-col">
                    <a class="inline-block cursor-pointer rounded-[10px] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold border border-[#cadbd2] bg-transparent text-[var(--green)]" href="{{ route('owner.profile.edit') }}">{{ __('owner-dashboard.profile') }}</a>
                    <a class="owner-dashboard__add shrink-0 px-5 py-3 shadow-[0_7px_16px_rgba(23,107,82,0.16)] max-[560px]:w-full max-[560px]:text-center inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] font-[inherit] text-[13px] font-bold text-white" href="{{ route('owner.properties.create') }}">{{ __('owner-dashboard.add_listing') }}</a>
                </div>
            </header>

            @if ($subscription)
                <div class="owner-dashboard__notice owner-dashboard__notice--active mb-5 flex items-center gap-3 rounded-xl border border-[#cfe8dc] bg-[#f3fbf6] px-4 py-[13px] text-[var(--green)] max-[560px]:items-start max-[560px]:p-3">
                    <span class="owner-dashboard__notice-icon grid size-7 shrink-0 place-items-center rounded-full bg-[#e6f3ec] text-[13px] font-extrabold text-[var(--green)]" aria-hidden="true">✓</span>
                    <p class="m-0 text-[13px] leading-[1.8]">
                        {{ __('owner-dashboard.subscription_active_until') }}
                        <strong>{{ $subscription->ends_at->format('Y-m-d H:i') }}</strong>
                        <span>{{ __('owner-dashboard.remaining', ['time' => $subscription->ends_at->diffForHumans()]) }}</span>
                    </p>
                </div>
            @else
                <div class="owner-dashboard__notice mb-5 flex items-center gap-3 rounded-xl border border-[#dce8e1] bg-white px-4 py-[13px] text-[#52675e] max-[560px]:items-start max-[560px]:p-3">
                    <span class="owner-dashboard__notice-icon grid size-7 shrink-0 place-items-center rounded-full bg-[#e6f3ec] text-[13px] font-extrabold text-[var(--green)]" aria-hidden="true">i</span>
                    <p class="m-0 text-[13px] leading-[1.8]">{{ __('owner-dashboard.no_active_subscription') }}</p>
                </div>
            @endif

            <section class="owner-dashboard__stats mb-6 grid grid-cols-4 gap-[14px] max-[850px]:grid-cols-2 max-[560px]:gap-[10px]" aria-label="{{ __('owner-dashboard.listing_statistics') }}">
                <article class="owner-dashboard__stat relative flex min-h-[110px] flex-col justify-between overflow-hidden rounded-[14px] border border-[#e3ebe6] border-e-4 border-e-[#a7c6b6] bg-white px-[19px] py-[17px] shadow-[0_5px_18px_rgba(24,59,44,0.035)] max-[560px]:min-h-[96px] max-[560px]:p-[14px]">
                    <span class="text-xs font-semibold text-[var(--muted)]">{{ __('owner-dashboard.total_listings') }}</span>
                    <strong class="text-[28px] leading-none text-[var(--ink)] max-[560px]:text-[25px]">{{ $statistics['properties'] }}</strong>
                </article>
                <article class="owner-dashboard__stat owner-dashboard__stat--published relative flex min-h-[110px] flex-col justify-between overflow-hidden rounded-[14px] border border-[#e3ebe6] border-e-4 border-e-[#3a9b70] bg-white px-[19px] py-[17px] shadow-[0_5px_18px_rgba(24,59,44,0.035)] max-[560px]:min-h-[96px] max-[560px]:p-[14px]">
                    <span class="text-xs font-semibold text-[var(--muted)]">{{ __('owner-dashboard.published') }}</span>
                    <strong class="text-[28px] leading-none text-[var(--ink)] max-[560px]:text-[25px]">{{ $statistics['published'] }}</strong>
                </article>
                <article class="owner-dashboard__stat owner-dashboard__stat--pending relative flex min-h-[110px] flex-col justify-between overflow-hidden rounded-[14px] border border-[#e3ebe6] border-e-4 border-e-[#dfa75f] bg-white px-[19px] py-[17px] shadow-[0_5px_18px_rgba(24,59,44,0.035)] max-[560px]:min-h-[96px] max-[560px]:p-[14px]">
                    <span class="text-xs font-semibold text-[var(--muted)]">{{ __('owner-dashboard.pending') }}</span>
                    <strong class="text-[28px] leading-none text-[var(--ink)] max-[560px]:text-[25px]">{{ $statistics['pending'] }}</strong>
                </article>
                <article class="owner-dashboard__stat owner-dashboard__stat--inquiries relative flex min-h-[110px] flex-col justify-between overflow-hidden rounded-[14px] border border-[#e3ebe6] border-e-4 border-e-[#7795cb] bg-white px-[19px] py-[17px] shadow-[0_5px_18px_rgba(24,59,44,0.035)] max-[560px]:min-h-[96px] max-[560px]:p-[14px]">
                    <span class="text-xs font-semibold text-[var(--muted)]">{{ __('owner-dashboard.contact_requests') }}</span>
                    <strong class="text-[28px] leading-none text-[var(--ink)] max-[560px]:text-[25px]">{{ $statistics['inquiries'] }}</strong>
                </article>
            </section>

            <section class="owner-dashboard__panel mt-5 rounded-2xl border border-[#e2eae5] bg-white px-6 py-[23px] shadow-[0_7px_24px_rgba(24,59,44,0.035)] max-[850px]:p-5" aria-labelledby="owner-listings-title">
                <div class="owner-dashboard__panel-heading mb-[18px] flex items-center justify-between gap-[14px]">
                    <div>
                        <span class="owner-dashboard__eyebrow text-[10px] font-bold text-[#82928a]">{{ __('owner-dashboard.content_management') }}</span>
                        <h2 class="mt-px mb-0 text-[19px] text-[var(--ink)]" id="owner-listings-title">{{ __('owner-dashboard.my_listings') }}</h2>
                    </div>
                    <span class="owner-dashboard__count whitespace-nowrap rounded-full bg-[#f0f5f2] px-[10px] py-[5px] text-[11px] text-[#66776f]">{{ __('owner-dashboard.listing_count', ['count' => $properties->count()]) }}</span>
                </div>

                @if ($properties->count())
                    <div class="owner-dashboard__table-wrap w-full overflow-x-auto">
                        <table class="owner-dashboard__table w-full border-collapse text-right max-[850px]:block">
                            <thead class="max-[850px]:hidden">
                                <tr>
                                    <th class="whitespace-nowrap border-b border-[#e7eee9] bg-[#f8faf8] px-3 py-[11px] text-[11px] font-bold text-[#75847c]" scope="col">{{ __('owner-dashboard.property') }}</th>
                                    <th class="whitespace-nowrap border-b border-[#e7eee9] bg-[#f8faf8] px-3 py-[11px] text-[11px] font-bold text-[#75847c]" scope="col">{{ __('owner-dashboard.status') }}</th>
                                    <th class="whitespace-nowrap border-b border-[#e7eee9] bg-[#f8faf8] px-3 py-[11px] text-[11px] font-bold text-[#75847c]" scope="col">{{ __('owner-dashboard.last_confirmation') }}</th>
                                    <th class="whitespace-nowrap border-b border-[#e7eee9] bg-[#f8faf8] px-3 py-[11px] text-[11px] font-bold text-[#75847c]" scope="col">{{ __('owner-dashboard.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="max-[850px]:block">
                                @foreach ($properties as $p)
                                    <tr class="hover:bg-[#fcfdfc] max-[850px]:grid max-[850px]:grid-cols-2 max-[850px]:gap-x-[14px] max-[850px]:gap-y-[10px] max-[850px]:border-b max-[850px]:border-[#edf1ee] max-[850px]:py-[14px] last:max-[850px]:border-b-0">
                                        <td class="border-b border-[#edf1ee] px-3 py-[13px] align-middle text-xs text-[#43564d] first:min-w-[220px] max-[850px]:flex max-[850px]:w-auto max-[850px]:min-w-0 max-[850px]:items-center max-[850px]:justify-between max-[850px]:gap-2 max-[850px]:border-0 max-[850px]:py-[3px] max-[850px]:text-[11px] max-[850px]:first:col-span-full max-[850px]:first:items-start max-[850px]:before:text-[10px] max-[850px]:before:font-bold max-[850px]:before:text-[#86938c] max-[850px]:before:content-[attr(data-label)] max-[850px]:first:before:hidden max-[850px]:last:before:hidden" data-label="{{ __('owner-dashboard.property') }}">
                                            <span class="owner-dashboard__property-title mb-[3px] block text-[13px] font-bold text-[var(--ink)]">{{ $p->title }}</span>
                                            <small class="block text-[10px] text-[var(--muted)]">{{ $p->city }} · {{ number_format($p->price) }} {{ $p->currency }}</small>
                                        </td>
                                        <td class="border-b border-[#edf1ee] px-3 py-[13px] align-middle text-xs text-[#43564d] max-[850px]:flex max-[850px]:w-auto max-[850px]:min-w-0 max-[850px]:items-center max-[850px]:justify-between max-[850px]:gap-2 max-[850px]:border-0 max-[850px]:py-[3px] max-[850px]:text-[11px] max-[850px]:before:text-[10px] max-[850px]:before:font-bold max-[850px]:before:text-[#86938c] max-[850px]:before:content-[attr(data-label)]" data-label="{{ __('owner-dashboard.status') }}">
                                            <span class="owner-dashboard__status inline-flex items-center whitespace-nowrap rounded-full bg-[#f1f3f2] px-[9px] py-1 text-[10px] font-bold text-[#64736c] {{ $p->status === 'published' ? 'bg-[#e7f5ed] text-[#26754f]' : ($p->status === 'pending' ? 'bg-[#fff4e2] text-[#94621b]' : 'bg-[#f0efef] text-[#76716f]') }}">
                                                {{ __('owner-dashboard.status_'.$p->status) }}
                                            </span>
                                        </td>
                                        <td class="border-b border-[#edf1ee] px-3 py-[13px] align-middle text-xs text-[#43564d] max-[850px]:flex max-[850px]:w-auto max-[850px]:min-w-0 max-[850px]:items-center max-[850px]:justify-between max-[850px]:gap-2 max-[850px]:border-0 max-[850px]:py-[3px] max-[850px]:text-[11px] max-[850px]:before:text-[10px] max-[850px]:before:font-bold max-[850px]:before:text-[#86938c] max-[850px]:before:content-[attr(data-label)]" data-label="{{ __('owner-dashboard.last_confirmation') }}">
                                            {{ optional($p->last_confirmed_at)->diffForHumans() ?? '—' }}
                                        </td>
                                        <td class="border-b border-[#edf1ee] px-3 py-[13px] align-middle text-xs text-[#43564d] max-[850px]:flex max-[850px]:w-auto max-[850px]:min-w-0 max-[850px]:items-center max-[850px]:justify-between max-[850px]:gap-2 max-[850px]:border-0 max-[850px]:py-[3px] max-[850px]:text-[11px] max-[850px]:before:text-[10px] max-[850px]:before:font-bold max-[850px]:before:text-[#86938c] max-[850px]:before:content-[attr(data-label)] max-[850px]:last:before:hidden" data-label="{{ __('owner-dashboard.action') }}">
                                            <div class="owner-dashboard__actions flex items-center gap-[7px] whitespace-nowrap max-[850px]:flex-wrap max-[850px]:justify-end">
                                                <form class="m-0" method="post" action="{{ route('owner.properties.confirm', $p) }}">
                                                    @csrf
                                                    <button class="rounded-lg px-[10px] py-[7px] text-[11px] inline-block cursor-pointer border-0 font-[inherit] font-bold bg-[var(--mint)] text-[var(--green)]" type="submit">{{ __('owner-dashboard.confirm_availability') }}</button>
                                                </form>
                                                <form class="m-0" method="post" action="{{ route('owner.properties.toggle', $p) }}">
                                                    @csrf
                                                    <button class="rounded-lg px-[10px] py-[7px] text-[11px] inline-block cursor-pointer font-[inherit] font-bold border border-[#cadbd2] bg-transparent text-[var(--green)]" type="submit">
                                                        {{ $p->status === 'hidden' ? __('owner-dashboard.activate') : __('owner-dashboard.hide') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="owner-dashboard__empty flex min-h-[250px] flex-col items-center justify-center px-4 py-7 text-center">
                        <span class="owner-dashboard__empty-icon grid size-[50px] place-items-center rounded-full bg-[#edf6f0] text-2xl text-[var(--green)]" aria-hidden="true">⌂</span>
                        <h3 class="mt-3 mb-1 text-base">{{ __('owner-dashboard.no_listings') }}</h3>
                        <p class="mb-4 mt-0 text-xs text-[var(--muted)]">{{ __('owner-dashboard.first_listing_hint') }}</p>
                        <a class="inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" href="{{ route('owner.properties.create') }}">{{ __('owner-dashboard.add_first_listing') }}</a>
                    </div>
                @endif
            </section>

            <section class="owner-dashboard__panel owner-dashboard__complaints mt-5 rounded-2xl border border-[#e2eae5] bg-white px-6 py-[23px] shadow-[0_7px_24px_rgba(24,59,44,0.035)] max-[850px]:p-5" id="owner-complaints" aria-labelledby="owner-complaints-title">
                <div class="owner-dashboard__panel-heading mb-[18px] flex items-center justify-between gap-[14px]">
                    <div>
                        <span class="owner-dashboard__eyebrow text-[10px] font-bold text-[#82928a]">{{ __('owner-dashboard.complaint_attention') }}</span>
                        <h2 class="mt-px mb-0 text-[19px] text-[var(--ink)]" id="owner-complaints-title">{{ __('owner-dashboard.complaints') }}</h2>
                    </div>
                    <span class="owner-dashboard__count whitespace-nowrap rounded-full bg-[#f0f5f2] px-[10px] py-[5px] text-[11px] text-[#66776f]">{{ __('owner-dashboard.complaint_count', ['count' => $reports->total()]) }}</span>
                </div>

                <form class="owner-dashboard__complaint-form rounded-xl border border-[#e6eee9] bg-[#fbfdfb] p-[18px]" method="post" action="{{ route('owner.complaints.store') }}">
                    @csrf
                    <p class="mb-4 mt-0 text-xs leading-[1.8] text-[var(--muted)]">{{ __('owner-dashboard.complaint_intro') }}</p>
                    <div class="owner-dashboard__complaint-grid grid grid-cols-2 gap-[14px]">
                        <label class="flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] [&_b]:text-[#bd5d48]">
                            <span>{{ __('owner-dashboard.complaint_subject') }} <b>*</b></span>
                            <select class="w-full min-w-0 rounded-lg border border-[#dce7e1] bg-white px-[11px] py-[9px] text-xs text-[var(--ink)] outline-none focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)] min-h-[42px]" name="subject_type" required>
                                <option value="owner" @selected(old('subject_type') === 'owner')>{{ __('owner-dashboard.owner') }}</option>
                                <option value="tenant" @selected(old('subject_type') === 'tenant')>{{ __('owner-dashboard.tenant') }}</option>
                            </select>
                        </label>
                        <label class="flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] [&_b]:text-[#bd5d48]">
                            <span>{{ __('owner-dashboard.person_name') }} <b>*</b></span>
                            <input class="w-full min-w-0 rounded-lg border border-[#dce7e1] bg-white px-[11px] py-[9px] text-xs text-[var(--ink)] outline-none focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)] min-h-[42px]" name="subject_name" value="{{ old('subject_name') }}" placeholder="{{ __('owner-dashboard.person_name') }}" required maxlength="150">
                        </label>
                        <label class="flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] [&_b]:text-[#bd5d48]">
                            <span>{{ __('owner-dashboard.complaint_contact') }}</span>
                            <input class="w-full min-w-0 rounded-lg border border-[#dce7e1] bg-white px-[11px] py-[9px] text-xs text-[var(--ink)] outline-none focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)] min-h-[42px]" name="subject_contact" value="{{ old('subject_contact') }}" placeholder="{{ __('owner-dashboard.optional') }}" maxlength="120">
                        </label>
                        <label class="flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] [&_b]:text-[#bd5d48]">
                            <span>{{ __('owner-dashboard.complaint_type') }} <b>*</b></span>
                            <select class="w-full min-w-0 rounded-lg border border-[#dce7e1] bg-white px-[11px] py-[9px] text-xs text-[var(--ink)] outline-none focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)] min-h-[42px]" name="type" required>
                                <option value="behavior" @selected(old('type') === 'behavior')>{{ __('owner-dashboard.behavior') }}</option>
                                <option value="fraud" @selected(old('type') === 'fraud')>{{ __('owner-dashboard.fraud') }}</option>
                                <option value="harassment" @selected(old('type') === 'harassment')>{{ __('owner-dashboard.harassment') }}</option>
                                <option value="other" @selected(old('type') === 'other')>{{ __('owner-dashboard.other') }}</option>
                            </select>
                        </label>
                        <label class="owner-dashboard__complaint-details col-span-full flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] max-[640px]:col-auto">
                            <span>{{ __('owner-dashboard.complaint_details') }} <b>*</b></span>
                            <textarea class="w-full min-w-0 resize-y rounded-lg border border-[#dce7e1] bg-white px-[11px] py-[9px] text-xs text-[var(--ink)] outline-none focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)] min-h-[42px]" name="details" rows="4" placeholder="{{ __('owner-dashboard.complaint_details_placeholder') }}" required maxlength="3000">{{ old('details') }}</textarea>
                        </label>
                    </div>
                    <button class="mt-[15px] inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" type="submit">{{ __('owner-dashboard.submit_complaint') }}</button>
                </form>

                <div class="owner-dashboard__complaint-list mt-6">
                    <h3 class="mb-3 mt-0 text-sm text-[var(--ink)]">{{ __('owner-dashboard.previous_complaints') }}</h3>
                    @forelse ($reports as $report)
                        <article class="owner-dashboard__complaint-item border-b border-[#edf1ee] py-[14px] last-of-type:border-b-0">
                            <div class="owner-dashboard__complaint-meta flex items-center justify-between gap-3">
                                <div class="flex flex-wrap items-baseline gap-2">
                                    <strong class="text-xs text-[#263b32]">{{ $report->subject_type === 'property' ? ($report->property?->title ?? __('owner-dashboard.property_report')) : ($report->subject_type === 'owner' ? __('owner-dashboard.owner_complaint') : __('owner-dashboard.tenant_complaint')) }}</strong>
                                    @if ($report->subject_name)
                                        <span class="text-[11px] text-[#78867f]">{{ $report->subject_name }}</span>
                                    @endif
                                </div>
                                <span class="owner-dashboard__status inline-flex items-center whitespace-nowrap rounded-full px-[9px] py-1 text-[10px] font-bold {{ $report->status === 'resolved' ? 'bg-[#e7f5ed] text-[#26754f]' : 'bg-[#fff4e2] text-[#94621b]' }}">
                                    {{ $report->status === 'resolved' ? __('owner-dashboard.resolved') : __('owner-dashboard.under_review') }}
                                </span>
                            </div>
                            <p class="my-[10px] mb-[6px] whitespace-pre-line text-xs leading-[1.9] text-[#52675e]">{{ $report->details ?: __('owner-dashboard.no_details') }}</p>
                            <small class="text-[10px] text-[#8a9690]">{{ $report->created_at->format('Y-m-d H:i') }}</small>
                        </article>
                    @empty
                        <div class="owner-dashboard__complaint-empty rounded-[9px] bg-[#f8faf8] px-3 py-[18px] text-center text-xs text-[#77857d]">{{ __('owner-dashboard.no_complaints') }}</div>
                    @endforelse
                    @if ($reports->hasPages())
                        <div class="owner-dashboard__complaint-pagination mt-3">{{ $reports->fragment('owner-complaints')->links() }}</div>
                    @endif
                </div>
            </section>

            <section class="owner-dashboard__panel owner-dashboard__subscription mt-5 rounded-2xl border border-[#e2eae5] bg-white px-6 py-[23px] shadow-[0_7px_24px_rgba(24,59,44,0.035)] max-[850px]:p-5" aria-labelledby="owner-subscription-title">
                <div class="owner-dashboard__panel-heading mb-[18px] flex items-center justify-between gap-[14px]">
                    <div>
                        <span class="owner-dashboard__eyebrow text-[10px] font-bold text-[#82928a]">{{ __('owner-dashboard.subscription_visibility') }}</span>
                        <h2 class="mt-px mb-0 text-[19px] text-[var(--ink)]" id="owner-subscription-title">{{ __('owner-dashboard.monthly_subscription') }}</h2>
                    </div>
                </div>
                <p class="mb-4 mt-[-5px] text-xs text-[var(--muted)]">{{ __('owner-dashboard.subscription_info') }}</p>
                <a class="inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" href="{{ route('owner.subscription') }}">{{ __('owner-dashboard.manage_subscription') }}</a>
            </section>
        </div>
    </main>
@endsection
