@extends('admin.layout')

@section('admin-content')
    <div class="admin-legal-pages__heading">
        <div>
            <h1>{{ $page ? __('legal.admin.edit_page') : __('legal.admin.add_page') }}</h1>
            <p class="muted">{{ __('legal.admin.translation_hint') }}</p>
        </div>
    </div>

    <form class="admin-legal-pages__form" method="post" action="{{ $page ? route('admin.legal-pages.update', $page) : route('admin.legal-pages.store') }}">
        @csrf
        @if ($page)
            @method('PUT')
        @endif
        <section class="panel admin-legal-pages__metadata">
            <label>
                {{ __('legal.admin.slug') }}
                <input class="field" name="slug" value="{{ old('slug', $page?->slug) }}" pattern="[A-Za-z0-9_-]+" maxlength="120" required>
                <small>{{ __('legal.admin.slug_hint') }}</small>
            </label>
            <label>
                {{ __('legal.admin.sort_order') }}
                <input class="field" type="number" name="sort_order" min="0" max="65535" value="{{ old('sort_order', $page?->sort_order ?? 0) }}">
            </label>
            <label class="admin-legal-pages__publish">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page?->is_published ?? true))>
                {{ __('legal.admin.publish') }}
            </label>
        </section>

        @foreach ($languages as $language)
            @php($translation = $page?->translations->firstWhere('language_id', $language->id))
            <section class="panel admin-legal-pages__translation" lang="{{ $language->code }}" dir="{{ $language->direction }}">
                <h2>{{ $language->native_name }} <small>{{ strtoupper($language->code) }}</small></h2>
                <label>
                    {{ __('legal.admin.page_title') }}
                    <input class="field" name="translations[{{ $language->id }}][title]" value="{{ old("translations.{$language->id}.title", $translation?->title) }}" maxlength="255" required>
                </label>
                <label>
                    {{ __('legal.admin.content') }}
                    <textarea name="translations[{{ $language->id }}][content]" rows="16" maxlength="50000" required>{{ old("translations.{$language->id}.content", $translation?->content) }}</textarea>
                    <small>{{ __('legal.admin.plain_text_hint') }}</small>
                </label>
            </section>
        @endforeach

        <div class="admin-legal-pages__form-actions">
            <a class="btn outline" href="{{ route('admin.legal-pages.index') }}">{{ __('legal.admin.cancel') }}</a>
            <button class="btn" type="submit">{{ __('legal.admin.save') }}</button>
        </div>
    </form>
@endsection
