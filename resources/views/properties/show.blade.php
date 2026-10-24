@extends('layouts.app')

@section('content')
    @php($images = $property->mediaUrls())

    <section class="property-detail-section">
        <div class="wrap property-detail">
            <div class="property-gallery-grid @if (count($images) === 1) has-one-image @elseif (count($images) === 0) has-no-images @endif">
                @forelse ($images as $index => $image)
                    <div class="property-gallery-image @if ($index === 0) property-gallery-feature @endif">
                        <img src="{{ $image }}" alt="{{ __('property-details.image_alt', ['title' => $property->title, 'number' => $index + 1]) }}" @if ($index > 0) loading="lazy" @endif>
                    </div>
                @empty
                    <div class="property-gallery-placeholder">
                        <span aria-hidden="true">⌂</span>
                        <p>{{ __('property-details.images_placeholder') }}</p>
                    </div>
                @endforelse
            </div>

            <div class="property-detail-layout">
                <article class="property-overview panel">
                    <span class="tag">{{ $property->purpose === 'rent' ? __('property-details.for_rent') : __('property-details.for_sale') }} · {{ $property->city }}</span>
                    <h1>{{ $property->title }}</h1>
                    <p class="property-address">
                        <span aria-hidden="true">⌖</span>
                        {{ $property->neighborhood }}@if ($property->address) · {{ $property->address }}@endif
                    </p>
                    <p class="property-description">{{ $property->description }}</p>

                    <div class="property-facts" aria-label="{{ __('property-details.features') }}">
                        <div><span>{{ __('property-details.bedrooms') }}</span><strong>{{ $property->bedrooms ?? '—' }}</strong></div>
                        <div><span>{{ __('property-details.floor') }}</span><strong>{{ $property->floor ?? '—' }}</strong></div>
                        <div><span>{{ __('property-details.area') }}</span><strong>{{ $property->area ? __('property-details.sqm', ['area' => $property->area]) : '—' }}</strong></div>
                        <div><span>{{ __('property-details.furnishing') }}</span><strong>{{ $property->furnished ? __('property-details.furnished') : __('property-details.unfurnished') }}</strong></div>
                    </div>

                    @if ($property->reward_available)
                        <div class="property-reward-notice">
                            {{ __('property-details.reward_notice') }}
                        </div>
                    @endif
                </article>

                <aside class="property-detail-sidebar">
                    <section class="property-contact panel" aria-labelledby="contact-heading">
                        <div class="property-price">
                            <span>{{ __('property-details.price') }}</span>
                            <h2>{{ number_format($property->price) }} <small>{{ $property->currency }}</small></h2>
                        </div>
                        <h3 id="contact-heading">{{ __('property-details.contact_owner') }}</h3>
                        <form method="post" action="{{ route('properties.contact', $property) }}" class="property-contact-form">
                            @csrf
                            <label for="contact-phone">{{ __('property-details.your_phone') }}</label>
                            <input id="contact-phone" class="field" name="phone" type="tel" autocomplete="tel" placeholder="{{ __('property-details.phone_placeholder') }}" required>
                            <label for="contact-message">{{ __('property-details.your_message') }} <span>{{ __('property-details.optional') }}</span></label>
                            <textarea id="contact-message" name="message" rows="4" placeholder="{{ __('property-details.message_placeholder') }}"></textarea>
                            <button class="btn" type="submit">{{ __('property-details.request_contact') }}</button>
                        </form>
                    </section>

                    <details class="property-report panel">
                        <summary>{{ __('property-details.report_problem') }}</summary>
                        <form method="post" action="{{ route('properties.report', $property) }}" class="property-report-form">
                            @csrf
                            <label for="report-type">{{ __('property-details.report_type') }}</label>
                            <select id="report-type" name="type">
                                <option value="old">{{ __('property-details.old_listing') }}</option>
                                <option value="suspicious">{{ __('property-details.suspicious_listing') }}</option>
                                <option value="impersonation">{{ __('property-details.impersonation') }}</option>
                                <option value="other">{{ __('property-details.other') }}</option>
                            </select>
                            <label for="report-details">{{ __('property-details.report_details') }}</label>
                            <textarea id="report-details" name="details" rows="3" placeholder="{{ __('property-details.report_placeholder') }}"></textarea>
                            <button class="btn outline" type="submit">{{ __('property-details.submit_report') }}</button>
                        </form>
                    </details>

                    <p class="property-confirmation">
                        {{ __('property-details.last_confirmed') }}
                        {{ optional($property->last_confirmed_at)->diffForHumans() ?? __('property-details.unspecified') }}
                    </p>
                </aside>
            </div>
        </div>
    </section>
@endsection
