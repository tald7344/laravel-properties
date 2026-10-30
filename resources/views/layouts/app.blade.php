
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
</head>

<body
    data-page="{{ request()->is('admin/*') ? 'admin' : (request()->routeIs('owner.dashboard') ? 'owner-dashboard' : (request()->routeIs('owner.profile.*') ? 'owner-profile' : (request()->routeIs('renter.dashboard') ? 'renter-dashboard' : (request()->routeIs('renter.profile.*') ? 'renter-profile' : (request()->routeIs('owner.properties.create', 'owner.properties.edit') ? 'owner-property-form' : 'site'))))) }}">
    <nav class="nav">
        <div class="wrap navin"><a class="logo" href="{{ route('home') }}">{{ __('layout.brand') }}</a>
            <div class="links">
                <a href="{{ route('properties.index') }}">{{ __('layout.explore') }}</a>
                <details class="language-menu">
                    <summary aria-label="{{ __('layout.language_change') }}">
                        <span>{{ $currentLanguage?->native_name ?? strtoupper(app()->getLocale()) }}</span>
                        <span class="language-menu-chevron" aria-hidden="true">⌄</span>
                    </summary>
                    <div class="language-menu-options">
                        @forelse ($languages as $language)
                            <a href="{{ route('language.switch', $language) }}" lang="{{ $language->code }}"
                                dir="{{ $language->direction }}"
                                @if ($language->code === app()->getLocale()) aria-current="true" @endif>
                                <span>{{ $language->native_name }}</span>
                                <small>{{ strtoupper($language->code) }}</small>
                            </a>
                        @empty
                            <span class="language-menu-empty">{{ __('layout.language_none') }}</span>
                        @endforelse
                    </div>
                </details>
                @auth @if (in_array(auth()->user()->role, ['owner', 'admin']))
                    <a href="{{ route('owner.dashboard') }}">{{ __('layout.owner_dashboard') }}</a>
                    @if (auth()->user()->role === 'owner')
                        <a href="{{ route('owner.profile.edit') }}">{{ __('layout.profile') }}</a>
                    @endif
                @elseif (in_array(auth()->user()->role, ['tenant', 'renter']))
                    <a href="{{ route('renter.dashboard') }}">{{ __('layout.renter_dashboard') }}</a>
                    <a href="{{ route('renter.profile.edit') }}">{{ __('layout.profile') }}</a>
                    @endif @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}">{{ __('layout.admin') }}</a>
                    @endif
                    <form method="post" action="{{ route('logout') }}" style="display:inline">
                    @csrf<button class="btn outline">{{ __('layout.logout') }}</button></form>@else<a
                    class="btn" href="{{ route('auth.form') }}">{{ __('layout.login_register') }}</a>@endauth
        </div>
    </div>
</nav>
@if (session('success'))
    <div class="wrap">
        <div class="flash">{{ session('success') }}</div>
    </div>
    @endif @if ($errors->any())
        <div class="wrap">
            <div class="error">{{ $errors->first() }}</div>
        </div>
    @endif @yield('content')<footer class="footer">
        <div class="wrap">{{ __('layout.footer') }}</div>
    </footer>
</body>

</html>
