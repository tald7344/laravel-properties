@extends('layouts.app')
@section('content')
    <section class="py-8">
        <div class="mx-auto max-w-[1160px] px-[22px]" style="max-width:900px">
            <div class="rounded-[17px] border border-[#e5ece8] bg-white p-[18px]">
                <h1>{{ __('owner-create.title') }}</h1>
                <p class="text-[var(--muted)]">{{ __('owner-create.review_notice') }}</p>
                <form method="post" action="{{ route('owner.properties.store') }}">
                    @csrf
                    <div class="formgrid">
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" name="title" placeholder="{{ __('owner-create.listing_title') }}" required>
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" name="neighborhood" placeholder="{{ __('owner-create.neighborhood') }}" required>
                        <select name="city" class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]"><option value="Damascus">{{ __('owner-create.damascus') }}</option><option value="Jaramana">{{ __('owner-create.jaramana') }}</option><option value="Sahnaya">{{ __('owner-create.sahnaya') }}</option></select>
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" name="address" placeholder="{{ __('owner-create.full_address') }}">
                        <select name="purpose" class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]"><option value="rent">{{ __('owner-create.rent') }}</option><option value="sale">{{ __('owner-create.sale') }}</option></select>
                        <select name="category" class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]"><option value="residential">{{ __('owner-create.residential') }}</option><option value="commercial">{{ __('owner-create.commercial') }}</option></select>
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" type="number" step="0.01" name="price" placeholder="{{ __('owner-create.price') }}" required>
                        <select name="currency" class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]"><option>USD</option><option>SYP</option></select>
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" type="number" name="bedrooms" placeholder="{{ __('owner-create.bedrooms') }}">
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" type="number" name="floor" placeholder="{{ __('owner-create.floor') }}">
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" type="number" name="area" placeholder="{{ __('owner-create.area') }}">
                        <label><input type="checkbox" name="furnished" value="1"> {{ __('owner-create.furnished') }}</label>
                        <label><input type="checkbox" name="reward_available" value="1"> {{ __('owner-create.reward') }}</label>
                        <textarea name="description" rows="6" placeholder="{{ __('owner-create.description') }}" required class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]"></textarea>
                    </div>
                    <button class="inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" style="margin-top:16px">{{ __('owner-create.submit') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
