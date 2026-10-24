@extends('layouts.app')

@section('content')
    <main class="renter-dashboard">
        <div class="wrap renter-dashboard__container">
            <header class="renter-dashboard__heading">
                <div>
                    <span class="tag">{{ __('renter-dashboard.workspace') }}</span>
                    <h1>{{ __('renter-dashboard.greeting', ['name' => auth()->user()->name]) }}</h1>
                    <p>{{ __('renter-dashboard.intro') }}</p>
                </div>
                <a class="btn" href="{{ route('renter.profile.edit') }}">{{ __('renter-dashboard.profile') }}</a>
            </header>

            <section class="renter-dashboard__panel" id="complaints" aria-labelledby="renter-complaints-title">
                <div class="renter-dashboard__panel-heading">
                    <div>
                        <span class="renter-dashboard__eyebrow">{{ __('renter-dashboard.support') }}</span>
                        <h2 id="renter-complaints-title">{{ __('renter-dashboard.complaints') }}</h2>
                    </div>
                    <span class="renter-dashboard__count">{{ __('renter-dashboard.complaint_count', ['count' => $reports->total()]) }}</span>
                </div>

                <form class="renter-complaint-form" method="post" action="{{ route('renter.complaints.store') }}">
                    @csrf
                    <p>{{ __('renter-dashboard.complaint_intro') }}</p>
                    <div class="renter-complaint-form__grid">
                        <label>
                            <span>{{ __('renter-dashboard.subject') }} <b>{{ __('renter-dashboard.required') }}</b></span>
                            <select name="subject_type" required>
                                <option value="owner" @selected(old('subject_type') === 'owner')>{{ __('renter-dashboard.owner') }}</option>
                                <option value="tenant" @selected(old('subject_type') === 'tenant')>{{ __('renter-dashboard.tenant') }}</option>
                            </select>
                        </label>
                        <label>
                            <span>{{ __('renter-dashboard.person_name') }} <b>{{ __('renter-dashboard.required') }}</b></span>
                            <input name="subject_name" value="{{ old('subject_name') }}" maxlength="150" required>
                        </label>
                        <label>
                            <span>{{ __('renter-dashboard.contact_hint') }}</span>
                            <input name="subject_contact" value="{{ old('subject_contact') }}" maxlength="120">
                        </label>
                        <label>
                            <span>{{ __('renter-dashboard.type') }} <b>{{ __('renter-dashboard.required') }}</b></span>
                            <select name="type" required>
                                <option value="behavior" @selected(old('type') === 'behavior')>{{ __('renter-dashboard.behavior') }}</option>
                                <option value="fraud" @selected(old('type') === 'fraud')>{{ __('renter-dashboard.fraud') }}</option>
                                <option value="harassment" @selected(old('type') === 'harassment')>{{ __('renter-dashboard.harassment') }}</option>
                                <option value="other" @selected(old('type') === 'other')>{{ __('renter-dashboard.other') }}</option>
                            </select>
                        </label>
                        <label class="renter-complaint-form__details">
                            <span>{{ __('renter-dashboard.details') }} <b>{{ __('renter-dashboard.required') }}</b></span>
                            <textarea name="details" rows="4" maxlength="3000" required>{{ old('details') }}</textarea>
                        </label>
                    </div>
                    <button class="btn" type="submit">{{ __('renter-dashboard.submit') }}</button>
                </form>

                <div class="renter-dashboard__complaints">
                    <h3>{{ __('renter-dashboard.previous') }}</h3>
                    @forelse ($reports as $report)
                        <article class="renter-complaint">
                            <div class="renter-complaint__heading">
                                <div>
                                    <strong>
                                        {{ $report->subject_type === 'property'
                                            ? __('renter-dashboard.property_report')
                                            : ($report->subject_type === 'owner' ? __('renter-dashboard.owner_complaint') : __('renter-dashboard.tenant_complaint')) }}
                                    </strong>
                                    <span>{{ $report->subject_type === 'property' ? ($report->property?->title ?? __('renter-dashboard.property')) : $report->subject_name }}</span>
                                </div>
                                <span class="renter-complaint__status {{ $report->status === 'resolved' ? 'is-resolved' : '' }}">
                                    {{ $report->status === 'resolved' ? __('renter-dashboard.resolved') : __('renter-dashboard.under_review') }}
                                </span>
                            </div>
                            <p>{{ $report->details }}</p>
                            <small>{{ $report->created_at->format('Y-m-d H:i') }}</small>
                        </article>
                    @empty
                        <p class="renter-dashboard__empty">{{ __('renter-dashboard.empty') }}</p>
                    @endforelse
                    @if ($reports->hasPages())
                        <div class="renter-dashboard__pagination">{{ $reports->fragment('complaints')->links() }}</div>
                    @endif
                </div>
            </section>
        </div>
    </main>
@endsection
