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
  ToggleControl,
} from '@wordpress/components';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const { sectionTitle, sectionSubtitle, items } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionOferta verdionOferta--editor alignfull',
  });

  function updateItem(index, patch) {
    setAttributes({
      items: items.map((item, i) => (i === index ? { ...item, ...patch } : item)),
    });
  }

  return (
    <>
      <InspectorControls>
        <PanelBody title="Nagłówek sekcji" initialOpen={true}>
          <TextControl
            label="Tytuł sekcji"
            value={sectionTitle ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ sectionTitle: val })}
          />
          <TextControl
            label="Podtytuł sekcji"
            value={sectionSubtitle ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ sectionSubtitle: val })}
          />
        </PanelBody>

        <PanelBody title="Karty oferty" initialOpen={true}>
          {items.map((item, index) => (
            <div
              key={index}
              style={{
                border: '1px solid #e0e0e0',
                borderRadius: '4px',
                padding: '12px',
                marginBottom: '12px',
              }}
            >
              <p style={{ fontWeight: 600, marginBottom: '8px' }}>
                Karta {index + 1}
              </p>

              <SelectControl
                label="Typ ikony"
                value={item.iconType ?? 'image'}
                options={[
                  { label: 'Obrazek z biblioteki', value: 'image' },
                  { label: 'SVG (wklejony kod)', value: 'svg' },
                ]}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateItem(index, { iconType: val })}
              />

              {item.iconType === 'image' && (
                <MediaUploadCheck>
                  <MediaUpload
                    onSelect={(media) =>
                      updateItem(index, {
                        iconId: media.id,
                        iconUrl: media.url,
                      })
                    }
                    allowedTypes={['image']}
                    value={item.iconId}
                    render={({ open }) => (
                      <div style={{ marginBottom: '8px' }}>
                        {item.iconUrl && (
                          <img
                            src={item.iconUrl}
                            alt={item.iconAlt || item.title}
                            style={{
                              display: 'block',
                              width: '100%',
                              maxHeight: '80px',
                              objectFit: 'contain',
                              marginBottom: '4px',
                              borderRadius: '4px',
                            }}
                          />
                        )}
                        <Button
                          onClick={open}
                          variant="secondary"
                          style={{ width: '100%' }}
                        >
                          {item.iconUrl ? 'Zmień obrazek' : 'Wybierz obrazek'}
                        </Button>
                      </div>
                    )}
                  />
                </MediaUploadCheck>
              )}

              {item.iconType === 'svg' && (
                <TextareaControl
                  label="Kod SVG"
                  value={item.iconSvg ?? ''}
                  rows={4}
                  __next40pxDefaultSize={true}
                  __nextHasNoMarginBottom={true}
                  onChange={(val) => updateItem(index, { iconSvg: val })}
                />
              )}

              <TextControl
                label="Tytuł"
                value={item.title ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateItem(index, { title: val })}
              />

              <TextareaControl
                label="Opis"
                value={item.description ?? ''}
                rows={3}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateItem(index, { description: val })}
              />

              <TextControl
                label="URL (WIĘCEJ)"
                value={item.linkUrl ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateItem(index, { linkUrl: val })}
              />

              <TextControl
                label="Tekst linku"
                value={item.linkLabel ?? 'WIĘCEJ'}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateItem(index, { linkLabel: val })}
              />

              <ToggleControl
                label="Otwórz w nowej karcie"
                checked={item.linkTarget ?? false}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateItem(index, { linkTarget: val })}
              />

              {items.length > 1 && (
                <Flex justify="flex-end">
                  <FlexBlock>
                    <Button
                      isDestructive
                      size="small"
                      onClick={() =>
                        setAttributes({
                          items: items.filter((_, i) => i !== index),
                        })
                      }
                    >
                      Usuń kartę
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
                items: [
                  ...items,
                  {
                    iconType: 'image',
                    iconSvg: '',
                    iconId: null,
                    iconUrl: '',
                    iconAlt: '',
                    title: 'Nowa usługa',
                    description: '',
                    linkUrl: '',
                    linkLabel: 'WIĘCEJ',
                    linkTarget: false,
                  },
                ],
              })
            }
          >
            + Dodaj kartę
          </Button>
        </PanelBody>
      </InspectorControls>

      {/* Canvas preview */}
      <div {...blockProps}>
        <div className="container-content">
          <header className="verdionOferta__header">
            <RichText
              tagName="h2"
              className="verdionOferta__title"
              value={sectionTitle}
              onChange={(val) => setAttributes({ sectionTitle: val })}
              placeholder="Tytuł sekcji..."
            />
            <RichText
              tagName="p"
              className="verdionOferta__subtitle"
              value={sectionSubtitle}
              onChange={(val) => setAttributes({ sectionSubtitle: val })}
              placeholder="Podtytuł..."
            />
          </header>
          <div className="verdionOferta__grid">
            {items.map((item, i) => (
              <div key={i} className="verdionOferta__card">
                {item.iconType === 'svg' && item.iconSvg ? (
                  <div
                    className="verdionOferta__icon"
                    dangerouslySetInnerHTML={{ __html: item.iconSvg }}
                  />
                ) : item.iconUrl ? (
                  <div className="verdionOferta__icon">
                    <img src={item.iconUrl} alt={item.iconAlt || item.title} />
                  </div>
                ) : (
                  <div className="verdionOferta__iconPlaceholder" />
                )}
                <strong className="verdionOferta__cardTitle">{item.title}</strong>
                <p className="verdionOferta__cardDesc">{item.description}</p>
                {item.linkUrl && (
                  <span className="verdionOferta__cardLink">
                    {item.linkLabel || 'WIĘCEJ'} <span aria-hidden="true">→</span>
                  </span>
                )}
              </div>
            ))}
          </div>
        </div>
      </div>
    </>
  );
}
