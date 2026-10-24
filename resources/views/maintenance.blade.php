<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ __('maintenance.title') }}</title>
    <link rel="stylesheet" href="{{ asset('build/css/app.css') }}">
</head>

<body>
    <main class="section">
        <div class="wrap">
            <div class="panel" style="max-width:600px;margin:12vh auto;text-align:center">
                <h1>{{ __('maintenance.headline') }}</h1>
                <p class="muted">{{ __('maintenance.message') }}</p>
            </div>
        </div>
    </main>
</body>

</html>
