@extends('layouts.app') 
@section('content')<section class="px-5 py-8">
        <div class="mx-auto flex max-w-[1160px] gap-5 px-[22px] py-8">
            <aside class="flex w-[238px] shrink-0 flex-col gap-3 rounded-xl bg-[#102b27] p-5 text-white">
                <h3>{{ __('admin-section.management') }}</h3><a href="{{ route('admin.dashboard') }}">▦ {{ __('admin-section.analytics') }}</a><a
                    href="{{ route('admin.section', 'properties') }}">⌂ {{ __('admin-section.properties') }}</a><a
                    href="{{ route('admin.section', 'users') }}">♙ {{ __('admin-section.users') }}</a><a
                    href="{{ route('admin.section', 'subscriptions') }}">◷ {{ __('admin-section.subscriptions') }}</a><a
                    href="{{ route('admin.section', 'complaints') }}">⚑ {{ __('admin-section.complaints') }}</a><a
                    href="{{ route('admin.section', 'settings') }}">⚙ {{ __('admin-section.settings') }}</a>
            </aside>
            <main class="min-w-0 flex-1">
                <h1>
                    {{ __("admin-section.{$section}") }}
                </h1>
                @if ($section === 'properties')
                    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
                            <tr>
                                <th>{{ __('admin-section.property') }}</th>
                                <th>{{ __('admin-section.owner') }}</th>
                                <th>{{ __('admin-section.city') }}</th>
                                <th>{{ __('admin-section.status') }}</th>
                                <th></th>
                            </tr>
                            @foreach ($properties as $p)
                                <tr>
                                    <td>{{ $p->title }}</td>
                                    <td>{{ $p->owner->name }}</td>
                                    <td>{{ $p->city }}</td>
                                    <td>{{ __("admin-section.status_{$p->status}") }}</td>
                                    <td>
                                        <form method="post" action="{{ route('admin.moderate', $p) }}">
                                            @csrf
                                            <select name="status" class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]">
                                                <option value="published">{{ __('admin-section.publish') }}</option>
                                                <option value="suspended">{{ __('admin-section.suspend') }}</option>
                                                <option value="expired">{{ __('admin-section.expire') }}</option>
                                            </select>
                                            <button class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white">{{ __('admin-section.save') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @elseif($section === 'users')
                    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
                            <tr>
                                <th>{{ __('admin-section.name') }}</th>
                                <th>{{ __('admin-section.phone') }}</th>
                                <th>{{ __('admin-section.role') }}</th>
                                <th>{{ __('admin-section.registered') }}</th>
                            </tr>
                            @foreach ($users as $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->phone }}</td>
                                    <td>{{ __("admin-section.role_{$u->role}") }}</td>
                                    <td>{{ $u->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @elseif($section === 'subscriptions')
                    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
                            <tr>
                                <th>{{ __('admin-section.owner') }}</th>
                                <th>{{ __('admin-section.amount') }}</th>
                                <th>{{ __('admin-section.sham_cash_reference') }}</th>
                                <th>{{ __('admin-section.status') }}</th>
                                <th>{{ __('admin-section.ends') }}</th>
                            </tr>
                            @foreach ($subscriptions as $s)
                                <tr>
                                    <td>{{ $s->user->name }}</td>
                                    <td>{{ $s->amount }}</td>
                                    <td>{{ $s->sham_cash_reference }}</td>
                                    <td>{{ __("admin-section.subscription_{$s->status}") }}</td>
                                    <td>{{ $s->ends_at?->format('Y-m-d H:i') ?? __('admin-section.pending_approval') }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @elseif($section === 'complaints')
                    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                        <table class="w-full border-collapse text-right text-sm [&_th]:border-b [&_th]:border-[#e4eeea] [&_th]:px-3 [&_th]:py-3 [&_th]:text-xs [&_th]:font-bold [&_td]:border-b [&_td]:border-[#edf3f0] [&_td]:px-3 [&_td]:py-3">
                            <tr>
                                <th>{{ __('admin-section.property') }}</th>
                                <th>{{ __('admin-section.type') }}</th>
                                <th>{{ __('admin-section.details') }}</th>
                                <th>{{ __('admin-section.status') }}</th>
                                <th></th>
                            </tr>
                            @foreach ($reports as $r)
                                <tr>
                                    <td>
                                        @if ($r->subject_type === 'property')
                                            {{ $r->property?->title ?? __('admin-section.deleted_property') }}
                                        @else
                                            {{ $r->subject_type === 'owner' ? __('admin-section.owner') : __('admin-section.tenant') }}: {{ $r->subject_name }}
                                        @endif
                                    </td>
                                    <td>{{ __("complaints.type_{$r->type}") }}</td>
                                    <td>{{ $r->details }}</td>
                                    <td>{{ __("admin-section.status_{$r->status}") }}</td>
                                    <td>
                                        @if ($r->status === 'open')
                                            <form method="post" action="{{ route('admin.reports.resolve', $r) }}">
                                                @csrf
                                                <button class="inline-block rounded-xl bg-[#dff5e9] px-[18px] py-[11px] font-bold text-[#176b52]">{{ __('admin-section.close') }}</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="rounded-xl border border-[#e4eeea] bg-white p-5 shadow-sm">
                        <form method="post" action="{{ route('admin.settings.save') }}">
                            @csrf
                            @foreach ($settings as $setting)
                                <label class="mb-[14px] block">{{ $setting->key }}<input class="w-full rounded-lg border border-[#cadbd2] px-3 py-2 text-sm"
                                        name="settings[{{ $setting->key }}]" value="{{ $setting->value }}"></label>
                            @endforeach
                            <button class="inline-block cursor-pointer rounded-xl bg-[#176b52] px-[18px] py-[11px] font-bold text-white">{{ __('admin-section.save_settings') }}</button>
                        </form>
                    </div>
                @endif
            </main>
        </div>
</section>
@endsection
