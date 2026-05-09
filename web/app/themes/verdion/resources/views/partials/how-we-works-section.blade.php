@php
  $subtitle    = $attributes['subtitle'] ?? 'JAK DZIAŁAMY';
  $title       = $attributes['title'] ?? 'Jak pracujemy?';
  $bgColor     = $attributes['backgroundColor'] ?? '';
  $steps       = $attributes['steps'] ?? [];
  $anchor      = $attributes['anchor'] ?? '';
  $anchorAttr  = $anchor ? " id=\"{$anchor}\"" : '';
  $bgStyle     = $bgColor ? ' style="background-color: ' . esc_attr($bgColor) . '"' : '';
  $titleId     = 'verdionHowWeWorks-headline';
@endphp

<section class="verdionHowWeWorks alignfull" aria-labelledby="{{ $titleId }}" {!! $anchorAttr !!}{!! $bgStyle !!}>
  <div class="container-content">
    <header class="verdionHowWeWorks__header">
      @if ($subtitle !== '')
        <p class="verdionHowWeWorks__subtitle">{{ $subtitle }}</p>
      @endif
      <h2 class="verdionHowWeWorks__title" id="{{ $titleId }}">{{ $title }}</h2>
    </header>

    @if (!empty($steps))
      <ol class="verdionHowWeWorks__steps">
        @foreach ($steps as $idx => $step)
          <li class="verdionHowWeWorks__step">
            <div class="verdionHowWeWorks__stepCircle">
              <span class="verdionHowWeWorks__stepNumber" aria-hidden="true">{{ $step['number'] ?? sprintf('%02d', $idx + 1) }}</span>
            </div>
            @if (!empty($step['title']))
              <h3 class="verdionHowWeWorks__stepTitle">{{ $step['title'] }}</h3>
            @endif
            @if (!empty($step['description']))
              <p class="verdionHowWeWorks__stepDesc">{{ $step['description'] }}</p>
            @endif
          </li>
        @endforeach
      </ol>
    @endif
  </div>
</section>
