<?php
// Add admin menu
function rhuarcs_add_admin_menu() {
    add_menu_page(
        'Product Management',
        'Products',
        'edit_posts',
        'rhuarcs-products',
        'rhuarcs_admin_page',
        'dashicons-products',
        20
    );
}
add_action('admin_menu', 'rhuarcs_add_admin_menu');

// Admin page callback
function rhuarcs_admin_page() {
    ?>
    <div id="rhuarcs-admin" class="wrap">
        <!-- React will render here -->
    </div>
    <?php
}

// Enqueue admin scripts
function rhuarcs_admin_scripts($hook) {
    if ('toplevel_page_rhuarcs-products' !== $hook) {
        return;
    }

    wp_enqueue_script(
        'rhuarcs-admin',
        get_template_directory_uri() . '/assets/js/admin/build/index.js',
        array('react', 'react-dom'),
        '1.0.0',
        true
    );

    wp_localize_script('rhuarcs-admin', 'rhuarcsAdmin', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('rhuarcs_admin_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'rhuarcs_admin_scripts');