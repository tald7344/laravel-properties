@extends('admin.layout')
@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-4 max-[600px]:items-start max-[600px]:flex-col">
        <div><h1>{{ __('users.title') }}</h1><p class="text-sm text-[#697873]">{{ __('users.description') }}</p></div>
        <span class="inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ __('users.user_count', ['count' => $users->total()]) }}</span>
    </div>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
            <tr><th>{{ __('users.name') }}</th><th>{{ __('users.phone') }}</th><th>{{ __('users.role') }}</th><th>{{ __('users.phone_verification') }}</th><th>{{ __('users.registration') }}</th></tr>
            @foreach ($users as $user)
                <tr><td>{{ $user->name }}</td><td>{{ $user->phone }}</td><td><span class="inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ $user->role }}</span></td><td>{{ $user->phone_verified ? __('users.verified') : __('users.unverified') }}</td><td>{{ $user->created_at->format('Y-m-d') }}</td></tr>
            @endforeach
        </table>
        {{ $users->links() }}
    </div>
@endsection
