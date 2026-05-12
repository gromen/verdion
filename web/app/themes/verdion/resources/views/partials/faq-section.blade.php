@php
  $sectionTitle = $attributes['sectionTitle'] ?? 'NAJCZĘSTSZE PYTANIA';
  $items        = $attributes['items'] ?? [];
  $anchor       = $attributes['anchor'] ?? '';
  $anchorAttr   = $anchor ? " id=\"{$anchor}\"" : '';
@endphp

<section class="verdionFaq alignfull" aria-labelledby="verdionFaq-title"{!! $anchorAttr !!}>
  <div class="container-content verdionFaq__inner">

    @if ($sectionTitle !== '')
      <h2 id="verdionFaq-title" class="verdionFaq__title">{{ $sectionTitle }}</h2>
    @endif

    @if (!empty($items))
      <div class="verdionFaq__list" role="list">
        @foreach ($items as $item)
          <div class="verdionFaq__item" role="listitem">
            <strong class="verdionFaq__question">{{ $item['question'] ?? '' }}</strong>
            <p class="verdionFaq__answer">{{ $item['answer'] ?? '' }}</p>
          </div>
        @endforeach
      </div>
    @endif

  </div>
</section>
