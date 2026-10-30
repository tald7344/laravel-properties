<?php

namespace App\Http\Middleware;

use App\Services\SettingsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{

    private SettingsService $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $defaultLanguage = $this->settingsService->value('default_language', 'ar');
        $locale = session('locale', $defaultLanguage);
        app()->setLocale($locale);
        return $next($request);
    }
}
