@php
  $lokalizacja    = function_exists('get_field') ? get_field('lokalizacja')    : null;
  $klient         = function_exists('get_field') ? get_field('klient')         : null;
  $rok_realizacji = function_exists('get_field') ? get_field('rok_realizacji') : null;
  $galeria        = function_exists('get_field') ? get_field('galeria')        : [];
  $krotki_opis    = function_exists('get_field') ? get_field('krotki_opis')    : null;
  $kategorie      = get_the_terms(get_the_ID(), 'realizacja_kategoria');
@endphp

<article @php(post_class('realizacja realizacja--single'))>

  @if (has_post_thumbnail())
    <div class="realizacja__hero">
      {!! get_the_post_thumbnail(null, 'full', [
        'class'          => 'realizacja__heroImg',
        'loading'        => 'eager',
        'fetchpriority'  => 'high',
        'decoding'       => 'async',
        'alt'            => get_the_title(),
      ]) !!}
    </div>
  @endif

  <div class="container-content realizacja__body">

    <header class="realizacja__header">
      <h1 class="realizacja__title">{{ get_the_title() }}</h1>

      @if ($krotki_opis)
        <p class="realizacja__lead">{{ $krotki_opis }}</p>
      @endif

      <dl class="realizacja__meta">
        @if ($kategorie && ! is_wp_error($kategorie))
          <div class="realizacja__metaItem">
            <dt>{{ __('Kategoria', 'verdion') }}</dt>
            <dd>
              @foreach ($kategorie as $term)
                <a href="{{ get_term_link($term) }}" class="realizacja__tag">{{ $term->name }}</a>
              @endforeach
            </dd>
          </div>
        @endif

        @if ($lokalizacja)
          <div class="realizacja__metaItem">
            <dt>{{ __('Lokalizacja', 'verdion') }}</dt>
            <dd>{{ $lokalizacja }}</dd>
          </div>
        @endif

        @if ($klient)
          <div class="realizacja__metaItem">
            <dt>{{ __('Klient', 'verdion') }}</dt>
            <dd>{{ $klient }}</dd>
          </div>
        @endif

        @if ($rok_realizacji)
          <div class="realizacja__metaItem">
            <dt>{{ __('Rok', 'verdion') }}</dt>
            <dd>{{ $rok_realizacji }}</dd>
          </div>
        @endif
      </dl>
    </header>

    <div class="realizacja__content entry-content">
      @php(the_content())
    </div>

    @if (! empty($galeria))
      <div class="realizacja__gallery" aria-label="{{ __('Galeria realizacji', 'verdion') }}">
        @foreach ($galeria as $image)
          <figure class="realizacja__galleryItem">
            <a href="{{ $image['url'] }}" aria-label="{{ $image['alt'] ?: $image['title'] }}">
              {!! wp_get_attachment_image($image['ID'], 'large', false, [
                'class'   => 'realizacja__galleryImg',
                'loading' => 'lazy',
                'alt'     => $image['alt'] ?: $image['title'],
              ]) !!}
            </a>
          </figure>
        @endforeach
      </div>
    @endif

    <nav class="realizacja__nav" aria-label="{{ __('Nawigacja realizacji', 'verdion') }}">
      <a href="{{ get_post_type_archive_link('realizacja') }}" class="realizacja__navBack">
        ← {{ __('Wszystkie realizacje', 'verdion') }}
      </a>
    </nav>

  </div>
</article>
