import {
  InspectorControls,
  MediaUpload,
  MediaUploadCheck,
  RichText,
  useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import {
  Button,
  Flex,
  FlexBlock,
  PanelBody,
  SelectControl,
  TextareaControl,
  TextControl,
} from '@wordpress/components';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const {
    heroImageId,
    heroImageUrl,
    category,
    title,
    intro,
    ctaLabel,
    ctaUrl,
    benefitsTitle,
    benefits,
    galleryTitle,
    galleryImages,
  } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionOfferDetails verdionOfferDetails--editor alignfull',
  });

  /* ── helpers ─────────────────────────────────────────────────── */

  function updateBenefit(index, patch) {
    setAttributes({
      benefits: benefits.map((b, i) => (i === index ? { ...b, ...patch } : b)),
    });
  }

  /* ── render ───────────────────────────────────────────────────── */

  return (
    <>
      {/* ═══════════════════════ INSPECTOR ═══════════════════════ */}
      <InspectorControls>

        {/* Hero */}
        <PanelBody title="Hero" initialOpen={true}>
          <MediaUploadCheck>
            <MediaUpload
              onSelect={(media) =>
                setAttributes({
                  heroImageId: media.id,
                  heroImageUrl: media.url,
                  heroImageAlt: media.alt || '',
                })
              }
              allowedTypes={['image']}
              value={heroImageId}
              render={({ open }) => (
                <div style={{ marginBottom: '8px' }}>
                  {heroImageUrl && (
                    <img
                      src={heroImageUrl}
                      alt=""
                      style={{
                        display: 'block',
                        width: '100%',
                        maxHeight: '120px',
                        objectFit: 'cover',
                        borderRadius: '4px',
                        marginBottom: '4px',
                      }}
                    />
                  )}
                  <Button
                    onClick={open}
                    variant="secondary"
                    style={{ width: '100%' }}
                  >
                    {heroImageId ? 'Zmień zdjęcie hero' : 'Wybierz zdjęcie hero'}
                  </Button>
                </div>
              )}
            />
          </MediaUploadCheck>
          {heroImageId && (
            <Button
              isDestructive
              size="small"
              style={{ marginBottom: '12px' }}
              onClick={() =>
                setAttributes({
                  heroImageId: undefined,
                  heroImageUrl: '',
                  heroImageAlt: '',
                })
              }
            >
              Usuń zdjęcie
            </Button>
          )}
          <TextControl
            label="Kategoria / badge"
            value={category ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ category: val })}
          />
          <TextControl
            label="Tekst przycisku CTA"
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

        {/* Korzyści */}
        <PanelBody title="Korzyści" initialOpen={false}>
          <TextControl
            label="Tytuł sekcji"
            value={benefitsTitle ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ benefitsTitle: val })}
          />

          {benefits.map((b, index) => (
            <div
              key={index}
              style={{
                border: '1px solid #e0e0e0',
                borderRadius: '4px',
                padding: '12px',
                marginBottom: '12px',
                marginTop: '8px',
              }}
            >
              <p style={{ fontWeight: 600, marginBottom: '8px' }}>
                Korzyść {index + 1}
              </p>

              <SelectControl
                label="Typ ikony"
                value={b.iconType ?? 'svg'}
                options={[
                  { label: 'SVG (wklejony kod)', value: 'svg' },
                  { label: 'Obrazek z biblioteki', value: 'image' },
                ]}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateBenefit(index, { iconType: val })}
              />

              {b.iconType === 'image' && (
                <MediaUploadCheck>
                  <MediaUpload
                    onSelect={(media) =>
                      updateBenefit(index, {
                        iconId: media.id,
                        iconUrl: media.url,
                      })
                    }
                    allowedTypes={['image']}
                    value={b.iconId}
                    render={({ open }) => (
                      <div style={{ marginBottom: '8px' }}>
                        {b.iconUrl && (
                          <img
                            src={b.iconUrl}
                            alt=""
                            style={{
                              display: 'block',
                              width: '48px',
                              height: '48px',
                              objectFit: 'contain',
                              marginBottom: '4px',
                            }}
                          />
                        )}
                        <Button
                          onClick={open}
                          variant="secondary"
                          style={{ width: '100%' }}
                        >
                          {b.iconUrl ? 'Zmień ikonę' : 'Wybierz ikonę'}
                        </Button>
                      </div>
                    )}
                  />
                </MediaUploadCheck>
              )}

              {b.iconType === 'svg' && (
                <TextareaControl
                  label="Kod SVG"
                  value={b.iconSvg ?? ''}
                  rows={3}
                  __next40pxDefaultSize={true}
                  __nextHasNoMarginBottom={true}
                  onChange={(val) => updateBenefit(index, { iconSvg: val })}
                />
              )}

              <TextControl
                label="Tytuł"
                value={b.title ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateBenefit(index, { title: val })}
              />
              <TextareaControl
                label="Opis"
                value={b.description ?? ''}
                rows={2}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateBenefit(index, { description: val })}
              />

              {benefits.length > 1 && (
                <Flex justify="flex-end">
                  <FlexBlock>
                    <Button
                      isDestructive
                      size="small"
                      onClick={() =>
                        setAttributes({
                          benefits: benefits.filter((_, i) => i !== index),
                        })
                      }
                    >
                      Usuń
                    </Button>
                  </FlexBlock>
                </Flex>
              )}
            </div>
          ))}

          <Button
            variant="secondary"
            style={{ width: '100%', marginTop: '4px' }}
            onClick={() =>
              setAttributes({
                benefits: [
                  ...benefits,
                  {
                    iconType: 'svg',
                    iconSvg: '',
                    iconId: null,
                    iconUrl: '',
                    title: 'Nowa korzyść',
                    description: '',
                  },
                ],
              })
            }
          >
            + Dodaj
          </Button>
        </PanelBody>

        {/* Galeria */}
        <PanelBody title="Galeria" initialOpen={false}>
          <TextControl
            label="Tytuł sekcji"
            value={galleryTitle ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ galleryTitle: val })}
          />
          <MediaUploadCheck>
            <MediaUpload
              onSelect={(mediaItems) => {
                const images = Array.isArray(mediaItems)
                  ? mediaItems.map((m) => ({
                      id: m.id,
                      url: m.url,
                      alt: m.alt || '',
                    }))
                  : [{ id: mediaItems.id, url: mediaItems.url, alt: mediaItems.alt || '' }];
                setAttributes({ galleryImages: images });
              }}
              allowedTypes={['image']}
              multiple={true}
              gallery={true}
              value={galleryImages.map((img) => img.id)}
              render={({ open }) => (
                <Button
                  onClick={open}
                  variant="secondary"
                  style={{ width: '100%', marginTop: '8px' }}
                >
                  {galleryImages.length > 0
                    ? `Edytuj galerię (${galleryImages.length} zdjęć)`
                    : 'Wybierz zdjęcia do galerii'}
                </Button>
              )}
            />
          </MediaUploadCheck>
          {galleryImages.length > 0 && (
            <div
              style={{
                display: 'grid',
                gridTemplateColumns: 'repeat(3, 1fr)',
                gap: '4px',
                marginTop: '8px',
              }}
            >
              {galleryImages.map((img, i) => (
                <img
                  key={i}
                  src={img.url}
                  alt={img.alt}
                  style={{
                    width: '100%',
                    aspectRatio: '4/3',
                    objectFit: 'cover',
                    borderRadius: '4px',
                  }}
                />
              ))}
            </div>
          )}
        </PanelBody>

      </InspectorControls>

      {/* ═══════════════════════ CANVAS PREVIEW ══════════════════ */}
      <article {...blockProps}>

        {/* 1. Split Hero */}
        <section
          style={{
            display: 'grid',
            gridTemplateColumns: heroImageUrl ? '1fr 1fr' : '1fr',
            gap: '2rem',
            alignItems: 'center',
            padding: '3rem 2rem',
            maxWidth: '72rem',
            margin: '0 auto',
          }}
        >
          <div>
            {category && (
              <span
                style={{
                  display: 'inline-block',
                  background: 'var(--color-brand, #3a7d44)',
                  color: '#fff',
                  fontSize: '0.75rem',
                  fontWeight: 700,
                  letterSpacing: '0.08em',
                  textTransform: 'uppercase',
                  padding: '0.25rem 0.75rem',
                  borderRadius: '999px',
                  marginBottom: '1rem',
                }}
              >
                {category}
              </span>
            )}
            <RichText
              tagName="h1"
              value={title}
              onChange={(val) => setAttributes({ title: val })}
              placeholder="Tytuł oferty…"
              style={{
                fontSize: 'clamp(1.75rem, 4vw, 2.75rem)',
                fontWeight: 700,
                color: 'var(--color-neutral-900, #111)',
                margin: '0 0 1rem',
                lineHeight: 1.2,
              }}
            />
            <RichText
              tagName="p"
              value={intro}
              onChange={(val) => setAttributes({ intro: val })}
              placeholder="Krótki opis…"
              style={{
                fontSize: '1rem',
                color: 'var(--color-neutral-600, #555)',
                lineHeight: 1.6,
                margin: '0 0 1.5rem',
              }}
            />
            {ctaUrl && (
              <span
                style={{
                  display: 'inline-block',
                  background: 'var(--color-brand, #3a7d44)',
                  color: '#fff',
                  padding: '0.75rem 1.5rem',
                  borderRadius: '0.375rem',
                  fontWeight: 600,
                  fontSize: '0.875rem',
                }}
              >
                {ctaLabel} →
              </span>
            )}
          </div>

          {heroImageUrl && (
            <div>
              <img
                src={heroImageUrl}
                alt=""
                style={{
                  width: '100%',
                  borderRadius: '1rem',
                  display: 'block',
                  aspectRatio: '4/3',
                  objectFit: 'cover',
                }}
              />
            </div>
          )}
        </section>

        {/* 2. Benefits preview */}
        {benefits.length > 0 && (
          <section
            style={{
              background: 'var(--color-neutral-50, #f9fafb)',
              padding: '3rem 2rem',
            }}
          >
            <div style={{ maxWidth: '72rem', margin: '0 auto' }}>
              {benefitsTitle && (
                <h2
                  style={{
                    textAlign: 'center',
                    fontWeight: 700,
                    textTransform: 'uppercase',
                    letterSpacing: '0.06em',
                    color: 'var(--color-neutral-900, #111)',
                    marginBottom: '2rem',
                    fontSize: '1.5rem',
                  }}
                >
                  {benefitsTitle}
                </h2>
              )}
              <div
                style={{
                  display: 'grid',
                  gridTemplateColumns: `repeat(${Math.min(benefits.length, 4)}, 1fr)`,
                  gap: '1.25rem',
                }}
              >
                {benefits.map((b, i) => (
                  <div
                    key={i}
                    style={{
                      background: '#fff',
                      borderRadius: '0.75rem',
                      padding: '1.25rem',
                      boxShadow: '0 1px 4px rgba(0,0,0,0.08)',
                    }}
                  >
                    {b.iconType === 'svg' && b.iconSvg ? (
                      <div
                        style={{ width: '40px', height: '40px', marginBottom: '0.75rem' }}
                        dangerouslySetInnerHTML={{ __html: b.iconSvg }}
                      />
                    ) : b.iconUrl ? (
                      <img
                        src={b.iconUrl}
                        alt=""
                        style={{ width: '40px', height: '40px', objectFit: 'contain', marginBottom: '0.75rem' }}
                      />
                    ) : (
                      <div
                        style={{
                          width: '40px',
                          height: '40px',
                          background: 'var(--color-brand, #3a7d44)',
                          borderRadius: '0.5rem',
                          marginBottom: '0.75rem',
                          opacity: 0.2,
                        }}
                      />
                    )}
                    <strong style={{ display: 'block', marginBottom: '0.375rem', color: 'var(--color-neutral-900, #111)' }}>
                      {b.title}
                    </strong>
                    <p style={{ fontSize: '0.875rem', color: 'var(--color-neutral-600, #555)', margin: 0 }}>
                      {b.description}
                    </p>
                  </div>
                ))}
              </div>
            </div>
          </section>
        )}

        {/* 4. Gallery preview */}
        {galleryImages.length > 0 && (
          <section
            style={{
              background: 'var(--color-neutral-50, #f9fafb)',
              padding: '3rem 2rem',
            }}
          >
            <div style={{ maxWidth: '72rem', margin: '0 auto' }}>
              {galleryTitle && (
                <h2
                  style={{
                    textAlign: 'center',
                    fontWeight: 700,
                    textTransform: 'uppercase',
                    letterSpacing: '0.06em',
                    color: 'var(--color-neutral-900, #111)',
                    marginBottom: '2rem',
                    fontSize: '1.5rem',
                  }}
                >
                  {galleryTitle}
                </h2>
              )}
              <div
                style={{
                  display: 'grid',
                  gridTemplateColumns: 'repeat(3, 1fr)',
                  gap: '0.75rem',
                }}
              >
                {galleryImages.map((img, i) => (
                  <img
                    key={i}
                    src={img.url}
                    alt={img.alt}
                    style={{
                      width: '100%',
                      aspectRatio: '4/3',
                      objectFit: 'cover',
                      borderRadius: '0.5rem',
                      display: 'block',
                    }}
                  />
                ))}
              </div>
            </div>
          </section>
        )}

      </article>
    </>
  );
}
