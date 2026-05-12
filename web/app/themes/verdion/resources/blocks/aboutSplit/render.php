<?php

use function Roots\view;

echo view('partials.about-split', [
    'attributes' => $attributes,
    'content'    => $content,
])->render();
