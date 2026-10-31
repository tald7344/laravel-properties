<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ __('maintenance.title') }}</title>
    <link rel="stylesheet" href="{{ asset('build/css/app.css') }}">
</head>

<body>
    <main class="py-8">
        <div class="mx-auto max-w-[1160px] px-[22px]">
            <div class="rounded-[17px] border border-[#e5ece8] bg-white p-[18px]" style="max-width:600px;margin:12vh auto;text-align:center">
                <h1>{{ __('maintenance.headline') }}</h1>
                <p class="text-[var(--muted)]">{{ __('maintenance.message') }}</p>
            </div>
        </div>
    </main>
</body>

</html>
