// inc/custom-post-types.php

function rhuarcs_register_post_types() {
    // Products Post Type
    register_post_type('products', array(
        'labels' => array(
            'name' => __('Products', 'rhuarcs'),
            'singular_name' => __('Product', 'rhuarcs'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-products',
        'rewrite' => array('slug' => 'products'),
    ));

    // Product Categories
    register_taxonomy('product_category', 'products', array(
        'labels' => array(
            'name' => __('Product Categories', 'rhuarcs'),
            'singular_name' => __('Product Category', 'rhuarcs'),
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'product-category'),
    ));
}
add_action('init', 'rhuarcs_register_post_types');