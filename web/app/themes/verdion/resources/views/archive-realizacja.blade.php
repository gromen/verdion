@extends('layouts.app')

@section('content')
  @php
    $wszystkie_kategorie = get_terms([
      'taxonomy'   => 'realizacja_kategoria',
      'hide_empty' => true,
    ]);
    $aktywna_kategoria = get_queried_object();
  @endphp

  <div class="container-content">

    <header class="archiveHeader">
      <h1 class="archiveHeader__title">{{ __('Realizacje', 'verdion') }}</h1>
      <p class="archiveHeader__desc">{{ __('Zobacz efekty naszej pracy', 'verdion') }}</p>
    </header>

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
