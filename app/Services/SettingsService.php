<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService {

    public function value(string $key, mixed $default = null): mixed
    {
        $setting = Setting::where('key', $key)->first();

        if (! $setting) return $default;

        return match ($setting->type) {
            'boolean' => (bool) $setting->value,
            'integer' => (int) $setting->value,
            'decimal' => (float) $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }
}