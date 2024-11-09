<?php
// functions.php additions

if (!defined('ABSPATH')) exit;

// Theme Setup
function rhuarcs_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    
    // Register nav menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'rhuarcs'),
        'footer' => __('Footer Menu', 'rhuarcs')
    ]);
}
add_action('after_setup_theme', 'rhuarcs_theme_setup');

// Enqueue scripts and styles
function rhuarcs_enqueue_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('rhuarcs-style', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
    wp_enqueue_style('rhuarcs-main', get_template_directory_uri() . '/assets/css/main.css', [], wp_get_theme()->get('Version'));
    
    // Enqueue scripts
    wp_enqueue_script('rhuarcs-scripts', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], wp_get_theme()->get('Version'), true);
    
    // Localize script for AJAX
    wp_localize_script('rhuarcs-scripts', 'rhuarcsData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('rhuarcs_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'rhuarcs_enqueue_scripts');

// Admin scripts
function rhuarcs_admin_scripts($hook) {
    if ('toplevel_page_rhuarcs-products' !== $hook) return;
    
    wp_enqueue_script('react');
    wp_enqueue_script('react-dom');
    wp_enqueue_script('rhuarcs-admin', get_template_directory_uri() . '/assets/js/admin/build/index.js', ['react', 'react-dom'], wp_get_theme()->get('Version'), true);
    
    wp_localize_script('rhuarcs-admin', 'rhuarcsAdmin', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('rhuarcs_admin_nonce')
    ]);
}
add_action('admin_enqueue_scripts', 'rhuarcs_admin_scripts');