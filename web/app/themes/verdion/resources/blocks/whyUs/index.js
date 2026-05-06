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
  TextareaControl,
  TextControl,
} from '@wordpress/components';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const { cards, heading } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionWhyUs verdionWhyUs--editor alignfull',
  });

  function updateCard(index, patch) {
    setAttributes({
      cards: cards.map((c, i) => (i === index ? { ...c, ...patch } : c)),
    });
  }

  return (
    <>
      <InspectorControls>
        <PanelBody title="Nagłówek" initialOpen={true}>
          <TextControl
            label="Treść nagłówka"
            value={heading ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ heading: val })}
          />
        </PanelBody>
        <PanelBody title="Karty" initialOpen={true}>
          {cards.map((card, index) => (
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

              {/* Image upload + preview */}
              <MediaUploadCheck>
                <MediaUpload
                  onSelect={(media) =>
                    updateCard(index, {
                      iconId: media.id,
                      icon: media.url,
                    })
                  }
                  allowedTypes={['image']}
                  value={card.iconId}
                  render={({ open }) => (
                    <div style={{ marginBottom: '8px' }}>
                      {card.icon && (
                        <img
                          src={card.icon}
                          alt={card.title}
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
                        {card.icon ? 'Zmień obrazek' : 'Wybierz obrazek'}
                      </Button>
                    </div>
                  )}
                />
              </MediaUploadCheck>

              {/* Title */}
              <TextControl
                label="Tytuł"
                value={card.title ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateCard(index, { title: val })}
              />

              {/* Description */}
              <TextareaControl
                label="Opis"
                value={card.description ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateCard(index, { description: val })}
                rows={3}
              />

              {/* Remove */}
              <Flex justify="flex-end">
                <FlexBlock>
                  <Button
                    isDestructive
                    size="small"
                    onClick={() =>
                      setAttributes({
                        cards: cards.filter((_, i) => i !== index),
                      })
                    }
                  >
                    Usuń kartę
                  </Button>
                </FlexBlock>
              </Flex>
            </div>
          ))}

          <Button
            variant="secondary"
            style={{ width: '100%', marginTop: '4px' }}
            onClick={() =>
              setAttributes({
                cards: [
                  ...cards,
                  {
                    iconId: null,
                    icon: '',
                    title: 'Nowa cecha',
                    description: '',
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
        <RichText
          tagName="h2"
          className="verdionWhyUs__heading"
          value={heading}
          onChange={(val) => setAttributes({ heading: val })}
          placeholder="Nagłówek sekcji..."
        />
        <div className="verdionWhyUs__content">
          {cards.map((card, i) => (
            <div key={i} className="verdionWhyUs__card">
              {card.icon && (
                <img
                  src={card.icon}
                  alt={card.title ?? ''}
                  className="verdionWhyUs__cardIcon"
                  style={{
                    width: '48px',
                    height: '48px',
                    objectFit: 'contain',
                  }}
                />
              )}
              <strong className="verdionWhyUs__cardTitle">{card.title}</strong>
              <span className="verdionWhyUs__cardDescription">
                {card.description}
              </span>
            </div>
          ))}
        </div>
      </div>
    </>
  );
}
