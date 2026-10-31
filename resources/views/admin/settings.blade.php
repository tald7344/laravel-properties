@extends('admin.layout')
@section('admin-content')
    <h1 class="text-2xl font-bold text-[#14231f]">{{ __('settings.title') }}</h1>
    <p class="text-sm text-[#697873]">{{ __('settings.description') }}</p>
    <form method="post" action="{{ route('admin.settings.update') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4 max-[700px]:grid-cols-1">
            <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                <h2 class="mb-4 text-lg font-bold">{{ __('settings.general') }}</h2>
                <label class="mb-3 block text-sm font-bold">{{ __('settings.site_name') }}<input class="mt-2 w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm font-normal" name="website_name"
                        value="{{ $settings['website_name'] ?? ($settings['site_name'] ?? __('layout.site_name')) }}"
                        required></label>
                <label class="mb-3 block text-sm font-bold">{{ __('settings.default_language') }}<select class="mt-2 w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm font-normal" name="default_language">
                        @foreach ($languages as $language)
                            <option value="{{ $language->code }}" @selected(($settings['default_language'] ?? 'ar') === $language->code)>
                                {{ $language->native_name }}
                            </option>
                        @endforeach
                    </select></label>
                <label>
                    {{ __('settings.default_currency') }}
                    <select class="mt-2 w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm font-normal" name="default_currency">
                        <option value="USD" @selected(($settings['default_currency'] ?? 'USD') === 'USD')>USD</option>
                        <option value="SYP" @selected(($settings['default_currency'] ?? '') === 'SYP')>SYP</option>
                    </select>
                </label>
            </div>
            <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                <h2 class="mb-4 text-lg font-bold">{{ __('settings.maintenance_subscription') }}</h2>
                <label class="mb-3 block text-sm font-bold">
                    <input type="checkbox" name="maintenance_mode" value="1" @checked((bool) ($settings['maintenance_mode'] ?? false))>
                    {{ __('settings.maintenance_mode') }}
                </label>
                <label class="mb-3 block text-sm font-bold">
                    {{ __('settings.premium_price_per_property') }}
                    <input class="mt-2 w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm font-normal" type="number" step="0.01"
                        name="premium_monthly_price_per_property"
                        value="{{ $settings['premium_monthly_price_per_property'] ?? 3 }}" min="0.01" required>
                </label>
            </div>
            <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                <h2 class="mb-4 text-lg font-bold">{{ __('settings.seo') }}</h2>
                <label class="mb-3 block text-sm font-bold">{{ __('settings.seo_title') }}<input class="mt-2 w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm font-normal" name="seo_title"
                        value="{{ $settings['seo_title'] ?? '' }}"></label>
                <label class="mb-3 block text-sm font-bold">{{ __('settings.seo_description') }}
                    <textarea class="mt-2 w-full resize-y rounded-lg border border-[#cadbd2] px-3 py-2 text-sm font-normal" name="seo_description" rows="3">{{ $settings['seo_description'] ?? '' }}</textarea>
                </label>
                <label class="mb-3 block text-sm font-bold">{{ __('settings.seo_keywords') }}<input class="mt-2 w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm font-normal" name="seo_keywords"
                        value="{{ $settings['seo_keywords'] ?? '' }}"></label>
            </div>
            <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                <h2 class="mb-4 text-lg font-bold">{{ __('settings.default_reward') }}</h2>
                <label class="mb-3 block text-sm font-bold"><input type="checkbox" name="default_reward_enabled" value="1" @checked((bool) ($settings['default_reward_enabled'] ?? false))>
                    {{ __('settings.enable_default_reward') }}</label>
                <label class="mb-3 block text-sm font-bold">{{ __('settings.reward_amount') }}<input class="mt-2 w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm font-normal" type="number" step="0.01"
                        name="default_reward_amount" value="{{ $settings['default_reward_amount'] ?? 0 }}"></label>
            </div>
            <section class="col-span-full rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm" aria-labelledby="social-links-title">
                <div class="mb-[18px] flex items-center justify-between gap-4">
                    <div>
                        <h2 id="social-links-title">{{ __('legal.social.title') }}</h2>
                        <p class="mt-[5px] text-[11px] leading-[1.7] text-[#78908a]">{{ __('legal.social.description') }}</p>
                    </div>
                    <button class="inline-block rounded-xl bg-[#dff5e9] px-[18px] py-[11px] font-bold text-[#176b52]" type="button" data-add-social>{{ __('legal.social.add') }}</button>
                </div>
                <div class="grid gap-3" data-social-links data-next-index="{{ count($socialLinks) }}">
                    @foreach ($socialLinks as $index => $socialLink)
                        <div class="grid grid-cols-[minmax(160px,.7fr)_minmax(220px,1.4fr)_auto] items-end gap-3 max-[700px]:grid-cols-1" data-social-row>
                            <label class="grid gap-[7px] text-[11px] font-bold text-[#14231f]">
                                {{ __('legal.social.name') }}
                                <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-[11px] font-normal" name="social_links[{{ $index }}][name]" value="{{ $socialLink['name'] }}" maxlength="60" required>
                            </label>
                            <label class="grid gap-[7px] text-[11px] font-bold text-[#14231f]">
                                {{ __('legal.social.url') }}
                                <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-[11px] font-normal" type="url" name="social_links[{{ $index }}][url]" value="{{ $socialLink['url'] }}" placeholder="https://" required>
                            </label>
                            <button class="cursor-pointer rounded-lg border border-[#cadbd2] px-3 py-2 text-[11px] text-[#176b52]" type="button" data-remove-social>{{ __('legal.social.remove') }}</button>
                        </div>
                    @endforeach
                </div>
                <template data-social-template>
                    <div class="grid grid-cols-[minmax(160px,.7fr)_minmax(220px,1.4fr)_auto] items-end gap-3 max-[700px]:grid-cols-1" data-social-row>
                        <label class="grid gap-[7px] text-[11px] font-bold text-[#14231f]">
                            {{ __('legal.social.name') }}
                            <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-[11px] font-normal" name="social_links[__INDEX__][name]" maxlength="60" required>
                        </label>
                        <label class="grid gap-[7px] text-[11px] font-bold text-[#14231f]">
                            {{ __('legal.social.url') }}
                            <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-[11px] font-normal" type="url" name="social_links[__INDEX__][url]" placeholder="https://" required>
                        </label>
                        <button class="cursor-pointer rounded-lg border border-[#cadbd2] px-3 py-2 text-[11px] text-[#176b52]" type="button" data-remove-social>{{ __('legal.social.remove') }}</button>
                    </div>
                </template>
                <p class="mt-[14px]! text-[11px] leading-[1.7] text-[#78908a]">{{ __('legal.social.hint') }}</p>
            </section>
        </div>
        <button class="mt-[18px] cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white">{{ __('settings.save_all') }}</button>
    </form>
@endsection
