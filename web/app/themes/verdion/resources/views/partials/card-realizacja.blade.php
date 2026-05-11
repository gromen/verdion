@php
  $kategorie   = get_the_terms(get_the_ID(), 'realizacja_kategoria');
  $lokalizacja = function_exists('get_field') ? get_field('lokalizacja') : null;
  $rok         = function_exists('get_field') ? get_field('rok_realizacji') : null;
  $opis        = function_exists('get_field') ? get_field('krotki_opis') : get_the_excerpt();
@endphp

<article @php(post_class('realizacjaCard'))>
  <a href="{{ get_permalink() }}" class="realizacjaCard__link verdionLink" aria-label="{{ get_the_title() }}">

    <div class="realizacjaCard__thumb">
      @if (has_post_thumbnail())
        {!! get_the_post_thumbnail(null, 'medium_large', [
          'class'   => 'realizacjaCard__img',
          'loading' => 'lazy',
          'alt'     => get_the_title(),
        ]) !!}
      @else
        <div class="realizacjaCard__imgPlaceholder" aria-hidden="true"></div>
      @endif

      @if ($kategorie && ! is_wp_error($kategorie))
        <span class="realizacjaCard__badge">{{ $kategorie[0]->name }}</span>
      @endif
    </div>

    <div class="realizacjaCard__body">
      <h2 class="realizacjaCard__title">{{ get_the_title() }}</h2>

      @if ($opis)
        <p class="realizacjaCard__desc">{{ $opis }}</p>
      @endif

      <footer class="realizacjaCard__meta">
        @if ($lokalizacja)
          <span class="realizacjaCard__metaItem">{{ $lokalizacja }}</span>
        @endif
        @if ($rok)
          <span class="realizacjaCard__metaItem">{{ $rok }}</span>
        @endif
      </footer>
    </div>

  </a>
</article>
