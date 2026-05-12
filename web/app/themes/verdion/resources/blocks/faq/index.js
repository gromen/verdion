import { registerBlockType } from '@wordpress/blocks';
import {
  useBlockProps,
  InspectorControls,
  RichText,
} from '@wordpress/block-editor';
import {
  PanelBody,
  Button,
  Flex,
  FlexBlock,
  TextControl,
  TextareaControl,
} from '@wordpress/components';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const { sectionTitle, items } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionFaq verdionFaq--editor alignfull',
  });

  function updateItem(index, patch) {
    setAttributes({
      items: items.map((item, i) => (i === index ? { ...item, ...patch } : item)),
    });
  }

  return (
    <>
      <InspectorControls>
        <PanelBody title="Pytania i odpowiedzi" initialOpen={true}>
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
                Pytanie {index + 1}
              </p>
              <TextControl
                label="Pytanie"
                value={item.question ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateItem(index, { question: val })}
              />
              <TextareaControl
                label="Odpowiedź"
                value={item.answer ?? ''}
                rows={3}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateItem(index, { answer: val })}
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
                items: [...items, { question: 'Nowe pytanie', answer: '' }],
              })
            }
          >
            + Dodaj pytanie
          </Button>
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div className="container-content verdionFaq__inner">
          <RichText
            tagName="h2"
            className="verdionFaq__title"
            value={sectionTitle}
            onChange={(val) => setAttributes({ sectionTitle: val })}
            placeholder="Tytuł sekcji FAQ…"
          />
          <div className="verdionFaq__list">
            {items.map((item, i) => (
              <div key={i} className="verdionFaq__item">
                <strong className="verdionFaq__question">
                  {item.question || 'Pytanie…'}
                </strong>
                <p className="verdionFaq__answer">
                  {item.answer || 'Odpowiedź…'}
                </p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </>
  );
}
