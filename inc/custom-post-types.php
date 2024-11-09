<?php
function rhuarcs_register_post_types() {
    // Products Post Type
    register_post_type('products', array(
        'labels' => array(
            'name' => __('Products', 'rhuarcs'),
            'singular_name' => __('Product', 'rhuarcs'),
            'add_new' => __('Add New Product', 'rhuarcs'),
            'add_new_item' => __('Add New Product', 'rhuarcs'),
            'edit_item' => __('Edit Product', 'rhuarcs'),
            'new_item' => __('New Product', 'rhuarcs'),
            'view_item' => __('View Product', 'rhuarcs'),
            'search_items' => __('Search Products', 'rhuarcs'),
            'not_found' => __('No products found', 'rhuarcs'),
            'not_found_in_trash' => __('No products found in Trash', 'rhuarcs')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'custom-fields'
        ),
        'menu_icon' => 'dashicons-products',
        'rewrite' => array('slug' => 'products'),
        'show_in_rest' => true
    ));

    // Product Categories
    register_taxonomy('product_category', 'products', array(
        'labels' => array(
            'name' => __('Product Categories', 'rhuarcs'),
            'singular_name' => __('Product Category', 'rhuarcs'),
            'search_items' => __('Search Categories', 'rhuarcs'),
            'all_items' => __('All Categories', 'rhuarcs'),
            'parent_item' => __('Parent Category', 'rhuarcs'),
            'parent_item_colon' => __('Parent Category:', 'rhuarcs'),
            'edit_item' => __('Edit Category', 'rhuarcs'),
            'update_item' => __('Update Category', 'rhuarcs'),
            'add_new_item' => __('Add New Category', 'rhuarcs'),
            'new_item_name' => __('New Category Name', 'rhuarcs'),
            'menu_name' => __('Categories', 'rhuarcs')
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'product-category'),
        'show_in_rest' => true
    ));
}
add_action('init', 'rhuarcs_register_post_types');