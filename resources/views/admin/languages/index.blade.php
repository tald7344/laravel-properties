@extends('admin.layout')
@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-4 max-[600px]:items-start max-[600px]:flex-col">
        <div><h1>{{ __('languages.title') }}</h1><p class="text-sm text-[#697873]">{{ __('languages.description') }}</p></div>
        <a class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white" href="{{ route('admin.languages.create') }}">+ {{ __('languages.add') }}</a>
    </div>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
            <tr><th>{{ __('languages.language') }}</th><th>{{ __('languages.code') }}</th><th>{{ __('languages.direction') }}</th><th>{{ __('languages.status') }}</th><th>{{ __('languages.action') }}</th></tr>
            @foreach ($languages as $language)
                <tr>
                    <td>{{ $language->native_name }} @if ($language->is_default)<span class="inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ __('languages.default') }}</span>@endif</td>
                    <td>{{ $language->code }}</td><td>{{ strtoupper($language->direction) }}</td>
                    <td>{{ $language->is_active ? __('languages.active') : __('languages.inactive') }}</td>
                    <td>
                        <a class="inline-block rounded-xl bg-[#dff5e9] px-[18px] py-[11px] font-bold text-[#176b52]" href="{{ route('admin.languages.edit', $language) }}">{{ __('languages.edit') }}</a>
                        @if (! $language->is_default)
                            <form method="post" action="{{ route('admin.languages.default', $language) }}" class="inline-block">@csrf<button class="inline-block cursor-pointer rounded-xl border border-[#cadbd2] px-[18px] py-[11px] font-bold text-[#176b52]">{{ __('languages.set_default') }}</button></form>
                            <form method="post" action="{{ route('admin.languages.destroy', $language) }}" class="inline-block" data-confirm="{{ __('languages.delete_confirm') }}">@csrf @method('DELETE')<button class="inline-block cursor-pointer rounded-xl border border-[#cadbd2] px-[18px] py-[11px] font-bold text-[#176b52]">{{ __('languages.delete') }}</button></form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
