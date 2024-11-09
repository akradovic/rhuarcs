<?php

// Theme Setup
function rhuarcs_setup() {
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'rhuarcs'),
        'footer' => __('Footer Menu', 'rhuarcs'),
    ));
}
add_action('after_setup_theme', 'rhuarcs_setup');

// Enqueue Scripts and Styles
function rhuarcs_scripts() {
    wp_enqueue_style('rhuarcs-styles', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('rhuarcs-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    wp_enqueue_script('rhuarcs-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'rhuarcs_scripts');

// Include required files
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/admin/product-management.php';

// Admin page setup
if (is_admin()) {
    require_once get_template_directory() . '/inc/admin/admin-page.php';
}