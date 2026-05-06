<?php

use function Roots\view;

echo view( 'partials.why-us', [
    'attributes' => $attributes,
    'content'    => $content,
] )->render();
