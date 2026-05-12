@php
  $bgImageId   = $attributes['bgImageId'] ?? null;
  $bgImageAlt  = $attributes['bgImageAlt'] ?? '';
  $title       = $attributes['title'] ?? 'GOTOWY NA PIĘKNY OGRÓD?';
  $subtitle    = $attributes['subtitle'] ?? '';
  $buttonLabel = $attributes['buttonLabel'] ?? 'ZAMÓW WYCENĘ';
  $buttonUrl   = $attributes['buttonUrl'] ?? '#kontakt';
  $buttonType  = $attributes['buttonType'] ?? 'primary';
  $buttonClass = $buttonType === 'secondary' ? 'ctaSecondary' : 'ctaPrimary';
  $anchor      = $attributes['anchor'] ?? '';
  $anchorAttr  = $anchor ? " id=\"{$anchor}\"" : '';
@endphp

<section
  class="verdionCtaBanner alignfull"
  aria-labelledby="verdionCtaBanner-title"
  {!! $anchorAttr !!}
>

  @if ($bgImageId)
    <div class="verdionCtaBanner__bg" aria-hidden="true">
      {!! wp_get_attachment_image($bgImageId, 'full', false, [
        'class'   => 'verdionCtaBanner__bgImg',
        'loading' => 'lazy',
        'alt'     => '',
      ]) !!}
    </div>
  @endif

  <div class="verdionCtaBanner__inner container-content">
    <h2 id="verdionCtaBanner-title" class="verdionCtaBanner__title">
      {!! $title !!}
    </h2>

    @if ($subtitle)
      <p class="verdionCtaBanner__subtitle">{{ $subtitle }}</p>
    @endif

    <a href="{{ esc_url($buttonUrl) }}" class="{{ $buttonClass }}">
      {{ $buttonLabel }} →
    </a>
  </div>

</section>
