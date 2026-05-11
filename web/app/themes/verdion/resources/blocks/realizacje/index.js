import {
  InspectorControls,
  RichText,
  useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import {
  PanelBody,
  RangeControl,
  Spinner,
  TextControl,
  ToggleControl,
} from '@wordpress/components';
import { useEntityRecords } from '@wordpress/core-data';

import metadata from './block.json';

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

function Edit({ attributes, setAttributes }) {
  const { subtitle, title, desc, count, ctaLabel, ctaUrl, ctaOpensNewTab } =
    attributes;

  const blockProps = useBlockProps({
    className: 'verdionRealizacje verdionRealizacje--editor alignfull',
  });

  const { records: posts, isResolving } = useEntityRecords(
    'postType',
    'realizacja',
    { per_page: count, _embed: true },
  );

  return (
    <>
      <InspectorControls>
        <PanelBody title="Nagłówek sekcji" initialOpen={true}>
          <TextControl
            label="Tekst nad tytułem"
            value={subtitle ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ subtitle: val })}
          />
          <TextControl
            label="Opis"
            value={desc ?? ''}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ desc: val })}
          />
        </PanelBody>

        <PanelBody title="Karty realizacji" initialOpen={true}>
          <RangeControl
            label="Liczba realizacji"
            value={count}
            min={3}
            max={6}
            step={3}
            __next40pxDefaultSize={true}
            __nextHasNoMarginBottom={true}
            onChange={(val) => setAttributes({ count: val })}
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
        <div className="container-content">
          <header className="verdionRealizacje__header">
            {subtitle ? (
              <p className="verdionRealizacje__subtitle">{subtitle}</p>
            ) : (
              <p className="verdionRealizacje__subtitle verdionRealizacje__subtitle--placeholder">
                Tekst nad tytułem (panel boczny)
              </p>
            )}
            <RichText
              tagName="h2"
              className="verdionRealizacje__title"
              value={title}
              onChange={(val) => setAttributes({ title: val })}
              placeholder="Tytuł sekcji…"
            />
            {desc ? <p className="verdionRealizacje__desc">{desc}</p> : null}
          </header>

          {isResolving && (
            <div
              style={{
                display: 'flex',
                justifyContent: 'center',
                padding: '2rem',
              }}
            >
              <Spinner />
            </div>
          )}

          {!isResolving && posts && posts.length > 0 && (
            <div className="realizacjeGrid">
              {posts.map((post) => {
                const media = post._embedded?.['wp:featuredmedia']?.[0];
                const imgSrc = media?.source_url ?? null;
                const imgAlt = media?.alt_text ?? post.title?.rendered ?? '';
                const termGroups = post._embedded?.['wp:term'] ?? [];
                const kategorie = termGroups.find(
                  (g) => g[0]?.taxonomy === 'realizacja_kategoria',
                );
                const kategorieName = kategorie?.[0]?.name ?? null;
                return (
                  <div key={post.id} className="realizacjaCard">
                    <div className="realizacjaCard__thumb">
                      {imgSrc ? (
                        <img
                          src={imgSrc}
                          alt={imgAlt}
                          className="realizacjaCard__img"
                        />
                      ) : (
                        <div className="realizacjaCard__imgPlaceholder" />
                      )}
                      {kategorieName && (
                        <span className="realizacjaCard__badge">
                          {kategorieName}
                        </span>
                      )}
                    </div>
                    <div className="realizacjaCard__body">
                      <h3 className="realizacjaCard__title">
                        {post.title?.rendered ?? ''}
                      </h3>
                    </div>
                  </div>
                );
              })}
            </div>
          )}

          {!isResolving && (!posts || posts.length === 0) && (
            <p
              style={{ textAlign: 'center', opacity: 0.55, padding: '2rem 0' }}
            >
              Brak realizacji do wyświetlenia.
            </p>
          )}

          {ctaLabel && ctaUrl && (
            <div className="verdionRealizacje__ctaWrap">
              <span className="verdionRealizacje__cta verdionLink">
                {ctaLabel} <span aria-hidden="true">→</span>
              </span>
            </div>
          )}
        </div>
      </div>
    </>
  );
}
