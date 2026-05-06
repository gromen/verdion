<?php

namespace App\Taxonomies;

class RealizacjaKategoria
{
    public static function register(): void
    {
        register_taxonomy('realizacja_kategoria', 'realizacja', [
            'labels' => [
                'name'              => __('Kategorie realizacji', 'verdion'),
                'singular_name'     => __('Kategoria realizacji', 'verdion'),
                'search_items'      => __('Szukaj kategorii', 'verdion'),
                'all_items'         => __('Wszystkie kategorie', 'verdion'),
                'parent_item'       => __('Nadrzędna kategoria', 'verdion'),
                'parent_item_colon' => __('Nadrzędna kategoria:', 'verdion'),
                'edit_item'         => __('Edytuj kategorię', 'verdion'),
                'update_item'       => __('Zaktualizuj kategorię', 'verdion'),
                'add_new_item'      => __('Dodaj nową kategorię', 'verdion'),
                'new_item_name'     => __('Nazwa nowej kategorii', 'verdion'),
                'menu_name'         => __('Kategorie', 'verdion'),
            ],
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'realizacje/kategoria', 'with_front' => false],
        ]);
    }
}
