@extends('admin.layout')
@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-4 max-[600px]:items-start max-[600px]:flex-col"><div><h1>{{ __('subscriptions.title') }}</h1><p class="text-sm text-[#697873]">{{ __('subscriptions.description') }}</p></div></div>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
            <tr><th>{{ __('subscriptions.owner') }}</th><th>{{ __('subscriptions.plan') }}</th><th>{{ __('subscriptions.amount') }}</th><th>{{ __('subscriptions.property_limit') }}</th><th>{{ __('subscriptions.reference') }}</th><th>{{ __('subscriptions.status') }}</th><th>{{ __('subscriptions.ends') }}</th><th></th></tr>
            @foreach ($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->user->name }}</td><td>{{ $subscription->plan }}</td><td>{{ $subscription->amount }}</td><td>{{ $subscription->property_limit ?? '—' }}</td><td>{{ $subscription->sham_cash_reference ?? '—' }}</td><td>{{ $subscription->status }}</td>
                    <td>{{ $subscription->ends_at?->format('Y-m-d H:i') ?? __('subscriptions.pending_approval') }} @if ($subscription->ends_at && $subscription->ends_at->isFuture())<small>({{ $subscription->ends_at->diffForHumans() }})</small>@endif</td>
                    <td>@if ($subscription->status === 'pending')<form method="post" action="{{ route('admin.subscriptions.approve', $subscription) }}">@csrf<button class="inline-block rounded-xl bg-[#dff5e9] px-[18px] py-[11px] font-bold text-[#176b52]">{{ __('subscriptions.approve_month') }}</button></form>@endif</td>
                </tr>
            @endforeach
        </table>
        {{ $subscriptions->links() }}
    </div>
@endsection
