@extends('admin.layout')
@section('admin-content')
    <h1>{{ $language ? __('languages.edit_language') : __('languages.add_language') }}</h1>
    <div class="panel">
        <form method="post" action="{{ $language ? route('admin.languages.update', $language) : route('admin.languages.store') }}">
            @csrf
            @if ($language) @method('PUT') @endif
            <div class="formgrid">
                <input class="field" name="code" placeholder="ar" value="{{ old('code', $language->code ?? '') }}" required>
                <input class="field" name="name" placeholder="{{ __('languages.name_placeholder') }}" value="{{ old('name', $language->name ?? '') }}" required>
                <input class="field" name="native_name" placeholder="{{ __('languages.native_name_placeholder') }}" value="{{ old('native_name', $language->native_name ?? '') }}" required>
                <select name="direction">
                    <option value="rtl" @selected(($language->direction ?? 'rtl') === 'rtl')>{{ __('languages.rtl') }}</option>
                    <option value="ltr" @selected(($language->direction ?? '') === 'ltr')>{{ __('languages.ltr') }}</option>
                </select>
            </div>
            <label style="display:block;margin-top:14px"><input type="checkbox" name="is_active" value="1" @checked($language?->is_active ?? true)> {{ __('languages.active_language') }}</label>
            <button class="btn" style="margin-top:16px">{{ __('languages.save') }}</button>
        </form>
    </div>
@endsection
