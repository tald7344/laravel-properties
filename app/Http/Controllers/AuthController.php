<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OwnerSubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function form()
    {
        return view('auth.form');
    }

    public function register(Request $request, OwnerSubscriptionService $subscriptions)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|min:8|max:30|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:owner,tenant',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['phone'] . '@phone.local',
            'phone' => $data['phone'],
            'password' => $data['password'],
            'role' => $data['role'],
        ]);

        if ($user->role === 'owner') {
            $subscriptions->ensureBasicPlan($user);
        }

        auth()->login($user);

        return redirect($data['role'] === 'owner'
            ? route('owner.dashboard')
            : route('renter.dashboard'));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('phone', $data['phone'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['phone' => __('بيانات الدخول غير صحيحة.')]);
        }

        auth()->login($user, $request->boolean('remember'));

        if ($user->role === 'owner') {
            return redirect()->route('owner.dashboard');
        }

        return in_array($user->role, ['tenant', 'renter'], true)
            ? redirect()->route('renter.dashboard')
            : redirect()->route('home');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
