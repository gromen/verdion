<?php

use function Roots\view;

echo view( 'partials.hero', [
    'attributes' => $attributes,
    'content'    => $content,
] )->render();
