<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request; use Symfony\Component\HttpFoundation\Response;
class SetLocale { public function handle(Request $request,Closure $next):Response{$locale=session('locale',\App\Models\Setting::value('default_language','ar'));app()->setLocale($locale);return $next($request);} }
