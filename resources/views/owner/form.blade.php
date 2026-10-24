@extends('layouts.app')

@section('content')
    <section class="section owner-property-page">
        <div class="wrap owner-property-wrap">
            <header class="owner-property-heading">
                <div>
                    <span class="owner-property-eyebrow">{{ __('owner-property.eyebrow') }}</span>
                    <h1>{{ $property ? __('owner-property.edit_title') : __('owner-property.create_title') }}</h1>
                    <p>{{ __('owner-property.intro') }}</p>
                </div>
                <a class="owner-property-back" href="{{ route('owner.dashboard') }}">{{ __('owner-property.back') }}</a>
            </header>

            <div class="owner-property-card">
                <form
                    class="owner-property-form"
                    method="post"
                    enctype="multipart/form-data"
                    action="{{ $property ? route('owner.properties.update', $property) : route('owner.properties.store') }}"
                >
                    @csrf
                    @if ($property)
                        @method('PUT')
                    @endif

                    <section class="owner-property-section" aria-labelledby="property-details-heading">
                        <div class="owner-property-section-heading">
                            <span class="owner-property-step">01</span>
                            <div>
                                <h2 id="property-details-heading">{{ __('owner-property.details') }}</h2>
                                <p>{{ __('owner-property.details_intro') }}</p>
                            </div>
                        </div>

                        <div class="owner-property-grid">
                            <label class="owner-property-field owner-property-field--full">
                                <span>{{ __('owner-property.listing_title') }} <b>*</b></span>
                                <input class="owner-property-control" name="title" placeholder="{{ __('owner-property.example_title') }}" value="{{ old('title', $property->title ?? '') }}" required>
                            </label>
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.listing_type') }} <b>*</b></span>
                                <select class="owner-property-control" name="purpose" required>
                                    <option value="rent" @selected(old('purpose', $property->purpose ?? 'rent') === 'rent')>{{ __('owner-property.rent') }}</option>
                                    <option value="sale" @selected(old('purpose', $property->purpose ?? '') === 'sale')>{{ __('owner-property.sale') }}</option>
                                </select>
                            </label>
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.property_type') }} <b>*</b></span>
                                <select class="owner-property-control" name="category" required>
                                    <option value="residential" @selected(old('category', $property->category ?? 'residential') === 'residential')>{{ __('owner-property.residential') }}</option>
                                    <option value="commercial" @selected(old('category', $property->category ?? '') === 'commercial')>{{ __('owner-property.commercial') }}</option>
                                </select>
                            </label>
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.city') }} <b>*</b></span>
                                <select class="owner-property-control" name="city" required>
                                    <option value="Damascus" @selected(old('city', $property->city ?? 'Damascus') === 'Damascus')>{{ __('owner-property.damascus') }}</option>
                                    <option value="Jaramana" @selected(old('city', $property->city ?? '') === 'Jaramana')>{{ __('owner-property.jaramana') }}</option>
                                    <option value="Sahnaya" @selected(old('city', $property->city ?? '') === 'Sahnaya')>{{ __('owner-property.sahnaya') }}</option>
                                </select>
                            </label>
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.neighborhood') }} <b>*</b></span>
                                <input class="owner-property-control" name="neighborhood" placeholder="{{ __('owner-property.neighborhood_placeholder') }}" value="{{ old('neighborhood', $property->neighborhood ?? '') }}" required>
                            </label>
                            <label class="owner-property-field owner-property-field--full">
                                <span>{{ __('owner-property.address') }} <small>{{ __('owner-property.optional') }}</small></span>
                                <input class="owner-property-control" name="address" placeholder="{{ __('owner-property.address_placeholder') }}" value="{{ old('address', $property->address ?? '') }}">
                            </label>
                        </div>
                    </section>

                    <section class="owner-property-section" aria-labelledby="property-specs-heading">
                        <div class="owner-property-section-heading">
                            <span class="owner-property-step">02</span>
                            <div>
                                <h2 id="property-specs-heading">{{ __('owner-property.price_specs') }}</h2>
                                <p>{{ __('owner-property.price_specs_intro') }}</p>
                            </div>
                        </div>

                        <div class="owner-property-grid">
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.price') }} <b>*</b></span>
                                <input class="owner-property-control" type="number" step="0.01" min="0" name="price" placeholder="{{ __('owner-property.price_placeholder') }}" value="{{ old('price', $property->price ?? '') }}" required>
                            </label>
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.currency') }}</span>
                                <select class="owner-property-control" name="currency">
                                    <option value="USD" @selected(old('currency', $property->currency ?? 'USD') === 'USD')>{{ __('owner-property.usd') }}</option>
                                    <option value="SYP" @selected(old('currency', $property->currency ?? '') === 'SYP')>{{ __('owner-property.syp') }}</option>
                                </select>
                            </label>
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.bedrooms') }}</span>
                                <input class="owner-property-control" type="number" min="0" max="20" name="bedrooms" placeholder="{{ __('owner-property.example_3') }}" value="{{ old('bedrooms', $property->bedrooms ?? '') }}">
                            </label>
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.bathrooms') }}</span>
                                <input class="owner-property-control" type="number" min="0" max="20" name="bathrooms" placeholder="{{ __('owner-property.example_2') }}" value="{{ old('bathrooms', $property->bathrooms ?? '') }}">
                            </label>
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.floor') }}</span>
                                <input class="owner-property-control" type="number" min="-2" max="100" name="floor" placeholder="{{ __('owner-property.floor_number') }}" value="{{ old('floor', $property->floor ?? '') }}">
                            </label>
                            <label class="owner-property-field">
                                <span>{{ __('owner-property.area') }} <small>{{ __('owner-property.square_meters') }}</small></span>
                                <input class="owner-property-control" type="number" min="1" name="area" placeholder="{{ __('owner-property.example_120') }}" value="{{ old('area', $property->area ?? '') }}">
                            </label>
                            <label class="owner-property-field owner-property-field--full">
                                <span>{{ __('owner-property.amenities') }} <small>{{ __('owner-property.comma_separated') }}</small></span>
                                <input class="owner-property-control" name="amenities" placeholder="{{ __('owner-property.amenities_placeholder') }}" value="{{ old('amenities', implode(', ', $property->amenities ?? [])) }}">
                            </label>
                            <label class="owner-property-field owner-property-field--full">
                                <span>{{ __('owner-property.description') }} <b>*</b></span>
                                <textarea class="owner-property-control owner-property-description" name="description" rows="5" placeholder="{{ __('owner-property.description_placeholder') }}" required>{{ old('description', $property->description ?? '') }}</textarea>
                            </label>
                        </div>

                        <div class="owner-property-options">
                            <label class="owner-property-check">
                                <input type="checkbox" name="furnished" value="1" @checked(old('furnished', $property?->furnished))>
                                <span>{{ __('owner-property.furnished') }}</span>
                            </label>
                            <label class="owner-property-check">
                                <input type="checkbox" name="reward_available" value="1" @checked(old('reward_available', $property?->reward_available))>
                                <span>{{ __('owner-property.optional_reward') }}</span>
                            </label>
                        </div>
                    </section>

                    <section class="owner-property-section" aria-labelledby="property-media-heading">
                        <div class="owner-property-section-heading">
                            <span class="owner-property-step">03</span>
                            <div>
                                <h2 id="property-media-heading">{{ __('owner-property.media') }}</h2>
                                <p>{{ __('owner-property.media_intro') }}</p>
                            </div>
                        </div>

                        <div class="owner-property-grid">
                            <label class="owner-property-field owner-property-field--full">
                                <span>{{ __('owner-property.photos') }} <small>{{ __('owner-property.up_to_12_photos') }}</small></span>
                                <input class="owner-property-control owner-property-file" type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple>
                            </label>
                            <label class="owner-property-field owner-property-field--full">
                                <span>{{ __('owner-property.video') }} <small>{{ __('owner-property.optional') }}</small></span>
                                <input class="owner-property-control owner-property-file" type="file" name="video" accept="video/mp4,video/webm,video/quicktime">
                            </label>
                            <label class="owner-property-field owner-property-field--full">
                                <span>{{ __('owner-property.video_url') }} <small>{{ __('owner-property.optional') }}</small></span>
                                <input class="owner-property-control" type="url" name="video_url" placeholder="https://..." value="{{ old('video_url', $property->video_url ?? '') }}">
                            </label>
                        </div>

                        @if ($property && $property->media)
                            <div class="owner-property-media-preview">
                                @foreach ($property->media as $image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ __('owner-property.image_alt') }}">
                                @endforeach
                            </div>
                        @endif
                    </section>

                    <div class="owner-property-actions">
                        <p><b>*</b> {{ __('owner-property.required') }}</p>
                        <button class="btn" type="submit">{{ $property ? __('owner-property.save_changes') : __('owner-property.submit_review') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
