// inc/admin/admin-page.php
function rhuarcs_add_admin_menu() {
    add_menu_page(
        'Product Management',
        'Products',
        'edit_products',
        'rhuarcs-products',
        'rhuarcs_admin_page',
        'dashicons-products',
        20
    );
}
add_action('admin_menu', 'rhuarcs_add_admin_menu');

function rhuarcs_admin_page() {
    ?>
    <div id="rhuarcs-admin"></div>
    <?php
}