
// single-product.php
<?php get_header(); ?>

<div class="container mx-auto px-4 py-8">
    <?php while (have_posts()) : the_post(); ?>
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="md:flex">
                <!-- Product Image -->
                <div class="md:w-1/2">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="aspect-w-1 aspect-h-1">
                            <?php the_post_thumbnail('large', ['class' => 'object-cover w-full h-full']); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Product Details -->
                <div class="p-6 md:w-1/2">
                    <h1 class="text-3xl font-bold mb-4"><?php the_title(); ?></h1>
                    
                    <!-- Price -->
                    <div class="text-2xl font-bold text-brand-purple mb-6">
                        $<?php echo number_format((float) get_post_meta(get_the_ID(), '_price', true