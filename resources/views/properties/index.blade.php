@extends('layouts.app')
@section('content')
<section class="properties-page">
<div class="wrap">
    <div class="properties-heading"><div><span class="tag">دليل دارك العقاري</span><h1>اعثر على عقارك المثالي</h1><p class="muted">تصفح {{ number_format($properties->total()) }} عقارًا منشورًا من المالك مباشرة.</p></div><a class="btn" href="{{ route('auth.form') }}">أضف عقارك مجانًا</a></div>
    <form class="property-searchbar" method="get">
        <div class="search-main"><span>⌕</span><input name="neighborhood" value="{{ request('neighborhood') }}" placeholder="ابحث عن مدينة أو حي أو نوع عقار"></div>
        <select name="purpose"><option value="">كل العمليات</option><option value="rent" @selected(request('purpose')==='rent')>للإيجار</option><option value="sale" @selected(request('purpose')==='sale')>للبيع</option></select>
        <select name="city"><option value="">كل المدن</option>@foreach($cities as $city)<option value="{{ $city }}" @selected(request('city')===$city)>{{ $city }}</option>@endforeach</select>
        <button class="btn">بحث</button>
    </form>
    <div class="properties-layout">
        <aside class="property-filters">
            <div class="filter-heading"><h2>تصفية النتائج</h2><a href="{{ route('properties.index') }}">مسح الكل</a></div>
            <div class="filter-group"><label>نوع العقار</label><select name="category" form="advanced-filters"><option value="">الكل</option><option value="residential" @selected(request('category')==='residential')>سكني</option><option value="commercial" @selected(request('category')==='commercial')>تجاري / محل</option></select></div>
            <form id="advanced-filters" method="get">
                <input type="hidden" name="purpose" value="{{ request('purpose') }}"><input type="hidden" name="city" value="{{ request('city') }}"><input type="hidden" name="neighborhood" value="{{ request('neighborhood') }}">
                <div class="filter-group"><label>نطاق السعر</label><div class="filter-row"><input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="من"><input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="إلى"></div></div>
                <div class="filter-group"><label>المساحة بالمتر</label><div class="filter-row"><input type="number" name="min_area" value="{{ request('min_area') }}" placeholder="من"><input type="number" name="max_area" value="{{ request('max_area') }}" placeholder="إلى"></div></div>
                <div class="filter-group"><label>غرف النوم</label><select name="bedrooms"><option value="">أي عدد</option>@foreach([1,2,3,4,5] as $value)<option value="{{ $value }}" @selected((string)request('bedrooms')===(string)$value)>{{ $value }}{{ $value===5?'+':'' }} غرف</option>@endforeach</select></div>
                <div class="filter-group"><label>الحمامات</label><select name="bathrooms"><option value="">أي عدد</option>@foreach([1,2,3,4] as $value)<option value="{{ $value }}" @selected((string)request('bathrooms')===(string)$value)>{{ $value }}{{ $value===4?'+':'' }}</option>@endforeach</select></div>
                <div class="filter-group"><label>الحالة</label><label class="check"><input type="checkbox" name="furnished" value="1" @checked(request('furnished')==='1')> مفروش</label><label class="check"><input type="checkbox" name="reward" value="1" @checked(request('reward')==='1')> مكافأة اختيارية</label></div>
                <button class="btn filter-submit">تطبيق الفلاتر</button>
            </form>
        </aside>
        <main class="property-results">
            <div class="results-toolbar"><strong>{{ number_format($properties->total()) }} نتيجة</strong><select name="sort" form="sort-form"><option value="latest" @selected(request('sort','latest')==='latest')>الأحدث أولًا</option><option value="price_low" @selected(request('sort')==='price_low')>السعر: الأقل</option><option value="price_high" @selected(request('sort')==='price_high')>السعر: الأعلى</option></select><form id="sort-form" method="get">@foreach(request()->except('sort','page') as $key=>$value)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endforeach</form></div>
            @if($properties->count())<div class="property-list">@foreach($properties as $property)@php($image=$property->media[0]??null)<a class="property-result-card" href="{{ route('properties.show',$property) }}"><div class="property-thumb">@if($image)<img src="{{ asset('storage/'.$image) }}" alt="{{ $property->title }}">@else<span>صورة العقار</span>@endif<span class="property-badge">{{ $property->purpose==='rent'?'للإيجار':'للبيع' }}</span></div><div class="property-result-body"><div class="result-top"><span class="muted">{{ $property->city }} · {{ $property->neighborhood }}</span><span class="save">♡</span></div><h2>{{ $property->title }}</h2><div class="result-meta"><span>⌂ {{ $property->bedrooms??'—' }} غرف</span><span>▣ {{ $property->area??'—' }} م²</span><span>♧ {{ $property->furnished?'مفروش':'غير مفروش' }}</span></div><div class="result-bottom"><strong>{{ number_format($property->price) }} {{ $property->currency }}</strong><small>من {{ $property->owner->name }}</small></div></div></a>@endforeach</div><div class="property-pagination">{{ $properties->links() }}</div>@else<div class="panel empty-properties"><h3>لا توجد نتائج</h3><p class="muted">جرّب توسيع خيارات البحث أو إزالة بعض الفلاتر.</p></div>@endif
        </main>
    </div>
</div>
</section>
@endsection
