@php
  $subtitle    = $attributes['subtitle']    ?? 'KONTAKT';
  $title       = $attributes['title']       ?? 'Skontaktuj się z nami';
  $intro       = $attributes['intro']       ?? 'Jesteśmy do Twojej dyspozycji — zadzwoń, napisz lub odwiedź nas osobiście.';
  $phone       = $attributes['phone']       ?? '+48 123 456 789';
  $phoneLabel  = $attributes['phoneLabel']  ?? 'Zadzwoń teraz';
  $email       = $attributes['email']       ?? 'kontakt@verdion.pl';
  $emailLabel  = $attributes['emailLabel']  ?? 'Odpisujemy w 24h';
  $address     = $attributes['address']     ?? 'ul. Zielona 12, 30-001 Kraków';
  $addressLabel = $attributes['addressLabel'] ?? 'Odwiedź nas';
  $hours       = $attributes['hours']       ?? "Pon–Pt: 8:00–17:00\nSob: 9:00–13:00";
  $hoursLabel  = $attributes['hoursLabel']  ?? 'Godziny pracy';
  $wpformsId   = $attributes['wpformsId']   ?? '63';
  $formTitle   = $attributes['formTitle']   ?? 'Napisz do nas';
  $mapEmbedUrl = $attributes['mapEmbedUrl'] ?? '';
  $anchor      = $attributes['anchor']      ?? '';
  $anchorAttr  = $anchor ? " id=\"{$anchor}\"" : '';
@endphp

<section
  class="verdionContact alignfull"
  aria-labelledby="verdionContact-title"
  {!! $anchorAttr !!}
>

  {{-- ===== HEADER: dark green background ===== --}}
  <div class="verdionContact__header">
    <div class="container-content">
      <p class="verdionContact__subtitle">{{ $subtitle }}</p>
      <h1 id="verdionContact-title" class="verdionContact__title">{{ $title }}</h1>
      <p class="verdionContact__intro">{{ $intro }}</p>
    </div>

    {{-- Decorative SVG wave transitioning to body background --}}
    <div class="verdionContact__headerDeco" aria-hidden="true">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 1440 80"
        preserveAspectRatio="none"
      >
        <path
          d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z"
          fill="#f8fafc"
        />
      </svg>
    </div>
  </div>

  {{-- ===== BODY: two-column layout ===== --}}
  <div class="verdionContact__body">
    <div class="container-content verdionContact__bodyInner">

      {{-- LEFT: contact info cards --}}
      <div class="verdionContact__info" aria-label="{{ __('Dane kontaktowe', 'verdion') }}">

        {{-- Phone --}}
        <div class="verdionContact__infoCard">
          <div class="verdionContact__infoIcon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/>
            </svg>
          </div>
          <div class="verdionContact__infoContent">
            <span class="verdionContact__infoLabel">{{ $phoneLabel }}</span>
            <p class="verdionContact__infoValue">
              <a
                href="tel:{{ preg_replace('/\s+/', '', $phone) }}"
                aria-label="{{ __('Zadzwoń pod numer', 'verdion') }} {{ $phone }}"
              >{{ $phone }}</a>
            </p>
          </div>
        </div>

        {{-- Email --}}
        <div class="verdionContact__infoCard">
          <div class="verdionContact__infoIcon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
          </div>
          <div class="verdionContact__infoContent">
            <span class="verdionContact__infoLabel">{{ $emailLabel }}</span>
            <p class="verdionContact__infoValue">
              <a
                href="mailto:{{ $email }}"
                aria-label="{{ __('Napisz na adres', 'verdion') }} {{ $email }}"
              >{{ $email }}</a>
            </p>
          </div>
        </div>

        {{-- Address --}}
        <div class="verdionContact__infoCard">
          <div class="verdionContact__infoIcon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
          </div>
          <div class="verdionContact__infoContent">
            <span class="verdionContact__infoLabel">{{ $addressLabel }}</span>
            <address class="verdionContact__infoValue">{{ $address }}</address>
          </div>
        </div>

        {{-- Hours --}}
        <div class="verdionContact__infoCard">
          <div class="verdionContact__infoIcon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm.01 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/>
            </svg>
          </div>
          <div class="verdionContact__infoContent">
            <span class="verdionContact__infoLabel">{{ $hoursLabel }}</span>
            <p class="verdionContact__infoValue">{!! nl2br(e($hours)) !!}</p>
          </div>
        </div>

      </div>{{-- /.verdionContact__info --}}

      {{-- RIGHT: WPForms form --}}
      <div class="verdionContact__formWrap">
        <h2 class="verdionContact__formTitle">{{ $formTitle }}</h2>
        {!! do_shortcode('[wpforms id="' . esc_attr($wpformsId) . '"]') !!}
      </div>

    </div>{{-- /.verdionContact__bodyInner --}}
  </div>{{-- /.verdionContact__body --}}

  {{-- ===== MAP: full-width Google Maps iframe ===== --}}
  @if (!empty($mapEmbedUrl))
  <div class="verdionContact__map" aria-label="{{ __('Mapa dojazdu', 'verdion') }}">
    <iframe
      src="{{ esc_url($mapEmbedUrl) }}"
      width="100%"
      height="420"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      title="{{ __('Mapa lokalizacji firmy Verdion', 'verdion') }}"
    ></iframe>
  </div>
  @endif

</section>
