@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="wrap admin-layout">
            <aside class="panel admin-sidebar">
                <h3>{{ __('admin-section.management') }}</h3>
                <a href="{{ route('admin.dashboard') }}">▦ {{ __('roles.view_analytics') }}</a>
                <a href="{{ route('admin.roles') }}">♙ {{ __('roles.defined_roles') }}</a>
                <a href="{{ route('admin.section', 'settings') }}">⚙ {{ __('roles.settings') }}</a>
            </aside>
            <main class="admin-main">
                <h1>{{ __('roles.defined_roles') }}</h1>
                <p class="muted">{{ __('roles.role_system') }}</p>
                <div class="grid">
                    @foreach ($roles as $role)
                        <div class="panel">
                            <h2>{{ __('roles.name_'.$role->name) !== 'roles.name_'.$role->name ? __('roles.name_'.$role->name) : $role->label }} <small class="muted">({{ $role->name }})</small></h2>
                            @forelse ($role->permissions as $permission)
                                <span class="tag" style="margin:3px">{{ $permission->label }}</span>
                            @empty
                                <p class="muted">{{ __('roles.no_custom_permissions') }}</p>
                            @endforelse
                        </div>
                    @endforeach
                </div>
                <div class="panel" style="margin-top:20px">
                    <h2>{{ __('roles.defined_permissions') }}</h2>
                    @foreach ($permissions as $permission)
                        <span class="tag" style="margin:3px">{{ $permission->label }} · {{ $permission->name }}</span>
                    @endforeach
                </div>
            </main>
        </div>
    </section>
@endsection
