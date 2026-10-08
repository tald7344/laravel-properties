<?php
namespace App\Http\Controllers;
use App\Models\Subscription;
class AdminSubscriptionsController extends Controller { public function index(){abort_unless(auth()->check()&&auth()->user()->role==='admin',403);$subscriptions=Subscription::with('user')->latest()->paginate(20);return view('admin.subscriptions',compact('subscriptions'));} }
