<?php wp_footer(); ?>

<footer>
    <div class="footer-container">
        <?php
            wp_nav_menu([
                'theme_location' => 'footer-menu', // Utilisez l'emplacement de menu défini dans WP
                'container'       => false,
                'menu_class'      => 'footer-menu',
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
            ]);
        ?>
    </div>
    
    <!-- Appeler le fichier de la modale -->
    <?php get_template_part('template-parts/contact-modal'); ?>

    <!-- Appeler le fichier de la lightbox -->
    <?php get_template_part('template-parts/lightbox'); ?>

</footer>

</body>
</html>