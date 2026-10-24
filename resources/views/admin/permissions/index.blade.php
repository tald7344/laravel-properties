@extends('admin.layout')
@section('admin-content')
    <div class="sectionhead">
        <div><h1>{{ __('permissions.title') }}</h1><p class="muted">{{ __('permissions.description') }}</p></div>
        <a class="btn" href="{{ route('admin.permissions.create') }}">+ {{ __('permissions.add') }}</a>
    </div>
    <div class="panel">
        <table class="table">
            <tr><th>{{ __('permissions.permission') }}</th><th>{{ __('permissions.programmatic_name') }}</th><th>{{ __('permissions.route') }}</th><th>{{ __('permissions.roles') }}</th><th>{{ __('permissions.action') }}</th></tr>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->label }}</td><td>{{ $permission->name }}</td><td><code>{{ $permission->route_name ?? '—' }}</code></td>
                    <td>@foreach ($permission->roles as $role)<span class="tag">{{ $role->name }}</span> @endforeach</td>
                    <td>
                        <a class="btn alt" href="{{ route('admin.permissions.edit', $permission) }}">{{ __('permissions.edit') }}</a>
                        <form method="post" action="{{ route('admin.permissions.destroy', $permission) }}" style="display:inline" data-confirm="{{ __('permissions.delete_confirm') }}">@csrf @method('DELETE')<button class="btn outline">{{ __('permissions.delete') }}</button></form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
