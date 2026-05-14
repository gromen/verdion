@php
  $bgImageUrl       = $attributes['bgImageUrl'] ?? null;
  $cards            = $attributes['cards'] ?? [];
  $heading          = $attributes['heading'] ?? '';
  $anchor           = $attributes['anchor'] ?? '';
  $anchorAttr       = $anchor ? " id=\"{$anchor}\"" : '';
@endphp

<section
  class="verdionWhyUs alignfull"
  aria-labelledby="verdionWhyUs-headline"
  {!! $anchorAttr !!}
>


  @if (!empty($heading))
    <div class="verdionWhyUs__header">
      <h2 class="verdionWhyUs__heading">{!! $heading !!}</h2>
    </div>
  @endif

  @if (!empty($cards))
    <div class="container-content verdionWhyUs__content">
      @foreach ($cards as $card)
        <div class="verdionWhyUs__card">
          @if (!empty($card['iconId']))
            {!! wp_get_attachment_image($card['iconId'], 'medium', false, [
              'class'   => 'verdionWhyUs__cardIcon',
              'loading' => 'lazy',
              'alt'     => $card['title'] ?? '',
            ]) !!}
          @elseif (!empty($card['icon']))
            <img class="verdionWhyUs__cardIcon" src="{{ $card['icon'] }}" alt="{{ $card['title'] ?? '' }}" loading="lazy" width="64" height="64">
          @endif
          <h3 class="verdionWhyUs__cardTitle">{{ $card['title'] ?? '' }}</h3>
          <p class="verdionWhyUs__cardDescription">{{ $card['description'] ?? '' }}</p>
        </div>
      @endforeach
    </div>
  @endif
</section>
