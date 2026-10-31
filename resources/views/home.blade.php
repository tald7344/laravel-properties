@extends('layouts.app')
@section('content')
    <main class="home-page overflow-hidden bg-white text-[#1b2c29]">
        <section class="home-hero relative bg-[#f1f5f3] pt-[70px] pb-0 max-[600px]:pt-[35px]">
            <div class="home-hero-grid grid min-h-[390px] grid-cols-[.92fr_1.08fr] items-center max-[900px]:min-h-0 max-[900px]:grid-cols-1 mx-auto max-w-[1160px] px-[22px]">
                <div class="home-hero-copy [direction:rtl] pb-12 text-right max-[900px]:px-0 max-[900px]:pt-5 max-[900px]:pb-[5px] max-[900px]:text-center"><span class="eyebrow mb-[10px] block text-[11px] font-extrabold tracking-[1.4px] text-[var(--green)]">{{ __('home.brand') }}</span>
                    <h1 class="mb-[18px] mt-0 text-[56px] leading-[1.12] tracking-[-1.5px] max-[600px]:text-[40px]">{{ __('home.hero_title') }}<br><em class="not-italic text-[var(--green)]">{{ __('home.hero_title_emphasis') }}</em></h1>
                    <p class="mb-0 mt-0 max-w-[440px] text-[15px] leading-[1.9] text-[var(--muted)] max-[900px]:mx-auto">{{ __('home.hero_description') }}</p><a
                        class="home-hero-btn mt-3 inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" href="{{ route('properties.index') }}">{{ __('home.explore_properties') }} <span class="mr-3">←</span></a>
                </div>
                <div class="home-hero-art relative h-[390px] self-end max-[900px]:mt-[10px] max-[900px]:h-[280px] max-[600px]:mb-[-25px] max-[600px]:h-[220px] max-[600px]:origin-bottom max-[600px]:scale-[.82]">
                    <div class="hero-orb absolute bottom-0 right-[7%] h-[320px] w-[400px] rounded-[55%_45%_0_0] bg-[#e1ebe6] max-[600px]:right-0 max-[600px]:h-[240px] max-[600px]:w-[330px]"></div>
                    <div class="hero-house absolute bottom-0 right-[18%] h-[300px] w-[300px]">
                        <div class="house-roof"></div>
                        <div class="house-body"><i></i><i></i><b></b></div>
                        <div class="house-window"></div>
                        <div class="house-door"></div>
                    </div>
                    <div class="hero-plant plant-one absolute bottom-1 right-0 text-[105px] leading-none text-[#286b52]">♧</div>
                    <div class="hero-plant plant-two absolute bottom-1 left-[15%] text-[70px] leading-none text-[#286b52]">♧</div>
                </div>
            </div>
            <div class="home-search-wrap relative z-[2] mx-auto max-w-[1160px] px-[22px]">
                <form class="home-search -mt-10 grid grid-cols-[1.7fr_1fr_1fr_auto] items-center gap-0 rounded-[14px] border border-[#e2ebe7] bg-white p-2 shadow-[0_15px_35px_rgba(25,65,50,.1)] max-[900px]:grid-cols-2 max-[600px]:grid-cols-1 max-[600px]:p-[9px]" method="get" action="{{ route('properties.index') }}">
                    <div class="home-search-field border-l border-[#e8efec] px-[18px] py-2 text-right max-[900px]:col-span-full max-[900px]:border-l-0 max-[900px]:border-b max-[600px]:col-auto max-[600px]:border-b max-[600px]:px-3 max-[600px]:py-[11px]"><span class="float-right ml-2 text-[20px] text-[var(--green)]">⌕</span><label class="mb-[5px] block text-[10px] text-[var(--muted)]">{{ __('home.search_label') }}</label><input class="w-4/5 border-0 bg-transparent p-0 text-[13px] text-[var(--ink)] outline-none" name="neighborhood"
                            placeholder="{{ __('home.search_placeholder') }}"></div>
                    <div class="home-search-field border-l border-[#e8efec] px-[18px] py-2 text-right max-[600px]:border-l-0 max-[600px]:border-b max-[600px]:px-3 max-[600px]:py-[11px]"><label class="mb-[5px] block text-[10px] text-[var(--muted)]">{{ __('home.transaction_type') }}</label><select class="w-full border-0 bg-transparent p-0 text-[13px] text-[var(--ink)] outline-none" name="purpose">
                            <option value="">{{ __('home.all_transactions') }}</option>
                            <option value="rent">{{ __('home.rent') }}</option>
                            <option value="sale">{{ __('home.sale') }}</option>
                        </select></div>
                    <div class="home-search-field border-l border-[#e8efec] px-[18px] py-2 text-right max-[600px]:border-l-0 max-[600px]:border-b max-[600px]:px-3 max-[600px]:py-[11px] [&:last-of-type]:max-[600px]:border-b-0"><label class="mb-[5px] block text-[10px] text-[var(--muted)]">{{ __('home.property_type') }}</label><select class="w-full border-0 bg-transparent p-0 text-[13px] text-[var(--ink)] outline-none" name="category">
                            <option value="">{{ __('home.all_types') }}</option>
                            <option value="residential">{{ __('home.residential') }}</option>
                            <option value="commercial">{{ __('home.commercial') }}</option>
                        </select></div><button class="mx-[5px] whitespace-nowrap max-[900px]:m-2 max-[600px]:my-[6px] max-[600px]:mx-0 max-[600px]:w-full inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" type="submit">{{ __('home.search_button') }}</button>
                </form>
            </div>
        </section>
        <section class="home-trust py-[92px] pb-[74px] max-[600px]:py-[55px]">
            <div class="home-trust-grid grid grid-cols-[1fr_.8fr_1.15fr] items-center gap-[38px] [direction:rtl] max-[900px]:grid-cols-2 max-[600px]:grid-cols-1 mx-auto max-w-[1160px] px-[22px]">
                <div class="home-trust-copy [direction:rtl] text-right max-[900px]:col-span-full max-[900px]:text-center"><span class="eyebrow mb-[10px] block text-[11px] font-extrabold tracking-[1.4px] text-[var(--green)]">{{ __('home.why_dark') }}</span>
                    <h2 class="mb-[9px] mt-0 text-[32px] leading-[1.25]">{{ __('home.local_experience') }}<br><em class="not-italic text-[var(--green)]">{{ __('home.local_experience_emphasis') }}</em></h2>
                    <p class="mb-0 mt-0 text-[13px] leading-[1.9] text-[var(--muted)]">{{ __('home.trust_description') }}</p><a
                        class="text-link text-[12px] font-extrabold text-[var(--green)]" href="{{ route('properties.index') }}">{{ __('home.learn_platform') }} <span class="mr-2">←</span></a>
                </div>
                <div class="home-trust-image flex h-[220px] items-start justify-center overflow-hidden rounded-xl bg-[linear-gradient(135deg,#e8f1ed,#c9ded4)] max-[900px]:h-[200px] max-[600px]:h-[170px]">
                    <div class="mini-building text-[180px] leading-none text-white [text-shadow:15px_0_#d5e6de]">⌂</div>
                </div>
                <div class="home-metrics grid grid-cols-2 gap-3 [direction:rtl] max-[900px]:col-span-full max-[600px]:col-auto">
                    <div class="rounded-lg border border-[#e8eeeb] p-5 text-center [&:nth-child(2)]:bg-[#f5eee1]"><strong class="block text-[25px] text-[var(--green)]">{{ $stats['properties'] }}+</strong><span class="mt-1 block text-[11px] text-[var(--muted)]">{{ __('home.listed_property') }}</span></div>
                    <div class="rounded-lg border border-[#e8eeeb] p-5 text-center [&:nth-child(2)]:bg-[#f5eee1]"><strong class="block text-[25px] text-[var(--green)]">{{ $stats['owners'] }}+</strong><span class="mt-1 block text-[11px] text-[var(--muted)]">{{ __('home.registered_owner') }}</span></div>
                    <div class="rounded-lg border border-[#e8eeeb] p-5 text-center [&:nth-child(2)]:bg-[#f5eee1]"><strong class="block text-[25px] text-[var(--green)]">100%</strong><span class="mt-1 block text-[11px] text-[var(--muted)]">{{ __('home.direct_contact') }}</span></div>
                    <div class="rounded-lg border border-[#e8eeeb] p-5 text-center [&:nth-child(2)]:bg-[#f5eee1]"><strong class="block text-[25px] text-[var(--green)]">24/7</strong><span class="mt-1 block text-[11px] text-[var(--muted)]">{{ __('home.available_browsing') }}</span></div>
                </div>
            </div>
        </section>
        <section class="home-section home-listings bg-[#fbfcfb] py-[70px] max-[600px]:py-[50px]">
            <div class="mx-auto max-w-[1160px] px-[22px]">
                <div class="home-section-heading mb-[26px] flex items-end justify-between [direction:rtl] text-right max-[600px]:items-start">
                    <div><span class="eyebrow mb-[10px] block text-[11px] font-extrabold tracking-[1.4px] text-[var(--green)]">{{ __('home.discover') }}</span>
                        <h2 class="mb-1 mt-0 text-[31px] leading-[1.25]">{{ __('home.trending_properties') }}</h2>
                        <p class="mb-0 mt-0 text-[13px] text-[var(--muted)]">{{ __('home.latest_listings') }}</p>
                    </div><a class="max-[600px]:px-[10px] max-[600px]:py-2 max-[600px]:text-[10px] inline-block cursor-pointer rounded-[10px] border-0 px-[14px] py-[9px] font-[inherit] text-[13px] font-bold bg-[var(--mint)] text-[var(--green)]" href="{{ route('properties.index') }}">{{ __('home.view_all') }}</a>
                </div>
                <div class="home-listing-grid grid grid-cols-3 gap-5 max-[900px]:grid-cols-2 max-[600px]:grid-cols-1">
                    @forelse($top->take(3) as $property)
                        @php($image = $property->imageUrl())
                        <a class="home-listing-card overflow-hidden rounded-lg border border-[#e7ece9] bg-white transition-[transform,box-shadow] duration-200 hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(20,70,50,.1)]" href="{{ route('properties.show', $property) }}">
                            <div class="home-listing-image relative grid h-[210px] place-items-center overflow-hidden bg-[linear-gradient(135deg,#d3e8dc,#f0f5ef)] max-[600px]:h-[200px]">
                                @if ($image)
                                <img class="h-full w-full object-cover" src="{{ $image }}" alt="{{ $property->title }}">@else<div
                                        class="listing-placeholder text-[65px] text-[#8db5a2]">⌂</div>
                                @endif
                                <span class="absolute right-3 top-3 rounded-[5px] bg-white px-[9px] py-[5px] text-[10px] font-extrabold text-[var(--green)]">
                                    {{ $property->purpose === 'rent' ? __('home.rent') : __('home.sale') }}</span><b class="absolute bottom-3 left-[13px] grid h-[25px] w-[25px] place-items-center rounded-full bg-white text-[var(--green)]">♡</b>
                            </div>
                            <div class="home-listing-body [direction:rtl] p-[15px] text-right"><strong class="mb-2 block text-[18px] text-[var(--green)]">{{ number_format($property->price) }}
                                    {{ $property->currency }}</strong>
                                <h3 class="mb-[5px] mt-0 text-[15px]">{{ $property->title }}</h3>
                                <p class="my-[5px] block text-[11px] text-[var(--muted)]">{{ $property->city }} · {{ $property->neighborhood }}</p>
                                <small class="my-[5px] block text-[11px] text-[var(--muted)]">{{ $property->bedrooms ?? '—' }} {{ __('home.bedrooms') }} · {{ $property->area ?? '—' }} {{ __('home.area_unit') }} ·
                                    {{ $property->furnished ? __('home.furnished') : __('home.unfurnished') }}</small>
                            </div>
                    </a>@empty<div class="rounded-[17px] border border-[#e5ece8] bg-white p-[18px]">{{ __('home.no_properties') }}</div>
                    @endforelse
                </div>
            </div>
        </section>
        <section class="home-section home-services bg-[#f4f8f6] py-[70px] max-[600px]:py-[50px]">
            <div class="mx-auto max-w-[1160px] px-[22px]">
                <div class="home-section-heading centered mb-[26px] block text-center">
                    <div><span class="eyebrow mb-[10px] block text-[11px] font-extrabold tracking-[1.4px] text-[var(--green)]">{{ __('home.features') }}</span>
                        <h2 class="mb-1 mt-0 text-[31px] leading-[1.25]">{{ __('home.everything_you_need') }}</h2>
                        <p class="mb-0 mt-0 text-[13px] text-[var(--muted)]">{{ __('home.features_description') }}</p>
                    </div>
                </div>
                <div class="home-service-grid grid grid-cols-4 gap-[14px] [direction:rtl] max-[900px]:grid-cols-2 max-[600px]:grid-cols-1">
                    <div class="home-service relative min-h-[190px] rounded-lg border border-[#e2ebe6] p-5 text-right featured bg-[#1f2927] text-white"><b class="text-[11px] text-[#95a8a1]">01</b><span class="mb-[5px] mt-4 block text-[26px] text-[#e1ad67]">⌕</span>
                        <h3 class="mb-0 mt-0 text-[15px]">{{ __('home.one_click_search') }}</h3>
                        <p class="mt-0 text-[11px] leading-[1.8] text-[#c7d2ce]">{{ __('home.smart_filters') }}</p><a class="text-[11px] text-[#e1ad67]"
                            href="{{ route('properties.index') }}">{{ __('home.start_search') }} ←</a>
                    </div>
                    <div class="home-service relative min-h-[190px] rounded-lg border border-[#e2ebe6] bg-white p-5 text-right"><b class="text-[11px] text-[#95a8a1]">02</b><span class="mb-[5px] mt-4 block text-[26px] text-[var(--green)]">⌂</span>
                        <h3 class="mb-0 mt-0 text-[15px]">{{ __('home.trusted_listings') }}</h3>
                        <p class="mt-0 text-[11px] leading-[1.8] text-[var(--muted)]">{{ __('home.real_listings') }}</p>
                    </div>
                    <div class="home-service relative min-h-[190px] rounded-lg border border-[#e2ebe6] bg-white p-5 text-right"><b class="text-[11px] text-[#95a8a1]">03</b><span class="mb-[5px] mt-4 block text-[26px] text-[var(--green)]">♧</span>
                        <h3 class="mb-0 mt-0 text-[15px]">{{ __('home.direct_communication') }}</h3>
                        <p class="mt-0 text-[11px] leading-[1.8] text-[var(--muted)]">{{ __('home.no_middlemen') }}</p>
                    </div>
                    <div class="home-service relative min-h-[190px] rounded-lg border border-[#e2ebe6] bg-white p-5 text-right"><b class="text-[11px] text-[#95a8a1]">04</b><span class="mb-[5px] mt-4 block text-[26px] text-[var(--green)]">✓</span>
                        <h3 class="mb-0 mt-0 text-[15px]">{{ __('home.simple_experience') }}</h3>
                        <p class="mt-0 text-[11px] leading-[1.8] text-[var(--muted)]">{{ __('home.all_details_one_page') }}</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="home-section home-cities py-[70px] max-[600px]:py-[50px]">
            <div class="mx-auto max-w-[1160px] px-[22px]">
                <div class="home-section-heading mb-[26px] flex items-end justify-between [direction:rtl] text-right max-[600px]:items-start">
                    <div><span class="eyebrow mb-[10px] block text-[11px] font-extrabold tracking-[1.4px] text-[var(--green)]">{{ __('home.selected_cities') }}</span>
                        <h2 class="mb-[9px] mt-0 text-[31px] leading-[1.25]">{{ __('home.find_your_place') }}</h2>
                    </div><a class="text-link text-[12px] font-extrabold text-[var(--green)]" href="{{ route('properties.index') }}">{{ __('home.all_cities') }} ←</a>
                </div>
                <div class="home-city-grid grid grid-cols-[1.2fr_1fr_1fr] grid-rows-[180px_140px] gap-3 max-[600px]:grid-cols-2 max-[600px]:grid-rows-[170px_120px]"><a href="{{ route('properties.index', ['city' => 'Damascus']) }}"
                        class="city-card city-damascus relative flex flex-col items-start justify-end overflow-hidden rounded-[7px] bg-[linear-gradient(135deg,#4d8270,#d6a36f)] bg-cover bg-center p-[18px] text-white [grid-row:span_2] max-[600px]:col-span-full max-[600px]:[grid-row:auto]"><span class="relative text-[15px] font-extrabold">{{ __('home.damascus') }}</span><b class="relative mt-1 text-[10px]">{{ __('home.explore_city') }} ↗</b></a><a
                        href="{{ route('properties.index', ['city' => 'Jaramana']) }}"
                        class="city-card city-jaramana relative flex flex-col items-start justify-end overflow-hidden rounded-[7px] bg-[linear-gradient(135deg,#a9704d,#d6c8a1)] bg-cover bg-center p-[18px] text-white"><span class="relative text-[15px] font-extrabold">{{ __('home.jaramana') }}</span><b class="relative mt-1 text-[10px]">{{ __('home.explore_city') }} ↗</b></a><a
                        href="{{ route('properties.index', ['city' => 'Sahnaya']) }}"
                        class="city-card city-sahnaya relative flex flex-col items-start justify-end overflow-hidden rounded-[7px] bg-[linear-gradient(135deg,#436c76,#bacfc7)] bg-cover bg-center p-[18px] text-white"><span class="relative text-[15px] font-extrabold">{{ __('home.sahnaya') }}</span><b class="relative mt-1 text-[10px]">{{ __('home.explore_city') }} ↗</b></a></div>
            </div>
        </section>
        <section class="home-testimonials bg-white py-[74px]">
            <div class="mx-auto max-w-[1160px] px-[22px]">
                <div class="home-section-heading centered mb-[26px] block text-center">
                    <div><span class="eyebrow mb-[10px] block text-[11px] font-extrabold tracking-[1.4px] text-[var(--green)]">{{ __('home.user_reviews') }}</span>
                        <h2 class="mb-[9px] mt-0 text-[31px] leading-[1.25]">{{ __('home.what_users_say') }}</h2>
                    </div>
                </div>
                <div class="testimonial-grid grid grid-cols-3 gap-5 [direction:rtl] max-[600px]:grid-cols-1">
                    <article class="rounded-lg border border-[#edf0ee] px-5 py-[26px] text-center max-[600px]:hidden">
                        <div class="avatar mx-auto mb-[9px] grid h-[54px] w-[54px] place-items-center rounded-full border-2 border-[#b8d8c8] bg-[#eef7f1] text-[22px] text-[var(--green)]">{{ __('home.reviewer_initial_one') }}</div>
                        <div><strong class="block text-[13px]">{{ __('home.reviewer_one') }}</strong><small class="block text-[10px] text-[var(--muted)]">{{ __('home.owner') }}</small></div>
                        <p class="my-[18px] text-[11px] leading-[1.9] text-[var(--muted)]">{{ __('home.review_one') }}</p><span class="tracking-[3px] text-[#e4ab5d]">★★★★★</span>
                    </article>
                    <article class="testimonial-featured rounded-lg border border-[#d7e6de] px-5 py-[26px] text-center shadow-[0_10px_30px_rgba(20,70,50,.1)]">
                        <div class="avatar mx-auto mb-[9px] grid h-[54px] w-[54px] place-items-center rounded-full border-2 border-[#b8d8c8] bg-[#eef7f1] text-[22px] text-[var(--green)]">{{ __('home.reviewer_initial_two') }}</div>
                        <div><strong class="block text-[13px]">{{ __('home.reviewer_two') }}</strong><small class="block text-[10px] text-[var(--muted)]">{{ __('home.renter') }}</small></div>
                        <p class="my-[18px] text-[11px] leading-[1.9] text-[var(--muted)]">{{ __('home.review_two') }}</p><span class="tracking-[3px] text-[#e4ab5d]">★★★★★</span>
                    </article>
                    <article class="rounded-lg border border-[#edf0ee] px-5 py-[26px] text-center max-[600px]:hidden">
                        <div class="avatar mx-auto mb-[9px] grid h-[54px] w-[54px] place-items-center rounded-full border-2 border-[#b8d8c8] bg-[#eef7f1] text-[22px] text-[var(--green)]">{{ __('home.reviewer_initial_three') }}</div>
                        <div><strong class="block text-[13px]">{{ __('home.reviewer_three') }}</strong><small class="block text-[10px] text-[var(--muted)]">{{ __('home.renter') }}</small></div>
                        <p class="my-[18px] text-[11px] leading-[1.9] text-[var(--muted)]">{{ __('home.review_three') }}</p><span class="tracking-[3px] text-[#e4ab5d]">★★★★★</span>
                    </article>
                </div>
            </div>
        </section>
        <section class="home-cta bg-[#232725] py-[50px] text-white">
            <div class="flex items-center justify-between [direction:rtl] max-[600px]:block max-[600px]:text-center mx-auto max-w-[1160px] px-[22px]">
                <div><span class="eyebrow mb-[10px] block text-[11px] font-extrabold tracking-[1.4px] text-[var(--green)]">{{ __('home.have_property') }}</span>
                    <h2 class="mb-2 mt-0 text-[31px] leading-[1.25]">{{ __('home.ready_to_list') }}</h2>
                    <p class="mb-0 mt-0 text-[13px] text-[#b8c5bf]">{{ __('home.join_owners') }}</p>
                </div><a class="mt-0 bg-[#e3a85e] text-[#1b2c29] max-[600px]:mt-5 max-[600px]:w-full inline-block cursor-pointer rounded-[10px] border-0 px-[14px] py-[9px] font-[inherit] text-[13px] font-bold" href="{{ route('auth.form') }}">{{ __('home.list_now') }} <span class="mr-3">←</span></a>
            </div>
        </section>
    </main>
@endsection
