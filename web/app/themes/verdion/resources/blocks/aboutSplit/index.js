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
  PanelBody,
  TextControl,
  ToggleControl,
} from '@wordpress/components';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const {
    subtitle,
    title,
    body,
    imageId,
    imageUrl,
    imageAlt,
    ctaLabel,
    ctaUrl,
    ctaOpensNewTab,
  } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionAboutSplit verdionAboutSplit--editor alignfull',
  });

  return (
    <>
      <InspectorControls>
        <PanelBody title="Subtitle" initialOpen={true}>
          <TextControl
            label="Tekst nad tytułem"
            value={subtitle ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ subtitle: val })}
          />
        </PanelBody>

        <PanelBody title="Obrazek" initialOpen={true}>
          <MediaUploadCheck>
            <MediaUpload
              onSelect={(media) =>
                setAttributes({
                  imageId: media.id,
                  imageUrl: media.url,
                  imageAlt: media.alt || '',
                })
              }
              allowedTypes={['image']}
              value={imageId}
              render={({ open }) => (
                <>
                  <Button
                    onClick={open}
                    variant="secondary"
                    style={{ width: '100%', marginBottom: '8px' }}
                  >
                    {imageId ? 'Zmień obrazek' : 'Wybierz obrazek'}
                  </Button>
                  {imageId && (
                    <Button
                      isDestructive
                      size="small"
                      onClick={() =>
                        setAttributes({
                          imageId: undefined,
                          imageUrl: '',
                          imageAlt: '',
                        })
                      }
                    >
                      Usuń obrazek
                    </Button>
                  )}
                </>
              )}
            />
          </MediaUploadCheck>
          <TextControl
            label="Opis alternatywny (alt)"
            value={imageAlt ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ imageAlt: val })}
            help="Pozostaw pusty tylko dla dekoracji."
          />
        </PanelBody>

        <PanelBody title="Przycisk CTA" initialOpen={true}>
          <TextControl
            label="Tekst"
            value={ctaLabel ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ ctaLabel: val })}
          />
          <TextControl
            label="URL"
            value={ctaUrl ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ ctaUrl: val })}
          />
          <ToggleControl
            label="Otwórz w nowej karcie"
            checked={ctaOpensNewTab === true}
            onChange={(val) => setAttributes({ ctaOpensNewTab: val })}
            __nextHasNoMarginBottom={true}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div className="container-content verdionAboutSplit__inner">
          <div className="verdionAboutSplit__copy">
            {subtitle ? (
              <p className="verdionAboutSplit__subtitle">{subtitle}</p>
            ) : (
              <p className="verdionAboutSplit__subtitle verdionAboutSplit__subtitle--placeholder">
                Subtitle (panel boczny)
              </p>
            )}
            <RichText
              tagName="h2"
              className="verdionAboutSplit__title"
              value={title}
              onChange={(val) => setAttributes({ title: val })}
              placeholder="Tytuł sekcji…"
            />
            <RichText
              tagName="div"
              className="verdionAboutSplit__body"
              value={body}
              onChange={(val) => setAttributes({ body: val })}
              placeholder="Treść…"
            />
            <span className="verdionAboutSplit__cta verdionAboutSplit__cta--fake">
              {ctaLabel} <span aria-hidden="true">→</span>
            </span>
          </div>
          <div className="verdionAboutSplit__media">
            {imageUrl ? (
              <img
                src={imageUrl}
                alt={imageAlt || ''}
                className="verdionAboutSplit__mediaImg"
              />
            ) : (
              <div className="verdionAboutSplit__mediaPlaceholder">
                Wybierz obrazek w panelu bocznym
              </div>
            )}
          </div>
        </div>
      </div>
    </>
  );
}
