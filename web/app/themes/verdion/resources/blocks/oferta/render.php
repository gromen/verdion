<?php

use function Roots\view;

echo view('partials.oferta-section', [
    'attributes' => $attributes,
    'content'    => $content,
])->render();
