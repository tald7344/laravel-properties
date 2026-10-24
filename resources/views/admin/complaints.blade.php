@extends('admin.layout')

@section('admin-content')
    <div class="sectionhead">
        <div>
            <h1>{{ __('complaints.title') }}</h1>
            <p class="muted">{{ __('complaints.review_intro') }}</p>
        </div>
        <span class="tag">{{ __('complaints.report_count', ['count' => $reports->total()]) }}</span>
    </div>
    <div class="panel">
        <table class="table">
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
                    <td><a class="btn alt" href="{{ route('admin.complaints.show', $report) }}">{{ __('complaints.details_action') }}</a></td>
                </tr>
            @endforeach
        </table>
        {{ $reports->links() }}
    </div>
@endsection
