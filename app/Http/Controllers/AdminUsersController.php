<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminUsersController extends Controller
{
    public function index()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
        $users = User::with('roles')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }
}
