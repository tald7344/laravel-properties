@extends('layouts.app')

@section('content')
    <main class="owner-dashboard">
        <div class="wrap owner-dashboard__container">
            <header class="owner-dashboard__heading">
                <div>
                    <span class="tag">{{ __('owner-dashboard.workspace') }}</span>
                    <h1>{{ __('owner-dashboard.greeting', ['name' => auth()->user()->name]) }}</h1>
                    <p>{{ __('owner-dashboard.intro') }}</p>
                </div>
                <div class="owner-dashboard__heading-actions">
                    <a class="btn outline" href="{{ route('owner.profile.edit') }}">{{ __('owner-dashboard.profile') }}</a>
                    <a class="btn owner-dashboard__add" href="{{ route('owner.properties.create') }}">{{ __('owner-dashboard.add_listing') }}</a>
                </div>
            </header>

            @if ($subscription)
                <div class="owner-dashboard__notice owner-dashboard__notice--active">
                    <span class="owner-dashboard__notice-icon" aria-hidden="true">✓</span>
                    <p>
                        {{ __('owner-dashboard.subscription_active_until') }}
                        <strong>{{ $subscription->ends_at->format('Y-m-d H:i') }}</strong>
                        <span>{{ __('owner-dashboard.remaining', ['time' => $subscription->ends_at->diffForHumans()]) }}</span>
                    </p>
                </div>
            @else
                <div class="owner-dashboard__notice">
                    <span class="owner-dashboard__notice-icon" aria-hidden="true">i</span>
                    <p>{{ __('owner-dashboard.no_active_subscription') }}</p>
                </div>
            @endif

            <section class="owner-dashboard__stats" aria-label="{{ __('owner-dashboard.listing_statistics') }}">
                <article class="owner-dashboard__stat">
                    <span>{{ __('owner-dashboard.total_listings') }}</span>
                    <strong>{{ $statistics['properties'] }}</strong>
                </article>
                <article class="owner-dashboard__stat owner-dashboard__stat--published">
                    <span>{{ __('owner-dashboard.published') }}</span>
                    <strong>{{ $statistics['published'] }}</strong>
                </article>
                <article class="owner-dashboard__stat owner-dashboard__stat--pending">
                    <span>{{ __('owner-dashboard.pending') }}</span>
                    <strong>{{ $statistics['pending'] }}</strong>
                </article>
                <article class="owner-dashboard__stat owner-dashboard__stat--inquiries">
                    <span>{{ __('owner-dashboard.contact_requests') }}</span>
                    <strong>{{ $statistics['inquiries'] }}</strong>
                </article>
            </section>

            <section class="owner-dashboard__panel" aria-labelledby="owner-listings-title">
                <div class="owner-dashboard__panel-heading">
                    <div>
                        <span class="owner-dashboard__eyebrow">{{ __('owner-dashboard.content_management') }}</span>
                        <h2 id="owner-listings-title">{{ __('owner-dashboard.my_listings') }}</h2>
                    </div>
                    <span class="owner-dashboard__count">{{ __('owner-dashboard.listing_count', ['count' => $properties->count()]) }}</span>
                </div>

                @if ($properties->count())
                    <div class="owner-dashboard__table-wrap">
                        <table class="owner-dashboard__table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('owner-dashboard.property') }}</th>
                                    <th scope="col">{{ __('owner-dashboard.status') }}</th>
                                    <th scope="col">{{ __('owner-dashboard.last_confirmation') }}</th>
                                    <th scope="col">{{ __('owner-dashboard.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($properties as $p)
                                    <tr>
                                        <td data-label="{{ __('owner-dashboard.property') }}">
                                            <span class="owner-dashboard__property-title">{{ $p->title }}</span>
                                            <small>{{ $p->city }} · {{ number_format($p->price) }} {{ $p->currency }}</small>
                                        </td>
                                        <td data-label="{{ __('owner-dashboard.status') }}">
                                            <span class="owner-dashboard__status owner-dashboard__status--{{ $p->status }}">
                                                {{ __('owner-dashboard.status_'.$p->status) }}
                                            </span>
                                        </td>
                                        <td data-label="{{ __('owner-dashboard.last_confirmation') }}">
                                            {{ optional($p->last_confirmed_at)->diffForHumans() ?? '—' }}
                                        </td>
                                        <td data-label="{{ __('owner-dashboard.action') }}">
                                            <div class="owner-dashboard__actions">
                                                <form method="post" action="{{ route('owner.properties.confirm', $p) }}">
                                                    @csrf
                                                    <button class="btn alt" type="submit">{{ __('owner-dashboard.confirm_availability') }}</button>
                                                </form>
                                                <form method="post" action="{{ route('owner.properties.toggle', $p) }}">
                                                    @csrf
                                                    <button class="btn outline" type="submit">
                                                        {{ $p->status === 'hidden' ? __('owner-dashboard.activate') : __('owner-dashboard.hide') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="owner-dashboard__empty">
                        <span class="owner-dashboard__empty-icon" aria-hidden="true">⌂</span>
                        <h3>{{ __('owner-dashboard.no_listings') }}</h3>
                        <p>{{ __('owner-dashboard.first_listing_hint') }}</p>
                        <a class="btn" href="{{ route('owner.properties.create') }}">{{ __('owner-dashboard.add_first_listing') }}</a>
                    </div>
                @endif
            </section>

            <section class="owner-dashboard__panel owner-dashboard__complaints" id="owner-complaints" aria-labelledby="owner-complaints-title">
                <div class="owner-dashboard__panel-heading">
                    <div>
                        <span class="owner-dashboard__eyebrow">{{ __('owner-dashboard.complaint_attention') }}</span>
                        <h2 id="owner-complaints-title">{{ __('owner-dashboard.complaints') }}</h2>
                    </div>
                    <span class="owner-dashboard__count">{{ __('owner-dashboard.complaint_count', ['count' => $reports->total()]) }}</span>
                </div>

                <form class="owner-dashboard__complaint-form" method="post" action="{{ route('owner.complaints.store') }}">
                    @csrf
                    <p>{{ __('owner-dashboard.complaint_intro') }}</p>
                    <div class="owner-dashboard__complaint-grid">
                        <label>
                            <span>{{ __('owner-dashboard.complaint_subject') }} <b>*</b></span>
                            <select name="subject_type" required>
                                <option value="owner" @selected(old('subject_type') === 'owner')>{{ __('owner-dashboard.owner') }}</option>
                                <option value="tenant" @selected(old('subject_type') === 'tenant')>{{ __('owner-dashboard.tenant') }}</option>
                            </select>
                        </label>
                        <label>
                            <span>{{ __('owner-dashboard.person_name') }} <b>*</b></span>
                            <input name="subject_name" value="{{ old('subject_name') }}" placeholder="{{ __('owner-dashboard.person_name') }}" required maxlength="150">
                        </label>
                        <label>
                            <span>{{ __('owner-dashboard.complaint_contact') }}</span>
                            <input name="subject_contact" value="{{ old('subject_contact') }}" placeholder="{{ __('owner-dashboard.optional') }}" maxlength="120">
                        </label>
                        <label>
                            <span>{{ __('owner-dashboard.complaint_type') }} <b>*</b></span>
                            <select name="type" required>
                                <option value="behavior" @selected(old('type') === 'behavior')>{{ __('owner-dashboard.behavior') }}</option>
                                <option value="fraud" @selected(old('type') === 'fraud')>{{ __('owner-dashboard.fraud') }}</option>
                                <option value="harassment" @selected(old('type') === 'harassment')>{{ __('owner-dashboard.harassment') }}</option>
                                <option value="other" @selected(old('type') === 'other')>{{ __('owner-dashboard.other') }}</option>
                            </select>
                        </label>
                        <label class="owner-dashboard__complaint-details">
                            <span>{{ __('owner-dashboard.complaint_details') }} <b>*</b></span>
                            <textarea name="details" rows="4" placeholder="{{ __('owner-dashboard.complaint_details_placeholder') }}" required maxlength="3000">{{ old('details') }}</textarea>
                        </label>
                    </div>
                    <button class="btn" type="submit">{{ __('owner-dashboard.submit_complaint') }}</button>
                </form>

                <div class="owner-dashboard__complaint-list">
                    <h3>{{ __('owner-dashboard.previous_complaints') }}</h3>
                    @forelse ($reports as $report)
                        <article class="owner-dashboard__complaint-item">
                            <div class="owner-dashboard__complaint-meta">
                                <div>
                                    <strong>{{ $report->subject_type === 'property' ? ($report->property?->title ?? __('owner-dashboard.property_report')) : ($report->subject_type === 'owner' ? __('owner-dashboard.owner_complaint') : __('owner-dashboard.tenant_complaint')) }}</strong>
                                    @if ($report->subject_name)
                                        <span>{{ $report->subject_name }}</span>
                                    @endif
                                </div>
                                <span class="owner-dashboard__status {{ $report->status === 'resolved' ? 'owner-dashboard__status--published' : 'owner-dashboard__status--pending' }}">
                                    {{ $report->status === 'resolved' ? __('owner-dashboard.resolved') : __('owner-dashboard.under_review') }}
                                </span>
                            </div>
                            <p>{{ $report->details ?: __('owner-dashboard.no_details') }}</p>
                            <small>{{ $report->created_at->format('Y-m-d H:i') }}</small>
                        </article>
                    @empty
                        <div class="owner-dashboard__complaint-empty">{{ __('owner-dashboard.no_complaints') }}</div>
                    @endforelse
                    @if ($reports->hasPages())
                        <div class="owner-dashboard__complaint-pagination">{{ $reports->fragment('owner-complaints')->links() }}</div>
                    @endif
                </div>
            </section>

            <section class="owner-dashboard__panel owner-dashboard__subscription" aria-labelledby="owner-subscription-title">
                <div class="owner-dashboard__panel-heading">
                    <div>
                        <span class="owner-dashboard__eyebrow">{{ __('owner-dashboard.subscription_visibility') }}</span>
                        <h2 id="owner-subscription-title">{{ __('owner-dashboard.monthly_subscription') }}</h2>
                    </div>
                </div>
                <p>{{ __('owner-dashboard.subscription_info') }}</p>
                <form class="owner-dashboard__subscription-form" method="post" action="{{ route('owner.subscribe') }}">
                    @csrf
                    <input class="field" name="reference" placeholder="{{ __('owner-dashboard.sham_cash_number') }}" aria-label="{{ __('owner-dashboard.sham_cash_number') }}" required>
                    <button class="btn" type="submit">{{ __('owner-dashboard.submit_review') }}</button>
                </form>
            </section>
        </div>
    </main>
@endsection
