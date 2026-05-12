@php
  $excerpt = get_the_excerpt();
@endphp

<article @php(post_class('ofertaCard'))>
  <a href="{{ get_permalink() }}" class="ofertaCard__inner" aria-label="{{ get_the_title() }}">

    @if (has_post_thumbnail())
      <div class="ofertaCard__thumb">
        {!! get_the_post_thumbnail(null, 'medium_large', [
          'class'   => 'ofertaCard__img',
          'loading' => 'lazy',
          'alt'     => get_the_title(),
        ]) !!}
        <div class="ofertaCard__thumbOverlay" aria-hidden="true"></div>
      </div>
    @else
      <div class="ofertaCard__thumb ofertaCard__thumb--empty">
        <svg class="ofertaCard__thumbIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
          <path d="M12 2C8 7 4 10 4 15a8 8 0 0016 0c0-5-4-8-8-13z"/>
          <path d="M12 2v14" stroke-linecap="round"/>
          <path d="M8 10c2 1 4 1 6-1" stroke-linecap="round"/>
        </svg>
        <div class="ofertaCard__thumbOverlay" aria-hidden="true"></div>
      </div>
    @endif

    <div class="ofertaCard__body">
      <h2 class="ofertaCard__title">{{ get_the_title() }}</h2>

      @if ($excerpt)
        <p class="ofertaCard__desc">{{ $excerpt }}</p>
      @endif

      <span class="ofertaCard__cta" aria-hidden="true">
        Dowiedz się więcej →
      </span>
    </div>

  </a>
</article>
