import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const {
    subtitle,
    title,
    intro,
    phone,
    phoneLabel,
    email,
    emailLabel,
    address,
    addressLabel,
    hours,
    hoursLabel,
    wpformsId,
    formTitle,
    mapEmbedUrl,
  } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionContact--editor alignfull',
  });

  return (
    <>
      <InspectorControls>
        <PanelBody title="Nagłówek sekcji" initialOpen={true}>
          <TextControl
            label="Podtytuł (etykieta)"
            value={subtitle ?? ''}
            onChange={(val) => setAttributes({ subtitle: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextControl
            label="Tytuł sekcji"
            value={title ?? ''}
            onChange={(val) => setAttributes({ title: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextareaControl
            label="Wprowadzenie"
            value={intro ?? ''}
            rows={4}
            onChange={(val) => setAttributes({ intro: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
        </PanelBody>

        <PanelBody title="Dane kontaktowe" initialOpen={false}>
          <TextControl
            label="Etykieta telefonu"
            value={phoneLabel ?? ''}
            onChange={(val) => setAttributes({ phoneLabel: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextControl
            label="Numer telefonu"
            value={phone ?? ''}
            onChange={(val) => setAttributes({ phone: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextControl
            label="Etykieta e-mail"
            value={emailLabel ?? ''}
            onChange={(val) => setAttributes({ emailLabel: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextControl
            label="Adres e-mail"
            value={email ?? ''}
            onChange={(val) => setAttributes({ email: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextControl
            label="Etykieta adresu"
            value={addressLabel ?? ''}
            onChange={(val) => setAttributes({ addressLabel: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextControl
            label="Adres"
            value={address ?? ''}
            onChange={(val) => setAttributes({ address: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextControl
            label="Etykieta godzin"
            value={hoursLabel ?? ''}
            onChange={(val) => setAttributes({ hoursLabel: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextareaControl
            label="Godziny otwarcia"
            value={hours ?? ''}
            rows={3}
            onChange={(val) => setAttributes({ hours: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
        </PanelBody>

        <PanelBody title="Formularz WPForms" initialOpen={false}>
          <TextControl
            label="Tytuł nad formularzem"
            value={formTitle ?? ''}
            onChange={(val) => setAttributes({ formTitle: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
          <TextControl
            label="ID formularza WPForms"
            value={wpformsId ?? ''}
            help="ID formularza WPForms"
            onChange={(val) => setAttributes({ wpformsId: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
        </PanelBody>

        <PanelBody title="Mapa Google" initialOpen={false}>
          <TextControl
            label="URL mapy"
            value={mapEmbedUrl ?? ''}
            help="URL z Google Maps > Udostępnij > Umieść mapę"
            onChange={(val) => setAttributes({ mapEmbedUrl: val })}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        {/* Header bar */}
        <div
          style={{
            background: '#1a3a2a',
            color: '#fff',
            padding: '1.25rem 2rem',
            marginBottom: '1rem',
          }}
        >
          {subtitle && (
            <p
              style={{
                fontSize: '0.75rem',
                fontWeight: 600,
                letterSpacing: '0.12em',
                textTransform: 'uppercase',
                opacity: 0.7,
                margin: '0 0 0.25rem',
              }}
            >
              {subtitle}
            </p>
          )}
          <h2
            style={{
              fontSize: 'clamp(1.25rem, 2.5vw, 2rem)',
              fontWeight: 700,
              margin: 0,
            }}
          >
            {title || 'Kontakt'}
          </h2>
        </div>

        {/* Two-column placeholder */}
        <div
          style={{
            display: 'grid',
            gridTemplateColumns: '1fr 1fr',
            gap: '1rem',
            padding: '0 2rem 1rem',
          }}
        >
          <div
            style={{
              border: '2px dashed #1a3a2a',
              borderRadius: '6px',
              padding: '1.5rem',
              background: '#f4f8f5',
              display: 'flex',
              flexDirection: 'column',
              gap: '0.5rem',
            }}
          >
            <p
              style={{
                fontWeight: 700,
                fontSize: '1rem',
                margin: '0 0 0.5rem',
                color: '#1a3a2a',
              }}
            >
              📋 Dane kontaktowe
            </p>
            {phone && (
              <p style={{ margin: 0, fontSize: '0.85rem', color: '#444' }}>
                <strong>{phoneLabel || 'Telefon'}:</strong> {phone}
              </p>
            )}
            {email && (
              <p style={{ margin: 0, fontSize: '0.85rem', color: '#444' }}>
                <strong>{emailLabel || 'E-mail'}:</strong> {email}
              </p>
            )}
            {address && (
              <p style={{ margin: 0, fontSize: '0.85rem', color: '#444' }}>
                <strong>{addressLabel || 'Adres'}:</strong> {address}
              </p>
            )}
            {hours && (
              <p style={{ margin: 0, fontSize: '0.85rem', color: '#444', whiteSpace: 'pre-line' }}>
                <strong>{hoursLabel || 'Godziny'}:</strong> {hours}
              </p>
            )}
            {!phone && !email && !address && !hours && (
              <p style={{ margin: 0, fontSize: '0.85rem', color: '#888', fontStyle: 'italic' }}>
                Uzupełnij dane kontaktowe w panelu bocznym
              </p>
            )}
          </div>

          <div
            style={{
              border: '2px dashed #2d6a4f',
              borderRadius: '6px',
              padding: '1.5rem',
              background: '#f0f7f3',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              flexDirection: 'column',
              gap: '0.25rem',
            }}
          >
            <p
              style={{
                fontWeight: 700,
                fontSize: '1rem',
                margin: 0,
                color: '#2d6a4f',
              }}
            >
              📝 Formularz WPForms
            </p>
            <p style={{ margin: 0, fontSize: '0.8rem', color: '#555' }}>
              {formTitle ? `"${formTitle}"` : ''} [id: {wpformsId || '63'}]
            </p>
          </div>
        </div>

        {/* Map note */}
        <div
          style={{
            margin: '0 2rem 1.5rem',
            padding: '0.75rem 1rem',
            background: '#e8f4ec',
            borderRadius: '4px',
            fontSize: '0.85rem',
            color: '#2d6a4f',
          }}
        >
          🗺 Mapa Google Maps
          {mapEmbedUrl ? (
            <span style={{ marginLeft: '0.5rem', opacity: 0.75, fontSize: '0.75rem' }}>
              (URL ustawiony)
            </span>
          ) : (
            <span style={{ marginLeft: '0.5rem', opacity: 0.6, fontStyle: 'italic', fontSize: '0.75rem' }}>
              — brak URL mapy
            </span>
          )}
        </div>
      </div>
    </>
  );
}
