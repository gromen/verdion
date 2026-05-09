@php
  $subtitle       = $attributes['subtitle'] ?? 'NASZE REALIZACJE';
  $title          = $attributes['title'] ?? '';
  $desc           = $attributes['desc'] ?? '';
  $count          = (int)($attributes['count'] ?? 3);
  $ctaLabel       = $attributes['ctaLabel'] ?? 'Zobacz wszystkie realizacje';
  $ctaUrl         = $attributes['ctaUrl'] ?? '/realizacje';
  $ctaOpensNewTab = !empty($attributes['ctaOpensNewTab']);
  $anchor         = $attributes['anchor'] ?? '';
  $anchorAttr     = $anchor ? " id=\"{$anchor}\"" : '';
  $titleId        = 'verdionRealizacje-headline';

  $query = new WP_Query([
    'post_type'      => 'realizacja',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
    'no_found_rows'  => true,
  ]);
@endphp

<section class="verdionRealizacje alignfull" aria-labelledby="{{ $titleId }}" {!! $anchorAttr !!}>
  <div class="container-content">
    <header class="verdionRealizacje__header">
      @if ($subtitle !== '')
        <p class="verdionRealizacje__subtitle">{{ $subtitle }}</p>
      @endif

      @if ($title !== '')
        <h2 class="verdionRealizacje__title" id="{{ $titleId }}">{!! $title !!}</h2>
      @else
        <h2 class="verdionRealizacje__title sr-only" id="{{ $titleId }}">{{ __('Nasze realizacje', 'verdion') }}</h2>
      @endif

      @if ($desc !== '')
        <p class="verdionRealizacje__desc">{{ $desc }}</p>
      @endif
    </header>

    @if ($query->have_posts())
      <div class="realizacjeGrid">
        @while ($query->have_posts()) @php($query->the_post())
          @include('partials.card-realizacja')
        @endwhile
        @php(wp_reset_postdata())
      </div>
    @endif

    @if ($ctaLabel !== '' && $ctaUrl !== '')
      <div class="verdionRealizacje__ctaWrap">
        <a
          href="{{ esc_url($ctaUrl) }}"
          class="verdionRealizacje__cta"
          @if ($ctaOpensNewTab) target="_blank" rel="noopener noreferrer" @endif
        >
          {{ $ctaLabel }} <span aria-hidden="true">→</span>
        </a>
      </div>
    @endif
  </div>
</section>
