@php
  $bgImageUrl       = $attributes['bgImageUrl'] ?? null;
  $cards            = $attributes['cards'] ?? [];
  $anchor           = $attributes['anchor'] ?? '';
  $anchorAttr       = $anchor ? " id=\"{$anchor}\"" : '';
@endphp

<section
  class="verdionWhyUs alignfull"
  aria-labelledby="verdionWhyUs-headline"
  {!! $anchorAttr !!}
>


  @if (!empty($cards))
  <div class="verdionWhyUs__inner">
    <div class="container-content verdionWhyUs__content">
      @foreach ($cards as $card)
        <div class="verdionWhyUs__card">
          @if (!empty($card['iconId']))
            {!! wp_get_attachment_image($card['iconId'], 'thumbnail', false, [
              'class'   => 'verdionWhyUs__cardIcon',
              'loading' => 'lazy',
              'srcset' => wp_get_attachment_image_srcset($card['iconId'], 'thumbnail'),
              'alt'     => $card['title'] ?? '',
            ]) !!}
          @elseif (!empty($card['icon']))
            <img class="verdionWhyUs__cardIcon" src="{{ $card['icon'] }}" alt="{{ $card['title'] ?? '' }}" loading="lazy">
          @endif
          <h3 class="verdionWhyUs__cardTitle">{{ $card['title'] ?? '' }}</h3>
          <p class="verdionWhyUs__cardDescription">{{ $card['description'] ?? '' }}</p>
        </div>
      @endforeach
      </div>
    </div>
  @endif
</section>
