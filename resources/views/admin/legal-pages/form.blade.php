@extends('admin.layout')

@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-[18px]">
        <div>
            <h1>{{ $page ? __('legal.admin.edit_page') : __('legal.admin.add_page') }}</h1>
            <p class="text-sm text-[#697873]">{{ __('legal.admin.translation_hint') }}</p>
        </div>
    </div>

    <form class="grid gap-4" method="post" action="{{ $page ? route('admin.legal-pages.update', $page) : route('admin.legal-pages.store') }}">
        @csrf
        @if ($page)
            @method('PUT')
        @endif
        <section class="grid grid-cols-[minmax(0,1fr)_180px] gap-4 rounded-xl border border-[#e4eeea] bg-white p-[22px] max-[600px]:grid-cols-1">
            <label class="flex flex-col gap-2 text-xs font-bold text-[#14231f]">
                {{ __('legal.admin.slug') }}
                <input class="w-full rounded-lg border border-[#e4eeea] px-3 py-3 text-xs font-normal" name="slug" value="{{ old('slug', $page?->slug) }}" pattern="[A-Za-z0-9_-]+" maxlength="120" required>
                <small class="text-[11px] font-normal text-[#78908a]">{{ __('legal.admin.slug_hint') }}</small>
            </label>
            <label class="flex flex-col gap-2 text-xs font-bold text-[#14231f]">
                {{ __('legal.admin.sort_order') }}
                <input class="w-full rounded-lg border border-[#e4eeea] px-3 py-3 text-xs font-normal" type="number" name="sort_order" min="0" max="65535" value="{{ old('sort_order', $page?->sort_order ?? 0) }}">
            </label>
            <label class="col-span-full flex flex-row! items-center! gap-2 text-xs font-bold text-[#14231f]">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page?->is_published ?? true))>
                {{ __('legal.admin.publish') }}
            </label>
        </section>

        @foreach ($languages as $language)
            @php($translation = $page?->translations->firstWhere('language_id', $language->id))
            <section class="rounded-xl border border-[#e4eeea] bg-white p-[22px]" lang="{{ $language->code }}" dir="{{ $language->direction }}">
                <h2 class="mb-4 text-base font-bold">{{ $language->native_name }} <small class="text-[10px] font-normal text-[#78908a]">{{ strtoupper($language->code) }}</small></h2>
                <label class="mb-4 flex flex-col gap-2 text-xs font-bold text-[#14231f]">
                    {{ __('legal.admin.page_title') }}
                    <input class="w-full rounded-lg border border-[#e4eeea] px-3 py-3 text-xs font-normal" name="translations[{{ $language->id }}][title]" value="{{ old("translations.{$language->id}.title", $translation?->title) }}" maxlength="255" required>
                </label>
                <label class="flex flex-col gap-2 text-xs font-bold text-[#14231f]">
                    {{ __('legal.admin.content') }}
                    <textarea class="w-full resize-y rounded-[9px] border border-[#e4eeea] p-3 text-xs" name="translations[{{ $language->id }}][content]" rows="16" maxlength="50000" required>{{ old("translations.{$language->id}.content", $translation?->content) }}</textarea>
                    <small class="text-[11px] font-normal text-[#78908a]">{{ __('legal.admin.plain_text_hint') }}</small>
                </label>
            </section>
        @endforeach

        <div class="flex justify-end gap-[10px]">
            <a class="rounded-xl border border-[#cadbd2] px-[18px] py-[11px] font-bold" href="{{ route('admin.legal-pages.index') }}">{{ __('legal.admin.cancel') }}</a>
            <button class="cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white" type="submit">{{ __('legal.admin.save') }}</button>
        </div>
    </form>
@endsection
