<?php

use function Roots\view;

echo view('partials.footer-section', [
    'attributes' => $attributes,
    'content'    => $content,
])->render();
