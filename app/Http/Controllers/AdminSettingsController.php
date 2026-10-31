<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminSettingsController extends Controller
{
    private function admin()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }
    public function index(SettingsService $settingsService)
    {
        $this->admin();
        $settings = Setting::pluck('value', 'key');
        $socialLinks = $settingsService->value('social_links', []);
        $socialLinks = is_array($socialLinks) ? $socialLinks : [];
        $languages = Language::where('is_active', true)->orderByDesc('is_default')->orderBy('name')->get();
        return view('admin.settings', compact('settings', 'languages', 'socialLinks'));
    }
    public function update(Request $r)
    {
        $this->admin();
        $socialLinks = $r->input('social_links', []);
        if (is_array($socialLinks)) {
            $socialLinks = array_values(array_filter(
                $socialLinks,
                fn ($link) => is_array($link) && (filled($link['name'] ?? null) || filled($link['url'] ?? null))
            ));
            $r->merge(['social_links' => $socialLinks]);
        }
        $d = $r->validate([
            'default_language' => ['required', 'string', Rule::exists('languages', 'code')->where('is_active', true)],
            'maintenance_mode' => 'nullable|boolean',
            'website_name' => 'required|string|max:150',
            'premium_monthly_price_per_property' => 'required|numeric|min:0.01|max:1000000',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:500',
            'default_currency' => 'required|in:USD,SYP',
            'default_reward_enabled' => 'nullable|boolean',
            'default_reward_amount' => 'nullable|numeric|min:0',
            'social_links' => 'nullable|array|max:12',
            'social_links.*.name' => 'required|string|max:60',
            'social_links.*.url' => 'required|url:https|max:255',
        ]);
        $d['maintenance_mode'] = $r->boolean('maintenance_mode');
        $d['default_reward_enabled'] = $r->boolean('default_reward_enabled');
        foreach ($d as $key => $value) {
            $type = $key === 'social_links'
                ? 'json'
                : (is_bool($value) ? 'boolean' : (in_array($key, ['default_reward_amount'], true) ? 'integer' : (is_numeric($value) ? 'decimal' : 'string')));
            $settingValue = $key === 'social_links'
                ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
                : (is_bool($value) ? (int) $value : $value);
            Setting::updateOrCreate(['key' => $key], ['value' => $settingValue, 'type' => $type]);
        }
        return back()->with('success', 'تم حفظ إعدادات الموقع.');
    }
}
