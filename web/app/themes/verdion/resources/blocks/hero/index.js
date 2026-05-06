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
  Flex,
  FlexItem,
  FlexBlock,
} from '@wordpress/components';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const {
    headline,
    subheadline,
    ctaPrimaryLabel,
    ctaPrimaryUrl,
    ctaSecondaryLabel,
    ctaSecondaryUrl,
    bgImageId,
    bgImageUrl,
    badges,
  } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionHero verdionHero--editor alignfull',
    style: {
      minHeight: '60vh',
      background: bgImageUrl
        ? `linear-gradient(to bottom, rgba(15,45,30,0.4) 0%, rgba(15,45,30,0.75) 100%), url(${bgImageUrl}) center/cover no-repeat`
        : 'var(--wp--preset--color--primary)',
      display: 'flex',
      flexDirection: 'column',
      justifyContent: 'flex-end',
      padding: '0',
      position: 'relative',
    },
  });

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

        <PanelBody title="Badges (cechy)" initialOpen={false}>
          {badges.map((badge, index) => (
            <Flex key={index} align="flex-end" style={{ marginBottom: '8px' }}>
              <FlexBlock>
                <TextControl
                  label={`Badge ${index + 1}`}
                  value={badge.label}
                  onChange={(val) => {
                    const updated = badges.map((b, i) =>
                      i === index ? { ...b, label: val } : b,
                    );
                    setAttributes({ badges: updated });
                  }}
                />
              </FlexBlock>
              <FlexItem>
                <Button
                  isDestructive
                  size="small"
                  onClick={() => {
                    setAttributes({
                      badges: badges.filter((_, i) => i !== index),
                    });
                  }}
                  style={{ marginBottom: '8px' }}
                >
                  ✕
                </Button>
              </FlexItem>
            </Flex>
          ))}
          <Button
            variant="secondary"
            size="small"
            onClick={() =>
              setAttributes({
                badges: [...badges, { icon: 'yes', label: 'Nowa cecha' }],
              })
            }
            style={{ marginTop: '4px' }}
          >
            + Dodaj badge
          </Button>
        </PanelBody>

        <PanelBody title="Przyciski CTA" initialOpen={false}>
          <TextControl
            label="Przycisk główny — tekst"
            value={ctaPrimaryLabel}
            onChange={(val) => setAttributes({ ctaPrimaryLabel: val })}
          />
          <TextControl
            label="Przycisk główny — link"
            value={ctaPrimaryUrl}
            onChange={(val) => setAttributes({ ctaPrimaryUrl: val })}
          />
          <TextControl
            label="Przycisk drugorzędny — tekst"
            value={ctaSecondaryLabel}
            onChange={(val) => setAttributes({ ctaSecondaryLabel: val })}
          />
          <TextControl
            label="Przycisk drugorzędny — link"
            value={ctaSecondaryUrl}
            onChange={(val) => setAttributes({ ctaSecondaryUrl: val })}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div
          style={{
            padding: '4rem 2rem 2rem',
            maxWidth: '72rem',
            margin: '0 auto',
            width: '100%',
          }}
        >
          <RichText
            tagName="h1"
            value={headline}
            onChange={(val) => setAttributes({ headline: val })}
            placeholder="Nagłówek hero (H1)…"
            style={{
              color: '#fff',
              fontSize: 'clamp(2.5rem, 5vw, 5rem)',
              fontWeight: '700',
              lineHeight: '1.1',
              letterSpacing: '-0.02em',
              margin: '0 0 1rem',
            }}
          />
          <RichText
            tagName="p"
            value={subheadline}
            onChange={(val) => setAttributes({ subheadline: val })}
            placeholder="Podtytuł…"
            style={{
              color: 'rgba(255,255,255,0.85)',
              fontSize: '1.125rem',
              lineHeight: '1.6',
              maxWidth: '36rem',
              margin: '0 0 2rem',
            }}
          />
          <div style={{ display: 'flex', gap: '1rem', flexWrap: 'wrap' }}>
            <span
              style={{
                background: 'var(--wp--preset--color--brand)',
                color: '#fff',
                padding: '0.75rem 1.5rem',
                borderRadius: '0.375rem',
                fontWeight: '600',
                fontSize: '0.875rem',
              }}
            >
              {ctaPrimaryLabel} →
            </span>
            <span
              style={{
                border: '2px solid rgba(255,255,255,0.7)',
                color: '#fff',
                padding: '0.75rem 1.5rem',
                borderRadius: '0.375rem',
                fontWeight: '600',
                fontSize: '0.875rem',
              }}
            >
              {ctaSecondaryLabel} →
            </span>
          </div>
        </div>

        {badges && badges.length > 0 && (
          <div
            style={{
              display: 'flex',
              flexWrap: 'wrap',
              gap: '1.5rem',
              padding: '1.5rem 2rem',
              borderTop: '1px solid rgba(255,255,255,0.15)',
              maxWidth: '72rem',
              margin: '0 auto',
              width: '100%',
            }}
          >
            {badges.map((badge, i) => (
              <span
                key={i}
                style={{
                  color: 'rgba(255,255,255,0.85)',
                  fontSize: '0.875rem',
                  display: 'flex',
                  alignItems: 'center',
                  gap: '0.375rem',
                }}
              >
                ✓ {badge.label}
              </span>
            ))}
          </div>
        )}
      </div>
    </>
  );
}
