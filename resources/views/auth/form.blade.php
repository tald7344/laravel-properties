@extends('layouts.app')
@section('content')
	<main class="auth-page">
		<div class="auth-wrap">
			<header class="auth-intro" data-reveal>
				<span class="tag">{{ __('auth.welcome') }}</span>
				<h1>{{ __('auth.start_journey') }}</h1>
				<p class="muted">{{ __('auth.intro') }}</p>
				<nav class="auth-jump" aria-label="{{ __('auth.account_navigation') }}">
					<a href="#login-section" data-auth-target="login">{{ __('auth.login') }} <span>↓</span></a>
					<a href="#signup-section" data-auth-target="signup">{{ __('auth.register') }} <span>↓</span></a>
				</nav>
			</header>

			<div class="auth-views" data-auth-views>
			<section id="login-section" class="auth-panel auth-login is-active" data-auth-view="login" aria-labelledby="login-title">
				<div class="auth-panel-heading"><span class="auth-icon" aria-hidden="true">↗</span><div>
					<span class="eyebrow">{{ __('auth.already_have_account') }}</span><h2 id="login-title">{{ __('auth.login') }}</h2>
				</div></div>
				<form method="post" action="{{ route('auth.login') }}" class="auth-form">
					@csrf
					<label class="auth-field"><span>{{ __('auth.phone') }}</span><input class="field" name="phone" value="{{ old('phone') }}" placeholder="{{ __('auth.enter_phone') }}" autocomplete="tel" required></label>
					<label class="auth-field"><span>{{ __('auth.password_label') }}</span><input class="field" type="password" name="password" placeholder="{{ __('auth.enter_password') }}" autocomplete="current-password" required></label>
					<button class="btn auth-submit">{{ __('auth.login_account') }} <span aria-hidden="true">←</span></button>
				</form>
				<p class="auth-switch">{{ __('auth.no_account') }} <a href="#signup-section" data-auth-target="signup">{{ __('auth.create_new_account') }}</a></p>
			</section>

			<section id="signup-section" class="auth-panel auth-signup" data-auth-view="signup" aria-labelledby="signup-title" hidden>
				<div class="auth-panel-heading"><span class="auth-icon" aria-hidden="true">＋</span><div>
					<span class="eyebrow">{{ __('auth.one_step') }}</span><h2 id="signup-title">{{ __('auth.create_account') }}</h2><p class="muted">{{ __('auth.owner_or_renter') }}</p>
				</div></div>
				<form method="post" action="{{ route('auth.register') }}" class="auth-form">
					@csrf
					<label class="auth-field"><span>{{ __('auth.full_name') }}</span><input class="field" name="name" value="{{ old('name') }}" placeholder="{{ __('auth.enter_name') }}" autocomplete="name" required></label>
					<label class="auth-field"><span>{{ __('auth.phone') }}</span><input class="field" name="phone" value="{{ old('phone') }}" placeholder="{{ __('auth.enter_phone') }}" autocomplete="tel" required></label>
					<label class="auth-field"><span>{{ __('auth.how_use') }}</span><select class="field" name="role" required>
						<option value="tenant" @selected(old('role', 'tenant') === 'tenant')>{{ __('auth.looking_for_property') }}</option>
						<option value="owner" @selected(old('role') === 'owner')>{{ __('auth.property_owner') }}</option>
					</select></label>
					<div class="auth-password-row">
						<label class="auth-field"><span>{{ __('auth.password_label') }}</span><input class="field" type="password" name="password" placeholder="{{ __('auth.password_minimum') }}" autocomplete="new-password" required></label>
						<label class="auth-field"><span>{{ __('auth.confirm_password') }}</span><input class="field" type="password" name="password_confirmation" placeholder="{{ __('auth.repeat_password') }}" autocomplete="new-password" required></label>
					</div>
					<button class="btn auth-submit">{{ __('auth.create_account') }} <span aria-hidden="true">←</span></button>
				</form>
				<p class="auth-switch">{{ __('auth.has_account') }} <a href="#login-section" data-auth-target="login">{{ __('auth.sign_in') }}</a></p>
			</section>
			</div>
		</div>
	</main>
@endsection
