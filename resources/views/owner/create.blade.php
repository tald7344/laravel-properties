@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="wrap" style="max-width:900px">
            <div class="panel">
                <h1>{{ __('owner-create.title') }}</h1>
                <p class="muted">{{ __('owner-create.review_notice') }}</p>
                <form method="post" action="{{ route('owner.properties.store') }}">
                    @csrf
                    <div class="formgrid">
                        <input class="field" name="title" placeholder="{{ __('owner-create.listing_title') }}" required>
                        <input class="field" name="neighborhood" placeholder="{{ __('owner-create.neighborhood') }}" required>
                        <select name="city"><option value="Damascus">{{ __('owner-create.damascus') }}</option><option value="Jaramana">{{ __('owner-create.jaramana') }}</option><option value="Sahnaya">{{ __('owner-create.sahnaya') }}</option></select>
                        <input class="field" name="address" placeholder="{{ __('owner-create.full_address') }}">
                        <select name="purpose"><option value="rent">{{ __('owner-create.rent') }}</option><option value="sale">{{ __('owner-create.sale') }}</option></select>
                        <select name="category"><option value="residential">{{ __('owner-create.residential') }}</option><option value="commercial">{{ __('owner-create.commercial') }}</option></select>
                        <input class="field" type="number" step="0.01" name="price" placeholder="{{ __('owner-create.price') }}" required>
                        <select name="currency"><option>USD</option><option>SYP</option></select>
                        <input class="field" type="number" name="bedrooms" placeholder="{{ __('owner-create.bedrooms') }}">
                        <input class="field" type="number" name="floor" placeholder="{{ __('owner-create.floor') }}">
                        <input class="field" type="number" name="area" placeholder="{{ __('owner-create.area') }}">
                        <label><input type="checkbox" name="furnished" value="1"> {{ __('owner-create.furnished') }}</label>
                        <label><input type="checkbox" name="reward_available" value="1"> {{ __('owner-create.reward') }}</label>
                        <textarea class="full" name="description" rows="6" placeholder="{{ __('owner-create.description') }}" required></textarea>
                    </div>
                    <button class="btn" style="margin-top:16px">{{ __('owner-create.submit') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
