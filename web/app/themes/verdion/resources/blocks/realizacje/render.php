<?php

use function Roots\view;

echo view('partials.realizacje-section', [
    'attributes' => $attributes,
    'content'    => $content,
])->render();
