@extends('layouts.app')
@section('content')
	<main class="auth-page relative isolate overflow-hidden bg-[radial-gradient(ellipse_at_10%_15%,rgba(223,245,233,0.8),transparent_32%),#f7faf8] pb-[60px] pt-12 max-[600px]:pb-[50px] max-[600px]:pt-[38px]">
		<div class="auth-wrap relative z-[1] mx-auto grid min-h-[min(650px,calc(100svh-180px))] w-[min(calc(100%-40px),760px)] content-center gap-[22px] max-[600px]:min-h-[calc(100svh-200px)] max-[600px]:w-[min(calc(100%-28px),760px)] max-[600px]:gap-4">
			<header class="auth-intro px-1 pb-2 text-center" data-reveal>
				<span class="inline-block rounded-full bg-[var(--mint)] px-[9px] py-1 text-xs font-bold text-[var(--green)]">{{ __('auth.welcome') }}</span>
				<h1 class="mb-[7px] mt-3 text-[clamp(29px,4vw,40px)]">{{ __('auth.start_journey') }}</h1>
				<p class="m-0 text-[var(--muted)]">{{ __('auth.intro') }}</p>
				<nav class="mt-[22px] flex justify-center gap-[10px] max-[600px]:gap-1.5" aria-label="{{ __('auth.account_navigation') }}">
					<a class="rounded-full border border-[#dce9e2] bg-white/70 px-[15px] py-[9px] text-xs font-bold text-[var(--green)] transition-[background,transform] duration-200 hover:-translate-y-0.5 hover:bg-white max-[600px]:px-[11px] max-[600px]:py-2 max-[600px]:text-[11px]" href="#login-section" data-auth-target="login">{{ __('auth.login') }} <span class="mr-2">↓</span></a>
					<a class="rounded-full border border-[#dce9e2] bg-white/70 px-[15px] py-[9px] text-xs font-bold text-[var(--green)] transition-[background,transform] duration-200 hover:-translate-y-0.5 hover:bg-white max-[600px]:px-[11px] max-[600px]:py-2 max-[600px]:text-[11px]" href="#signup-section" data-auth-target="signup">{{ __('auth.register') }} <span class="mr-2">↓</span></a>
				</nav>
			</header>

			<div class="auth-views [perspective:1200px]" data-auth-views>
			<section id="login-section" class="auth-panel auth-login is-active rounded-[22px] border border-[#e1ebe5] bg-white p-[clamp(22px,5vw,38px)] shadow-[0_16px_44px_rgba(28,72,52,0.06)] animate-[auth-enter_.55s_cubic-bezier(.2,.8,.2,1)_both] transition-[transform,box-shadow] duration-500 hover:-translate-y-[3px] hover:shadow-[0_22px_54px_rgba(28,72,52,0.09)] max-[600px]:rounded-[17px] max-[600px]:p-[22px_18px]" data-auth-view="login" aria-labelledby="login-title">
				<div class="auth-panel-heading mb-[25px] flex items-center gap-[15px]"><span class="auth-icon grid size-12 shrink-0 place-items-center rounded-[15px] bg-[var(--mint)] text-2xl font-bold text-[var(--green)]" aria-hidden="true">↗</span><div>
					<span class="mb-1 block text-[11px] font-extrabold text-[var(--green)] tracking-normal">{{ __('auth.already_have_account') }}</span><h2 class="m-0 text-[25px] max-[600px]:text-[22px]" id="login-title">{{ __('auth.login') }}</h2>
				</div></div>
				<form method="post" action="{{ route('auth.login') }}" class="auth-form grid gap-[17px]">
					@csrf
					<label class="auth-field grid gap-[7px] text-xs font-bold text-[#445c52]"><span>{{ __('auth.phone') }}</span><input class="w-full min-h-[49px] rounded-[10px] border border-[#dbe7e1] bg-white px-[14px] py-3 font-[inherit] transition-[border-color,box-shadow] focus:border-[#5c9c7f] focus:outline-0 focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="phone" value="{{ old('phone') }}" placeholder="{{ __('auth.enter_phone') }}" autocomplete="tel" required></label>
					<label class="auth-field grid gap-[7px] text-xs font-bold text-[#445c52]"><span>{{ __('auth.password_label') }}</span><input class="w-full min-h-[49px] rounded-[10px] border border-[#dbe7e1] bg-white px-[14px] py-3 font-[inherit] transition-[border-color,box-shadow] focus:border-[#5c9c7f] focus:outline-0 focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" type="password" name="password" placeholder="{{ __('auth.enter_password') }}" autocomplete="current-password" required></label>
					<button class="auth-submit group mt-[3px] inline-flex min-h-[49px] cursor-pointer items-center justify-center gap-3 rounded-xl border-0 bg-[var(--green)] px-[18px] py-[11px] font-[inherit] font-bold text-white">{{ __('auth.login_account') }} <span class="transition-transform duration-200 group-hover:-translate-x-1" aria-hidden="true">←</span></button>
				</form>
				<p class="auth-switch mb-0 mt-5 border-t border-[#edf2ef] pt-[17px] text-center text-xs text-[var(--muted)]">{{ __('auth.no_account') }} <a class="font-bold text-[var(--green)]" href="#signup-section" data-auth-target="signup">{{ __('auth.create_new_account') }}</a></p>
			</section>

			<section id="signup-section" class="auth-panel auth-signup rounded-[22px] border border-[#e1ebe5] bg-white p-[clamp(22px,5vw,38px)] shadow-[0_16px_44px_rgba(28,72,52,0.06)] animate-[auth-enter_.55s_cubic-bezier(.2,.8,.2,1)_both] transition-[transform,box-shadow] duration-500 hover:-translate-y-[3px] hover:shadow-[0_22px_54px_rgba(28,72,52,0.09)] max-[600px]:rounded-[17px] max-[600px]:p-[22px_18px]" data-auth-view="signup" aria-labelledby="signup-title" hidden>
				<div class="auth-panel-heading mb-[25px] flex items-center gap-[15px]"><span class="auth-icon grid size-12 shrink-0 place-items-center rounded-[15px] bg-[var(--mint)] text-2xl font-bold text-[var(--green)]" aria-hidden="true">＋</span><div>
					<span class="mb-1 block text-[11px] font-extrabold text-[var(--green)] tracking-normal">{{ __('auth.one_step') }}</span><h2 class="m-0 text-[25px] max-[600px]:text-[22px]" id="signup-title">{{ __('auth.create_account') }}</h2><p class="mb-0 mt-[5px] text-[13px] text-[var(--muted)]">{{ __('auth.owner_or_renter') }}</p>
				</div></div>
				<form method="post" action="{{ route('auth.register') }}" class="auth-form grid gap-[17px]">
					@csrf
					<label class="auth-field grid gap-[7px] text-xs font-bold text-[#445c52]"><span>{{ __('auth.full_name') }}</span><input class="w-full min-h-[49px] rounded-[10px] border border-[#dbe7e1] bg-white px-[14px] py-3 font-[inherit] transition-[border-color,box-shadow] focus:border-[#5c9c7f] focus:outline-0 focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="name" value="{{ old('name') }}" placeholder="{{ __('auth.enter_name') }}" autocomplete="name" required></label>
					<label class="auth-field grid gap-[7px] text-xs font-bold text-[#445c52]"><span>{{ __('auth.phone') }}</span><input class="w-full min-h-[49px] rounded-[10px] border border-[#dbe7e1] bg-white px-[14px] py-3 font-[inherit] transition-[border-color,box-shadow] focus:border-[#5c9c7f] focus:outline-0 focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" name="phone" value="{{ old('phone') }}" placeholder="{{ __('auth.enter_phone') }}" autocomplete="tel" required></label>
					<label class="auth-field grid gap-[7px] text-xs font-bold text-[#445c52]"><span>{{ __('auth.how_use') }}</span><select name="role" required class="w-full rounded-[10px] border border-[#dbe7e1] bg-white p-[10px] font-[inherit] text-[13px]">
						<option value="tenant" @selected(old('role', 'tenant') === 'tenant')>{{ __('auth.looking_for_property') }}</option>
						<option value="owner" @selected(old('role') === 'owner')>{{ __('auth.property_owner') }}</option>
					</select></label>
					<div class="auth-password-row grid grid-cols-2 gap-[14px] max-[600px]:grid-cols-1">
						<label class="auth-field grid gap-[7px] text-xs font-bold text-[#445c52]"><span>{{ __('auth.password_label') }}</span><input class="w-full min-h-[49px] rounded-[10px] border border-[#dbe7e1] bg-white px-[14px] py-3 font-[inherit] transition-[border-color,box-shadow] focus:border-[#5c9c7f] focus:outline-0 focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" type="password" name="password" placeholder="{{ __('auth.password_minimum') }}" autocomplete="new-password" required></label>
						<label class="auth-field grid gap-[7px] text-xs font-bold text-[#445c52]"><span>{{ __('auth.confirm_password') }}</span><input class="w-full min-h-[49px] rounded-[10px] border border-[#dbe7e1] bg-white px-[14px] py-3 font-[inherit] transition-[border-color,box-shadow] focus:border-[#5c9c7f] focus:outline-0 focus:shadow-[0_0_0_3px_rgba(23,107,82,0.1)]" type="password" name="password_confirmation" placeholder="{{ __('auth.repeat_password') }}" autocomplete="new-password" required></label>
					</div>
					<button class="auth-submit group mt-[3px] inline-flex min-h-[49px] cursor-pointer items-center justify-center gap-3 rounded-xl border-0 bg-[var(--green)] px-[18px] py-[11px] font-[inherit] font-bold text-white">{{ __('auth.create_account') }} <span class="transition-transform duration-200 group-hover:-translate-x-1" aria-hidden="true">←</span></button>
				</form>
				<p class="auth-switch mb-0 mt-5 border-t border-[#edf2ef] pt-[17px] text-center text-xs text-[var(--muted)]">{{ __('auth.has_account') }} <a class="font-bold text-[var(--green)]" href="#login-section" data-auth-target="login">{{ __('auth.sign_in') }}</a></p>
			</section>
			</div>
		</div>
	</main>
@endsection
