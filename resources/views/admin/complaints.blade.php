@extends('admin.layout')

@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-4 max-[600px]:items-start max-[600px]:flex-col">
        <div>
            <h1>{{ __('complaints.title') }}</h1>
            <p class="text-sm text-[#697873]">{{ __('complaints.review_intro') }}</p>
        </div>
        <span class="inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ __('complaints.report_count', ['count' => $reports->total()]) }}</span>
    </div>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
            <tr>
                <th>{{ __('complaints.subject') }}</th>
                <th>{{ __('complaints.type') }}</th>
                <th>{{ __('complaints.reporter') }}</th>
                <th>{{ __('complaints.status') }}</th>
                <th>{{ __('complaints.date') }}</th>
                <th></th>
            </tr>
            @foreach ($reports as $report)
                <tr>
                    <td>
                        @if ($report->subject_type === 'property')
                            {{ $report->property?->title ?? __('complaints.deleted_property') }}
                        @else
                            {{ $report->subject_type === 'owner' ? __('complaints.owner') : __('complaints.tenant') }}: {{ $report->subject_name }}
                        @endif
                    </td>
                    <td>{{ __("complaints.type_{$report->type}") }}</td>
                    <td>{{ $report->reporter?->name ?? __('complaints.visitor') }}</td>
                    <td>{{ $report->status === 'resolved' ? __('complaints.resolved') : __('complaints.open') }}</td>
                    <td>{{ $report->created_at->format('Y-m-d') }}</td>
                    <td><a class="inline-block rounded-xl bg-[#dff5e9] px-[18px] py-[11px] font-bold text-[#176b52]" href="{{ route('admin.complaints.show', $report) }}">{{ __('complaints.details_action') }}</a></td>
                </tr>
            @endforeach
        </table>
        {{ $reports->links() }}
    </div>
@endsection
