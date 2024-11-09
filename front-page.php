<?php get_header(); ?>

<main>
    <!-- Hero Section -->
    <section class="bg-purple-800 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Rhuarc's Pet Supplies</h1>
            <p class="text-xl mb-8">Your trusted source for quality pet products</p>
            <a href="/products" class="bg-white text-purple-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                Shop Now
            </a>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8">Featured Products</h2>
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'orderby' => 'date',
                'order' => 'DESC',
            );
            $featured_products = new WP_Query($args);
            
            if ($featured_products->have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php while ($featured_products->have_posts()) : $featured_products->the_post(); ?>
                        <?php get_template_part('template-parts/content', 'product'); ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; wp_reset_postdata(); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>