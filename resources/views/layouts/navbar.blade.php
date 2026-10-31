<nav class="nav">
        <div class="wrap navin">
            <a class="logo" href="{{ route('home') }}">{{ __('layout.brand') }}</a>
            <div class="links">
                <a href="{{ route('properties.index') }}">{{ __('layout.explore') }}</a>
                <details class="language-menu">
                    <summary aria-label="{{ __('layout.language_change') }}">
                        <span>{{ $currentLanguage?->native_name ?? strtoupper(app()->getLocale()) }}</span>
                        <span class="language-menu-chevron" aria-hidden="true">
                            <img src="{{ asset('assets/icons/chevron-down-black.svg') }}">
                        </span>
                    </summary>
                    <div class="language-menu-options">
                        @forelse ($languages as $language)
                            <a href="{{ route('language.switch', $language) }}" lang="{{ $language->code }}"                                
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