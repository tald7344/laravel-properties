@extends('admin.layout')
@section('admin-title','لوحة التحليلات')
@section('admin-content')
<div class="admin-welcome"><div><h2>صباح الخير، {{ auth()->user()->name }} 👋</h2><p>إحصائيات مباشرة من بيانات منصة دارك.</p></div><span class="admin-status"><i></i> النظام يعمل بشكل طبيعي</span></div>
<div class="analytics-grid">
@foreach([['properties','كل العقارات','⌂','green'],['published','منشورة','✓','gold'],['owners','الملاك','♙','mint'],['open_reports','بلاغات مفتوحة','⚑','rose']] as [$key,$label,$icon,$color])
<div class="analytics-card"><div class="analytics-icon {{ $color }}">{{ $icon }}</div><span>{{ $label }}</span><strong>{{ number_format($statistics[$key]) }}</strong><small class="up">بيانات حقيقية</small></div>
@endforeach
</div>
<div class="analytics-grid analytics-grid-secondary">
@foreach([['pending','قيد المراجعة'],['rent_properties','للإيجار'],['sale_properties','للبيع'],['active_subscriptions','اشتراكات فعالة'],['inquiries','طلبات تواصل'],['renters','المستأجرون'],['resolved_reports','بلاغات محلولة'],['confirmed_deals','صفقات مؤكدة']] as [$key,$label])
<div class="analytics-card compact"><span>{{ $label }}</span><strong>{{ number_format($statistics[$key]) }}</strong></div>
@endforeach
</div>
<div class="analytics-columns">
<div class="analytics-panel main-chart"><div class="panel-heading"><div><h3>نمو الإعلانات</h3><p>العقارات المنشورة خلال آخر ستة أشهر</p></div></div><div class="chart-area"><div class="chart-y"><span>{{ max(1, collect($statistics['monthly_properties'])->max('count')) }}</span><span>0</span></div><div class="chart-bars">@php($maxMonthly=max(1,collect($statistics['monthly_properties'])->max('count'))) @foreach($statistics['monthly_properties'] as $month)<i style="height:{{ max(5,($month['count']/$maxMonthly)*100) }}%" title="{{ $month['count'] }}"></i>@endforeach</div></div><div class="chart-x">@foreach($statistics['monthly_properties'] as $month)<span>{{ $month['label'] }}</span>@endforeach</div></div>
<div class="analytics-panel quick-panel"><div class="panel-heading"><div><h3>ملخص الأداء</h3><p>توزيع الحالات الحالية</p></div></div>@foreach([['منشورة','published','var(--admin-green)'],['مراجعة','pending','var(--admin-gold)'],['معلقة','suspended','#c27070']] as [$label,$key,$color])<div class="progress-row"><div><span>{{ $label }}</span><b>{{ $statistics[$key] }}</b></div><div class="progress"><i style="width:{{ $statistics['properties'] ? min(100,($statistics[$key]/$statistics['properties'])*100) : 0 }}%;background:{{ $color }}"></i></div></div>@endforeach<div class="quick-total"><span>اشتراكات معلقة</span><strong>{{ $statistics['pending_subscriptions'] }}</strong><a href="{{ route('admin.subscriptions.index') }}">إدارة</a></div></div>
</div>
<div class="analytics-columns lower">
<div class="analytics-panel"><div class="panel-heading"><div><h3>آخر البلاغات</h3><p>تحتاج إلى متابعة فريق الإدارة</p></div><a href="{{ route('admin.complaints.index') }}" class="panel-link">عرض الكل</a></div>@forelse($reports as $report)<div class="activity-row"><span class="activity-avatar">⚑</span><div><b>{{ $report->property?->title ?? 'عقار محذوف' }}</b><small>{{ $report->type }} · {{ $report->created_at->diffForHumans() }}</small></div><span class="status-pill warning">مفتوح</span></div>@empty<div class="empty-state">لا توجد بلاغات مفتوحة حاليًا.</div>@endforelse</div>
<div class="analytics-panel"><div class="panel-heading"><div><h3>اشتراكات الملاك</h3><p>الاشتراكات الفعالة وتاريخ انتهائها</p></div><a href="{{ route('admin.subscriptions.index') }}" class="panel-link">إدارة</a></div>@forelse($subscriptions as $subscription)<div class="activity-row"><span class="activity-avatar owner">♙</span><div><b>{{ $subscription->user?->name ?? 'مستخدم محذوف' }}</b><small>ينتهي {{ optional($subscription->ends_at)->diffForHumans() }}</small></div><span class="status-pill success">فعال</span></div>@empty<div class="empty-state">لا توجد اشتراكات فعالة.</div>@endforelse</div>
</div>
@endsection
