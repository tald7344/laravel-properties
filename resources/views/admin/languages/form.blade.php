@extends('admin.layout')
@section('admin-content')
    <h1>{{ $language ? __('languages.edit_language') : __('languages.add_language') }}</h1>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <form method="post" action="{{ $language ? route('admin.languages.update', $language) : route('admin.languages.store') }}">
            @csrf
            @if ($language) @method('PUT') @endif
            <div class="grid grid-cols-2 gap-3 max-[600px]:grid-cols-1">
                <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm" name="code" placeholder="ar" value="{{ old('code', $language->code ?? '') }}" required>
                <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm" name="name" placeholder="{{ __('languages.name_placeholder') }}" value="{{ old('name', $language->name ?? '') }}" required>
                <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm" name="native_name" placeholder="{{ __('languages.native_name_placeholder') }}" value="{{ old('native_name', $language->native_name ?? '') }}" required>
                <select name="direction" class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]">
                    <option value="rtl" @selected(($language->direction ?? 'rtl') === 'rtl')>{{ __('languages.rtl') }}</option>
                    <option value="ltr" @selected(($language->direction ?? '') === 'ltr')>{{ __('languages.ltr') }}</option>
                </select>
            </div>
            <label class="mt-[14px] block"><input type="checkbox" name="is_active" value="1" @checked($language?->is_active ?? true)> {{ __('languages.active_language') }}</label>
            <button class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white" >{{ __('languages.save') }}</button>
        </form>
    </div>
@endsection
