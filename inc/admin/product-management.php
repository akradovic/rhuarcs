<?php
// inc/custom-post-types.php

function rhuarcs_register_post_types() {
    register_post_type('product', [
        'labels' => [
            'name' => __('Products', 'rhuarcs'),
            'singular_name' => __('Product', 'rhuarcs')
        ],
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'menu_icon' => 'dashicons-cart',
        'rewrite' => ['slug' => 'products']
    ]);
    
    register_taxonomy('product_category', 'product', [
        'hierarchical' => true,
        'labels' => ['name' => 'Categories'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'product-category']
    ]);
    
    register_taxonomy('pet_type', 'product', [
        'hierarchical' => true,
        'labels' => ['name' => 'Pet Types'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'pet-type']
    ]);
}
add_action('init', 'rhuarcs_register_post_types');

// inc/admin/product-management.php
function rhuarcs_get_products() {
    check_ajax_referer('rhuarcs_admin_nonce', 'nonce');
    
    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ];
    
    $products = [];
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $products[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'description' => get_the_content(),
                'price' => get_post_meta(get_the_ID(), '_price', true),
                'stock' => get_post_meta(get_the_ID(), '_stock', true),
                'category' => wp_get_post_terms(get_the_ID(), 'product_category', ['fields' => 'names']),
                'pet_type' => wp_get_post_terms(get_the_ID(), 'pet_type', ['fields' => 'names']),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
            ];
        }
    }
    wp_reset_postdata();
    
    wp_send_json_success($products);
}
add_action('wp_ajax_rhuarcs_get_products', 'rhuarcs_get_products');

function rhuarcs_add_product() {
    check_ajax_referer('rhuarcs_admin_nonce', 'nonce');
    
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Insufficient permissions');
        return;
    }
    
    $product_data = [
        'post_title' => sanitize_text_field($_POST['title']),
        'post_content' => wp_kses_post($_POST['description']),
        'post_type' => 'product',
        'post_status' => 'publish'
    ];
    
    $product_id = wp_insert_post($product_data);
    
    if ($product_id) {
        update_post_meta($product_id, '_price', sanitize_text_field($_POST['price']));
        update_post_meta($product_id, '_stock', sanitize_text_field($_POST['stock']));
        
        wp_send_json_success(['id' => $product_id]);
    } else {
        wp_send_json_error('Failed to create product');
    }
}
add_action('wp_ajax_rhuarcs_add_product', 'rhuarcs_add_product');