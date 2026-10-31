@extends('admin.layout')

@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-[18px] max-[600px]:items-start max-[600px]:flex-col">
        <div>
            <h1>{{ __('legal.admin.title') }}</h1>
            <p class="text-sm text-[#697873]">{{ __('legal.admin.description') }}</p>
        </div>
        <a class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white" href="{{ route('admin.legal-pages.create') }}">+ {{ __('legal.admin.add') }}</a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <table class="w-full min-w-[700px] border-collapse text-right text-sm">
            <thead>
                <tr>
                    <th>{{ __('legal.admin.page') }}</th>
                    <th>{{ __('legal.admin.slug') }}</th>
                    <th>{{ __('legal.admin.languages') }}</th>
                    <th>{{ __('legal.admin.status') }}</th>
                    <th>{{ __('legal.admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
                    <tr>
                        <td>{{ $page->translations->first()?->title ?? $page->slug }}</td>
                        <td><code>{{ $page->slug }}</code></td>
                        <td>{{ $page->translations->count() }} / {{ $activeLanguageCount }}</td>
                        <td>{{ $page->is_published ? __('legal.admin.published') : __('legal.admin.draft') }}</td>
                        <td class="whitespace-nowrap">
                            <a class="inline-block rounded-xl bg-[#dff5e9] px-3 py-2 text-[11px] font-bold text-[#176b52]" href="{{ route('admin.legal-pages.edit', $page) }}">{{ __('legal.admin.edit') }}</a>
                            @if ($page->is_published)
                                <a class="inline-block rounded-xl border border-[#cadbd2] px-3 py-2 text-[11px] font-bold" href="{{ route('legal.show', $page->slug) }}" target="_blank" rel="noopener">{{ __('legal.admin.view') }}</a>
                            @endif
                            <form class="inline-flex flex-wrap gap-[6px]" method="post" action="{{ route('admin.legal-pages.destroy', $page) }}" data-confirm="{{ __('legal.admin.delete_confirm') }}">
                                @csrf
                                @method('DELETE')
                                <button class="cursor-pointer rounded-xl border border-[#cadbd2] px-3 py-2 text-[11px] font-bold" type="submit">{{ __('legal.admin.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-[22px] text-center text-[#78908a]">{{ __('legal.admin.empty') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $pages->links() }}
    </div>
@endsection
