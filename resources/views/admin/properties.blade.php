@extends('admin.layout')
@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-4 max-[600px]:items-start max-[600px]:flex-col">
        <div><h1>{{ __('admin-properties.title') }}</h1><p class="text-sm text-[#697873]">{{ __('admin-properties.description') }}</p></div>
        <span class="inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ __('admin-properties.listing_count', ['count' => $properties->total()]) }}</span>
    </div>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
            <tr><th>{{ __('admin-properties.property') }}</th><th>{{ __('admin-properties.owner') }}</th><th>{{ __('admin-properties.city') }}</th><th>{{ __('admin-properties.price') }}</th><th>{{ __('admin-properties.status') }}</th><th>{{ __('admin-properties.action') }}</th></tr>
            @foreach ($properties as $property)
                <tr>
                    <td>{{ $property->title }}</td><td>{{ $property->owner->name }}</td><td>{{ $property->city }}</td><td>{{ number_format($property->price) }} {{ $property->currency }}</td><td>{{ __("admin-properties.status_{$property->status}") }}</td>
                    <td>
                        <a class="inline-block rounded-xl bg-[#dff5e9] px-[18px] py-[11px] font-bold text-[#176b52]" href="{{ route('admin.properties.show', $property) }}">{{ __('admin-properties.details_media') }}</a>
                        <form method="post" action="{{ route('admin.moderate', $property) }}" class="inline-block">
                            @csrf
                            <select name="status" class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]"><option value="published">{{ __('admin-properties.publish') }}</option><option value="suspended">{{ __('admin-properties.suspend') }}</option><option value="expired">{{ __('admin-properties.expire') }}</option></select>
                            <button class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white">{{ __('admin-properties.save') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $properties->links() }}
    </div>
@endsection
