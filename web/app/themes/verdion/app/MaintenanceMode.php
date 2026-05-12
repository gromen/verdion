<?php

/**
 * Maintenance mode — shows a 503 page to non-logged-in visitors.
 *
 * Activate:   wp option update verdion_maintenance_active 1
 * Deactivate: wp option update verdion_maintenance_active 0
 */

namespace App;

function verdion_maintenance_check(): void
{
    // Bail if maintenance mode is disabled (0 = off, anything else = on).
    if ((int) get_option('verdion_maintenance_active', 1) === 0) {
        return;
    }

    // Skip for logged-in users and wp-admin.
    if (is_user_logged_in() || is_admin()) {
        return;
    }

    // Skip for WP-CLI (called in global namespace to allow compiler optimization).
    if (\defined('WP_CLI') && \WP_CLI) {
        return;
    }

    // Skip for REST API requests.
    if (\defined('REST_REQUEST') && \REST_REQUEST) {
        return;
    }

    // Skip for the login page (defensive — wp-login.php typically exits before template_redirect).
    if (isset($GLOBALS['pagenow']) && $GLOBALS['pagenow'] === 'wp-login.php') {
        return;
    }

    // Send maintenance headers.
    status_header(503);
    header('Content-Type: text/html; charset=UTF-8');
    header('Retry-After: 86400');
    header('X-Robots-Tag: noindex, nofollow');
    header('Cache-Control: no-store, no-cache, must-revalidate');

    // Require the self-contained maintenance view (fatal error if missing — easier to diagnose).
    require get_theme_file_path('resources/views/maintenance.php');

    exit;
}
