<?php
// functions.php

if (!defined('ABSPATH')) exit;

// Include necessary files
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/admin/product-management.php';
require_once get_template_directory() . '/inc/helpers.php';

// Enqueue admin scripts
function rhuarcs_admin_scripts() {
    if (current_user_can('edit_products')) {
        wp_enqueue_script('rhuarcs-admin', 
            get_template_directory_uri() . '/assets/js/admin/build/index.js',
            array('wp-element'), // WordPress's React
            '1.0.0',
            true
        );

        // Add admin ajax url and nonce to our script
        wp_localize_script('rhuarcs-admin', 'rhuarcsAdmin', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('rhuarcs_admin_nonce')
        ));
    }
}
add_action('admin_enqueue_scripts', 'rhuarcs_admin_scripts');