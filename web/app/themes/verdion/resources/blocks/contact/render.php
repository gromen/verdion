<?php

use function Roots\view;

echo view( 'partials.contact-section', [
    'attributes'     => $attributes,
    'content'        => $content,
    'wrapperAttrs'   => get_block_wrapper_attributes(),
] )->render();
