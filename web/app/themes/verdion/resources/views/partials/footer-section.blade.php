@php
  $tagline        = $attributes['tagline'] ?? 'Automatyczne systemy nawadniania i trawniki.';
  $menuId         = (int)($attributes['quickLinksMenuId'] ?? 0);
  $ofertaLinks    = $attributes['ofertaLinks'] ?? [];
  $phone          = $attributes['phone'] ?? '';
  $email          = $attributes['email'] ?? '';
  $city           = $attributes['city'] ?? '';
  $facebookUrl    = $attributes['facebookUrl'] ?? '';
  $instagramUrl   = $attributes['instagramUrl'] ?? '';
  $socialThirdUrl = $attributes['socialThirdUrl'] ?? '';
  $copyrightText  = preg_replace('/\d{4}/', date('Y'), $attributes['copyrightText'] ?? '© ' . date('Y') . ' VERDION. Wszelkie prawa zastrzeżone.');
  $privacyLabel   = $attributes['privacyLabel'] ?? 'Polityka prywatności';
  $privacyUrl     = $attributes['privacyUrl'] ?? '';
  $cookiesLabel   = $attributes['cookiesLabel'] ?? 'Cookies';
  $cookiesUrl     = $attributes['cookiesUrl'] ?? '';
  $anchor         = $attributes['anchor'] ?? '';
  $anchorAttr     = $anchor ? " id=\"{$anchor}\"" : '';
@endphp

<footer class="verdionFooter alignfull"{!! $anchorAttr !!}>
  <div class="verdionFooter__top container-content">

    {{-- Col 1: Logo + Tagline --}}
    <div class="verdionFooter__brand">
      <a href="{{ home_url('/') }}" class="verdionFooter__logo" aria-label="Verdion – strona główna">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none" aria-hidden="true">
          <path d="M20 4C14 10 8 14 8 22c0 6.627 5.373 12 12 12s12-5.373 12-12C32 14 26 10 20 4z" fill="#2e7d32"/>
          <path d="M20 4C20 14 16 20 20 32" stroke="#8bc34a" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        <span class="verdionFooter__logoText">VERDION</span>
      </a>
      @if ($tagline)
        <p class="verdionFooter__tagline">{{ $tagline }}</p>
      @endif
    </div>

    {{-- Col 2: Szybkie Linki (WP Menu) --}}
    <div class="verdionFooter__col">
      <h3 class="verdionFooter__colTitle">SZYBKIE LINKI</h3>
      @if ($menuId > 0)
        {!! wp_nav_menu([
          'menu'        => $menuId,
          'container'   => false,
          'menu_class'  => 'verdionFooter__nav',
          'echo'        => false,
        ]) !!}
      @else
        {!! wp_nav_menu([
          'theme_location' => 'footer_navigation',
          'container'      => false,
          'menu_class'     => 'verdionFooter__nav',
          'echo'           => false,
          'fallback_cb'    => false,
        ]) !!}
      @endif
    </div>

    {{-- Col 3: Oferta --}}
    <div class="verdionFooter__col">
      <h3 class="verdionFooter__colTitle">OFERTA</h3>
      @if (!empty($ofertaLinks))
        <ul class="verdionFooter__nav">
          @foreach ($ofertaLinks as $link)
            <li>
              @if (!empty($link['url']))
                <a href="{{ esc_url($link['url']) }}">{{ $link['label'] }}</a>
              @else
                <span>{{ $link['label'] }}</span>
              @endif
            </li>
          @endforeach
        </ul>
      @endif
    </div>

    {{-- Col 4: Kontakt --}}
    <div class="verdionFooter__col">
      <h3 class="verdionFooter__colTitle">KONTAKT</h3>
      <ul class="verdionFooter__contact">
        @if ($phone)
          <li class="verdionFooter__contactItem">
            <svg class="verdionFooter__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
            </svg>
            <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a>
          </li>
        @endif
        @if ($email)
          <li class="verdionFooter__contactItem">
            <svg class="verdionFooter__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
              <polyline points="22,6 12,12 2,6"/>
            </svg>
            <a href="mailto:{{ $email }}">{{ $email }}</a>
          </li>
        @endif
        @if ($city)
          <li class="verdionFooter__contactItem">
            <svg class="verdionFooter__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
              <circle cx="12" cy="10" r="3"/>
            </svg>
            <span>{{ $city }}</span>
          </li>
        @endif
      </ul>
    </div>

    {{-- Col 5: Social Media --}}
    <div class="verdionFooter__col verdionFooter__col--social">
      <h3 class="verdionFooter__colTitle">OBSERWUJ NAS</h3>
      <div class="verdionFooter__socials">
        <a
          href="{{ $facebookUrl ? esc_url($facebookUrl) : '#' }}"
          class="verdionFooter__socialBtn"
          @if($facebookUrl) target="_blank" rel="noopener noreferrer" @endif
          aria-label="Facebook"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
          </svg>
        </a>
        <a
          href="{{ $instagramUrl ? esc_url($instagramUrl) : '#' }}"
          class="verdionFooter__socialBtn"
          @if($instagramUrl) target="_blank" rel="noopener noreferrer" @endif
          aria-label="Instagram"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
          </svg>
        </a>
        <a
          href="{{ $socialThirdUrl ? esc_url($socialThirdUrl) : '#' }}"
          class="verdionFooter__socialBtn"
          @if($socialThirdUrl) target="_blank" rel="noopener noreferrer" @endif
          aria-label="Lokalizacja"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
        </a>
      </div>
    </div>

  </div>

  {{-- Bottom bar --}}
  <div class="verdionFooter__bottom">
    <div class="container-content verdionFooter__bottomInner">
      <p class="verdionFooter__copy">{{ $copyrightText }}</p>
      <nav class="verdionFooter__legal" aria-label="Linki prawne">
        @if ($privacyUrl)
          <a href="{{ esc_url($privacyUrl) }}" class="verdionFooter__legalLink">{{ $privacyLabel }}</a>
        @else
          <span class="verdionFooter__legalLink">{{ $privacyLabel }}</span>
        @endif
        @if ($cookiesUrl)
          <a href="{{ esc_url($cookiesUrl) }}" class="verdionFooter__legalLink">{{ $cookiesLabel }}</a>
        @else
          <span class="verdionFooter__legalLink">{{ $cookiesLabel }}</span>
        @endif
      </nav>
    </div>
  </div>
</footer>
