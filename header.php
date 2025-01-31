<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
    <?php wp_body_open(); ?>
    <header>
        <nav>
            <a href="<?php echo home_url( '/' ); ?>">
                <img class="logo" src="<?php echo get_template_directory_uri().'/assets/images/logo.svg'; ?>" alt="Logo Nathalie Mota">
            </a> 

            <!-- Bouton burger -->
            <button id="menu-toggle" class="menu-toggle" aria-label="Menu">
            <img id="menu-icon" src="<?php echo get_template_directory_uri().'/assets/images/burger.png'; ?>" alt="logo burger">
            </button>

        <!-- Menu principal -->

            <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'menu_class' => 'menu'
                ]);
            ?>

        </nav>
    </header>