import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import {
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
  const { menuId, ctaLabel, ctaUrl } = attributes;

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
    className: 'verdionHeader verdionHeader--editor alignfull',
  });

  const menuOptions = [
    { label: '— wybierz menu —', value: 0 },
    ...menus.map((m) => ({ label: m.name, value: m.id })),
  ];

  const selectedMenuName =
    menus.find((m) => Number(m.id) === Number(menuId))?.name ?? null;

  return (
    <>
      <InspectorControls>
        <PanelBody title="Menu" initialOpen={true}>
          {menusLoading ? (
            <Spinner />
          ) : (
            <SelectControl
              label="Menu nawigacyjne"
              value={menuId ?? 0}
              options={menuOptions}
              __next40pxDefaultSize={true}
              __nextHasNoMarginBottom={true}
              onChange={(val) => setAttributes({ menuId: Number(val) })}
            />
          )}
          <p style={{ fontSize: '12px', color: '#757575', margin: '8px 0 0' }}>
            Linki pobierane są z Wygląd → Menu.
          </p>
        </PanelBody>

        <PanelBody title="CTA" initialOpen={false}>
          <TextControl
            label="Etykieta przycisku CTA"
            value={ctaLabel ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ ctaLabel: val })}
          />
          <TextControl
            label="URL przycisku CTA"
            value={ctaUrl ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ ctaUrl: val })}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div
          style={{
            backgroundColor: '#0f2d1e',
            color: '#ffffff',
            padding: '0 32px',
            height: '72px',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'space-between',
            fontFamily: 'sans-serif',
          }}
        >
          {/* Logo */}
          <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
            <svg
              width="28"
              height="28"
              viewBox="0 0 32 32"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M16 3C16 3 6 10 6 19C6 24.523 10.477 29 16 29C21.523 29 26 24.523 26 19C26 10 16 3 16 3Z"
                fill="#4caf50"
              />
              <path
                d="M16 29V14"
                stroke="#0f2d1e"
                strokeWidth="1.5"
                strokeLinecap="round"
              />
              <path
                d="M16 20C16 20 11 16 11 11"
                stroke="#0f2d1e"
                strokeWidth="1.2"
                strokeLinecap="round"
              />
              <path
                d="M16 18C16 18 21 14 21 9"
                stroke="#0f2d1e"
                strokeWidth="1.2"
                strokeLinecap="round"
              />
            </svg>
            <span
              style={{
                fontSize: '18px',
                fontWeight: '700',
                letterSpacing: '0.08em',
                color: '#ffffff',
              }}
            >
              VERDION
            </span>
          </div>

          {/* Menu placeholder */}
          <div style={{ fontSize: '13px', opacity: 0.65 }}>
            {menuId && selectedMenuName
              ? `[Menu: ${selectedMenuName}]`
              : '[Menu: nie wybrano]'}
          </div>

          {/* CTA button */}
          <div
            style={{
              backgroundColor: '#2e7d32',
              color: '#ffffff',
              padding: '10px 20px',
              borderRadius: '4px',
              fontSize: '13px',
              fontWeight: '600',
              letterSpacing: '0.04em',
              cursor: 'default',
            }}
          >
            {ctaLabel || 'Kontakt'}
          </div>
        </div>
      </div>
    </>
  );
}
