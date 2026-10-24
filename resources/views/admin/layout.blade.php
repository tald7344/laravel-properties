@extends('layouts.app')

@section('content')
    <div class="admin-shell">
        <aside class="admin-sidebar" id="admin-sidebar">
            <div class="admin-brand"><span class="brand-mark">د</span><span class="brand-label">{{ __('admin-layout.brand') }} <small>ADMIN</small></span></div>
            <button type="button" class="admin-collapse" data-sidebar-toggle data-label-collapse="{{ __('admin-layout.collapse') }}" data-label-expand="{{ __('admin-layout.expand') }}"><span>☰</span><b>{{ __('admin-layout.collapse') }}</b></button>
            <div class="admin-nav-label">{{ __('admin-layout.home') }}</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-link"><i>▦</i><span>{{ __('admin-layout.dashboard') }}</span></a>
            <div class="admin-nav-label">{{ __('admin-layout.platform_management') }}</div>
            <a href="{{ route('admin.properties.index') }}" class="admin-link"><i>⌂</i><span>{{ __('admin-layout.properties') }}</span></a>
            <a href="{{ route('admin.users.index') }}" class="admin-link"><i>♙</i><span>{{ __('admin-layout.users') }}</span></a>
            <a href="{{ route('admin.subscriptions.index') }}" class="admin-link"><i>◷</i><span>{{ __('admin-layout.subscriptions') }}</span></a>
            <a href="{{ route('admin.complaints.index') }}" class="admin-link"><i>⚑</i><span>{{ __('admin-layout.complaints') }}</span></a>
            <div class="admin-nav-label">{{ __('admin-layout.system') }}</div>
            <a href="{{ route('admin.roles.index') }}" class="admin-link"><i>◉</i><span>{{ __('admin-layout.roles') }}</span></a>
            <a href="{{ route('admin.permissions.index') }}" class="admin-link"><i>◈</i><span>{{ __('admin-layout.permissions') }}</span></a>
            <a href="{{ route('admin.languages.index') }}" class="admin-link"><i>文</i><span>{{ __('admin-layout.languages') }}</span></a>
            <a href="{{ route('admin.settings.index') }}" class="admin-link"><i>⚙</i><span>{{ __('admin-layout.settings') }}</span></a>
            <div class="admin-sidebar-bottom"><span>{{ auth()->user()->name }}</span><small>{{ __('admin-layout.admin_role') }}</small></div>
        </aside>
        <main class="admin-canvas">
            <header class="admin-topbar">
                <div><span class="admin-eyebrow">{{ __('admin-layout.platform_name') }}</span><h1>@yield('admin-title', __('admin-layout.admin_title'))</h1></div>
                <div class="admin-top-actions"><span class="admin-date">{{ now()->translatedFormat('l, d F Y') }}</span><a class="btn outline" href="{{ route('home') }}">{{ __('admin-layout.view_site') }} ↗</a></div>
            </header>
            <div class="admin-content">@yield('admin-content')</div>
        </main>
    </div>
@endsection
