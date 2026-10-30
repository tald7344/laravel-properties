<?php

namespace App\Http\Middleware;

use App\Services\SettingsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    private SettingsService $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->settingsService->value('maintenance_mode', false) && !($request->is('admin/*') && auth()->check() && auth()->user()->role === 'admin')) {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
