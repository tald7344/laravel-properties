@extends('admin.layout')

@section('admin-content')
    <div class="sectionhead admin-legal-pages__heading">
        <div>
            <h1>{{ __('legal.admin.title') }}</h1>
            <p class="muted">{{ __('legal.admin.description') }}</p>
        </div>
        <a class="btn" href="{{ route('admin.legal-pages.create') }}">+ {{ __('legal.admin.add') }}</a>
    </div>

    <div class="panel admin-legal-pages__table-wrap">
        <table class="table">
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
                        <td class="admin-legal-pages__actions">
                            <a class="btn alt" href="{{ route('admin.legal-pages.edit', $page) }}">{{ __('legal.admin.edit') }}</a>
                            @if ($page->is_published)
                                <a class="btn outline" href="{{ route('legal.show', $page->slug) }}" target="_blank" rel="noopener">{{ __('legal.admin.view') }}</a>
                            @endif
                            <form method="post" action="{{ route('admin.legal-pages.destroy', $page) }}" data-confirm="{{ __('legal.admin.delete_confirm') }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn outline" type="submit">{{ __('legal.admin.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-legal-pages__empty">{{ __('legal.admin.empty') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $pages->links() }}
    </div>
@endsection
