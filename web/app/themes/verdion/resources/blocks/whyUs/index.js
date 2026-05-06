import {
  InspectorControls,
  MediaUpload,
  MediaUploadCheck,
  useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import {
  Button,
  Card,
  CardBody,
  CardHeader,
  CardMedia,
  Flex,
  __experimentalHeading as Heading,
  PanelBody,
  __experimentalText as Text,
} from '@wordpress/components';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const { cards } = attributes;

  const blockProps = useBlockProps({
    className: 'verdionWhyUs verdionWhyUs--editor alignfull',
    style: {
      display: 'flex',
      flexDirection: 'row',
      flexWrap: 'wrap',
      gap: '2rem',
      color: '#000',
    },
  });

  return (
    <>
      <InspectorControls>
        <PanelBody title="Karty" initialOpen={true}>
          {cards.map((card, index) => (
            <Card key={index}>
              <CardMedia>
                <MediaUploadCheck>
                  <MediaUpload
                    onSelect={(media) => {
                      const updated = cards.map((c, i) =>
                        i === index
                          ? { ...c, iconId: media.id, icon: media.url } // ← dodaj media.id
                          : c,
                      );
                      setAttributes({ cards: updated });
                    }}
                    allowedTypes={['image']}
                    value={card.icon}
                    render={({ open }) => (
                      <Button onClick={open} variant="secondary">
                        Wybierz obrazek
                      </Button>
                    )}
                  />
                </MediaUploadCheck>
              </CardMedia>
              <CardHeader>
                <Heading
                  level={4}
                  value={card.title}
                  onChange={(val) => {
                    const updated = cards.map((c, i) =>
                      i === index ? { ...c, title: val } : c,
                    );
                    setAttributes({ cards: updated });
                  }}
                >
                  {card.title}
                </Heading>
              </CardHeader>
              <CardBody>
                <Text
                  value={card.description}
                  onChange={(val) => {
                    const updated = cards.map((c, i) =>
                      i === index ? { ...c, description: val } : c,
                    );
                    setAttributes({ cards: updated });
                  }}
                />
              </CardBody>
            </Card>
            // <Flex key={index} align="flex-end" style={{ marginBottom: '16px' }}>
            //   <FlexBlock
            //     style={{ border: '1px solid rgba(0,0,0,0.1)', padding: '8px' }}
            //   >
            //     <TextControl
            //       label={`Karta ${index + 1}`}
            //       value={card.title}
            //       onChange={(val) => {
            //         const updated = cards.map((c, i) =>
            //           i === index ? { ...c, title: val } : c,
            //         );
            //         setAttributes({ cards: updated });
            //       }}
            //     />
            //     <TextControl
            //       label={`Opis ${index + 1}`}
            //       value={card.description}
            //       onChange={(val) => {
            //         const updated = cards.map((c, i) =>
            //           i === index ? { ...c, description: val } : c,
            //         );
            //         setAttributes({ cards: updated });
            //       }}
            //     />
            //   </FlexBlock>
            //   <FlexItem>
            //     <Button
            //       isDestructive
            //       size="small"
            //       onClick={() => {
            //         setAttributes({
            //           cards: cards.filter((_, i) => i !== index),
            //         });
            //       }}
            //       style={{ marginBottom: '8px' }}
            //     >
            //       ✕
            //     </Button>
            //   </FlexItem>
            // </Flex>
          ))}
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        {cards && cards.length > 0 && (
          <Flex align="flex-end" style={{ marginBottom: '8px' }}>
            {cards.map((card, i) => (
              <span
                key={i}
                style={{
                  color: '#000',
                  fontSize: '0.875rem',
                  display: 'flex',
                  alignItems: 'center',
                  gap: '0.375rem',
                }}
              >
                <div class="verdionWhyUs__cardContent">
                  <span class="verdionWhyUs__cardIcon">
                    <img src={card.icon} alt={card.title} />
                  </span>
                  <span class="verdionWhyUs__cardTitle">{card.title}</span>
                  <span class="verdionWhyUs__cardDescription">
                    {card.description}
                  </span>
                </div>
              </span>
            ))}
          </Flex>
        )}
      </div>
    </>
  );
}
