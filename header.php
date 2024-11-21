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

            <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu'
                ]);
            ?>

        </nav>
    </header>