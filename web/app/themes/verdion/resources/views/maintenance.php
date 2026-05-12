<!doctype html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>Strona w przygotowaniu — Verdion</title>
    <meta
      name="description"
      content="Strona verdion.pl jest właśnie przygotowywana. Zapraszamy wkrótce."
    />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Inter:wght@400;500&display=swap"
      rel="stylesheet"
    />

    <style>
      /* ============================================================
         Design tokens — Verdion palette (from theme.json)
         ============================================================ */
      :root {
        --color-brand: #2e7d32;
        --color-brandLight: #4caf50;
        --color-accent: #8bc34a;
        --color-primary: #0f2d1e;
        --color-primaryMid: #2e5a44;
        --color-water: #2196f3;
        --color-white: #ffffff;
        --color-neutral100: #f5f5f5;
        --color-neutral600: #6b6b6b;
        --color-neutral900: #1a1a1a;

        --gradient-brand: linear-gradient(135deg, #2e7d32 0%, #0f2d1e 100%);

        --font-display: "Fraunces", "Cormorant Garamond", Georgia, serif;
        --font-sans:
          "Inter", system-ui, -apple-system, "Segoe UI", Roboto,
          "Helvetica Neue", Arial, sans-serif;

        --radius-sm: 4px;
        --radius-base: 8px;
        --radius-lg: 16px;
      }

      /* ============================================================
         Reset / base
         ============================================================ */
      *,
      *::before,
      *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      html {
        font-size: 100%;
        -webkit-text-size-adjust: 100%;
        scroll-behavior: smooth;
      }

      body {
        min-height: 100dvh;
        font-family: var(--font-sans);
        font-size: clamp(1rem, 0.95rem + 0.25vw, 1.125rem);
        line-height: 1.6;
        color: var(--color-white);
        background: var(--color-primary);
        background-image: var(--gradient-brand);
        background-attachment: fixed;
        display: flex;
        flex-direction: column;
      }

      img,
      svg {
        display: block;
        max-width: 100%;
      }

      a {
        color: var(--color-accent);
        text-decoration: underline;
        text-underline-offset: 3px;
        transition: color 0.2s ease;
      }

      a:hover,
      a:focus-visible {
        color: var(--color-brandLight);
      }

      a:focus-visible {
        outline: 2px solid var(--color-accent);
        outline-offset: 3px;
        border-radius: var(--radius-sm);
      }

      /* ============================================================
         maintenancePage — page wrapper
         ============================================================ */
      .maintenancePage {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: clamp(1.5rem, 5vw, 4rem) clamp(1rem, 4vw, 2rem);
        gap: clamp(2rem, 5vw, 3.5rem);
        text-align: center;
        position: relative;
        overflow: hidden;
      }

      .maintenancePage::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
          radial-gradient(
            ellipse 80% 60% at 50% -10%,
            rgba(46, 125, 50, 0.35) 0%,
            transparent 70%
          ),
          radial-gradient(
            ellipse 60% 40% at 80% 110%,
            rgba(139, 195, 74, 0.12) 0%,
            transparent 60%
          );
        pointer-events: none;
        z-index: 0;
      }

      .maintenancePage > * {
        position: relative;
        z-index: 1;
      }

      /* ============================================================
         maintenancePage__header
         ============================================================ */
      .maintenancePage__header {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.25rem;
      }

      /* ============================================================
         maintenanceLogo
         ============================================================ */
      .maintenanceLogo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        text-decoration: none;
        transition: transform 0.2s ease;
      }

      .maintenanceLogo:hover,
      .maintenanceLogo:focus-visible {
        transform: translateY(-2px);
      }

      .maintenanceLogo__wordmark {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: clamp(1.5rem, 4vw, 2rem);
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--color-white);
        filter: drop-shadow(0 2px 16px rgba(0, 0, 0, 0.35));
      }

      /* ============================================================
         maintenancePage__badge
         ============================================================ */
      .maintenancePage__badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.3125rem 0.875rem;
        border: 1px solid rgba(139, 195, 74, 0.4);
        border-radius: 999px;
        background: rgba(46, 125, 50, 0.2);
        font-size: clamp(0.75rem, 0.7rem + 0.25vw, 0.875rem);
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--color-accent);
        backdrop-filter: blur(4px);
      }

      .maintenancePage__badge::before {
        content: "";
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: var(--color-accent);
        animation: pulse 2s ease-in-out infinite;
        flex-shrink: 0;
      }

      @keyframes pulse {
        0%,
        100% {
          opacity: 1;
          transform: scale(1);
        }
        50% {
          opacity: 0.5;
          transform: scale(0.8);
        }
      }

      /* ============================================================
         maintenancePage__content
         ============================================================ */
      .maintenancePage__content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        max-width: 36rem;
      }

      .maintenancePage__heading {
        font-family: var(--font-display);
        font-size: clamp(2rem, 6vw, 3.5rem);
        font-weight: 400;
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: var(--color-white);
      }

      .maintenancePage__heading em {
        font-style: italic;
        color: var(--color-accent);
      }

      .maintenancePage__lead {
        font-size: clamp(0.9375rem, 0.875rem + 0.25vw, 1.0625rem);
        color: rgba(255, 255, 255, 0.75);
        max-width: 28rem;
        line-height: 1.65;
      }

      /* ============================================================
         maintenancePage__contact
         ============================================================ */
      .maintenancePage__contact {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.625rem;
      }

      .maintenancePage__contactLabel {
        font-size: clamp(0.75rem, 0.7rem + 0.25vw, 0.875rem);
        color: rgba(255, 255, 255, 0.5);
        letter-spacing: 0.04em;
        text-transform: uppercase;
      }

      .maintenancePage__contactLinks {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.75rem 1.5rem;
        list-style: none;
      }

      .maintenancePage__contactLink {
        font-size: clamp(0.875rem, 0.825rem + 0.25vw, 1rem);
        font-weight: 500;
        color: var(--color-white);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        transition: color 0.2s ease;
      }

      .maintenancePage__contactLink:hover,
      .maintenancePage__contactLink:focus-visible {
        color: var(--color-accent);
      }

      .maintenancePage__contactLink:focus-visible {
        outline: 2px solid var(--color-accent);
        outline-offset: 3px;
        border-radius: var(--radius-sm);
      }

      /* ============================================================
         maintenancePage__footer
         ============================================================ */
      .maintenancePage__footer {
        font-size: clamp(0.75rem, 0.7rem + 0.25vw, 0.875rem);
        color: rgba(255, 255, 255, 0.35);
        letter-spacing: 0.01em;
      }

      /* ============================================================
         Decorative divider
         ============================================================ */
      .maintenancePage__divider {
        width: 3rem;
        height: 1px;
        background: linear-gradient(
          90deg,
          transparent,
          rgba(139, 195, 74, 0.6),
          transparent
        );
        border: none;
        flex-shrink: 0;
      }

      /* ============================================================
         Responsive — tablet and up
         ============================================================ */
      @media (min-width: 640px) {
        .maintenancePage__contactLinks {
          flex-direction: row;
        }
      }
    </style>
  </head>

  <body>
    <main class="maintenancePage" id="main">
      <header class="maintenancePage__header">
        <a
          class="maintenanceLogo"
          href="/"
          aria-label="Verdion — strona główna"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 40 40" fill="none" aria-hidden="true">
            <path d="M20 4C14 10 8 14 8 22c0 6.627 5.373 12 12 12s12-5.373 12-12C32 14 26 10 20 4z" fill="#2e7d32"/>
            <path d="M20 4C20 14 16 20 20 32" stroke="#8bc34a" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
          <span class="maintenanceLogo__wordmark">VERDION</span>
        </a>

        <span class="maintenancePage__badge" role="status" aria-live="polite">
          Strona w przygotowaniu
        </span>
      </header>

      <section class="maintenancePage__content" aria-labelledby="mainHeading">
        <h1 class="maintenancePage__heading" id="mainHeading">
          Coś <em>pięknego</em><br />nadchodzi
        </h1>
        <p class="maintenancePage__lead">
          Pracujemy nad nową odsłoną serwisu. Wróć wkrótce — będzie warto na nas
          poczekać.
        </p>
      </section>

      <hr class="maintenancePage__divider" aria-hidden="true" />

      <aside class="maintenancePage__contact" aria-label="Kontakt">
        <p class="maintenancePage__contactLabel">Masz pytanie? Napisz do nas</p>
        <ul class="maintenancePage__contactLinks" role="list">
          <li>
            <a
              class="maintenancePage__contactLink"
              href="mailto:biuro@verdion.pl"
            >
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
                focusable="false"
              >
                <rect x="2" y="4" width="20" height="16" rx="2" />
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
              </svg>
              biuro@verdion.pl
            </a>
          </li>
        </ul>
      </aside>

      <footer class="maintenancePage__footer">
        <p>
          &copy; <?= date('Y') ?> Verdion. Wszelkie prawa
          zastrzeżone.
        </p>
      </footer>
    </main>
  </body>
</html>
