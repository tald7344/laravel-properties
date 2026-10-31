@extends('admin.layout')
@section('admin-content')
    <h1>{{ isset($role) ? __('roles.edit_role') : __('roles.create_role') }}</h1>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <form method="post" action="{{ isset($role) ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
            @csrf
            @if (isset($role)) @method('PUT') @endif
            <div class="grid grid-cols-2 gap-3 max-[600px]:grid-cols-1">
                <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm" name="name" placeholder="{{ __('roles.name_placeholder') }}" value="{{ old('name', $role->name ?? '') }}" required>
                <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm" name="label" placeholder="{{ __('roles.label_placeholder') }}" value="{{ old('label', $role->label ?? '') }}" required>
            </div>
            <h3>{{ __('roles.permissions') }}</h3>
            <div class="grid grid-cols-2 gap-3 max-[600px]:grid-cols-1">
                @foreach ($permissions ?? \App\Models\Permission::orderBy('name')->get() as $permission)
                    <label><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked(isset($role) && $role->permissions->contains($permission->id))> {{ $permission->label }} <small class="text-sm text-[#697873]">{{ $permission->route_name }}</small></label>
                @endforeach
            </div>
            <button class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white" >{{ __('roles.save') }}</button>
        </form>
    </div>
@endsection
