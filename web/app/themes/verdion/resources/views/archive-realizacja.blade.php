@extends('layouts.app')

@section('content')
  @php
    $wszystkie_kategorie = get_terms([
      'taxonomy'   => 'realizacja_kategoria',
      'hide_empty' => true,
    ]);
    $aktywna_kategoria = get_queried_object();
  @endphp

  <section class="realizacjeArchive__hero">
    <div class="realizacjeArchive__heroInner container-content">
      <p class="realizacjeArchive__heroLabel">REALIZACJE</p>
      <h1 class="realizacjeArchive__heroTitle">Nasze realizacje</h1>
      <p class="realizacjeArchive__heroDesc">{{ __('Zobacz efekty naszej pracy — projekty nawadniania ogrodów i terenów zielonych.', 'verdion') }}</p>
    </div>
    <div class="realizacjeArchive__heroDeco" aria-hidden="true">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,80 C360,0 1080,0 1440,80 L1440,80 L0,80 Z" fill="#ffffff"/>
      </svg>
    </div>
  </section>

  <div class="container-content">

    @if (! empty($wszystkie_kategorie) && ! is_wp_error($wszystkie_kategorie))
      <nav class="archiveFilter" aria-label="{{ __('Filtruj realizacje', 'verdion') }}">
        <a
          href="{{ get_post_type_archive_link('realizacja') }}"
          class="archiveFilter__btn {{ ! is_tax('realizacja_kategoria') ? 'archiveFilter__btn--active' : '' }}"
        >
          {{ __('Wszystkie', 'verdion') }}
        </a>

        @foreach ($wszystkie_kategorie as $term)
          <a
            href="{{ get_term_link($term) }}"
            class="archiveFilter__btn {{ (isset($aktywna_kategoria->term_id) && $aktywna_kategoria->term_id === $term->term_id) ? 'archiveFilter__btn--active' : '' }}"
          >
            {{ $term->name }}
          </a>
        @endforeach
      </nav>
    @endif

    @if (have_posts())
      <div class="realizacjeGrid">
        @while(have_posts()) @php(the_post())
          @include('partials.card-realizacja')
        @endwhile
      </div>

      {!! get_the_posts_pagination([
        'mid_size'  => 2,
        'prev_text' => '← ' . __('Poprzednie', 'verdion'),
        'next_text' => __('Następne', 'verdion') . ' →',
      ]) !!}

    @else
      <p class="archiveEmpty">{{ __('Brak realizacji do wyświetlenia.', 'verdion') }}</p>
    @endif

  </div>
@endsection
