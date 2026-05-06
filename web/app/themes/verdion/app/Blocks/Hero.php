<?php

namespace App\Blocks;

class Hero
{
    public static function register(): void
    {
        register_block_type(
            get_theme_file_path('public/blocks/hero')
        );
    }
}
