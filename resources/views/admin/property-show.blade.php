@extends('admin.layout')
@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-4 max-[600px]:items-start max-[600px]:flex-col">
        <div><h1>{{ $property->title }}</h1><p class="text-sm text-[#697873]">{{ __('admin-properties.property_details_owner', ['name' => $property->owner->name]) }}</p></div>
        <a class="inline-block cursor-pointer rounded-xl border border-[#cadbd2] px-[18px] py-[11px] font-bold text-[#176b52]" href="{{ route('admin.properties.index') }}">{{ __('admin-properties.back_to_properties') }}</a>
    </div>
    <div class="grid grid-cols-2 gap-4 max-[700px]:grid-cols-1">
        <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
            <h2>{{ __('admin-properties.information') }}</h2>
            <p>{{ $property->description }}</p>
            <div class="meta">{{ $property->city }} · {{ $property->neighborhood }} · {{ $property->purpose === 'rent' ? __('admin-properties.for_rent') : __('admin-properties.for_sale') }} · {{ __("admin-properties.category_{$property->category}") }}</div>
            <div class="meta">{{ $property->bedrooms ?? '—' }} {{ __('admin-properties.bedrooms') }} · {{ $property->bathrooms ?? '—' }} {{ __('admin-properties.bathrooms') }} · {{ $property->area ?? '—' }} {{ __('admin-properties.area_unit') }} · {{ $property->furnished ? __('admin-properties.furnished') : __('admin-properties.unfurnished') }}</div>
            <h3>{{ number_format($property->price) }} {{ $property->currency }}</h3>
            <p>{{ __('admin-properties.amenities') }} {{ implode(__('admin-properties.amenity_separator'), $property->amenities ?? []) ?: '—' }}</p>
        </div>
        <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
            <h2>{{ __('admin-properties.status_heading') }}</h2>
            <p><span class="inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ __("admin-properties.status_{$property->status}") }}</span></p>
            <p class="text-sm text-[#697873]">{{ __('admin-properties.last_confirmed') }} {{ optional($property->last_confirmed_at)->diffForHumans() ?? '—' }}</p>
            <form method="post" action="{{ route('admin.moderate', $property) }}">
                @csrf
                <select name="status" class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]">
                    <option value="published">{{ __('admin-properties.publish') }}</option>
                    <option value="suspended">{{ __('admin-properties.suspend') }}</option>
                    <option value="expired">{{ __('admin-properties.expire') }}</option>
                </select>
                <button class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white">{{ __('admin-properties.save_status') }}</button>
            </form>
        </div>
    </div>
    <div class="mt-[18px] rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <h2>{{ __('admin-properties.photos_video') }}</h2>
        <div class="flex flex-wrap gap-3">
            @forelse ($property->media ?? [] as $image)
                <img class="h-[110px] w-[150px] rounded-[10px] border border-[var(--admin-line,#e4eeea)] object-cover" src="{{ asset('storage/'.$image) }}" alt="{{ __('admin-properties.property_image_alt') }}">
            @empty
                <p class="text-sm text-[#697873]">{{ __('admin-properties.no_uploaded_images') }}</p>
            @endforelse
        </div>
        @if ($property->video_url)
            <video class="mt-[14px] max-w-full" controls src="{{ str_starts_with($property->video_url, 'http') ? $property->video_url : asset('storage/'.$property->video_url) }}"></video>
        @endif
    </div>
@endsection
