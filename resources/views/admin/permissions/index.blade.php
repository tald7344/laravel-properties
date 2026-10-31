@extends('admin.layout')
@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-4 max-[600px]:items-start max-[600px]:flex-col">
        <div><h1>{{ __('permissions.title') }}</h1><p class="text-sm text-[#697873]">{{ __('permissions.description') }}</p></div>
        <a class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white" href="{{ route('admin.permissions.create') }}">+ {{ __('permissions.add') }}</a>
    </div>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
            <tr><th>{{ __('permissions.permission') }}</th><th>{{ __('permissions.programmatic_name') }}</th><th>{{ __('permissions.route') }}</th><th>{{ __('permissions.roles') }}</th><th>{{ __('permissions.action') }}</th></tr>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->label }}</td><td>{{ $permission->name }}</td><td><code>{{ $permission->route_name ?? '—' }}</code></td>
                    <td>@foreach ($permission->roles as $role)<span class="inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ $role->name }}</span> @endforeach</td>
                    <td>
                        <a class="inline-block rounded-xl bg-[#dff5e9] px-[18px] py-[11px] font-bold text-[#176b52]" href="{{ route('admin.permissions.edit', $permission) }}">{{ __('permissions.edit') }}</a>
                        <form method="post" action="{{ route('admin.permissions.destroy', $permission) }}" class="inline-block" data-confirm="{{ __('permissions.delete_confirm') }}">@csrf @method('DELETE')<button class="inline-block cursor-pointer rounded-xl border border-[#cadbd2] px-[18px] py-[11px] font-bold text-[#176b52]">{{ __('permissions.delete') }}</button></form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
