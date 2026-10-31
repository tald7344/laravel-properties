@extends('admin.layout')
@section('admin-content')
    <div class="mb-5 flex items-center justify-between gap-4 max-[600px]:items-start max-[600px]:flex-col">
        <div><h1>{{ __('roles.title') }}</h1><p class="text-sm text-[#697873]">{{ __('roles.description') }}</p></div>
        <a class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white" href="{{ route('admin.roles.create') }}">+ {{ __('roles.add_role') }}</a>
    </div>
    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
            <tr><th>{{ __('roles.role') }}</th><th>{{ __('roles.programmatic_name') }}</th><th>{{ __('roles.permissions') }}</th><th>{{ __('roles.action') }}</th></tr>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ __('roles.name_'.$role->name) !== 'roles.name_'.$role->name ? __('roles.name_'.$role->name) : $role->label }}</td>
                    <td>{{ $role->name }}</td>
                    <td>@forelse ($role->permissions as $permission)<span class="inline-flex rounded-full bg-[#dff5e9] px-3 py-1 text-xs font-bold text-[#176b52]">{{ $permission->label }}</span> @empty<span class="text-sm text-[#697873]">{{ __('roles.none') }}</span>@endforelse</td>
                    <td>
                        <a class="inline-block rounded-xl bg-[#dff5e9] px-[18px] py-[11px] font-bold text-[#176b52]" href="{{ route('admin.roles.edit', $role) }}">{{ __('roles.edit') }}</a>
                        <form method="post" action="{{ route('admin.roles.destroy', $role) }}" class="inline-block" data-confirm="{{ __('roles.delete_confirm') }}">@csrf @method('DELETE')<button class="inline-block cursor-pointer rounded-xl border border-[#cadbd2] px-[18px] py-[11px] font-bold text-[#176b52]">{{ __('roles.delete') }}</button></form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
