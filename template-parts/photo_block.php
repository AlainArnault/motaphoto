<?php
/**
 * Template-part pour l'affichage d'une photo dans une liste
 *
 * @package WordPress
 * @subpackage motaphoto
 * @since 1.0
 */

    //Préparer les variables
    $reference = get_post_meta( get_the_ID(), 'reference', true );
    $category = get_the_terms( get_the_ID(), 'categories' ); 
    $category_names = ! empty( $category ) && ! is_wp_error( $category ) ? wp_list_pluck( $category, 'name' ) : [];
?>

<div class="photo-item">
    <?php if (has_post_thumbnail()) : ?>
        <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>" alt="<?php the_title_attribute(); ?>" class="related-photo">
    <?php endif; ?>
    <div class="photo-overlay">
        <!-- Lien vers la page de détail de la photo -->
        <a href="<?php the_permalink(); ?>" class="eye-icon">
            <i class="fa fa-eye"></i> <!-- Icône œil -->
        </a>
        <!-- Lien pour ouvrir la lightbox -->
        <a href="#" class="fullscreen-icon open-lightbox" 
            data-photo-id="<?php echo get_the_ID(); ?>"
            data-thumbnail="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>"
            data-reference="<?php echo esc_html($reference); ?>"
            data-categories="<?php echo implode(', ', $category_names); ?>">
            <i class="fa fa-expand"></i> <!-- Icône plein écran -->
        </a>
        <p class="photo-data ref">Référence : <?php echo esc_html($reference); ?></p>
        <p class="photo-data cat">Catégorie : <?php echo implode(', ', $category_names); ?></p>
    </div>
</div>
