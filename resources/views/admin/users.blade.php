@extends('admin.layout')
@section('admin-content')
    <div class="sectionhead">
        <div><h1>{{ __('users.title') }}</h1><p class="muted">{{ __('users.description') }}</p></div>
        <span class="tag">{{ __('users.user_count', ['count' => $users->total()]) }}</span>
    </div>
    <div class="panel">
        <table class="table">
            <tr><th>{{ __('users.name') }}</th><th>{{ __('users.phone') }}</th><th>{{ __('users.role') }}</th><th>{{ __('users.phone_verification') }}</th><th>{{ __('users.registration') }}</th></tr>
            @foreach ($users as $user)
                <tr><td>{{ $user->name }}</td><td>{{ $user->phone }}</td><td><span class="tag">{{ $user->role }}</span></td><td>{{ $user->phone_verified ? __('users.verified') : __('users.unverified') }}</td><td>{{ $user->created_at->format('Y-m-d') }}</td></tr>
            @endforeach
        </table>
        {{ $users->links() }}
    </div>
@endsection
