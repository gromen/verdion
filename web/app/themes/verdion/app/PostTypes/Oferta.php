<?php

namespace App\PostTypes;

class Oferta
{
    public static function register(): void
    {
        register_post_type('oferta', [
            'labels' => [
                'name'               => __('Oferty', 'verdion'),
                'singular_name'      => __('Oferta', 'verdion'),
                'add_new'            => __('Dodaj ofertę', 'verdion'),
                'add_new_item'       => __('Dodaj nową ofertę', 'verdion'),
                'edit_item'          => __('Edytuj ofertę', 'verdion'),
                'new_item'           => __('Nowa oferta', 'verdion'),
                'view_item'          => __('Zobacz ofertę', 'verdion'),
                'view_items'         => __('Zobacz oferty', 'verdion'),
                'search_items'       => __('Szukaj ofert', 'verdion'),
                'not_found'          => __('Nie znaleziono ofert', 'verdion'),
                'not_found_in_trash' => __('Brak ofert w koszu', 'verdion'),
                'all_items'          => __('Wszystkie oferty', 'verdion'),
                'menu_name'          => __('Oferty', 'verdion'),
            ],
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'oferty', 'with_front' => false],
            'capability_type'    => 'post',
            'has_archive'        => 'oferty',
            'hierarchical'       => false,
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-store',
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
            'template'           => [
                ['verdion/offer-details', []],
                ['verdion/how-we-works', []],
                ['verdion/faq', []],
            ],
            'template_lock'      => false,
        ]);
    }
}
