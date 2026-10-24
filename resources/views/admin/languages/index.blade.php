@extends('admin.layout')
@section('admin-content')
    <div class="sectionhead">
        <div><h1>{{ __('languages.title') }}</h1><p class="muted">{{ __('languages.description') }}</p></div>
        <a class="btn" href="{{ route('admin.languages.create') }}">+ {{ __('languages.add') }}</a>
    </div>
    <div class="panel">
        <table class="table">
            <tr><th>{{ __('languages.language') }}</th><th>{{ __('languages.code') }}</th><th>{{ __('languages.direction') }}</th><th>{{ __('languages.status') }}</th><th>{{ __('languages.action') }}</th></tr>
            @foreach ($languages as $language)
                <tr>
                    <td>{{ $language->native_name }} @if ($language->is_default)<span class="tag">{{ __('languages.default') }}</span>@endif</td>
                    <td>{{ $language->code }}</td><td>{{ strtoupper($language->direction) }}</td>
                    <td>{{ $language->is_active ? __('languages.active') : __('languages.inactive') }}</td>
                    <td>
                        <a class="btn alt" href="{{ route('admin.languages.edit', $language) }}">{{ __('languages.edit') }}</a>
                        @if (! $language->is_default)
                            <form method="post" action="{{ route('admin.languages.default', $language) }}" style="display:inline">@csrf<button class="btn outline">{{ __('languages.set_default') }}</button></form>
                            <form method="post" action="{{ route('admin.languages.destroy', $language) }}" style="display:inline" data-confirm="{{ __('languages.delete_confirm') }}">@csrf @method('DELETE')<button class="btn outline">{{ __('languages.delete') }}</button></form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
