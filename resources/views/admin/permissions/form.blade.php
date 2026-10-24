@extends('admin.layout')
@section('admin-content')
    <h1>{{ isset($permission) ? __('permissions.edit_permission') : __('permissions.create_permission') }}</h1>
    <div class="panel">
        <form method="post" action="{{ isset($permission) ? route('admin.permissions.update', $permission) : route('admin.permissions.store') }}">
            @csrf
            @if (isset($permission)) @method('PUT') @endif
            <input class="field" name="name" placeholder="manage-properties" value="{{ old('name', $permission->name ?? '') }}" required style="margin-bottom:12px">
            <input class="field" name="label" placeholder="{{ __('permissions.label_placeholder') }}" value="{{ old('label', $permission->label ?? '') }}" required style="margin-bottom:12px">
            <input class="field" name="route_name" placeholder="admin.section" value="{{ old('route_name', $permission->route_name ?? '') }}">
            <p class="muted">{{ __('permissions.route_help') }}</p>
            <button class="btn">{{ __('permissions.save') }}</button>
        </form>
    </div>
@endsection
