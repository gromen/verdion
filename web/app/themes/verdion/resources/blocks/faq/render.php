<?php

use function Roots\view;

echo view( 'partials.faq-section', [
    'attributes' => $attributes,
    'content'    => $content,
] )->render();
