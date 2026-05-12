<?php
use function Roots\view;

echo view( 'partials.offer-details', [
	'attributes' => $attributes,
	'content'    => $content,
] )->render();
