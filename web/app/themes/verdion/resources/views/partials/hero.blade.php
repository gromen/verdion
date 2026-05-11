@php
  $bgImageId        = $attributes['bgImageId'] ?? null;
  $bgImageAlt       = $attributes['bgImageAlt'] ?? '';
  $headline         = $attributes['headline'] ?? 'ZIELEŃ<br>POD PEŁNĄ KONTROLĄ';
  $subheadline      = $attributes['subheadline'] ?? '';
  $ctaPrimaryLabel  = $attributes['ctaPrimaryLabel'] ?? 'Darmowa wycena';
  $ctaPrimaryUrl    = $attributes['ctaPrimaryUrl'] ?? '#kontakt';
  $ctaSecondaryLabel = $attributes['ctaSecondaryLabel'] ?? 'Zobacz realizacje';
  $ctaSecondaryUrl  = $attributes['ctaSecondaryUrl'] ?? '/realizacje';
  $badges           = $attributes['badges'] ?? [];
  $anchor           = $attributes['anchor'] ?? '';
  $anchorAttr       = $anchor ? " id=\"{$anchor}\"" : '';
@endphp

<section
  class="verdionHero alignfull"
  aria-labelledby="verdionHero-headline"
  {!! $anchorAttr !!}
>

  {{-- Background image — img tag for LCP (not CSS background) --}}
  @if ($bgImageId)
    <div class="verdionHero__bg" aria-hidden="true">
      {!! wp_get_attachment_image($bgImageId, 'full', false, [
        'class'          => 'verdionHero__bgImg',
        'loading'        => 'eager',
        'fetchpriority'  => 'high',
        'decoding'       => 'async',
        'alt'            => '',
      ]) !!}
    </div>
  @endif

  <div class="verdionHero__inner">
    <div class="container-content verdionHero__content">

      <h1
        id="verdionHero-headline"
        class="verdionHero__headline"
      >{!! $headline !!}</h1>

      @if ($subheadline)
        <p class="verdionHero__sub">{{ $subheadline }}</p>
      @endif

      <div class="verdionHero__cta">
        <a
          href="{{ $ctaPrimaryUrl }}"
          class="ctaPrimary"
        >
          {{ $ctaPrimaryLabel }} →
        </a>
        <a
          href="{{ $ctaSecondaryUrl }}"
          class="ctaSecondary"
        >
          {{ $ctaSecondaryLabel }} →
        </a>
      </div>

    </div>
  </div>

  @if (!empty($badges))
    <div class="verdionHero__badges container-content" aria-label="{{ __('Kluczowe cechy', 'verdion') }}">
      @foreach ($badges as $badge)
        <span class="verdionHero__badge">
          <span class="verdionHero__badgeCheck" aria-hidden="true">✓</span>
          {{ $badge['label'] }}
        </span>
      @endforeach
    </div>
  @endif

</section>
