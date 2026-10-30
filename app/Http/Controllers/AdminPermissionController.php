<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    private function admin()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }
    public function index()
    {
        $this->admin();
        $permissions = Permission::with('roles')->orderBy('name')->get();
        return view('admin.permissions.index', compact('permissions'));
    }
    public function create()
    {
        $this->admin();
        $permission = null;
        return view('admin.permissions.form', compact('permission'));
    }
    public function store(Request $r)
    {
        $this->admin();
        $d = $r->validate(['name' => 'required|alpha_dash|max:100|unique:permissions,name', 'label' => 'required|string|max:100', 'route_name' => 'nullable|string|max:150']);
        Permission::create($d);
        return redirect()->route('admin.permissions.index')->with('success', 'تم إنشاء الصلاحية.');
    }
    public function edit(Permission $permission)
    {
        $this->admin();
        return view('admin.permissions.form', compact('permission'));
    }
    public function update(Request $r, Permission $permission)
    {
        $this->admin();
        $d = $r->validate(['name' => 'required|alpha_dash|max:100|unique:permissions,name,' . $permission->id, 'label' => 'required|string|max:100', 'route_name' => 'nullable|string|max:150']);
        $permission->update($d);
        return redirect()->route('admin.permissions.index')->with('success', 'تم تحديث الصلاحية.');
    }
    public function destroy(Permission $permission)
    {
        $this->admin();
        $permission->delete();
        return back()->with('success', 'تم حذف الصلاحية.');
    }
}
