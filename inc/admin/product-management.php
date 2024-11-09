// inc/admin/product-management.php
class RhuarcsProductManagement {
    public function __construct() {
        add_action('wp_ajax_rhuarcs_get_products', array($this, 'get_products'));
        add_action('wp_ajax_rhuarcs_add_product', array($this, 'add_product'));
        add_action('wp_ajax_rhuarcs_update_product', array($this, 'update_product'));
        add_action('wp_ajax_rhuarcs_delete_product', array($this, 'delete_product'));
    }

    public function get_products() {
        check_ajax_referer('rhuarcs_admin_nonce', 'nonce');

        $args = array(
            'post_type' => 'products',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );

        $products = get_posts($args);
        $formatted_products = array();

        foreach ($products as $product) {
            $formatted_products[] = array(
                'id' => $product->ID,
                'name' => $product->post_title,
                'description' => $product->post_content,
                'price' => get_post_meta($product->ID, '_price', true),
                'stock' => get_post_meta($product->ID, '_stock', true),
                'category' => wp_get_post_terms($product->ID, 'product_category'),
                'image' => get_the_post_thumbnail_url($product->ID, 'medium')
            );
        }

        wp_send_json_success($formatted_products);
    }

    public function add_product() {
        check_ajax_referer('rhuarcs_admin_nonce', 'nonce');
        
        if (!current_user_can('edit_products')) {
            wp_send_json_error('Unauthorized');
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $product_id = wp_insert_post(array(
            'post_type' => 'products',
            'post_title' => sanitize_text_field($data['name']),
            'post_content' => wp_kses_post($data['description']),
            'post_status' => 'publish'
        ));

        if ($product_id) {
            update_post_meta($product_id, '_price', floatval($data['price']));
            update_post_meta($product_id, '_stock', intval($data['stock']));
            
            if (!empty($data['category'])) {
                wp_set_object_terms($product_id, $data['category'], 'product_category');
            }

            wp_send_json_success(array('id' => $product_id));
        }

        wp_send_json_error('Failed to create product');
    }

    // Add update_product and delete_product methods similarly
}

new RhuarcsProductManagement();