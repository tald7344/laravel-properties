@extends('admin.layout')
@section('admin-content')
    <div class="sectionhead"><div><h1>{{ __('subscriptions.title') }}</h1><p class="muted">{{ __('subscriptions.description') }}</p></div></div>
    <div class="panel">
        <table class="table">
            <tr><th>{{ __('subscriptions.owner') }}</th><th>{{ __('subscriptions.plan') }}</th><th>{{ __('subscriptions.amount') }}</th><th>{{ __('subscriptions.property_limit') }}</th><th>{{ __('subscriptions.reference') }}</th><th>{{ __('subscriptions.status') }}</th><th>{{ __('subscriptions.ends') }}</th><th></th></tr>
            @foreach ($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->user->name }}</td><td>{{ $subscription->plan }}</td><td>{{ $subscription->amount }}</td><td>{{ $subscription->property_limit ?? '—' }}</td><td>{{ $subscription->sham_cash_reference ?? '—' }}</td><td>{{ $subscription->status }}</td>
                    <td>{{ $subscription->ends_at?->format('Y-m-d H:i') ?? __('subscriptions.pending_approval') }} @if ($subscription->ends_at && $subscription->ends_at->isFuture())<small>({{ $subscription->ends_at->diffForHumans() }})</small>@endif</td>
                    <td>@if ($subscription->status === 'pending')<form method="post" action="{{ route('admin.subscriptions.approve', $subscription) }}">@csrf<button class="btn alt">{{ __('subscriptions.approve_month') }}</button></form>@endif</td>
                </tr>
            @endforeach
        </table>
        {{ $subscriptions->links() }}
    </div>
@endsection
