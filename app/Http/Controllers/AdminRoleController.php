<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    private function admin()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }
    public function index()
    {
        $this->admin();
        $roles = Role::with('permissions')->orderBy('name')->get();
        return view('admin.roles.index', compact('roles'));
    }
    public function create()
    {
        $this->admin();
        $role = null;
        $permissions = Permission::orderBy('name')->get();
        return view('admin.roles.form', compact('role', 'permissions'));
    }
    public function store(Request $r)
    {
        $this->admin();
        $d = $r->validate(['name' => 'required|alpha_dash|max:50|unique:roles,name', 'label' => 'required|string|max:100', 'permissions' => 'array', 'permissions.*' => 'exists:permissions,id']);
        $role = Role::create(['name' => $d['name'], 'label' => $d['label']]);
        $role->permissions()->sync($d['permissions'] ?? []);
        return redirect()->route('admin.roles.index')->with('success', 'تم إنشاء الدور.');
    }
    public function edit(Role $role)
    {
        $this->admin();
        $permissions = Permission::orderBy('name')->get();
        return view('admin.roles.form', compact('role', 'permissions'));
    }
    public function update(Request $r, Role $role)
    {
        $this->admin();
        $d = $r->validate(['name' => 'required|alpha_dash|max:50|unique:roles,name,' . $role->id, 'label' => 'required|string|max:100', 'permissions' => 'array', 'permissions.*' => 'exists:permissions,id']);
        $role->update(['name' => $d['name'], 'label' => $d['label']]);
        $role->permissions()->sync($d['permissions'] ?? []);
        return redirect()->route('admin.roles.index')->with('success', 'تم تحديث الدور.');
    }
    public function destroy(Role $role)
    {
        $this->admin();
        abort_if(in_array($role->name, ['admin', 'owner', 'renter']), 422, 'لا يمكن حذف أدوار النظام الأساسية.');
        $role->delete();
        return back()->with('success', 'تم حذف الدور.');
    }
}
