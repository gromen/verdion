import {
  InspectorControls,
  useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import {
  Button,
  PanelBody,
  SelectControl,
  Spinner,
  TextControl,
} from '@wordpress/components';
import apiFetch from '@wordpress/api-fetch';
import { useEffect, useState } from '@wordpress/element';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const {
    tagline,
    quickLinksMenuId,
    ofertaLinks,
    phone,
    email,
    city,
    facebookUrl,
    instagramUrl,
    socialThirdUrl,
    copyrightText,
    privacyLabel,
    privacyUrl,
    cookiesLabel,
    cookiesUrl,
  } = attributes;

  const [menus, setMenus] = useState([]);
  const [menusLoading, setMenusLoading] = useState(true);

  useEffect(() => {
    apiFetch({ path: '/wp/v2/menus' })
      .then((data) => {
        setMenus(data ?? []);
        setMenusLoading(false);
      })
      .catch(() => {
        setMenus([]);
        setMenusLoading(false);
      });
  }, []);

  const blockProps = useBlockProps({
    className: 'verdionFooter verdionFooter--editor alignfull',
  });

  const menuOptions = [
    { label: '— wybierz menu —', value: 0 },
    ...menus.map((m) => ({ label: m.name, value: m.id })),
  ];

  const selectedMenuName =
    menus.find((m) => Number(m.id) === Number(quickLinksMenuId))?.name ?? null;

  function updateOfertaLink(index, key, value) {
    const updated = (ofertaLinks ?? []).map((link, i) =>
      i === index ? { ...link, [key]: value } : link
    );
    setAttributes({ ofertaLinks: updated });
  }

  function addOfertaLink() {
    setAttributes({ ofertaLinks: [...(ofertaLinks ?? []), { label: '', url: '' }] });
  }

  function removeOfertaLink(index) {
    setAttributes({ ofertaLinks: (ofertaLinks ?? []).filter((_, i) => i !== index) });
  }

  return (
    <>
      <InspectorControls>
        {/* Panel 1 — Logo i tagline */}
        <PanelBody title="Logo i tagline" initialOpen={true}>
          <TextControl
            label="Tagline"
            value={tagline ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ tagline: val })}
          />
        </PanelBody>

        {/* Panel 2 — Szybkie linki */}
        <PanelBody title="Szybkie linki" initialOpen={false}>
          {menusLoading ? (
            <Spinner />
          ) : (
            <SelectControl
              label="Menu nawigacyjne"
              value={quickLinksMenuId ?? 0}
              options={menuOptions}
              __next40pxDefaultSize={true}
              __nextHasNoMarginBottom={true}
              onChange={(val) => setAttributes({ quickLinksMenuId: Number(val) })}
            />
          )}
          <p style={{ fontSize: '12px', color: '#757575', margin: '8px 0 0' }}>
            Linki pobierane są z Wygląd → Menu.
          </p>
        </PanelBody>

        {/* Panel 3 — Oferta */}
        <PanelBody title="Oferta" initialOpen={false}>
          {(ofertaLinks ?? []).map((link, i) => (
            <div
              key={i}
              style={{
                borderBottom: '1px solid #e0e0e0',
                paddingBottom: '12px',
                marginBottom: '12px',
              }}
            >
              <TextControl
                label={`Link ${i + 1} — etykieta`}
                value={link.label ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateOfertaLink(i, 'label', val)}
              />
              <TextControl
                label={`Link ${i + 1} — URL`}
                value={link.url ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateOfertaLink(i, 'url', val)}
              />
              <Button
                isDestructive
                variant="link"
                style={{ marginTop: '6px' }}
                onClick={() => removeOfertaLink(i)}
              >
                Usuń
              </Button>
            </div>
          ))}
          <Button variant="secondary" onClick={addOfertaLink}>
            + Dodaj link
          </Button>
        </PanelBody>

        {/* Panel 4 — Kontakt */}
        <PanelBody title="Kontakt" initialOpen={false}>
          <TextControl
            label="Telefon"
            value={phone ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ phone: val })}
          />
          <TextControl
            label="E-mail"
            value={email ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ email: val })}
          />
          <TextControl
            label="Miejscowość"
            value={city ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ city: val })}
          />
        </PanelBody>

        {/* Panel 5 — Social Media */}
        <PanelBody title="Social Media" initialOpen={false}>
          <TextControl
            label="Facebook URL"
            value={facebookUrl ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ facebookUrl: val })}
          />
          <TextControl
            label="Instagram URL"
            value={instagramUrl ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ instagramUrl: val })}
          />
          <TextControl
            label="Trzecia sieć społecznościowa URL"
            value={socialThirdUrl ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ socialThirdUrl: val })}
          />
        </PanelBody>

        {/* Panel 6 — Stopka dolna */}
        <PanelBody title="Stopka dolna" initialOpen={false}>
          <TextControl
            label="Tekst copyright"
            value={copyrightText ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ copyrightText: val })}
          />
          <TextControl
            label="Etykieta polityki prywatności"
            value={privacyLabel ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ privacyLabel: val })}
          />
          <TextControl
            label="URL polityki prywatności"
            value={privacyUrl ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ privacyUrl: val })}
          />
          <TextControl
            label="Etykieta cookies"
            value={cookiesLabel ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ cookiesLabel: val })}
          />
          <TextControl
            label="URL cookies"
            value={cookiesUrl ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ cookiesUrl: val })}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div
          style={{
            backgroundColor: '#0f2d1e',
            color: '#ffffff',
            padding: '48px 32px 24px',
            fontFamily: 'sans-serif',
          }}
        >
          {/* Top grid — 5 columns */}
          <div
            style={{
              display: 'grid',
              gridTemplateColumns: 'repeat(5, 1fr)',
              gap: '32px',
              marginBottom: '40px',
            }}
          >
            {/* Col 1 — Logo + tagline */}
            <div>
              <div
                style={{
                  fontSize: '20px',
                  fontWeight: '700',
                  marginBottom: '12px',
                  letterSpacing: '0.05em',
                }}
              >
                VERDION
              </div>
              {tagline ? (
                <p style={{ fontSize: '13px', opacity: 0.75, margin: 0 }}>
                  {tagline}
                </p>
              ) : (
                <p style={{ fontSize: '13px', opacity: 0.4, margin: 0, fontStyle: 'italic' }}>
                  Tagline (panel boczny)
                </p>
              )}
            </div>

            {/* Col 2 — Szybkie linki */}
            <div>
              <p
                style={{
                  fontSize: '11px',
                  fontWeight: '700',
                  letterSpacing: '0.12em',
                  textTransform: 'uppercase',
                  opacity: 0.55,
                  margin: '0 0 12px',
                }}
              >
                Szybkie linki
              </p>
              {quickLinksMenuId && selectedMenuName ? (
                <p style={{ fontSize: '13px', opacity: 0.75, margin: 0 }}>
                  [Menu: {selectedMenuName}]
                </p>
              ) : (
                <p style={{ fontSize: '13px', opacity: 0.4, margin: 0, fontStyle: 'italic' }}>
                  [Menu: nie wybrano]
                </p>
              )}
            </div>

            {/* Col 3 — Oferta */}
            <div>
              <p
                style={{
                  fontSize: '11px',
                  fontWeight: '700',
                  letterSpacing: '0.12em',
                  textTransform: 'uppercase',
                  opacity: 0.55,
                  margin: '0 0 12px',
                }}
              >
                Oferta
              </p>
              {ofertaLinks && ofertaLinks.length > 0 ? (
                <ul style={{ listStyle: 'none', margin: 0, padding: 0 }}>
                  {ofertaLinks.map((item, i) => (
                    <li key={i} style={{ marginBottom: '6px' }}>
                      <span style={{ fontSize: '13px', opacity: 0.75 }}>
                        {item.label || '—'}
                      </span>
                    </li>
                  ))}
                </ul>
              ) : (
                <p style={{ fontSize: '13px', opacity: 0.4, margin: 0, fontStyle: 'italic' }}>
                  Brak linków oferty
                </p>
              )}
            </div>

            {/* Col 4 — Kontakt */}
            <div>
              <p
                style={{
                  fontSize: '11px',
                  fontWeight: '700',
                  letterSpacing: '0.12em',
                  textTransform: 'uppercase',
                  opacity: 0.55,
                  margin: '0 0 12px',
                }}
              >
                Kontakt
              </p>
              <ul style={{ listStyle: 'none', margin: 0, padding: 0 }}>
                {phone && (
                  <li style={{ fontSize: '13px', opacity: 0.75, marginBottom: '4px' }}>
                    {phone}
                  </li>
                )}
                {email && (
                  <li style={{ fontSize: '13px', opacity: 0.75, marginBottom: '4px' }}>
                    {email}
                  </li>
                )}
                {city && (
                  <li style={{ fontSize: '13px', opacity: 0.75, marginBottom: '4px' }}>
                    {city}
                  </li>
                )}
                {!phone && !email && !city && (
                  <li style={{ fontSize: '13px', opacity: 0.4, fontStyle: 'italic' }}>
                    Dane kontaktowe (panel boczny)
                  </li>
                )}
              </ul>
            </div>

            {/* Col 5 — Social Media */}
            <div>
              <p
                style={{
                  fontSize: '11px',
                  fontWeight: '700',
                  letterSpacing: '0.12em',
                  textTransform: 'uppercase',
                  opacity: 0.55,
                  margin: '0 0 12px',
                }}
              >
                Social Media
              </p>
              <ul style={{ listStyle: 'none', margin: 0, padding: 0 }}>
                {facebookUrl && (
                  <li style={{ fontSize: '13px', opacity: 0.75, marginBottom: '4px' }}>
                    Facebook
                  </li>
                )}
                {instagramUrl && (
                  <li style={{ fontSize: '13px', opacity: 0.75, marginBottom: '4px' }}>
                    Instagram
                  </li>
                )}
                {socialThirdUrl && (
                  <li style={{ fontSize: '13px', opacity: 0.75, marginBottom: '4px' }}>
                    Social #3
                  </li>
                )}
                {!facebookUrl && !instagramUrl && !socialThirdUrl && (
                  <li style={{ fontSize: '13px', opacity: 0.4, fontStyle: 'italic' }}>
                    Linki social (panel boczny)
                  </li>
                )}
              </ul>
            </div>
          </div>

          {/* Bottom bar */}
          <div
            style={{
              borderTop: '1px solid rgba(255,255,255,0.15)',
              paddingTop: '20px',
              display: 'flex',
              justifyContent: 'space-between',
              alignItems: 'center',
              flexWrap: 'wrap',
              gap: '8px',
            }}
          >
            <span style={{ fontSize: '12px', opacity: 0.55 }}>
              {copyrightText || '© Verdion'}
            </span>
            <div style={{ display: 'flex', gap: '16px' }}>
              {privacyLabel && (
                <span style={{ fontSize: '12px', opacity: 0.55 }}>{privacyLabel}</span>
              )}
              {cookiesLabel && (
                <span style={{ fontSize: '12px', opacity: 0.55 }}>{cookiesLabel}</span>
              )}
              {!privacyLabel && !cookiesLabel && (
                <span style={{ fontSize: '12px', opacity: 0.35, fontStyle: 'italic' }}>
                  Polityka / Cookies (panel boczny)
                </span>
              )}
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
