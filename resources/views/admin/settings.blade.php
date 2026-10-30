@extends('admin.layout')
@section('admin-content')
    <h1>{{ __('settings.title') }}</h1>
    <p class="muted">{{ __('settings.description') }}</p>
    <form method="post" action="{{ route('admin.settings.update') }}">
        @csrf
        <div class="settings-grid">
            <div class="panel">
                <h2>{{ __('settings.general') }}</h2>
                <label>{{ __('settings.site_name') }}<input class="field" name="website_name"
                        value="{{ $settings['website_name'] ?? ($settings['site_name'] ?? __('layout.site_name')) }}"
                        required></label>
                <label>{{ __('settings.default_language') }}<select name="default_language">
                        @foreach ($languages as $language)
                            <option value="{{ $language->code }}" @selected(($settings['default_language'] ?? 'ar') === $language->code)>
                                {{ $language->native_name }}
                            </option>
                        @endforeach
                    </select></label>
                <label>
                    {{ __('settings.default_currency') }}
                    <select name="default_currency">
                        <option value="USD" @selected(($settings['default_currency'] ?? 'USD') === 'USD')>USD</option>
                        <option value="SYP" @selected(($settings['default_currency'] ?? '') === 'SYP')>SYP</option>
                    </select>
                </label>
            </div>
            <div class="panel">
                <h2>{{ __('settings.maintenance_subscription') }}</h2>
                <label>
                    <input type="checkbox" name="maintenance_mode" value="1" @checked((bool) ($settings['maintenance_mode'] ?? false))>
                    {{ __('settings.maintenance_mode') }}
                </label>
                <label>
                    {{ __('settings.premium_price_per_property') }}
                    <input class="field" type="number" step="0.01"
                        name="premium_monthly_price_per_property"
                        value="{{ $settings['premium_monthly_price_per_property'] ?? 3 }}" min="0.01" required>
                </label>
            </div>
            <div class="panel">
                <h2>{{ __('settings.seo') }}</h2>
                <label>{{ __('settings.seo_title') }}<input class="field" name="seo_title"
                        value="{{ $settings['seo_title'] ?? '' }}"></label>
                <label>{{ __('settings.seo_description') }}
                    <textarea name="seo_description" rows="3">{{ $settings['seo_description'] ?? '' }}</textarea>
                </label>
                <label>{{ __('settings.seo_keywords') }}<input class="field" name="seo_keywords"
                        value="{{ $settings['seo_keywords'] ?? '' }}"></label>
            </div>
            <div class="panel">
                <h2>{{ __('settings.default_reward') }}</h2>
                <label><input type="checkbox" name="default_reward_enabled" value="1" @checked((bool) ($settings['default_reward_enabled'] ?? false))>
                    {{ __('settings.enable_default_reward') }}</label>
                <label>{{ __('settings.reward_amount') }}<input class="field" type="number" step="0.01"
                        name="default_reward_amount" value="{{ $settings['default_reward_amount'] ?? 0 }}"></label>
            </div>
        </div>
        <button class="btn" style="margin-top:18px">{{ __('settings.save_all') }}</button>
    </form>
@endsection
