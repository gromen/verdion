@php
  $heroImageId   = $attributes['heroImageId']   ?? null;
  $heroImageUrl  = $attributes['heroImageUrl']  ?? '';
  $heroImageAlt  = $attributes['heroImageAlt']  ?? '';
  $category      = $attributes['category']      ?? '';
  $title         = $attributes['title']         ?? '';
  $intro         = $attributes['intro']         ?? '';
  $ctaLabel      = $attributes['ctaLabel']      ?? 'Zamów wycenę';
  $ctaUrl        = $attributes['ctaUrl']        ?? '';
  $benefitsTitle = $attributes['benefitsTitle'] ?? '';
  $benefits      = $attributes['benefits']      ?? [];
  $galleryTitle  = $attributes['galleryTitle']  ?? '';
  $galleryImages = $attributes['galleryImages'] ?? [];
  $faqTitle      = $attributes['faqTitle']      ?? '';
  $faqItems      = $attributes['faqItems']      ?? [];
  $anchor        = $attributes['anchor']        ?? '';
  $anchorAttr    = $anchor ? " id=\"{$anchor}\"" : '';
@endphp

<article class="verdionOfferDetails alignfull"{!! $anchorAttr !!}>

  {{-- ─────────────────────────── 1. Split Hero ──────────────────────────── --}}
  <section class="verdionOfferDetails__hero">
    <div class="container-content verdionOfferDetails__heroInner">

      <div class="verdionOfferDetails__heroContent">
        @if ($category !== '')
          <span class="verdionOfferDetails__badge">{{ $category }}</span>
        @endif

        @if ($title !== '')
          <h1 class="verdionOfferDetails__title">{{ $title }}</h1>
        @endif

        @if ($intro !== '')
          <p class="verdionOfferDetails__intro">{{ $intro }}</p>
        @endif

        @if ($ctaUrl !== '')
          <a href="{{ esc_url($ctaUrl) }}" class="ctaPrimary verdionOfferDetails__cta">
            {{ $ctaLabel }} <span aria-hidden="true">→</span>
          </a>
        @endif
      </div>

      @if ($heroImageId)
        <div class="verdionOfferDetails__heroImage">
          {!! wp_get_attachment_image(
            $heroImageId,
            'large',
            false,
            [
              'class'        => 'verdionOfferDetails__heroImg',
              'loading'      => 'eager',
              'fetchpriority'=> 'high',
              'alt'          => esc_attr($heroImageAlt),
            ]
          ) !!}
        </div>
      @endif

    </div>
  </section>

  {{-- ─────────────────────────── 2. Benefits ────────────────────────────── --}}
  @if (!empty($benefits))
    <section class="verdionOfferDetails__benefits" aria-labelledby="vod-benefits-title">
      <div class="container-content">
        @if ($benefitsTitle !== '')
          <h2 id="vod-benefits-title" class="verdionOfferDetails__sectionTitle">{{ $benefitsTitle }}</h2>
        @endif

        <div class="verdionOfferDetails__benefitsGrid">
          @foreach ($benefits as $b)
            <div class="verdionOfferDetails__benefitCard">
              @if (($b['iconType'] ?? '') === 'svg' && !empty($b['iconSvg']))
                <div class="verdionOfferDetails__benefitIcon" aria-hidden="true">
                  {!! $b['iconSvg'] !!}
                </div>
              @elseif (!empty($b['iconUrl']))
                <div class="verdionOfferDetails__benefitIcon">
                  <img
                    src="{{ esc_url($b['iconUrl']) }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    width="48"
                    height="48"
                  />
                </div>
              @endif

              @if (!empty($b['title']))
                <strong class="verdionOfferDetails__benefitTitle">{{ $b['title'] }}</strong>
              @endif

              @if (!empty($b['description']))
                <p class="verdionOfferDetails__benefitDesc">{{ $b['description'] }}</p>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ─────────────────────────── 3. Gallery ──────────────────────────────── --}}
  @if (!empty($galleryImages))
    <section class="verdionOfferDetails__gallery" aria-labelledby="vod-gallery-title">
      <div class="container-content">
        @if ($galleryTitle !== '')
          <h2 id="vod-gallery-title" class="verdionOfferDetails__sectionTitle">{{ $galleryTitle }}</h2>
        @endif

        <div class="verdionOfferDetails__galleryGrid">
          @foreach ($galleryImages as $img)
            @if (!empty($img['id']))
              {!! wp_get_attachment_image(
                (int) $img['id'],
                'medium_large',
                false,
                [
                  'class'  => 'verdionOfferDetails__galleryImg',
                  'loading'=> 'lazy',
                  'alt'    => esc_attr($img['alt'] ?? ''),
                ]
              ) !!}
            @elseif (!empty($img['url']))
              <img
                class="verdionOfferDetails__galleryImg"
                src="{{ esc_url($img['url']) }}"
                alt="{{ esc_attr($img['alt'] ?? '') }}"
                loading="lazy"
              />
            @endif
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ─────────────────────────── 4. FAQ ──────────────────────────────────── --}}
  @if (!empty($faqItems))
    <section class="verdionOfferDetails__faq" aria-labelledby="vod-faq-title">
      <div class="container-content">
        @if ($faqTitle !== '')
          <h2 id="vod-faq-title" class="verdionOfferDetails__sectionTitle">{{ $faqTitle }}</h2>
        @endif

        <div class="verdionOfferDetails__faqList">
          @foreach ($faqItems as $item)
            <details class="verdionOfferDetails__faqItem">
              <summary class="verdionOfferDetails__faqQ">{{ $item['question'] ?? '' }}</summary>
              <div class="verdionOfferDetails__faqA">
                <p>{{ $item['answer'] ?? '' }}</p>
              </div>
            </details>
          @endforeach
        </div>
      </div>
    </section>
  @endif

</article>
