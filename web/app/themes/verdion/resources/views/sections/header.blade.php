@php
  // Read header block attrs from front page if block is placed there.
  $headerAttrs = [];
  $frontPageId = (int) get_option('page_on_front');
  if ($frontPageId > 0) {
    $blocks = parse_blocks(get_post_field('post_content', $frontPageId));
    foreach ($blocks as $block) {
      if (($block['blockName'] ?? '') === 'verdion/header') {
        $headerAttrs = $block['attrs'] ?? [];
        break;
      }
    }
  }
@endphp

@include('partials.header-nav', ['attributes' => $headerAttrs, 'content' => ''])
