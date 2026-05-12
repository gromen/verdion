@extends('layouts.app')

@section('content')
<section class="verdion404">

  {{-- Decorative background blobs --}}
  <div class="verdion404__bg" aria-hidden="true">
    <div class="verdion404__blob verdion404__blob--1"></div>
    <div class="verdion404__blob verdion404__blob--2"></div>
  </div>

  <div class="verdion404__inner container-content">

    {{-- Big 404 number --}}
    <div class="verdion404__number" aria-hidden="true">
      <span class="verdion404__digit">4</span>
      <span class="verdion404__leaf" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 100" fill="none">
          <path d="M40 5C20 20 5 35 5 58c0 18 15 32 35 32s35-14 35-32C75 35 60 20 40 5z" fill="#2e7d32" opacity=".18"/>
          <path d="M40 5C20 20 5 35 5 58c0 18 15 32 35 32s35-14 35-32C75 35 60 20 40 5z" stroke="#2e7d32" stroke-width="2"/>
          <path d="M40 5 Q38 40 36 90" stroke="#8bc34a" stroke-width="1.5" stroke-linecap="round"/>
          <path d="M40 30 Q25 38 15 50" stroke="#8bc34a" stroke-width="1" stroke-linecap="round" opacity=".7"/>
          <path d="M40 45 Q55 50 65 62" stroke="#8bc34a" stroke-width="1" stroke-linecap="round" opacity=".7"/>
        </svg>
      </span>
      <span class="verdion404__digit">4</span>
    </div>

    {{-- Copy --}}
    <p class="verdion404__label">BŁĄD 404</p>
    <h1 class="verdion404__title">Ta strona gdzieś uciekła</h1>
    <p class="verdion404__desc">
      Strona, której szukasz, nie istnieje lub została przeniesiona.<br>
      Wróć na stronę główną albo sprawdź naszą ofertę.
    </p>

    {{-- CTAs --}}
    <div class="verdion404__ctas">
      <a href="{{ home_url('/') }}" class="ctaPrimary">
        ← Wróć na stronę główną
      </a>
      <a href="{{ home_url('/oferta') }}" class="ctaSecondary">
        Zobacz ofertę
      </a>
    </div>

    {{-- Quick links --}}
    <div class="verdion404__links">
      <p class="verdion404__linksLabel">Popularne strony:</p>
      <nav aria-label="Popularne strony">
        <a href="{{ home_url('/') }}">Strona główna</a>
        <a href="{{ home_url('/oferta') }}">Oferta</a>
        <a href="{{ home_url('/realizacje') }}">Realizacje</a>
        <a href="{{ home_url('/kontakt') }}">Kontakt</a>
      </nav>
    </div>

  </div>

</section>
@endsection
