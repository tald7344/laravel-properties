@extends('layouts.app')
@section('content')
    <main class="home-page">
        <section class="home-hero">
            <div class="wrap home-hero-grid">
                <div class="home-hero-copy"><span class="eyebrow">{{ __('home.brand') }}</span>
                    <h1>{{ __('home.hero_title') }}<br><em>{{ __('home.hero_title_emphasis') }}</em></h1>
                    <p>{{ __('home.hero_description') }}</p><a
                        class="btn home-hero-btn" href="{{ route('properties.index') }}">{{ __('home.explore_properties') }} <span>←</span></a>
                </div>
                <div class="home-hero-art">
                    <div class="hero-orb"></div>
                    <div class="hero-house">
                        <div class="house-roof"></div>
                        <div class="house-body"><i></i><i></i><b></b></div>
                        <div class="house-window"></div>
                        <div class="house-door"></div>
                    </div>
                    <div class="hero-plant plant-one">♧</div>
                    <div class="hero-plant plant-two">♧</div>
                </div>
            </div>
            <div class="wrap home-search-wrap">
                <form class="home-search" method="get" action="{{ route('properties.index') }}">
                    <div class="home-search-field"><span>⌕</span><label>{{ __('home.search_label') }}</label><input name="neighborhood"
                            placeholder="{{ __('home.search_placeholder') }}"></div>
                    <div class="home-search-field"><label>{{ __('home.transaction_type') }}</label><select name="purpose">
                            <option value="">{{ __('home.all_transactions') }}</option>
                            <option value="rent">{{ __('home.rent') }}</option>
                            <option value="sale">{{ __('home.sale') }}</option>
                        </select></div>
                    <div class="home-search-field"><label>{{ __('home.property_type') }}</label><select name="category">
                            <option value="">{{ __('home.all_types') }}</option>
                            <option value="residential">{{ __('home.residential') }}</option>
                            <option value="commercial">{{ __('home.commercial') }}</option>
                        </select></div><button class="btn" type="submit">{{ __('home.search_button') }}</button>
                </form>
            </div>
        </section>
        <section class="home-trust">
            <div class="wrap home-trust-grid">
                <div class="home-trust-copy"><span class="eyebrow">{{ __('home.why_dark') }}</span>
                    <h2>{{ __('home.local_experience') }}<br><em>{{ __('home.local_experience_emphasis') }}</em></h2>
                    <p>{{ __('home.trust_description') }}</p><a
                        class="text-link" href="{{ route('properties.index') }}">{{ __('home.learn_platform') }} <span>←</span></a>
                </div>
                <div class="home-trust-image">
                    <div class="mini-building">⌂</div>
                </div>
                <div class="home-metrics">
                    <div><strong>{{ $stats['properties'] }}+</strong><span>{{ __('home.listed_property') }}</span></div>
                    <div><strong>{{ $stats['owners'] }}+</strong><span>{{ __('home.registered_owner') }}</span></div>
                    <div><strong>100%</strong><span>{{ __('home.direct_contact') }}</span></div>
                    <div><strong>24/7</strong><span>{{ __('home.available_browsing') }}</span></div>
                </div>
            </div>
        </section>
        <section class="home-section home-listings">
            <div class="wrap">
                <div class="home-section-heading">
                    <div><span class="eyebrow">{{ __('home.discover') }}</span>
                        <h2>{{ __('home.trending_properties') }}</h2>
                        <p>{{ __('home.latest_listings') }}</p>
                    </div><a class="btn alt" href="{{ route('properties.index') }}">{{ __('home.view_all') }}</a>
                </div>
                <div class="home-listing-grid">
                    @forelse($top->take(3) as $property)
                        @php($image = $property->imageUrl())
                        <a class="home-listing-card" href="{{ route('properties.show', $property) }}">
                            <div class="home-listing-image">
                                @if ($image)
                                <img src="{{ $image }}" alt="{{ $property->title }}">@else<div
                                        class="listing-placeholder">⌂</div>
                                @endif
                                <span>
                                    {{ $property->purpose === 'rent' ? __('home.rent') : __('home.sale') }}</span><b>♡</b>
                            </div>
                            <div class="home-listing-body"><strong>{{ number_format($property->price) }}
                                    {{ $property->currency }}</strong>
                                <h3>{{ $property->title }}</h3>
                                <p>{{ $property->city }} · {{ $property->neighborhood }}</p>
                                <small>{{ $property->bedrooms ?? '—' }} {{ __('home.bedrooms') }} · {{ $property->area ?? '—' }} {{ __('home.area_unit') }} ·
                                    {{ $property->furnished ? __('home.furnished') : __('home.unfurnished') }}</small>
                            </div>
                    </a>@empty<div class="panel">{{ __('home.no_properties') }}</div>
                    @endforelse
                </div>
            </div>
        </section>
        <section class="home-section home-services">
            <div class="wrap">
                <div class="home-section-heading centered">
                    <div><span class="eyebrow">{{ __('home.features') }}</span>
                        <h2>{{ __('home.everything_you_need') }}</h2>
                        <p>{{ __('home.features_description') }}</p>
                    </div>
                </div>
                <div class="home-service-grid">
                    <div class="home-service featured"><b>01</b><span>⌕</span>
                        <h3>{{ __('home.one_click_search') }}</h3>
                        <p>{{ __('home.smart_filters') }}</p><a
                            href="{{ route('properties.index') }}">{{ __('home.start_search') }} ←</a>
                    </div>
                    <div class="home-service"><b>02</b><span>⌂</span>
                        <h3>{{ __('home.trusted_listings') }}</h3>
                        <p>{{ __('home.real_listings') }}</p>
                    </div>
                    <div class="home-service"><b>03</b><span>♧</span>
                        <h3>{{ __('home.direct_communication') }}</h3>
                        <p>{{ __('home.no_middlemen') }}</p>
                    </div>
                    <div class="home-service"><b>04</b><span>✓</span>
                        <h3>{{ __('home.simple_experience') }}</h3>
                        <p>{{ __('home.all_details_one_page') }}</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="home-section home-cities">
            <div class="wrap">
                <div class="home-section-heading">
                    <div><span class="eyebrow">{{ __('home.selected_cities') }}</span>
                        <h2>{{ __('home.find_your_place') }}</h2>
                    </div><a class="text-link" href="{{ route('properties.index') }}">{{ __('home.all_cities') }} ←</a>
                </div>
                <div class="home-city-grid"><a href="{{ route('properties.index', ['city' => 'Damascus']) }}"
                        class="city-card city-damascus"><span>{{ __('home.damascus') }}</span><b>{{ __('home.explore_city') }} ↗</b></a><a
                        href="{{ route('properties.index', ['city' => 'Jaramana']) }}"
                        class="city-card city-jaramana"><span>{{ __('home.jaramana') }}</span><b>{{ __('home.explore_city') }} ↗</b></a><a
                        href="{{ route('properties.index', ['city' => 'Sahnaya']) }}"
                        class="city-card city-sahnaya"><span>{{ __('home.sahnaya') }}</span><b>{{ __('home.explore_city') }} ↗</b></a></div>
            </div>
        </section>
        <section class="home-testimonials">
            <div class="wrap">
                <div class="home-section-heading centered">
                    <div><span class="eyebrow">{{ __('home.user_reviews') }}</span>
                        <h2>{{ __('home.what_users_say') }}</h2>
                    </div>
                </div>
                <div class="testimonial-grid">
                    <article>
                        <div class="avatar">{{ __('home.reviewer_initial_one') }}</div>
                        <div><strong>{{ __('home.reviewer_one') }}</strong><small>{{ __('home.owner') }}</small></div>
                        <p>{{ __('home.review_one') }}</p><span>★★★★★</span>
                    </article>
                    <article class="testimonial-featured">
                        <div class="avatar">{{ __('home.reviewer_initial_two') }}</div>
                        <div><strong>{{ __('home.reviewer_two') }}</strong><small>{{ __('home.renter') }}</small></div>
                        <p>{{ __('home.review_two') }}</p><span>★★★★★</span>
                    </article>
                    <article>
                        <div class="avatar">{{ __('home.reviewer_initial_three') }}</div>
                        <div><strong>{{ __('home.reviewer_three') }}</strong><small>{{ __('home.renter') }}</small></div>
                        <p>{{ __('home.review_three') }}</p><span>★★★★★</span>
                    </article>
                </div>
            </div>
        </section>
        <section class="home-cta">
            <div class="wrap">
                <div><span class="eyebrow">{{ __('home.have_property') }}</span>
                    <h2>{{ __('home.ready_to_list') }}</h2>
                    <p>{{ __('home.join_owners') }}</p>
                </div><a class="btn" href="{{ route('auth.form') }}">{{ __('home.list_now') }} <span>←</span></a>
            </div>
        </section>
    </main>
@endsection
