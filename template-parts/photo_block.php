<?php
/**
 * Template-part pour l'affichage d'une photo dans une liste
 *
 * @package WordPress
 * @subpackage motaphoto
 * @since 1.0
 */
?>

<div class="photo-item">
    <?php if (has_post_thumbnail()) : ?>
        <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>" alt="<?php the_title_attribute(); ?>" class="related-photo">
    <?php endif; ?>
    <div class="photo-overlay">
        <a href="<?php the_permalink(); ?>" class="eye-icon">
            <i class="fa fa-eye"></i> <!-- Icône œil -->
        </a>
        <a href="#" class="fullscreen-icon">
            <i class="fa fa-expand"></i> <!-- Icône plein écran -->
        </a>
    </div>
</div>
