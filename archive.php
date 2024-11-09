// archive-product.php
<?php get_header(); ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filters Sidebar -->
        <aside class="w-full md:w-64 bg-white rounded-lg shadow-sm p-4">
            <form class="product-filters space-y-6">
                <?php
                // Pet Type Filter
                $pet_types = get_terms(['taxonomy' => 'pet_type']);
                if (!empty($pet_types) && !is_wp_error($pet_types)) : ?>
                    <div>
                        <h3 class="font-medium mb-3">Pet Type</h3>
                        <div class="space-y-2">
                            <?php foreach ($pet_types as $type) : ?>
                                <label class="flex items-center">
                                    <input type="checkbox" name="pet_type[]" 
                                           value="<?php echo esc_attr($type->slug); ?>"
                                           <?php checked(in_array($type->slug, (array) get_query_var('pet_type'))); ?>
                                           class="form-checkbox">
                                    <span class="ml-2"><?php echo esc_html($type->name); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                // Categories Filter
                $categories = get_terms(['taxonomy' => 'product_category']);
                if (!empty($categories) && !is_wp_error($categories)) : ?>
                    <div>
                        <h3 class="font-medium mb-3">Categories</h3>
                        <div class="space-y-2">
                            <?php foreach ($categories as $category) : ?>
                                <label class="flex items-center">
                                    <input type="checkbox" name="category[]" 
                                           value="<?php echo esc_attr($category->slug); ?>"
                                           <?php checked(in_array($category->slug, (array) get_query_var('category'))); ?>
                                           class="form-checkbox">
                                    <span class="ml-2"><?php echo esc_html($category->name); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Price Range Filter -->
                <div>
                    <h3 class="font-medium mb-3">Price Range</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm">Min Price</label>
                            <input type="number" name="min_price" 
                                   value="<?php echo esc_attr(get_query_var('min_price')); ?>"
                                   class="form-input mt-1">
                        </div>
                        <div>
                            <label class="text-sm">Max Price</label>
                            <input type="number" name="max_price" 
                                   value="<?php echo esc_attr(get_query_var('max_price')); ?>"
                                   class="form-input mt-1">
                        </div>
                    </div>
                </div>
            </form>
        </aside>

        <!-- Products Grid -->
        <main class="flex-1">
            <?php if (have_posts()) : ?>
                <div class="product-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content', 'product'); ?>
                    <?php endwhile; ?>
                </div>

                <?php
                the_posts_pagination([
                    'prev_text' => __('Previous page', 'rhuarcs'),
                    'next_text' => __('Next page', 'rhuarcs'),
                ]);
                ?>
            <?php else : ?>
                <div class="text-center py-8">
                    <h2 class="text-xl font-medium mb-2">No Products Found</h2>
                    <p class="text-gray-600">Try adjusting your search or filter criteria</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>
