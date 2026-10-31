@extends('layouts.app')

@section('content')
    @php($images = $property->mediaUrls())

    <section class="property-detail-section min-h-[calc(100vh-150px)] bg-[#f5f8f6] py-[34px] pb-16 max-[700px]:py-5 max-[700px]:pb-[42px]">
        <div class="property-detail grid gap-[22px] max-[420px]:px-[14px] mx-auto max-w-[1160px] px-[22px]">
            <div class="property-gallery-grid grid auto-rows-[180px] grid-cols-[minmax(0,1.65fr)_minmax(220px,1fr)] grid-rows-[repeat(2,minmax(170px,1fr))] gap-3 overflow-hidden rounded-[17px] max-[850px]:grid-cols-[minmax(0,1.4fr)_minmax(180px,1fr)] max-[700px]:grid-cols-[minmax(0,1.4fr)_minmax(110px,1fr)] max-[700px]:grid-rows-[repeat(2,minmax(120px,1fr))] max-[700px]:gap-2 max-[700px]:rounded-xl max-[420px]:grid-cols-2 max-[420px]:grid-rows-[190px_120px] @if (count($images) === 1) grid-cols-1 grid-rows-[minmax(300px,430px)] max-[850px]:grid-cols-1 max-[700px]:grid-cols-1 max-[700px]:grid-rows-[minmax(230px,320px)] max-[420px]:grid-cols-1 max-[420px]:grid-rows-[minmax(230px,320px)] @elseif (count($images) === 0) grid-cols-1 grid-rows-[auto] max-[850px]:grid-cols-1 max-[700px]:grid-cols-1 max-[420px]:grid-cols-1 max-[420px]:grid-rows-[auto] @endif">
                @forelse ($images as $index => $image)
                    <div class="property-gallery-image min-w-0 overflow-hidden bg-[#e4eee8] @if ($index === 0 && count($images) > 1) property-gallery-feature row-span-2 max-[420px]:col-span-full max-[420px]:row-auto @elseif ($index === 0) property-gallery-feature @elseif (count($images) === 2 && $index === 1) row-span-2 max-[420px]:col-span-full max-[420px]:row-auto @endif">
                        <img class="block size-full object-cover transition-transform duration-[350ms] ease-in-out hover:scale-[1.025]" src="{{ $image }}" alt="{{ __('property-details.image_alt', ['title' => $property->title, 'number' => $index + 1]) }}" @if ($index > 0) loading="lazy" @endif>
                    </div>
                @empty
                    <div class="property-gallery-placeholder col-span-full grid min-h-[330px] place-content-center bg-[#e4eee8] text-center text-[#779487]">
                        <span class="text-[54px]" aria-hidden="true">⌂</span>
                        <p class="mt-2 mb-0">{{ __('property-details.images_placeholder') }}</p>
                    </div>
                @endforelse
            </div>

            <div class="property-detail-layout grid grid-cols-[minmax(0,1fr)_350px] items-start gap-5 max-[850px]:grid-cols-[minmax(0,1fr)_300px] max-[700px]:grid-cols-1 max-[700px]:gap-[14px]">
                <article class="property-overview rounded-[15px] border-[#e0ebe5] p-7 shadow-[0_8px_24px_rgba(23,78,56,0.045)] max-[700px]:p-[22px] border bg-white">
                    <span class="inline-block rounded-full bg-[var(--mint)] px-[9px] py-1 text-xs font-bold text-[var(--green)]">{{ $property->purpose === 'rent' ? __('property-details.for_rent') : __('property-details.for_sale') }} · {{ $property->city }}</span>
                    <h1 class="my-[14px] mb-[6px] text-[clamp(24px,3vw,34px)] leading-[1.45]">{{ $property->title }}</h1>
                    <p class="property-address m-0 flex items-center gap-[7px] text-sm text-[var(--muted)]">
                        <span class="text-[var(--green)]" aria-hidden="true">⌖</span>
                        {{ $property->neighborhood }}@if ($property->address) · {{ $property->address }}@endif
                    </p>
                    <p class="property-description my-6 whitespace-pre-line leading-[2]">{{ $property->description }}</p>

                    <div class="property-facts grid grid-cols-4 border-t border-[#edf2ef] pt-5 max-[700px]:grid-cols-2 max-[700px]:gap-y-[14px]" aria-label="{{ __('property-details.features') }}">
                        <div class="grid gap-[7px] border-s border-[#edf2ef] px-[14px] first:border-s-0 first:ps-0"><span class="text-xs text-[var(--muted)]">{{ __('property-details.bedrooms') }}</span><strong class="text-sm">{{ $property->bedrooms ?? '—' }}</strong></div>
                        <div class="grid gap-[7px] border-s border-[#edf2ef] px-[14px]"><span class="text-xs text-[var(--muted)]">{{ __('property-details.floor') }}</span><strong class="text-sm">{{ $property->floor ?? '—' }}</strong></div>
                        <div class="grid gap-[7px] border-s border-[#edf2ef] px-[14px] max-[700px]:border-s-0 max-[700px]:ps-0"><span class="text-xs text-[var(--muted)]">{{ __('property-details.area') }}</span><strong class="text-sm">{{ $property->area ? __('property-details.sqm', ['area' => $property->area]) : '—' }}</strong></div>
                        <div class="grid gap-[7px] border-s border-[#edf2ef] px-[14px]"><span class="text-xs text-[var(--muted)]">{{ __('property-details.furnishing') }}</span><strong class="text-sm">{{ $property->furnished ? __('property-details.furnished') : __('property-details.unfurnished') }}</strong></div>
                    </div>

                    @if ($property->reward_available)
                        <div class="property-reward-notice mt-[22px] rounded-[9px] bg-[#fff8eb] px-[14px] py-3 text-[13px] leading-[1.8] text-[#805a21]">
                            {{ __('property-details.reward_notice') }}
                        </div>
                    @endif
                </article>

                <aside class="property-detail-sidebar sticky top-5 grid gap-[14px] max-[700px]:static">
                    <section class="property-contact rounded-[15px] border-[#e0ebe5] p-[22px] shadow-[0_8px_24px_rgba(23,78,56,0.045)] border bg-white" aria-labelledby="contact-heading">
                        <div class="property-price border-b border-[#edf2ef] pb-[18px]">
                            <span class="text-xs text-[var(--muted)]">{{ __('property-details.price') }}</span>
                            <h2 class="mt-[5px] mb-0 text-[27px] text-[var(--green)]">{{ number_format($property->price) }} <small class="text-sm">{{ $property->currency }}</small></h2>
                        </div>
                        @if ($contactEnabled)
                            <h3 class="mt-[18px] mb-[14px] text-base" id="contact-heading">{{ __('property-details.contact_owner') }}</h3>
                            <form method="post" action="{{ route('properties.contact', $property) }}" class="property-contact-form grid gap-[9px]">
                                @csrf
                                <label class="mt-1 text-xs font-bold" for="contact-phone">{{ __('property-details.your_phone') }}</label>
                                <input id="contact-phone" class="min-w-0 border-[#dbe7e1] px-3 py-[11px] text-[13px] w-full rounded-[10px] border bg-white font-[inherit]" name="phone" type="tel" autocomplete="tel" placeholder="{{ __('property-details.phone_placeholder') }}" required>
                                <label class="mt-1 text-xs font-bold" for="contact-message">{{ __('property-details.your_message') }} <span class="font-normal text-[var(--muted)]">{{ __('property-details.optional') }}</span></label>
                                <textarea class="min-w-0 resize-y rounded-[10px] border border-[#dbe7e1] bg-white px-3 py-[11px] font-[inherit] text-[13px]" id="contact-message" name="message" rows="4" placeholder="{{ __('property-details.message_placeholder') }}"></textarea>
                                <button class="mt-[5px] w-full inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" type="submit">{{ __('property-details.request_contact') }}</button>
                            </form>
                        @else
                            <p class="text-[var(--muted)]">{{ __('property-details.owner_unavailable') }}</p>
                        @endif
                    </section>

                    <details class="property-report rounded-[15px] border-[#e0ebe5] px-5 py-[17px] shadow-[0_8px_24px_rgba(23,78,56,0.045)] border bg-white">
                        <summary class="cursor-pointer text-[13px] font-bold text-[var(--ink)]">{{ __('property-details.report_problem') }}</summary>
                        <form method="post" action="{{ route('properties.report', $property) }}" class="property-report-form mt-4 grid gap-[9px]">
                            @csrf
                            <label class="mt-1 text-xs font-bold" for="report-type">{{ __('property-details.report_type') }}</label>
                            <select class="min-w-0 rounded-[10px] border border-[#dbe7e1] bg-white px-3 py-[11px] font-[inherit] text-[13px]" id="report-type" name="type">
                                <option value="old">{{ __('property-details.old_listing') }}</option>
                                <option value="suspicious">{{ __('property-details.suspicious_listing') }}</option>
                                <option value="impersonation">{{ __('property-details.impersonation') }}</option>
                                <option value="other">{{ __('property-details.other') }}</option>
                            </select>
                            <label class="mt-1 text-xs font-bold" for="report-details">{{ __('property-details.report_details') }}</label>
                            <textarea class="min-w-0 resize-y rounded-[10px] border border-[#dbe7e1] bg-white px-3 py-[11px] font-[inherit] text-[13px]" id="report-details" name="details" rows="3" placeholder="{{ __('property-details.report_placeholder') }}"></textarea>
                            <button class="mt-[3px] justify-self-start inline-block cursor-pointer rounded-[10px] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold border border-[#cadbd2] bg-transparent text-[var(--green)]" type="submit">{{ __('property-details.submit_report') }}</button>
                        </form>
                    </details>

                    <p class="property-confirmation m-0 text-xs leading-[1.8] text-[var(--muted)]">
                        {{ __('property-details.last_confirmed') }}
                        {{ optional($property->last_confirmed_at)->diffForHumans() ?? __('property-details.unspecified') }}
                    </p>
                </aside>
            </div>
        </div>
    </section>
@endsection
