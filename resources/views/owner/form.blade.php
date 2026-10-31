@extends('layouts.app')

@section('content')
    <section class="owner-property-page min-h-[calc(100vh-76px)] bg-[#f5f8f6] bg-[image:radial-gradient(ellipse_at_12%_10%,rgba(223,245,233,0.75),transparent_34%)] py-12 pb-16 max-[640px]:py-[30px] max-[640px]:pb-[42px] py-8">
        <div class="owner-property-wrap max-w-[960px] mx-auto px-[22px]">
            <header class="owner-property-heading mb-6 flex items-center justify-between gap-6 max-[640px]:items-start max-[640px]:flex-col max-[640px]:gap-[14px]">
                <div>
                    <span class="owner-property-eyebrow mb-[6px] inline-block text-xs font-bold text-[#176b52]">{{ __('owner-property.eyebrow') }}</span>
                    <h1 class="mb-[6px] text-[clamp(26px,4vw,34px)] leading-[1.35] text-[#14231f]">{{ $property ? __('owner-property.edit_title') : __('owner-property.create_title') }}</h1>
                    <p class="m-0 text-sm leading-[1.8] text-[#697873]">{{ __('owner-property.intro') }}</p>
                </div>
                <a class="owner-property-back shrink-0 rounded-[10px] border border-[#dbe7e1] bg-white px-[14px] py-[10px] text-xs font-bold text-[#176b52] transition-colors hover:border-[#a8caba] hover:bg-[#fafffc]" href="{{ route('owner.dashboard') }}">{{ __('owner-property.back') }}</a>
            </header>

            <div class="owner-property-card overflow-hidden rounded-[18px] border border-[#e1ebe5] bg-white shadow-[0_16px_42px_rgba(23,78,56,0.07)]">
                <form
                    class="owner-property-form px-[34px] pt-2 pb-7 max-[640px]:px-[18px] max-[640px]:pt-1 max-[640px]:pb-5"
                    method="post"
                    enctype="multipart/form-data"
                    action="{{ $property ? route('owner.properties.update', $property) : route('owner.properties.store') }}"
                >
                    @csrf
                    @if ($property)
                        @method('PUT')
                    @endif

                    <section class="owner-property-section border-b border-[#edf2ef] py-7 max-[640px]:py-[23px]" aria-labelledby="property-details-heading">
                        <div class="owner-property-section-heading mb-5 flex items-start gap-[13px]">
                            <span class="owner-property-step grid size-[34px] shrink-0 place-items-center rounded-[10px] border border-[#d5eade] bg-[#f1faf5] text-[11px] font-extrabold text-[#176b52]">01</span>
                            <div>
                                <h2 class="mb-[3px] text-[17px] leading-[1.5] text-[#20372f]" id="property-details-heading">{{ __('owner-property.details') }}</h2>
                                <p class="m-0 text-xs leading-[1.7] text-[#81908a]">{{ __('owner-property.details_intro') }}</p>
                            </div>
                        </div>

                        <div class="owner-property-grid grid grid-cols-2 gap-x-[18px] gap-y-[17px] max-[640px]:grid-cols-1 max-[640px]:gap-[14px]">
                            <label class="owner-property-field owner-property-field--full col-span-full max-[640px]:col-auto flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.listing_title') }} <b>*</b></span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="title" placeholder="{{ __('owner-property.example_title') }}" value="{{ old('title', $property->title ?? '') }}" required>
                            </label>
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.listing_type') }} <b>*</b></span>
                                <select class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="purpose" required>
                                    <option value="rent" @selected(old('purpose', $property->purpose ?? 'rent') === 'rent')>{{ __('owner-property.rent') }}</option>
                                    <option value="sale" @selected(old('purpose', $property->purpose ?? '') === 'sale')>{{ __('owner-property.sale') }}</option>
                                </select>
                            </label>
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.property_type') }} <b>*</b></span>
                                <select class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="category" required>
                                    <option value="residential" @selected(old('category', $property->category ?? 'residential') === 'residential')>{{ __('owner-property.residential') }}</option>
                                    <option value="commercial" @selected(old('category', $property->category ?? '') === 'commercial')>{{ __('owner-property.commercial') }}</option>
                                </select>
                            </label>
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.city') }} <b>*</b></span>
                                <select class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="city" required>
                                    <option value="Damascus" @selected(old('city', $property->city ?? 'Damascus') === 'Damascus')>{{ __('owner-property.damascus') }}</option>
                                    <option value="Jaramana" @selected(old('city', $property->city ?? '') === 'Jaramana')>{{ __('owner-property.jaramana') }}</option>
                                    <option value="Sahnaya" @selected(old('city', $property->city ?? '') === 'Sahnaya')>{{ __('owner-property.sahnaya') }}</option>
                                </select>
                            </label>
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.neighborhood') }} <b>*</b></span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="neighborhood" placeholder="{{ __('owner-property.neighborhood_placeholder') }}" value="{{ old('neighborhood', $property->neighborhood ?? '') }}" required>
                            </label>
                            <label class="owner-property-field owner-property-field--full col-span-full max-[640px]:col-auto flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.address') }} <small>{{ __('owner-property.optional') }}</small></span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="address" placeholder="{{ __('owner-property.address_placeholder') }}" value="{{ old('address', $property->address ?? '') }}">
                            </label>
                        </div>
                    </section>

                    <section class="owner-property-section border-b border-[#edf2ef] py-7 max-[640px]:py-[23px]" aria-labelledby="property-specs-heading">
                        <div class="owner-property-section-heading mb-5 flex items-start gap-[13px]">
                            <span class="owner-property-step grid size-[34px] shrink-0 place-items-center rounded-[10px] border border-[#d5eade] bg-[#f1faf5] text-[11px] font-extrabold text-[#176b52]">02</span>
                            <div>
                                <h2 class="mb-[3px] text-[17px] leading-[1.5] text-[#20372f]" id="property-specs-heading">{{ __('owner-property.price_specs') }}</h2>
                                <p class="m-0 text-xs leading-[1.7] text-[#81908a]">{{ __('owner-property.price_specs_intro') }}</p>
                            </div>
                        </div>

                        <div class="owner-property-grid grid grid-cols-2 gap-x-[18px] gap-y-[17px] max-[640px]:grid-cols-1 max-[640px]:gap-[14px]">
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.price') }} <b>*</b></span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" type="number" step="0.01" min="0" name="price" placeholder="{{ __('owner-property.price_placeholder') }}" value="{{ old('price', $property->price ?? '') }}" required>
                            </label>
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.currency') }}</span>
                                <select class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="currency">
                                    <option value="USD" @selected(old('currency', $property->currency ?? 'USD') === 'USD')>{{ __('owner-property.usd') }}</option>
                                    <option value="SYP" @selected(old('currency', $property->currency ?? '') === 'SYP')>{{ __('owner-property.syp') }}</option>
                                </select>
                            </label>
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.bedrooms') }}</span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" type="number" min="0" max="20" name="bedrooms" placeholder="{{ __('owner-property.example_3') }}" value="{{ old('bedrooms', $property->bedrooms ?? '') }}">
                            </label>
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.bathrooms') }}</span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" type="number" min="0" max="20" name="bathrooms" placeholder="{{ __('owner-property.example_2') }}" value="{{ old('bathrooms', $property->bathrooms ?? '') }}">
                            </label>
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.floor') }}</span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" type="number" min="-2" max="100" name="floor" placeholder="{{ __('owner-property.floor_number') }}" value="{{ old('floor', $property->floor ?? '') }}">
                            </label>
                            <label class="owner-property-field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.area') }} <small>{{ __('owner-property.square_meters') }}</small></span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" type="number" min="1" name="area" placeholder="{{ __('owner-property.example_120') }}" value="{{ old('area', $property->area ?? '') }}">
                            </label>
                            <label class="owner-property-field owner-property-field--full col-span-full max-[640px]:col-auto flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.amenities') }} <small>{{ __('owner-property.comma_separated') }}</small></span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="amenities" placeholder="{{ __('owner-property.amenities_placeholder') }}" value="{{ old('amenities', implode(', ', $property->amenities ?? [])) }}">
                            </label>
                            <label class="owner-property-field owner-property-field--full col-span-full max-[640px]:col-auto flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.description') }} <b>*</b></span>
                                <textarea class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)] resize-y" name="description" rows="5" placeholder="{{ __('owner-property.description_placeholder') }}" required>{{ old('description', $property->description ?? '') }}</textarea>
                            </label>
                        </div>

                        <div class="owner-property-options flex flex-wrap gap-x-6 gap-y-3 pt-5">
                            <label class="owner-property-check inline-flex cursor-pointer items-center gap-[9px] text-xs text-[#43574f]">
                                <input class="m-0 size-[17px] accent-[#176b52]" type="checkbox" name="furnished" value="1" @checked(old('furnished', $property?->furnished))>
                                <span>{{ __('owner-property.furnished') }}</span>
                            </label>
                            <label class="owner-property-check inline-flex cursor-pointer items-center gap-[9px] text-xs text-[#43574f]">
                                <input class="m-0 size-[17px] accent-[#176b52]" type="checkbox" name="reward_available" value="1" @checked(old('reward_available', $property?->reward_available))>
                                <span>{{ __('owner-property.optional_reward') }}</span>
                            </label>
                        </div>
                    </section>

                    <section class="owner-property-section border-b border-[#edf2ef] py-7 max-[640px]:py-[23px]" aria-labelledby="property-media-heading">
                        <div class="owner-property-section-heading mb-5 flex items-start gap-[13px]">
                            <span class="owner-property-step grid size-[34px] shrink-0 place-items-center rounded-[10px] border border-[#d5eade] bg-[#f1faf5] text-[11px] font-extrabold text-[#176b52]">03</span>
                            <div>
                                <h2 class="mb-[3px] text-[17px] leading-[1.5] text-[#20372f]" id="property-media-heading">{{ __('owner-property.media') }}</h2>
                                <p class="m-0 text-xs leading-[1.7] text-[#81908a]">{{ __('owner-property.media_intro') }}</p>
                            </div>
                        </div>

                        <div class="owner-property-grid grid grid-cols-2 gap-x-[18px] gap-y-[17px] max-[640px]:grid-cols-1 max-[640px]:gap-[14px]">
                            <label class="owner-property-field owner-property-field--full col-span-full max-[640px]:col-auto flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.photos') }} <small>{{ __('owner-property.up_to_12_photos') }}</small></span>
                                <input class="owner-property-control block min-h-[50px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-[7px] py-[10px] font-[inherit] text-[13px] font-normal text-[#697873] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)] file:me-3 file:rounded-md file:border-0 file:bg-[#eaf5ee] file:px-3 file:py-2 file:text-xs file:text-[#176b52]" type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple>
                            </label>
                            <label class="owner-property-field owner-property-field--full col-span-full max-[640px]:col-auto flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.video') }} <small>{{ __('owner-property.optional') }}</small></span>
                                <input class="owner-property-control block min-h-[50px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-[7px] py-[10px] font-[inherit] text-[13px] font-normal text-[#697873] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)] file:me-3 file:rounded-md file:border-0 file:bg-[#eaf5ee] file:px-3 file:py-2 file:text-xs file:text-[#176b52]" type="file" name="video" accept="video/mp4,video/webm,video/quicktime">
                            </label>
                            <label class="owner-property-field owner-property-field--full col-span-full max-[640px]:col-auto flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#344b42] [&_b]:text-[#bd5d48] [&_small]:ms-1 [&_small]:text-[11px] [&_small]:font-normal [&_small]:text-[#89958f]">
                                <span>{{ __('owner-property.video_url') }} <small>{{ __('owner-property.optional') }}</small></span>
                                <input class="owner-property-control block min-h-[46px] w-full rounded-[9px] border border-[#dce7e1] bg-white px-3 py-[10px] font-[inherit] text-[13px] font-normal text-[#23382f] outline-none transition-[border-color,box-shadow] placeholder:text-[#a1aca7] focus:border-[#6ca88b] focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" type="url" name="video_url" placeholder="https://..." value="{{ old('video_url', $property->video_url ?? '') }}">
                            </label>
                        </div>

                        @if ($property && $property->media)
                            <div class="owner-property-media-preview mt-[18px] grid grid-cols-[repeat(auto-fill,minmax(110px,1fr))] gap-[10px]">
                                @foreach ($property->media as $image)
                                    <img class="h-[100px] w-full rounded-[9px] border border-[#e1ebe5] object-cover" src="{{ asset('storage/' . $image) }}" alt="{{ __('owner-property.image_alt') }}">
                                @endforeach
                            </div>
                        @endif
                    </section>

                    <div class="owner-property-actions flex items-center justify-between gap-4 pt-[22px] max-[640px]:items-stretch max-[640px]:flex-col-reverse">
                        <p class="m-0 text-[11px] text-[#84918b]"><b class="text-[#bd5d48">*</b> {{ __('owner-property.required') }}</p>
                        <button class="min-h-[46px] rounded-[10px] max-[640px]:w-full inline-block cursor-pointer border-0 bg-[var(--green)] py-[9px] font-[inherit] text-[13px] font-bold text-white" type="submit">{{ $property ? __('owner-property.save_changes') : __('owner-property.submit_review') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
