<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <header class="bg-purple-800 text-white">
        <div class="container mx-auto px-4">
            <nav class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-bold">
                            <?php bloginfo('name'); ?>
                        </a>
                    <?php endif; ?>
                </div>
                
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'hidden md:flex space-x-4',
                    'fallback_cb' => false,
                ));
                ?>
            </nav>
        </div>
    </header>