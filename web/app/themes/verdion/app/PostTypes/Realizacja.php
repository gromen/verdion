<?php

namespace App\PostTypes;

class Realizacja
{
    public static function register(): void
    {
        register_post_type('realizacja', [
            'labels' => [
                'name'               => __('Realizacje', 'verdion'),
                'singular_name'      => __('Realizacja', 'verdion'),
                'add_new'            => __('Dodaj realizację', 'verdion'),
                'add_new_item'       => __('Dodaj nową realizację', 'verdion'),
                'edit_item'          => __('Edytuj realizację', 'verdion'),
                'new_item'           => __('Nowa realizacja', 'verdion'),
                'view_item'          => __('Zobacz realizację', 'verdion'),
                'view_items'         => __('Zobacz realizacje', 'verdion'),
                'search_items'       => __('Szukaj realizacji', 'verdion'),
                'not_found'          => __('Nie znaleziono realizacji', 'verdion'),
                'not_found_in_trash' => __('Brak realizacji w koszu', 'verdion'),
                'all_items'          => __('Wszystkie realizacje', 'verdion'),
                'menu_name'          => __('Realizacje', 'verdion'),
            ],
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'query_var'           => true,
            'rewrite'             => ['slug' => 'realizacje', 'with_front' => false],
            'capability_type'     => 'post',
            'has_archive'         => 'realizacje',
            'hierarchical'        => false,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-admin-home',
            'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
            'template'            => [
                ['core/paragraph', ['placeholder' => __('Opisz realizację...', 'verdion')]],
            ],
        ]);
    }
}
