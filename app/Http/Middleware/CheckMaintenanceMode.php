<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request; use Symfony\Component\HttpFoundation\Response;
class CheckMaintenanceMode { public function handle(Request $request,Closure $next):Response{if(\App\Models\Setting::value('maintenance_mode',false)&&!($request->is('admin/*')&&auth()->check()&&auth()->user()->role==='admin'))return response()->view('maintenance',[],503);return $next($request);} }
