<footer class="border-t border-[#e5ece8] bg-[#102b27] pt-12 text-[#dcebe5]">
    <div class="mx-auto grid max-w-[1160px] grid-cols-[1.4fr_1fr_1fr] gap-[4.8rem] px-[22px] pb-12 max-[700px]:grid-cols-2 max-[700px]:gap-x-5 max-[700px]:gap-y-7 max-[420px]:grid-cols-1">
        <section class="max-[700px]:col-span-full max-[420px]:col-auto" aria-label="{{ __('legal.footer.brand') }}">
            <a class="text-[25px] font-extrabold text-white" href="{{ route('home') }}">{{ $siteName }}</a>
            <p class="mt-3 max-w-[390px] text-xs leading-[1.9] text-[#a9c1b8]">{{ __('layout.footer') }}</p>
        </section>
        <nav class="flex flex-col items-start gap-[9px]" aria-label="{{ __('legal.footer.legal_links') }}">
            <h2 class="mb-[5px] text-sm text-white">{{ __('legal.footer.legal_links') }}</h2>
            @foreach ($legalPages as $legalPage)
                @if ($legalPage->footerTranslation)
                    <a class="text-xs text-[#b6cec4] transition-colors duration-200 hover:text-white" href="{{ route('legal.show', $legalPage->slug) }}">{{ $legalPage->footerTranslation->title }}</a>
                @endif
            @endforeach
        </nav>
        <nav class="flex flex-col items-start gap-[9px]" aria-label="{{ __('legal.footer.social_links') }}">
            <h2 class="mb-[5px] text-sm text-white">{{ __('legal.footer.social_links') }}</h2>
            @forelse ($socialLinks as $socialLink)
                <a class="text-xs text-[#b6cec4] transition-colors duration-200 hover:text-white" href="{{ $socialLink['url'] }}" target="_blank" rel="noopener noreferrer">
                    {{ $socialLink['name'] }} <span class="ms-1 text-[#e3a85e]" aria-hidden="true">↗</span>
                </a>
            @empty
                <span class="text-xs text-[#b6cec4]">{{ __('legal.footer.social_empty') }}</span>
            @endforelse
        </nav>
    </div>
    <div class="border-t border-white/10 py-[14px] text-[15px] text-[#8eaaa0]">
        <p class="mx-auto max-w-[1160px] px-[22px]">{{ __('legal.footer.rights', ['year' => now()->year, 'name' => $siteName]) }}</p>
    </div>
</footer>