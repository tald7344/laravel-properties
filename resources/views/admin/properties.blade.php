@extends('admin.layout')
@section('admin-content')
    <div class="sectionhead">
        <div><h1>{{ __('admin-properties.title') }}</h1><p class="muted">{{ __('admin-properties.description') }}</p></div>
        <span class="tag">{{ __('admin-properties.listing_count', ['count' => $properties->total()]) }}</span>
    </div>
    <div class="panel">
        <table class="table">
            <tr><th>{{ __('admin-properties.property') }}</th><th>{{ __('admin-properties.owner') }}</th><th>{{ __('admin-properties.city') }}</th><th>{{ __('admin-properties.price') }}</th><th>{{ __('admin-properties.status') }}</th><th>{{ __('admin-properties.action') }}</th></tr>
            @foreach ($properties as $property)
                <tr>
                    <td>{{ $property->title }}</td><td>{{ $property->owner->name }}</td><td>{{ $property->city }}</td><td>{{ number_format($property->price) }} {{ $property->currency }}</td><td>{{ __("admin-properties.status_{$property->status}") }}</td>
                    <td>
                        <a class="btn alt" href="{{ route('admin.properties.show', $property) }}">{{ __('admin-properties.details_media') }}</a>
                        <form method="post" action="{{ route('admin.moderate', $property) }}" style="display:inline">
                            @csrf
                            <select name="status"><option value="published">{{ __('admin-properties.publish') }}</option><option value="suspended">{{ __('admin-properties.suspend') }}</option><option value="expired">{{ __('admin-properties.expire') }}</option></select>
                            <button class="btn">{{ __('admin-properties.save') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $properties->links() }}
    </div>
@endsection
