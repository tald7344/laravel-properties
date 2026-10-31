@extends('layouts.app')

@section('content')
    <main class="profile-page renter-profile min-h-[calc(100vh-76px)] bg-[#f5f8f6] py-[42px] pb-16">
        <div class="profile-page__container max-w-[900px] mx-auto px-[22px]">
            <header class="profile-page__heading mb-[22px]">
                <span class="inline-block rounded-full bg-[var(--mint)] px-[9px] py-1 text-xs font-bold text-[var(--green)]">{{ __('profiles.tenant_account') }}</span>
                <h1 class="my-[9px] mb-1 text-[clamp(26px,3vw,34px)]">{{ __('profiles.profile') }}</h1>
                <p class="m-0 text-[var(--muted)]">{{ __('profiles.tenant_intro') }}</p>
            </header>

            <form class="profile-form rounded-2xl border border-[#e2eae5] bg-white p-[26px] shadow-[0_7px_24px_rgba(24,59,44,0.035)] max-[600px]:p-[18px]" method="post" action="{{ route('renter.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="profile-form__grid grid grid-cols-2 gap-[18px] max-[600px]:grid-cols-1">
                    <label class="profile-form__field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#43574f]">
                        <span>{{ __('profiles.full_name') }}</span>
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" name="name" value="{{ old('name', auth()->user()->name) }}" autocomplete="name" required>
                    </label>
                    <label class="profile-form__field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#43574f]">
                        <span>{{ __('profiles.email') }}</span>
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" autocomplete="email" required>
                    </label>
                    <label class="profile-form__field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#43574f]">
                        <span>{{ __('profiles.phone') }}</span>
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" name="phone" value="{{ old('phone', auth()->user()->phone) }}" autocomplete="tel" required>
                    </label>
                    <label class="profile-form__field flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#43574f]">
                        <span>{{ __('profiles.location') }}</span>
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" name="location" value="{{ old('location', auth()->user()->location) }}" autocomplete="address-level2" maxlength="255">
                    </label>
                    <label class="profile-form__field profile-form__field--full col-span-full max-[600px]:col-auto flex min-w-0 flex-col gap-[7px] text-xs font-bold text-[#43574f]">
                        <span>{{ __('profiles.profile_photo') }}</span>
                        <input class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]" type="file" name="profile_image" accept=".jpg,.jpeg,.png,.webp,image/*">
                        <small class="text-[11px] leading-[1.7] font-normal text-[var(--muted)]">{{ __('profiles.photo_formats') }}</small>
                    </label>
                    @if (auth()->user()->profile_image)
                        <div class="profile-form__current profile-form__field--full col-span-full max-[600px]:col-auto flex items-center gap-3 text-xs text-[var(--muted)]">
                            <img class="size-[68px] rounded-full object-cover" src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->profile_image) }}" alt="{{ __('profiles.current_profile_photo') }}">
                            <span>{{ __('profiles.current_photo') }}</span>
                        </div>
                    @endif
                </div>
                <div class="profile-form__actions mt-6 flex justify-between gap-3 max-[600px]:flex-col-reverse">
                    <a class="inline-block cursor-pointer rounded-[10px] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold border border-[#cadbd2] bg-transparent text-[var(--green)]" href="{{ route('renter.dashboard') }}">{{ __('profiles.return_tenant_dashboard') }}</a>
                    <button class="max-[600px]:text-center inline-block cursor-pointer rounded-[10px] border-0 bg-[var(--green)] px-[14px] py-[9px] font-[inherit] text-[13px] font-bold text-white" type="submit">{{ __('profiles.save_changes') }}</button>
                </div>
            </form>
        </div>
    </main>
@endsection
