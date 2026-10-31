@extends('layouts.app')

@section('content')
    <main class="legal-page min-h-[calc(100vh-76px)] bg-[#f7f9f7] bg-[image:radial-gradient(ellipse_at_92%_0%,rgba(223,245,233,0.62),transparent_34%)] py-12 pb-[70px] max-[600px]:py-6 max-[600px]:pb-10">
        <article class="legal-page__content max-w-[900px] rounded-[18px] border border-[#e2eae5] bg-white px-[clamp(20px,5vw,56px)] py-[34px] shadow-[0_10px_32px_rgba(24,59,44,0.045)] max-[600px]:py-6 mx-auto">
            <span class="inline-block rounded-full bg-[var(--mint)] px-[9px] py-1 text-xs font-bold text-[var(--green)]">{{ __('legal.updated') }}</span>
            <h1 class="my-[14px] mb-6 text-[clamp(26px,4vw,36px)] leading-[1.4] text-[var(--ink)]">{{ $translation->title }}</h1>
            <div class="legal-page__text wrap-anywhere whitespace-pre-line text-sm leading-[2.1] text-[#43574f]">{{ $translation->content }}</div>
        </article>
    </main>
@endsection
