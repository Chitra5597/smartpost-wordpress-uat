<?php

/**
 * Legacy theme setup
 */

function smartpost_setup()
{
    add_theme_support('title-tag');

    register_nav_menu(
        'primary-menu',
        'Primary Menu'
    );
}

add_action('after_setup_theme', 'smartpost_setup');


/**
 * Register Sidebar
 */
function smartpost_sidebar()
{
    register_sidebar([
        'name' => 'Main Sidebar',
        'id' => 'main-sidebar'
    ]);
}

add_action('widgets_init', 'smartpost_sidebar');


/**
 * Load CSS and JS
 * Legacy style implementation
 */
function smartpost_assets()
{
    wp_enqueue_style(
        'smartpost-style',
        get_stylesheet_uri()
    );

    wp_enqueue_script(
        'legacy-js',
        get_template_directory_uri()
        . '/assets/js/legacy.js',
        array('jquery'),
        '1.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'smartpost_assets');


/**
 * Legacy widget code
 * Intentionally old pattern for upgrade practice
 */
function smartpost_old_function()
{
    // Will be improved during upgrade
    echo "<script>console.log('Legacy theme loaded');</script>";
}
add_action('wp_footer', 'smartpost_old_function');