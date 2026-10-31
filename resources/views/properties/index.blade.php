@extends('layouts.app')
@section('content')
    @php
        $initial = [
            'data' => $properties->getCollection()->map(fn ($property) => [
                'id' => $property->id,
                'url' => route('properties.show', $property),
                'image' => $property->imageUrl(),
                'title' => $property->title,
                'city' => $property->city,
                'neighborhood' => $property->neighborhood,
                'purpose' => $property->purpose,
                'price' => $property->price,
                'currency' => $property->currency,
                'bedrooms' => $property->bedrooms,
                'area' => $property->area,
                'furnished' => $property->furnished,
                'owner' => $property->owner?->name,
            ])->values(),
            'total' => $properties->total(),
            'current_page' => $properties->currentPage(),
            'last_page' => $properties->lastPage(),
        ];
    @endphp
    <section class="min-h-[calc(100vh-76px)] bg-[#f5f8f6] pb-[70px] pt-[42px]">
        <div data-property-search
            data-endpoint="{{ route('properties.search') }}"
            data-listing-url="{{ route('properties.index') }}"
            data-cities="{{ json_encode($cities, JSON_HEX_APOS | JSON_HEX_QUOT) }}"
            data-filters="{{ json_encode($filters, JSON_HEX_APOS | JSON_HEX_QUOT) }}"
            data-initial="{{ json_encode($initial, JSON_HEX_APOS | JSON_HEX_QUOT) }}"
            data-translations="{{ json_encode(__('property-search'), JSON_HEX_APOS | JSON_HEX_QUOT) }}"
            data-locale="{{ app()->getLocale() }}">
        </div>
        <noscript>
            <div class="mx-auto max-w-[1160px] px-[22px]">
                <h1>{{ __('properties.title') }}</h1>
                <p>{{ __('properties.enable_javascript') }}</p>
                @forelse ($properties as $property)
                    <p><a href="{{ route('properties.show', $property) }}">{{ $property->title }} — {{ $property->city }}</a></p>
                @empty
                    <p>{{ __('properties.no_listings') }}</p>
                @endforelse
                {{ $properties->links() }}
            </div>
        </noscript>
    </section>
@endsection
