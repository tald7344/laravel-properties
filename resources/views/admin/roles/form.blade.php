@extends('admin.layout')
@section('admin-content')
    <h1>{{ isset($role) ? __('roles.edit_role') : __('roles.create_role') }}</h1>
    <div class="panel">
        <form method="post" action="{{ isset($role) ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
            @csrf
            @if (isset($role)) @method('PUT') @endif
            <div class="formgrid">
                <input class="field" name="name" placeholder="{{ __('roles.name_placeholder') }}" value="{{ old('name', $role->name ?? '') }}" required>
                <input class="field" name="label" placeholder="{{ __('roles.label_placeholder') }}" value="{{ old('label', $role->label ?? '') }}" required>
            </div>
            <h3>{{ __('roles.permissions') }}</h3>
            <div class="permission-grid">
                @foreach ($permissions ?? \App\Models\Permission::orderBy('name')->get() as $permission)
                    <label><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked(isset($role) && $role->permissions->contains($permission->id))> {{ $permission->label }} <small class="muted">{{ $permission->route_name }}</small></label>
                @endforeach
            </div>
            <button class="btn" style="margin-top:18px">{{ __('roles.save') }}</button>
        </form>
    </div>
@endsection
