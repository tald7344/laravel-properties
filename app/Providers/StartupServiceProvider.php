<?php

namespace App\Providers;

use App\Services\LanguagesService;
use App\Services\SettingsService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class StartupServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $setting = $this->app->make(SettingsService::class);
        $language = $this->app->make(LanguagesService::class);

        View::composer('layouts.app', function ($view) use ($setting, $language): void {
            // Schema::hasTable(...) checks whether the settings and languages tables exist before the code tries to query them. This is useful during setup and in tests before migrations have run.
            $hasSettings = Schema::hasTable('settings');
            $hasLanguages = Schema::hasTable('languages');
            $siteName = $hasSettings ? $setting->value('website_name', $setting->value('site_name', __('layout.site_name'))) : __('layout.site_name');
            $languages = $hasLanguages ? $language->getActive() : collect();

            $view->with([
                'siteName' => $siteName,
                'languages' => $languages,
                'currentLanguage' => $languages->firstWhere('code', app()->getLocale()),
                'siteDescription' => $hasSettings ? $setting->value('seo_description', __('layout.description')) : __('layout.description'),
                'siteSeoKeywords' => $hasSettings ? $setting->value('seo_keywords', __('layout.keywords')) : __('layout.keywords'),
                'siteSeoTitle' => $hasSettings ? $setting->value('seo_title', $siteName) : $siteName,
            ]);
        });
    }
}
