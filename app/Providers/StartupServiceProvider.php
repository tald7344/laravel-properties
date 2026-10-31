<?php

namespace App\Providers;

use App\Services\LanguagesService;
use App\Services\SettingsService;
use App\Models\Language;
use App\Models\LegalPage;
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

        // View::share(...) Not usefull here because it's makes values available to all views.
        // It’s convenient for truly universal values, but if you load the settings and languages before calling it in boot(),
        // those lookups happen on every request—including requests that never render a view.
        View::composer('layouts.app', function ($view) use ($setting, $language): void {
            // Schema::hasTable(...) checks whether the settings and languages tables exist before the code tries to query them. This is useful during setup and in tests before migrations have run.
            $hasSettings = Schema::hasTable('settings');
            $hasLanguages = Schema::hasTable('languages');
            $hasLegalPages = Schema::hasTable('legal_pages') && Schema::hasTable('legal_page_translations');
            $siteName = $hasSettings ? $setting->value('website_name', $setting->value('site_name', __('layout.site_name'))) : __('layout.site_name');
            $languages = $hasLanguages ? $language->getActive() : collect();
            $currentLanguage = $languages->firstWhere('code', app()->getLocale());
            $defaultLanguage = $languages->firstWhere('is_default', true);
            $legalPages = $hasLegalPages
                ? LegalPage::with('translations.language')->where('is_published', true)->orderBy('sort_order')->orderBy('slug')->get()
                : collect();
            $legalPages->each(function (LegalPage $page) use ($currentLanguage, $defaultLanguage): void {
                $page->setRelation(
                    'footerTranslation',
                    $page->translations->firstWhere('language_id', $currentLanguage?->id)
                        ?? $page->translations->firstWhere('language_id', $defaultLanguage?->id)
                );
            });
            $socialLinks = $hasSettings ? $setting->value('social_links', []) : [];
            $socialLinks = is_array($socialLinks) ? $socialLinks : [];

            $view->with([
                'siteName' => $siteName,
                'languages' => $languages,
                'currentLanguage' => $currentLanguage,
                'legalPages' => $legalPages,
                'socialLinks' => $socialLinks,
                'siteDescription' => $hasSettings ? $setting->value('seo_description', __('layout.description')) : __('layout.description'),
                'siteSeoKeywords' => $hasSettings ? $setting->value('seo_keywords', __('layout.keywords')) : __('layout.keywords'),
                'siteSeoTitle' => $hasSettings ? $setting->value('seo_title', $siteName) : $siteName,
            ]);
        });
    }
}
