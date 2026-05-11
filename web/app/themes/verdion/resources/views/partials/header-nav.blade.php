@php
  $menuId      = (int)($attributes['menuId'] ?? 0);
  $ctaLabel    = $attributes['ctaLabel'] ?? 'Kontakt';
  $ctaUrl      = $attributes['ctaUrl'] ?? '';
  $anchor      = $attributes['anchor'] ?? '';
  $anchorAttr  = $anchor ? " id=\"{$anchor}\"" : '';
  $extraClass  = is_front_page() ? ' verdionHeader--transparent' : '';
@endphp

<header class="verdionHeader alignfull{{ $extraClass }}"{!! $anchorAttr !!} role="banner">
  <div class="verdionHeader__inner container-content">

    {{-- Logo --}}
    <a href="{{ home_url('/') }}" class="verdionHeader__logo" aria-label="Verdion – strona główna">
      <svg class="verdionHeader__logoMark" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 40 40" fill="none" aria-hidden="true">
        <path d="M20 4C14 10 8 14 8 22c0 6.627 5.373 12 12 12s12-5.373 12-12C32 14 26 10 20 4z" fill="#2e7d32"/>
        <path d="M20 4C20 14 16 20 20 32" stroke="#8bc34a" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      <span class="verdionHeader__logoText">VERDION</span>
    </a>

    {{-- Desktop nav --}}
    <nav class="verdionHeader__nav" aria-label="Nawigacja główna">
      @if ($menuId > 0)
        {!! wp_nav_menu([
          'menu'           => $menuId,
          'container'      => false,
          'menu_class'     => 'verdionHeader__menu',
          'echo'           => false,
          'fallback_cb'    => false,
        ]) !!}
      @else
        {!! wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'container'      => false,
          'menu_class'     => 'verdionHeader__menu',
          'echo'           => false,
          'fallback_cb'    => false,
        ]) !!}
      @endif
    </nav>

    {{-- CTA button --}}
    @if ($ctaLabel)
      <a
        href="{{ $ctaUrl ? esc_url($ctaUrl) : '#kontakt' }}"
        class="verdionHeader__cta ctaPrimary"
      >{{ $ctaLabel }}</a>
    @endif

    {{-- Hamburger toggle (mobile) --}}
    <button
      class="verdionHeader__toggle"
      aria-label="Otwórz menu"
      aria-expanded="false"
      aria-controls="verdionHeaderDrawer"
      type="button"
    >
      <span class="verdionHeader__bar"></span>
      <span class="verdionHeader__bar"></span>
      <span class="verdionHeader__bar"></span>
    </button>

  </div>

  {{-- Mobile drawer --}}
  <div class="verdionHeader__drawer" id="verdionHeaderDrawer" aria-hidden="true">
    <nav class="verdionHeader__drawerNav" aria-label="Menu mobilne">
      @if ($menuId > 0)
        {!! wp_nav_menu([
          'menu'        => $menuId,
          'container'   => false,
          'menu_class'  => 'verdionHeader__drawerMenu',
          'echo'        => false,
          'fallback_cb' => false,
        ]) !!}
      @else
        {!! wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'container'      => false,
          'menu_class'     => 'verdionHeader__drawerMenu',
          'echo'           => false,
          'fallback_cb'    => false,
        ]) !!}
      @endif
      @if ($ctaLabel)
        <a
          href="{{ $ctaUrl ? esc_url($ctaUrl) : '#kontakt' }}"
          class="verdionHeader__drawerCta"
        >{{ $ctaLabel }}</a>
      @endif
    </nav>
  </div>

  {{-- Inline script for scroll + mobile toggle --}}
  <script>
  (function () {
    var header = document.currentScript.closest('.verdionHeader');
    if (!header) return;

    // Scroll: add --scrolled class
    function onScroll() {
      if (window.scrollY > 40) {
        header.classList.add('verdionHeader--scrolled');
      } else {
        header.classList.remove('verdionHeader--scrolled');
      }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // Mobile toggle
    var toggle = header.querySelector('.verdionHeader__toggle');
    var drawer = header.querySelector('.verdionHeader__drawer');
    if (!toggle || !drawer) return;

    toggle.addEventListener('click', function () {
      var isOpen = header.classList.toggle('verdionHeader--open');
      toggle.setAttribute('aria-expanded', String(isOpen));
      drawer.setAttribute('aria-hidden', String(!isOpen));
      toggle.setAttribute('aria-label', isOpen ? 'Zamknij menu' : 'Otwórz menu');
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!header.contains(e.target) && header.classList.contains('verdionHeader--open')) {
        header.classList.remove('verdionHeader--open');
        toggle.setAttribute('aria-expanded', 'false');
        drawer.setAttribute('aria-hidden', 'true');
        toggle.setAttribute('aria-label', 'Otwórz menu');
      }
    });

    // Close on drawer link click
    drawer.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () {
        header.classList.remove('verdionHeader--open');
        toggle.setAttribute('aria-expanded', 'false');
        drawer.setAttribute('aria-hidden', 'true');
        toggle.setAttribute('aria-label', 'Otwórz menu');
      });
    });
  })();
  </script>
</header>
