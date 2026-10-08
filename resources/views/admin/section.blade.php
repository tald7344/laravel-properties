@extends('layouts.app') 
@section('content')<section class="section">
        <div class="wrap admin-layout">
            <aside class="panel admin-sidebar">
                <h3>الإدارة</h3><a href="{{ route('admin.dashboard') }}">▦ الإحصائيات</a><a
                    href="{{ route('admin.section', 'properties') }}">⌂ العقارات</a><a
                    href="{{ route('admin.section', 'users') }}">♙ المستخدمون</a><a
                    href="{{ route('admin.section', 'subscriptions') }}">◷ اشتراكات الملاك</a><a
                    href="{{ route('admin.section', 'complaints') }}">⚑ الشكاوى والبلاغات</a><a
                    href="{{ route('admin.section', 'settings') }}">⚙ الإعدادات</a>
            </aside>
            <main class="admin-main">
                <h1>
                    {{ ['properties' => 'العقارات', 'users' => 'المستخدمون', 'subscriptions' => 'اشتراكات الملاك', 'complaints' => 'الشكاوى والبلاغات', 'settings' => 'إعدادات الموقع'][$section] }}
                </h1>
                @if ($section === 'properties')
                    <div class="panel">
                        <table class="table">
                            <tr>
                                <th>العقار</th>
                                <th>المالك</th>
                                <th>المدينة</th>
                                <th>الحالة</th>
                                <th></th>
                            </tr>
                            @foreach ($properties as $p)
                                <tr>
                                    <td>{{ $p->title }}</td>
                                    <td>{{ $p->owner->name }}</td>
                                    <td>{{ $p->city }}</td>
                                    <td>{{ $p->status }}</td>
                                    <td>
                                        <form method="post" action="{{ route('admin.moderate', $p) }}">
                                            @csrf
                                            <select name="status">
                                                <option value="published">نشر</option>
                                                <option value="suspended">تعليق</option>
                                                <option value="expired">إنهاء</option>
                                            </select>
                                            <button class="btn">حفظ</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @elseif($section === 'users')
                    <div class="panel">
                        <table class="table">
                            <tr>
                                <th>الاسم</th>
                                <th>الهاتف</th>
                                <th>الدور</th>
                                <th>تاريخ التسجيل</th>
                            </tr>
                            @foreach ($users as $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->phone }}</td>
                                    <td>{{ $u->role }}</td>
                                    <td>{{ $u->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @elseif($section === 'subscriptions')
                    <div class="panel">
                        <table class="table">
                            <tr>
                                <th>المالك</th>
                                <th>المبلغ</th>
                                <th>مرجع شام كاش</th>
                                <th>الحالة</th>
                                <th>ينتهي</th>
                            </tr>
                            @foreach ($subscriptions as $s)
                                <tr>
                                    <td>{{ $s->user->name }}</td>
                                    <td>{{ $s->amount }}</td>
                                    <td>{{ $s->sham_cash_reference }}</td>
                                    <td>{{ $s->status }}</td>
                                    <td>{{ $s->ends_at?->format('Y-m-d H:i') ?? 'بانتظار الاعتماد' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @elseif($section === 'complaints')
                    <div class="panel">
                        <table class="table">
                            <tr>
                                <th>العقار</th>
                                <th>النوع</th>
                                <th>التفاصيل</th>
                                <th>الحالة</th>
                                <th></th>
                            </tr>
                            @foreach ($reports as $r)
                                <tr>
                                    <td>{{ $r->property->title }}</td>
                                    <td>{{ $r->type }}</td>
                                    <td>{{ $r->details }}</td>
                                    <td>{{ $r->status }}</td>
                                    <td>
                                        @if ($r->status === 'open')
                                            <form method="post" action="{{ route('admin.reports.resolve', $r) }}">
                                                @csrf
                                                <button class="btn alt">إغلاق</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="panel">
                        <form method="post" action="{{ route('admin.settings.save') }}">
                            @csrf
                            @foreach ($settings as $setting)
                                <label style="display:block;margin-bottom:14px">{{ $setting->key }}<input class="field"
                                        name="settings[{{ $setting->key }}]" value="{{ $setting->value }}"></label>
                            @endforeach
                            <button class="btn">حفظ الإعدادات</button>
                        </form>
                    </div>
                @endif
            </main>
        </div>
</section>
@endsection
