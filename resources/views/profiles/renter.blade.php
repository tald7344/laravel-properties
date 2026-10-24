@extends('layouts.app')

@section('content')
    <main class="profile-page renter-profile">
        <div class="wrap profile-page__container">
            <header class="profile-page__heading">
                <span class="tag">{{ __('profiles.tenant_account') }}</span>
                <h1>{{ __('profiles.profile') }}</h1>
                <p>{{ __('profiles.tenant_intro') }}</p>
            </header>

            <form class="profile-form" method="post" action="{{ route('renter.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="profile-form__grid">
                    <label class="profile-form__field">
                        <span>{{ __('profiles.full_name') }}</span>
                        <input class="field" name="name" value="{{ old('name', auth()->user()->name) }}" autocomplete="name" required>
                    </label>
                    <label class="profile-form__field">
                        <span>{{ __('profiles.email') }}</span>
                        <input class="field" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" autocomplete="email" required>
                    </label>
                    <label class="profile-form__field">
                        <span>{{ __('profiles.phone') }}</span>
                        <input class="field" name="phone" value="{{ old('phone', auth()->user()->phone) }}" autocomplete="tel" required>
                    </label>
                    <label class="profile-form__field">
                        <span>{{ __('profiles.location') }}</span>
                        <input class="field" name="location" value="{{ old('location', auth()->user()->location) }}" autocomplete="address-level2" maxlength="255">
                    </label>
                    <label class="profile-form__field profile-form__field--full">
                        <span>{{ __('profiles.profile_photo') }}</span>
                        <input class="field" type="file" name="profile_image" accept=".jpg,.jpeg,.png,.webp,image/*">
                        <small>{{ __('profiles.photo_formats') }}</small>
                    </label>
                    @if (auth()->user()->profile_image)
                        <div class="profile-form__current profile-form__field--full">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->profile_image) }}" alt="{{ __('profiles.current_profile_photo') }}">
                            <span>{{ __('profiles.current_photo') }}</span>
                        </div>
                    @endif
                </div>
                <div class="profile-form__actions">
                    <a class="btn outline" href="{{ route('renter.dashboard') }}">{{ __('profiles.return_tenant_dashboard') }}</a>
                    <button class="btn" type="submit">{{ __('profiles.save_changes') }}</button>
                </div>
            </form>
        </div>
    </main>
@endsection
