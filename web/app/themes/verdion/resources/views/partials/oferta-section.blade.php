@php
  $sectionTitle    = $attributes['sectionTitle'] ?? 'OFERTA';
  $sectionSubtitle = $attributes['sectionSubtitle'] ?? '';
  $anchor          = $attributes['anchor'] ?? '';
  $anchorAttr      = $anchor ? " id=\"{$anchor}\"" : '';
  $items           = $attributes['items'] ?? [];
  $titleId         = 'verdionOferta-headline';
@endphp

<section class="verdionOferta alignfull" aria-labelledby="{{ $titleId }}" {!! $anchorAttr !!}>
  <div class="container-content">
    <header class="verdionOferta__header">
      @if ($sectionTitle !== '')
        <h2 class="verdionOferta__title" id="{{ $titleId }}">{{ $sectionTitle }}</h2>
      @else
        <h2 class="verdionOferta__title sr-only" id="{{ $titleId }}">{{ __('Oferta', 'verdion') }}</h2>
      @endif

      @if ($sectionSubtitle !== '')
        <p class="verdionOferta__subtitle">{{ $sectionSubtitle }}</p>
      @endif
    </header>

    @if (!empty($items))
      <div class="verdionOferta__grid">
        @foreach ($items as $item)
          <div class="verdionOferta__card">
            <div class="verdionOferta__icon">
              @if (($item['iconType'] ?? '') === 'svg' && !empty($item['iconSvg']))
                {!! $item['iconSvg'] !!}
              @elseif (($item['iconType'] ?? '') === 'image' && !empty($item['iconUrl']))
                <img
                  src="{{ esc_url($item['iconUrl']) }}"
                  alt="{{ esc_attr(!empty($item['iconAlt']) ? $item['iconAlt'] : ($item['title'] ?? '')) }}"
                />
              @else
                <div class="verdionOferta__iconPlaceholder"></div>
              @endif
            </div>

            @if (!empty($item['title']))
              <strong class="verdionOferta__cardTitle">{{ $item['title'] }}</strong>
            @endif

            @if (!empty($item['description']))
              <p class="verdionOferta__cardDesc">{{ $item['description'] }}</p>
            @endif

            @if (!empty($item['linkUrl']))
              <a
                href="{{ esc_url($item['linkUrl']) }}"
                class="verdionOferta__cardLink"
                @if (!empty($item['linkTarget'])) target="_blank" rel="noopener noreferrer" @endif
              >{{ !empty($item['linkLabel']) ? $item['linkLabel'] : 'WIĘCEJ' }} <span aria-hidden="true">→</span></a>
            @endif
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
