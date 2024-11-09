<?php get_header(); ?>

<main class="container mx-auto px-4 py-8">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/content', get_post_type()); ?>
        <?php endwhile; ?>
    <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>