import { registerBlockType } from '@wordpress/blocks';
import {
  useBlockProps,
  InspectorControls,
  MediaUploadCheck,
  MediaUpload,
  RichText,
} from '@wordpress/block-editor';
import {
  PanelBody,
  Button,
  TextControl,
  SelectControl,
} from '@wordpress/components';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const {
    title,
    subtitle,
    buttonLabel,
    buttonUrl,
    buttonType,
    bgImageId,
    bgImageUrl,
  } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionCtaBanner verdionCtaBanner--editor alignfull',
    style: {
      position: 'relative',
      minHeight: '220px',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      background: bgImageUrl
        ? `linear-gradient(rgba(10,30,15,0.55), rgba(10,30,15,0.65)), url(${bgImageUrl}) center/cover no-repeat`
        : 'linear-gradient(rgba(10,30,15,0.7), rgba(10,30,15,0.8))',
      padding: '3rem 2rem',
    },
  });

  const buttonClass = buttonType === 'secondary' ? 'ctaSecondary' : 'ctaPrimary';

  return (
    <>
      <InspectorControls>
        <PanelBody title="Zdjęcie tła" initialOpen={true}>
          <MediaUploadCheck>
            <MediaUpload
              onSelect={(media) =>
                setAttributes({
                  bgImageId: media.id,
                  bgImageUrl: media.url,
                  bgImageAlt: media.alt || '',
                })
              }
              allowedTypes={['image']}
              value={bgImageId}
              render={({ open }) => (
                <Button
                  onClick={open}
                  variant="secondary"
                  style={{ width: '100%', marginBottom: '8px' }}
                >
                  {bgImageId ? 'Zmień zdjęcie tła' : 'Wybierz zdjęcie tła'}
                </Button>
              )}
            />
          </MediaUploadCheck>
          {bgImageId && (
            <Button
              isDestructive
              size="small"
              onClick={() =>
                setAttributes({
                  bgImageId: undefined,
                  bgImageUrl: '',
                  bgImageAlt: '',
                })
              }
            >
              Usuń zdjęcie
            </Button>
          )}
        </PanelBody>

        <PanelBody title="Przycisk CTA" initialOpen={false}>
          <TextControl
            label="Tekst przycisku"
            value={buttonLabel}
            onChange={(val) => setAttributes({ buttonLabel: val })}
          />
          <TextControl
            label="Link przycisku"
            value={buttonUrl}
            onChange={(val) => setAttributes({ buttonUrl: val })}
          />
          <SelectControl
            label="Typ przycisku"
            value={buttonType}
            options={[
              { label: 'Główny (primary)', value: 'primary' },
              { label: 'Drugorzędny (secondary)', value: 'secondary' },
            ]}
            onChange={(val) => setAttributes({ buttonType: val })}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div
          style={{
            textAlign: 'center',
            maxWidth: '48rem',
            width: '100%',
          }}
        >
          <RichText
            tagName="h2"
            value={title}
            onChange={(val) => setAttributes({ title: val })}
            placeholder="Tytuł sekcji CTA…"
            style={{
              color: '#fff',
              fontSize: 'clamp(1.75rem, 3vw, 2.5rem)',
              fontWeight: '700',
              letterSpacing: '0.02em',
              margin: '0 0 0.75rem',
              textTransform: 'uppercase',
            }}
          />
          <RichText
            tagName="p"
            value={subtitle}
            onChange={(val) => setAttributes({ subtitle: val })}
            placeholder="Podtytuł…"
            style={{
              color: 'rgba(255,255,255,0.85)',
              fontSize: '1rem',
              lineHeight: '1.6',
              margin: '0 0 1.75rem',
            }}
          />
          <span className={buttonClass}>
            {buttonLabel} →
          </span>
        </div>
      </div>
    </>
  );
}
