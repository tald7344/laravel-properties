@extends('admin.layout')

@section('admin-content')
    <div class="sectionhead">
        <div>
            <h1>{{ __('complaints.details_title') }}</h1>
            <p class="muted">
                @if ($report->subject_type === 'property')
                    {{ $report->property?->title ?? __('complaints.deleted_property') }}
                @else
                    {{ $report->subject_type === 'owner' ? __('complaints.owner_complaint') : __('complaints.tenant_complaint') }}: {{ $report->subject_name }}
                @endif
            </p>
        </div>
        <a class="btn outline" href="{{ route('admin.complaints.index') }}">{{ __('complaints.back') }}</a>
    </div>
    <div class="detail">
        <div class="panel">
            <h2>{{ __('complaints.information') }}</h2>
            <p><b>{{ __('complaints.type') }}:</b> {{ __("complaints.type_{$report->type}") }}</p>
            <p><b>{{ __('complaints.details') }}</b> {{ $report->details ?: __('complaints.no_details') }}</p>
            <p><b>{{ __('complaints.reporter') }}:</b> {{ $report->reporter?->name ?? __('complaints.visitor') }}</p>
            <p><b>{{ __('complaints.status') }}:</b> <span class="tag">{{ $report->status === 'resolved' ? __('complaints.resolved') : __('complaints.open') }}</span></p>
        </div>
        <div class="panel">
            @if ($report->subject_type === 'property')
                <h2>{{ __('complaints.reported_property') }}</h2>
                @if ($report->property)
                    <p>{{ $report->property->title }}</p>
                    <p class="muted">{{ $report->property->city }} · {{ $report->property->neighborhood }}</p>
                    <a class="btn alt" href="{{ route('admin.properties.show', $report->property) }}">{{ __('complaints.open_property') }}</a>
                @else
                    <p>{{ __('complaints.property_deleted_message') }}</p>
                @endif
            @else
                <h2>{{ __('complaints.person_subject') }}</h2>
                <p><b>{{ __('complaints.role') }}</b> {{ $report->subject_type === 'owner' ? __('complaints.person_type_owner') : __('complaints.person_type_tenant') }}</p>
                <p><b>{{ __('complaints.name') }}</b> {{ $report->subject_name }}</p>
                @if ($report->subject_contact)
                    <p><b>{{ __('complaints.contact_info') }}</b> {{ $report->subject_contact }}</p>
                @endif
            @endif
            @if ($report->status === 'open')
                <form method="post" action="{{ route('admin.complaints.resolve', $report) }}" style="margin-top:12px">
                    @csrf
                    <button class="btn">{{ __('complaints.close_report') }}</button>
                </form>
            @endif
        </div>
    </div>
@endsection
