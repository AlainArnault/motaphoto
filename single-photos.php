<?php
/**
 * Template pour afficher un article de type "photos"
 *
 * @package WordPress
 * @subpackage motaphoto
 * @since 1.0
 */

get_header();

// Boucle WordPress pour afficher les info de la photo
while ( have_posts() ) :
    the_post();

    // Préparer les variables
    $reference = get_post_meta( get_the_ID(), 'reference', true );
    $category = get_the_terms( get_the_ID(), 'categories' ); 
    $category_names = ! empty( $category ) && ! is_wp_error( $category ) ? wp_list_pluck( $category, 'name' ) : [];
    $formats = get_the_terms( get_the_ID(), 'format' ); 
    $format_names = ! empty( $formats ) && ! is_wp_error( $formats ) ? wp_list_pluck( $formats, 'name' ) : [];
    $type = get_post_meta( get_the_ID(), 'type', true );
    $year_taken = get_the_date( 'Y' ); // Année de publication

    // Structure HTML
    ?>
    <div class="photo-page">
        <div class="photo-info">
            <h2><?php the_title(); ?></h2>
            <p class="photo-description">Référence : <?php echo esc_html($reference); ?></p>
            <p class="photo-description">Catégorie : <?php echo implode(', ', $category_names); ?></p>
            <p class="photo-description">Format : <?php echo implode(', ', $format_names); ?></p>
            <p class="photo-description">Type : <?php echo esc_html($type); ?></p>
            <p class="photo-description">Année : <?php echo esc_html($year_taken); ?></p>
        </div>
        <div class="photo-image-container">
            <?php if (has_post_thumbnail()) : ?>
                <?php echo get_the_post_thumbnail(null, 'large'); ?>
            <?php endif; ?>
        </div>
        <div class="photo-actions">
            <div class="contact-us">
                <p>Cette photo vous intéresse ?</p>
                <a href="#" class="contact-link" id="contact-photo" data-ref="<?php echo esc_html($reference); ?>">Contactez-nous</a>
            </div>
            <div class="navigation">
                <?php 
                $prev_post = get_previous_post();
                $next_post = get_next_post();

                if ($prev_post) : ?>
                    <a href="<?php echo get_permalink($prev_post); ?>" 
                       class="nav-link prev" 
                       data-thumbnail="<?php echo get_the_post_thumbnail_url($prev_post, 'thumbnail'); ?>">
                       <i class="fa-solid fa-arrow-left-long"></i> Précédente  <!-- Flèche gauche -->
                    </a>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                    <a href="<?php echo get_permalink($next_post); ?>" 
                       class="nav-link next" 
                       data-thumbnail="<?php echo get_the_post_thumbnail_url($next_post, 'thumbnail'); ?>">
                       Suivante <i class="fa-solid fa-arrow-right-long"></i>  <!-- Flèche droite -->
                    </a>
                <?php endif; ?>
                <div id="thumbnail-preview"></div>
            </div>
        </div>
    </div>

    <?php endwhile;

// Photos apparentées

    // Récupérer la catégorie actuelle de la photo
    $category_ids = wp_list_pluck($category, 'term_id');

    // Créer la requête pour récupérer deux photos de la même catégorie
    $args_related_photos = array(
        'post_type' => 'photos',
        'posts_per_page' => 2,
        'post__not_in' => array(get_the_ID()),
        'tax_query' => array(
            array(
                'taxonomy' => 'categories',
                'field'    => 'id',
                'terms'    => $category_ids,
                'operator' => 'IN',
            ),
        ),
    );

    $related_photos = new WP_Query($args_related_photos);

    if ($related_photos->have_posts()) :
        echo '<div class="related-photos">';
        echo '<h3>Vous aimerez aussi</h3>';
        echo '<div class="photo-gallery">';
        
        while ($related_photos->have_posts()) : $related_photos->the_post();
            get_template_part('template-parts/photo_block');
        endwhile;
    
        echo '</div>'; // .photo-gallery
        echo '</div>'; // .related-photos
    
        wp_reset_postdata(); // Réinitialiser la requête
    endif;
    

get_footer();
?>
