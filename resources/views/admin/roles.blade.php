@extends('layouts.app')
@section('content')
    <section class="px-5 py-8">
        <div class="mx-auto flex max-w-[1160px] gap-5 px-[22px] py-8">
            <aside class="flex w-[238px] shrink-0 flex-col gap-3 rounded-xl bg-[#102b27] p-5 text-white">
                <h3>{{ __('admin-section.management') }}</h3>
                <a href="{{ route('admin.dashboard') }}">▦ {{ __('roles.view_analytics') }}</a>
                <a href="{{ route('admin.roles') }}">♙ {{ __('roles.defined_roles') }}</a>
                <a href="{{ route('admin.section', 'settings') }}">⚙ {{ __('roles.settings') }}</a>
            </aside>
            <main class="min-w-0 flex-1">
                <h1>{{ __('roles.defined_roles') }}</h1>
                <p class="text-sm text-[#697873]">{{ __('roles.role_system') }}</p>
                <div class="grid grid-cols-3 gap-4 max-[700px]:grid-cols-1">
                    @foreach ($roles as $role)
                        <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                            <h2>{{ __('roles.name_'.$role->name) !== 'roles.name_'.$role->name ? __('roles.name_'.$role->name) : $role->label }} <small class="text-sm text-[#697873]">({{ $role->name }})</small></h2>
                            @forelse ($role->permissions as $permission)
                                <span class="m-[3px] inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ $permission->label }}</span>
                            @empty
                                <p class="text-sm text-[#697873]">{{ __('roles.no_custom_permissions') }}</p>
                            @endforelse
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                    <h2>{{ __('roles.defined_permissions') }}</h2>
                    @foreach ($permissions as $permission)
                        <span class="m-[3px] inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ $permission->label }} · {{ $permission->name }}</span>
                    @endforeach
                </div>
            </main>
        </div>
    </section>
@endsection
