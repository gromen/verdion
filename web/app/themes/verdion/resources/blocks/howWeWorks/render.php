<?php

use function Roots\view;

echo view('partials.how-we-works-section', [
    'attributes' => $attributes,
    'content'    => $content,
])->render();
