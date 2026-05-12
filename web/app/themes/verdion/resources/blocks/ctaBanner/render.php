<?php

use function Roots\view;

echo view( 'partials.cta-banner', [
    'attributes' => $attributes,
    'content'    => $content,
] )->render();
