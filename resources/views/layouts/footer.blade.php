<footer class="site-footer pt-3">
    <div class="wrap site-footer__grid">
        <section class="site-footer__brand" aria-label="{{ __('legal.footer.brand') }}">
            <a class="site-footer__logo" href="{{ route('home') }}">{{ $siteName }}</a>
            <p>{{ __('layout.footer') }}</p>
        </section>
        <nav class="site-footer__legal" aria-label="{{ __('legal.footer.legal_links') }}">
            <h2>{{ __('legal.footer.legal_links') }}</h2>
            @foreach ($legalPages as $legalPage)
                @if ($legalPage->footerTranslation)
                    <a href="{{ route('legal.show', $legalPage->slug) }}">{{ $legalPage->footerTranslation->title }}</a>
                @endif
            @endforeach
        </nav>
        <nav class="site-footer__social" aria-label="{{ __('legal.footer.social_links') }}">
            <h2>{{ __('legal.footer.social_links') }}</h2>
            @forelse ($socialLinks as $socialLink)
                <a href="{{ $socialLink['url'] }}" target="_blank" rel="noopener noreferrer">
                    {{ $socialLink['name'] }} <span aria-hidden="true">↗</span>
                </a>
            @empty
                <span class="site-footer__empty">{{ __('legal.footer.social_empty') }}</span>
            @endforelse
        </nav>
    </div>
    <div class="site-footer__bottom">
        <div class="wrap">{{ __('legal.footer.rights', ['year' => now()->year, 'name' => $siteName]) }}</div>
    </div>
</footer>