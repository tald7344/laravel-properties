@extends('layouts.app')

@section('content')
    <main class="legal-page">
        <article class="wrap legal-page__content">
            <span class="tag">{{ __('legal.updated') }}</span>
            <h1>{{ $translation->title }}</h1>
            <div class="legal-page__text">{{ $translation->content }}</div>
        </article>
    </main>
@endsection
