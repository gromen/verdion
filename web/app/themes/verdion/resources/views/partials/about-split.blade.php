@php
  $subtitle         = $attributes['subtitle'] ?? '';
  $title            = $attributes['title'] ?? '';
  $body             = $attributes['body'] ?? '';
  $imageId          = $attributes['imageId'] ?? null;
  $imageAlt         = $attributes['imageAlt'] ?? '';
  $ctaLabel         = $attributes['ctaLabel'] ?? '';
  $ctaUrl           = $attributes['ctaUrl'] ?? '#';
  $ctaOpensNewTab   = !empty($attributes['ctaOpensNewTab']);
  $anchor           = $attributes['anchor'] ?? '';
  $anchorAttr       = $anchor ? " id=\"{$anchor}\"" : '';
  $titleId          = 'verdionAboutSplit-headline';
  $ctaRel           = $ctaOpensNewTab ? 'noopener noreferrer' : null;
  $ctaTarget        = $ctaOpensNewTab ? '_blank' : null;
@endphp

<section
  class="verdionAboutSplit alignfull"
  aria-labelledby="{{ $titleId }}"
  {!! $anchorAttr !!}
>
  <div class="container-content verdionAboutSplit__inner">
    <div class="verdionAboutSplit__copy">
      @if ($subtitle !== '')
        <p class="verdionAboutSplit__subtitle">{{ $subtitle }}</p>
      @endif

      @if ($title !== '')
        <h2 class="verdionAboutSplit__title" id="{{ $titleId }}">{!! $title !!}</h2>
      @else
        <h2 class="verdionAboutSplit__title sr-only" id="{{ $titleId }}">{{ __('Sekcja o nas', 'verdion') }}</h2>
      @endif

      @if ($body !== '')
        <div class="verdionAboutSplit__body">{!! $body !!}</div>
      @endif

      @if ($ctaLabel !== '' && $ctaUrl !== '')
        <a
          class="ctaPrimary"
          href="{{ esc_url($ctaUrl) }}"
          @if ($ctaTarget) target="{{ $ctaTarget }}" @endif
          @if ($ctaRel) rel="{{ $ctaRel }}" @endif
        >
          {{ $ctaLabel }} <span aria-hidden="true">→</span>
        </a>
      @endif
    </div>

    @if ($imageId)
      <div class="verdionAboutSplit__media">
        {!! wp_get_attachment_image($imageId, 'large', false, [
          'class' => 'verdionAboutSplit__mediaImg',
          'alt' => $imageAlt,
          'loading' => 'lazy',
          'sizes' => '(min-width: 768px) 50vw, 100vw',
        ]) !!}
      </div>
    @endif
  </div>
</section>
