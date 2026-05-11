import {
  InspectorControls,
  PanelColorSettings,
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
  const { subtitle, title, backgroundColor, steps } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionHowWeWorks verdionHowWeWorks--editor alignfull',
  });

  function addStep() {
    if (steps.length >= 8) return;
    const num = String(steps.length + 1).padStart(2, '0');
    setAttributes({
      steps: [...steps, { number: num, title: '', description: '' }],
    });
  }

  function removeStep(index) {
    setAttributes({ steps: steps.filter((_, i) => i !== index) });
  }

  function updateStep(index, patch) {
    setAttributes({
      steps: steps.map((s, i) => (i === index ? { ...s, ...patch } : s)),
    });
  }

  function moveStep(from, to) {
    const arr = [...steps];
    const [item] = arr.splice(from, 1);
    arr.splice(to, 0, item);
    setAttributes({ steps: arr });
  }

  return (
    <>
      <InspectorControls>
        <PanelBody title="Nagłówek sekcji" initialOpen={true}>
          <TextControl
            label="Podtytuł (etykieta)"
            value={subtitle ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ subtitle: val })}
          />
          <TextControl
            label="Tytuł sekcji"
            value={title ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ title: val })}
          />
        </PanelBody>

        <PanelColorSettings
          title="Tło sekcji"
          initialOpen={false}
          colorSettings={[
            {
              value: backgroundColor,
              onChange: (val) => setAttributes({ backgroundColor: val ?? '' }),
              label: 'Kolor tła',
            },
          ]}
        />

        <PanelBody title={`Kroki (${steps.length}/8)`} initialOpen={true}>
          {steps.map((step, index) => (
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
                Krok {index + 1}
              </p>

              <TextControl
                label="Numer"
                value={step.number ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateStep(index, { number: val })}
              />

              <TextControl
                label="Tytuł"
                value={step.title ?? ''}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateStep(index, { title: val })}
              />

              <TextareaControl
                label="Opis"
                value={step.description ?? ''}
                rows={3}
                __next40pxDefaultSize={true}
                __nextHasNoMarginBottom={true}
                onChange={(val) => updateStep(index, { description: val })}
              />

              <Flex justify="space-between" style={{ marginTop: '8px' }}>
                <Flex gap={1}>
                  <Button
                    size="small"
                    variant="tertiary"
                    disabled={index === 0}
                    onClick={() => moveStep(index, index - 1)}
                    aria-label="Przesuń krok w górę"
                  >
                    ↑
                  </Button>
                  <Button
                    size="small"
                    variant="tertiary"
                    disabled={index === steps.length - 1}
                    onClick={() => moveStep(index, index + 1)}
                    aria-label="Przesuń krok w dół"
                  >
                    ↓
                  </Button>
                </Flex>
                {steps.length > 1 && (
                  <FlexBlock style={{ textAlign: 'right' }}>
                    <Button
                      isDestructive
                      size="small"
                      onClick={() => removeStep(index)}
                    >
                      Usuń krok
                    </Button>
                  </FlexBlock>
                )}
              </Flex>
            </div>
          ))}

          <Button
            variant="secondary"
            style={{ width: '100%', marginTop: '4px' }}
            disabled={steps.length >= 8}
            onClick={addStep}
          >
            + Dodaj krok
          </Button>
        </PanelBody>
      </InspectorControls>

      {/* Canvas preview */}
      <div
        {...blockProps}
        style={{
          ...(blockProps.style || {}),
          ...(backgroundColor ? { backgroundColor } : {}),
        }}
      >
        <div className="container-content">
          <header className="verdionHowWeWorks__header">
            {subtitle && (
              <p className="verdionHowWeWorks__subtitle">{subtitle}</p>
            )}
            <h2 className="verdionHowWeWorks__title">
              {title || 'Jak pracujemy?'}
            </h2>
          </header>

          <div className="verdionHowWeWorks__steps">
            {steps.map((step, idx) => (
              <div key={idx} className="verdionHowWeWorks__step">
                <div className="verdionHowWeWorks__stepCircle">
                  <span className="verdionHowWeWorks__stepNumber">
                    {step.number || String(idx + 1).padStart(2, '0')}
                  </span>
                </div>
                <h3 className="verdionHowWeWorks__stepTitle">
                  {step.title || '(brak tytułu)'}
                </h3>
                {step.description && (
                  <p className="verdionHowWeWorks__stepDesc">
                    {step.description}
                  </p>
                )}
              </div>
            ))}
          </div>
        </div>
      </div>
    </>
  );
}
