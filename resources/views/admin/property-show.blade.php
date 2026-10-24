@extends('admin.layout')
@section('admin-content')
    <div class="sectionhead">
        <div><h1>{{ $property->title }}</h1><p class="muted">{{ __('admin-properties.property_details_owner', ['name' => $property->owner->name]) }}</p></div>
        <a class="btn outline" href="{{ route('admin.properties.index') }}">{{ __('admin-properties.back_to_properties') }}</a>
    </div>
    <div class="detail">
        <div class="panel">
            <h2>{{ __('admin-properties.information') }}</h2>
            <p>{{ $property->description }}</p>
            <div class="meta">{{ $property->city }} · {{ $property->neighborhood }} · {{ $property->purpose === 'rent' ? __('admin-properties.for_rent') : __('admin-properties.for_sale') }} · {{ __("admin-properties.category_{$property->category}") }}</div>
            <div class="meta">{{ $property->bedrooms ?? '—' }} {{ __('admin-properties.bedrooms') }} · {{ $property->bathrooms ?? '—' }} {{ __('admin-properties.bathrooms') }} · {{ $property->area ?? '—' }} {{ __('admin-properties.area_unit') }} · {{ $property->furnished ? __('admin-properties.furnished') : __('admin-properties.unfurnished') }}</div>
            <h3>{{ number_format($property->price) }} {{ $property->currency }}</h3>
            <p>{{ __('admin-properties.amenities') }} {{ implode(__('admin-properties.amenity_separator'), $property->amenities ?? []) ?: '—' }}</p>
        </div>
        <div class="panel">
            <h2>{{ __('admin-properties.status_heading') }}</h2>
            <p><span class="tag">{{ __("admin-properties.status_{$property->status}") }}</span></p>
            <p class="muted">{{ __('admin-properties.last_confirmed') }} {{ optional($property->last_confirmed_at)->diffForHumans() ?? '—' }}</p>
            <form method="post" action="{{ route('admin.moderate', $property) }}">
                @csrf
                <select name="status">
                    <option value="published">{{ __('admin-properties.publish') }}</option>
                    <option value="suspended">{{ __('admin-properties.suspend') }}</option>
                    <option value="expired">{{ __('admin-properties.expire') }}</option>
                </select>
                <button class="btn">{{ __('admin-properties.save_status') }}</button>
            </form>
        </div>
    </div>
    <div class="panel" style="margin-top:18px">
        <h2>{{ __('admin-properties.photos_video') }}</h2>
        <div class="media-preview">
            @forelse ($property->media ?? [] as $image)
                <img src="{{ asset('storage/'.$image) }}" alt="{{ __('admin-properties.property_image_alt') }}">
            @empty
                <p class="muted">{{ __('admin-properties.no_uploaded_images') }}</p>
            @endforelse
        </div>
        @if ($property->video_url)
            <video controls style="max-width:100%;margin-top:14px" src="{{ str_starts_with($property->video_url, 'http') ? $property->video_url : asset('storage/'.$property->video_url) }}"></video>
        @endif
    </div>
@endsection
