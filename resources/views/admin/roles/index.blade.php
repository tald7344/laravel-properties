@extends('admin.layout')
@section('admin-content')
    <div class="sectionhead">
        <div><h1>{{ __('roles.title') }}</h1><p class="muted">{{ __('roles.description') }}</p></div>
        <a class="btn" href="{{ route('admin.roles.create') }}">+ {{ __('roles.add_role') }}</a>
    </div>
    <div class="panel">
        <table class="table">
            <tr><th>{{ __('roles.role') }}</th><th>{{ __('roles.programmatic_name') }}</th><th>{{ __('roles.permissions') }}</th><th>{{ __('roles.action') }}</th></tr>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ __('roles.name_'.$role->name) !== 'roles.name_'.$role->name ? __('roles.name_'.$role->name) : $role->label }}</td>
                    <td>{{ $role->name }}</td>
                    <td>@forelse ($role->permissions as $permission)<span class="tag">{{ $permission->label }}</span> @empty<span class="muted">{{ __('roles.none') }}</span>@endforelse</td>
                    <td>
                        <a class="btn alt" href="{{ route('admin.roles.edit', $role) }}">{{ __('roles.edit') }}</a>
                        <form method="post" action="{{ route('admin.roles.destroy', $role) }}" style="display:inline" data-confirm="{{ __('roles.delete_confirm') }}">@csrf @method('DELETE')<button class="btn outline">{{ __('roles.delete') }}</button></form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
