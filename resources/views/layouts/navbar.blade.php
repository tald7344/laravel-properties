<nav class="border-b border-[#e7eee9] bg-white">
    <div class="max-[700px]:h-auto max-[700px]:min-h-[68px] max-[700px]:flex-wrap max-[700px]:py-[10px] mx-auto max-w-[1160px] px-[22px] flex h-[76px] items-center justify-between gap-[18px]">
        <a class="text-[21px] font-extrabold text-[var(--green)]" href="{{ route('home') }}">{{ __('layout.brand') }}</a>
        <div class="max-[700px]:flex-wrap max-[700px]:justify-end max-[700px]:gap-x-[14px] max-[700px]:gap-y-[10px] flex items-center gap-4 text-[13px] text-[#49635a]">
            <a class="max-[800px]:hidden" href="{{ route('properties.index') }}">{{ __('layout.explore') }}</a>
            <details class="language-menu group relative text-[13px] text-[#49635a]">
                <summary
                    class="flex list-none cursor-pointer items-center gap-[7px] rounded-[9px] border border-[#e5ece8] bg-white px-[10px] py-2 focus-visible:outline-2 focus-visible:outline-[var(--green)] focus-visible:outline-offset-2 group-open:border-[#b8d6c8]"
                    aria-label="{{ __('layout.language_change') }}">
                    <span>{{ $currentLanguage?->native_name ?? strtoupper(app()->getLocale()) }}</span>
                    <span class="language-menu-chevron text-base leading-none text-[var(--muted)]" aria-hidden="true">
                        <img class="size-4" src="{{ asset('assets/icons/chevron-down-black.svg') }}">
                    </span>
                </summary>
                <div class="language-menu-options absolute end-0 top-[calc(100%+8px)] z-20 min-w-[170px] rounded-[11px] border border-[#e5ece8] bg-white p-[6px] shadow-[0_12px_28px_rgba(20,50,38,0.13)]">
                    @forelse ($languages as $language)
                        <a class="max-[800px]:hidden flex items-center justify-between gap-4 rounded-[7px] px-[10px] py-[9px] text-[var(--ink)] hover:bg-[#f0f7f3] hover:text-[var(--green)] aria-[current=true]:bg-[#f0f7f3] aria-[current=true]:text-[var(--green)] focus-visible:outline-2 focus-visible:outline-[var(--green)] focus-visible:outline-offset-2"
                            href="{{ route('language.switch', $language) }}" lang="{{ $language->code }}"
                            @if ($language->code === app()->getLocale()) aria-current="true" @endif>
                            <span>{{ $language->native_name }}</span>
                            <small class="text-[10px] text-[var(--muted)]">{{ strtoupper($language->code) }}</small>
                        </a>
                    @empty
                        <span class="language-menu-empty block whitespace-nowrap p-[10px] text-[10px] text-[var(--muted)]">{{ __('layout.language_none') }}</span>
                    @endforelse
                </div>
            </details>
            @auth 
                @if (in_array(auth()->user()->role, ['owner', 'admin']))
                    <a class="max-[800px]:hidden" href="{{ route('owner.dashboard') }}">{{ __('layout.owner_dashboard') }}</a>
                    @if (auth()->user()->role === 'owner')
                        <a class="max-[800px]:hidden"
                            href="{{ route('owner.profile.edit') }}">{{ __('layout.profile') }}</a>
                    @endif
                @elseif (in_array(auth()->user()->role, ['tenant', 'renter']))
                    <a class="max-[800px]:hidden" href="{{ route('renter.dashboard') }}">{{ __('layout.renter_dashboard') }}</a>
                    <a class="max-[800px]:hidden" href="{{ route('renter.profile.edit') }}">{{ __('layout.profile') }}</a>
                @endif 

                @if (auth()->user()->role === 'admin')
                    <a class="max-[800px]:hidden" href="{{ route('admin.dashboard') }}">{{ __('layout.admin') }}</a>
                @endif
                    <form method="post" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button class="inline-block cursor-pointer rounded-[10px] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold border border-[#cadbd2] bg-transparent text-[var(--green)]">
                            {{ __('layout.logout') }}</button>
                    </form>
                @else
                <a class="inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white"
                   href="{{ route('auth.form') }}">
                {{ __('layout.login_register') }}
                </a>
            @endauth
    </div>
</div>
</nav>
