@extends('admin.layout')
@section('admin-content')
    <h1>{{ isset($permission) ? __('permissions.edit_permission') : __('permissions.create_permission') }}</h1>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <form method="post" action="{{ isset($permission) ? route('admin.permissions.update', $permission) : route('admin.permissions.store') }}">
            @csrf
            @if (isset($permission)) @method('PUT') @endif
            <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm" name="name" placeholder="manage-properties" value="{{ old('name', $permission->name ?? '') }}" required >
            <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm" name="label" placeholder="{{ __('permissions.label_placeholder') }}" value="{{ old('label', $permission->label ?? '') }}" required >
            <input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm" name="route_name" placeholder="admin.section" value="{{ old('route_name', $permission->route_name ?? '') }}">
            <p class="text-sm text-[#697873]">{{ __('permissions.route_help') }}</p>
            <button class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white">{{ __('permissions.save') }}</button>
        </form>
    </div>
@endsection
