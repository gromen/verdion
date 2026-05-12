<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Expose CPT archive pages as menu items in Wygląd → Menu.
 */
add_action('load-nav-menus.php', function () {
    add_meta_box(
        'verdion-cpt-archives',
        __('Archiwa', 'verdion'),
        function () {
            $cpts = get_post_types(['public' => true, 'has_archive' => true, '_builtin' => false], 'objects');

            if (empty($cpts)) {
                echo '<p>' . esc_html__('Brak archiwów CPT.', 'verdion') . '</p>';
                return;
            }

            echo '<div id="verdion-cpt-archives-tabs" class="posttypediv">';
            echo '<ul id="verdion-cpt-archives-checklist" class="categorychecklist form-no-clear">';

            foreach ($cpts as $cpt) {
                $archive_url = get_post_type_archive_link($cpt->name);
                if (! $archive_url) {
                    continue;
                }
                $id = 'cpt-archive-' . $cpt->name;
                printf(
                    '<li><label class="menu-item-title"><input type="checkbox" class="menu-item-checkbox" name="menu-item[%1$s][menu-item-object-id]" value="-1"> %2$s</label>
                    <input type="hidden" class="menu-item-type" name="menu-item[%1$s][menu-item-type]" value="custom">
                    <input type="hidden" class="menu-item-title" name="menu-item[%1$s][menu-item-title]" value="%3$s">
                    <input type="hidden" class="menu-item-url" name="menu-item[%1$s][menu-item-url]" value="%4$s">
                    <input type="hidden" class="menu-item-classes" name="menu-item[%1$s][menu-item-classes]" value=""></li>',
                    esc_attr($id),
                    esc_html($cpt->labels->name),
                    esc_attr($cpt->labels->name),
                    esc_url($archive_url)
                );
            }

            echo '</ul></div>';
            echo '<p class="button-controls"><span class="add-to-menu"><input type="submit" class="button-secondary submit-add-to-menu right" value="' . esc_attr__('Dodaj do menu', 'verdion') . '" name="add-menu-item" id="verdion-cpt-archives-submit"></span></p>';
        },
        'nav-menus'
    );
});

require_once __DIR__ . '/MaintenanceMode.php';
add_action('template_redirect', 'App\verdion_maintenance_check', 1);
