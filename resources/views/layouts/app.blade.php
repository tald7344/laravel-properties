
<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ $currentLanguage?->direction ?? (app()->getLocale() === 'ar' ? 'rtl' : 'ltr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? $siteSeoTitle }}</title>
    <meta name="description" content="{{ $siteDescription }}">
    <meta name="keywords" content="{{ $siteSeoKeywords }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/scss/navigation.scss'])
    @if (request()->is('auth') || request()->is('properties'))
        @vite('resources/css/page-overrides.scss')
    @endif
    @if (request()->routeIs('properties.show'))
        @vite('resources/scss/property-details.scss')
    @endif
    @if (request()->is('admin/*'))
        @vite(['resources/css/admin.css'])
    @endif
    @if (request()->is('owner/dashboard') || request()->routeIs('owner.subscription'))
        @vite(['resources/scss/owner-dashboard.scss'])
    @endif
    @if (request()->routeIs('owner.properties.create', 'owner.properties.edit'))
        @vite('resources/scss/owner-property-form.scss')
    @endif
    @if (request()->routeIs('owner.profile.*'))
        @vite('resources/scss/profile-owner.scss')
    @endif
    @if (request()->routeIs('renter.profile.*'))
        @vite('resources/scss/profile-renter.scss')
    @endif
    @if (request()->routeIs('renter.dashboard'))
        @vite('resources/scss/renter-dashboard.scss')
    @endif
    @if (request()->routeIs('legal.show'))
        @vite('resources/scss/legal-page.scss')
    @endif
    @if (request()->routeIs('admin.settings.index'))
        @vite('resources/scss/admin-settings.scss')
    @endif
    @if (request()->routeIs('admin.legal-pages.*'))
        @vite('resources/scss/admin-legal-pages.scss')
    @endif
</head>

@php
    $pageName = 'site';
    $adminPageName = '';
    if (request()->is('admin/*')) {
        $pageName = 'admin';
        $adminPageName = request()->routeIs('admin.settings.index')
            ? 'settings'
            : (request()->routeIs('admin.legal-pages.*') ? 'legal-pages' : '');
    } elseif (request()->routeIs('legal.show')) {
        $pageName = 'legal-page';
    } elseif (request()->routeIs('owner.dashboard')) {
        $pageName = 'owner-dashboard';
    } elseif (request()->routeIs('owner.profile.*')) {
        $pageName = 'owner-profile';
    } elseif (request()->routeIs('renter.dashboard')) {
        $pageName = 'renter-dashboard';
    } elseif (request()->routeIs('renter.profile.*')) {
        $pageName = 'renter-profile';
    } elseif (request()->routeIs('owner.properties.create', 'owner.properties.edit')) {
        $pageName = 'owner-property-form';
    }
@endphp
<body data-page="{{ $pageName }}" data-admin-page="{{ $adminPageName }}">
@include('layouts.navbar')
@if (session('success'))
    <div class="mx-auto max-w-[1160px] px-[22px]">
        <div class="flash">{{ session('success') }}</div>
    </div>
    @endif @if ($errors->any())
        <div class="mx-auto max-w-[1160px] px-[22px]">
            <div class="error">{{ $errors->first() }}</div>
        </div>
    @endif
    @yield('content')
    @if (!request()->is('admin/*'))
        @include('layouts.footer')
    @endif
</body>

</html>
