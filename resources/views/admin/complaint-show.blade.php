@extends('admin.layout')

@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-4 max-[600px]:items-start max-[600px]:flex-col">
        <div>
            <h1>{{ __('complaints.details_title') }}</h1>
            <p class="text-sm text-[#697873]">
                @if ($report->subject_type === 'property')
                    {{ $report->property?->title ?? __('complaints.deleted_property') }}
                @else
                    {{ $report->subject_type === 'owner' ? __('complaints.owner_complaint') : __('complaints.tenant_complaint') }}: {{ $report->subject_name }}
                @endif
            </p>
        </div>
        <a class="inline-block cursor-pointer rounded-xl border border-[#cadbd2] px-[18px] py-[11px] font-bold text-[#176b52]" href="{{ route('admin.complaints.index') }}">{{ __('complaints.back') }}</a>
    </div>
    <div class="grid grid-cols-2 gap-4 max-[700px]:grid-cols-1">
        <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
            <h2>{{ __('complaints.information') }}</h2>
            <p><b>{{ __('complaints.type') }}:</b> {{ __("complaints.type_{$report->type}") }}</p>
            <p><b>{{ __('complaints.details') }}</b> {{ $report->details ?: __('complaints.no_details') }}</p>
            <p><b>{{ __('complaints.reporter') }}:</b> {{ $report->reporter?->name ?? __('complaints.visitor') }}</p>
            <p><b>{{ __('complaints.status') }}:</b> <span class="inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ $report->status === 'resolved' ? __('complaints.resolved') : __('complaints.open') }}</span></p>
        </div>
        <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
            @if ($report->subject_type === 'property')
                <h2>{{ __('complaints.reported_property') }}</h2>
                @if ($report->property)
                    <p>{{ $report->property->title }}</p>
                    <p class="text-sm text-[#697873]">{{ $report->property->city }} · {{ $report->property->neighborhood }}</p>
                    <a class="inline-block rounded-xl bg-[#dff5e9] px-[18px] py-[11px] font-bold text-[#176b52]" href="{{ route('admin.properties.show', $report->property) }}">{{ __('complaints.open_property') }}</a>
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
                <form class="mt-3" method="post" action="{{ route('admin.complaints.resolve', $report) }}">
                    @csrf
                    <button class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white">{{ __('complaints.close_report') }}</button>
                </form>
            @endif
        </div>
    </div>
@endsection
