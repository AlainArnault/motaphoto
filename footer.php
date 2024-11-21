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
</footer>

</body>
</html>