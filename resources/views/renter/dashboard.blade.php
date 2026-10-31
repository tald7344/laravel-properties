@extends('layouts.app')

@section('content')
    <main class="renter-dashboard min-h-[calc(100vh-76px)] bg-[#f5f8f6] bg-[image:radial-gradient(ellipse_at_92%_0%,rgba(223,245,233,0.7),transparent_35%)] py-[42px] pb-16">
        <div class="renter-dashboard__container max-w-[1000px] mx-auto px-[22px]">
            <header class="renter-dashboard__heading mb-6 flex items-center justify-between gap-6 max-[640px]:items-start">
                <div>
                    <span class="inline-block rounded-full bg-[var(--mint)] px-[9px] py-1 text-xs font-bold text-[var(--green)]">{{ __('renter-dashboard.workspace') }}</span>
                    <h1 class="my-[9px] mb-[3px] text-[clamp(26px,3vw,34px)]">{{ __('renter-dashboard.greeting', ['name' => auth()->user()->name]) }}</h1>
                    <p class="m-0 text-[var(--muted)]">{{ __('renter-dashboard.intro') }}</p>
                </div>
                <a class="inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" href="{{ route('renter.profile.edit') }}">{{ __('renter-dashboard.profile') }}</a>
            </header>

            <section class="renter-dashboard__panel rounded-2xl border border-[#e2eae5] bg-white p-6 shadow-[0_7px_24px_rgba(24,59,44,0.035)] max-[640px]:p-[17px]" id="complaints" aria-labelledby="renter-complaints-title">
                <div class="renter-dashboard__panel-heading mb-[18px] flex items-center justify-between gap-[14px]">
                    <div>
                        <span class="renter-dashboard__eyebrow text-[10px] font-bold text-[#82928a]">{{ __('renter-dashboard.support') }}</span>
                        <h2 class="mt-px mb-0 text-[19px]" id="renter-complaints-title">{{ __('renter-dashboard.complaints') }}</h2>
                    </div>
                    <span class="renter-dashboard__count whitespace-nowrap rounded-full bg-[#f0f5f2] px-[10px] py-[5px] text-[11px] text-[#66776f]">{{ __('renter-dashboard.complaint_count', ['count' => $reports->total()]) }}</span>
                </div>

                <form class="renter-complaint-form rounded-xl border border-[#e6eee9] bg-[#fbfdfb] p-[18px]" method="post" action="{{ route('renter.complaints.store') }}">
                    @csrf
                    <p class="mb-4 mt-0 text-xs leading-[1.8] text-[var(--muted)]">{{ __('renter-dashboard.complaint_intro') }}</p>
                    <div class="renter-complaint-form__grid grid grid-cols-2 gap-[14px] max-[640px]:grid-cols-1">
                        <label class="flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] [&_b]:text-[#c55b4f]">
                            <span>{{ __('renter-dashboard.subject') }} <b>{{ __('renter-dashboard.required') }}</b></span>
                            <select class="w-full min-w-0 rounded-lg border border-[#dbe7e1] bg-white px-[11px] py-[10px] text-xs text-[var(--ink)]" name="subject_type" required>
                                <option value="owner" @selected(old('subject_type') === 'owner')>{{ __('renter-dashboard.owner') }}</option>
                                <option value="tenant" @selected(old('subject_type') === 'tenant')>{{ __('renter-dashboard.tenant') }}</option>
                            </select>
                        </label>
                        <label class="flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] [&_b]:text-[#c55b4f]">
                            <span>{{ __('renter-dashboard.person_name') }} <b>{{ __('renter-dashboard.required') }}</b></span>
                            <input class="w-full min-w-0 rounded-lg border border-[#dbe7e1] bg-white px-[11px] py-[10px] text-xs text-[var(--ink)]" name="subject_name" value="{{ old('subject_name') }}" maxlength="150" required>
                        </label>
                        <label class="flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] [&_b]:text-[#c55b4f]">
                            <span>{{ __('renter-dashboard.contact_hint') }}</span>
                            <input class="w-full min-w-0 rounded-lg border border-[#dbe7e1] bg-white px-[11px] py-[10px] text-xs text-[var(--ink)]" name="subject_contact" value="{{ old('subject_contact') }}" maxlength="120">
                        </label>
                        <label class="flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] [&_b]:text-[#c55b4f]">
                            <span>{{ __('renter-dashboard.type') }} <b>{{ __('renter-dashboard.required') }}</b></span>
                            <select class="w-full min-w-0 rounded-lg border border-[#dbe7e1] bg-white px-[11px] py-[10px] text-xs text-[var(--ink)]" name="type" required>
                                <option value="behavior" @selected(old('type') === 'behavior')>{{ __('renter-dashboard.behavior') }}</option>
                                <option value="fraud" @selected(old('type') === 'fraud')>{{ __('renter-dashboard.fraud') }}</option>
                                <option value="harassment" @selected(old('type') === 'harassment')>{{ __('renter-dashboard.harassment') }}</option>
                                <option value="other" @selected(old('type') === 'other')>{{ __('renter-dashboard.other') }}</option>
                            </select>
                        </label>
                        <label class="renter-complaint-form__details col-span-full max-[640px]:col-auto flex min-w-0 flex-col gap-[7px] text-[11px] font-bold text-[#43574f] [&_b]:text-[#c55b4f]">
                            <span>{{ __('renter-dashboard.details') }} <b>{{ __('renter-dashboard.required') }}</b></span>
                            <textarea class="w-full min-w-0 resize-y rounded-lg border border-[#dbe7e1] bg-white px-[11px] py-[10px] text-xs text-[var(--ink)]" name="details" rows="4" maxlength="3000" required>{{ old('details') }}</textarea>
                        </label>
                    </div>
                    <button class="mt-[15px] inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" type="submit">{{ __('renter-dashboard.submit') }}</button>
                </form>

                <div class="renter-dashboard__complaints mt-6">
                    <h3 class="mb-3 mt-0 text-[15px]">{{ __('renter-dashboard.previous') }}</h3>
                    @forelse ($reports as $report)
                        <article class="renter-complaint border-t border-[#edf1ee] py-[15px]">
                            <div class="renter-complaint__heading flex items-center justify-between gap-[14px]">
                                <div>
                                    <strong class="block text-xs">
                                        {{ $report->subject_type === 'property'
                                            ? __('renter-dashboard.property_report')
                                            : ($report->subject_type === 'owner' ? __('renter-dashboard.owner_complaint') : __('renter-dashboard.tenant_complaint')) }}
                                    </strong>
                                    <span class="mt-[3px] block text-[11px] text-[var(--muted)]">{{ $report->subject_type === 'property' ? ($report->property?->title ?? __('renter-dashboard.property')) : $report->subject_name }}</span>
                                </div>
                                <span class="renter-complaint__status rounded-full bg-[#f0f5f2] px-[10px] py-[5px] text-[11px] whitespace-nowrap text-[#66776f] {{ $report->status === 'resolved' ? 'is-resolved bg-[#e7f5ed] text-[#26754f]' : '' }}">
                                    {{ $report->status === 'resolved' ? __('renter-dashboard.resolved') : __('renter-dashboard.under_review') }}
                                </span>
                            </div>
                            <p class="my-3 mb-[7px] whitespace-pre-wrap text-xs leading-[1.8] text-[#52675e]">{{ $report->details }}</p>
                            <small class="text-[10px] text-[var(--muted)]">{{ $report->created_at->format('Y-m-d H:i') }}</small>
                        </article>
                    @empty
                        <p class="renter-dashboard__empty py-5 text-xs text-[var(--muted)]">{{ __('renter-dashboard.empty') }}</p>
                    @endforelse
                    @if ($reports->hasPages())
                        <div class="renter-dashboard__pagination mt-[15px]">{{ $reports->fragment('complaints')->links() }}</div>
                    @endif
                </div>
            </section>
        </div>
    </main>
@endsection
