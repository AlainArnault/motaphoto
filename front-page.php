<?php
/**
 * Template pour la page d'accueil
 *
 * @package WordPress
 * @subpackage motaphoto
 * @since 1.0
 */

get_header();

// Récupérer une photo aléatoire
$args_hero = array(
    'post_type' => 'photos',
    'posts_per_page' => 1,
    'orderby' => 'rand',     // Trier aléatoirement
);

$query_hero = new WP_Query($args_hero);

if ($query_hero->have_posts()) :
    while ($query_hero->have_posts()) :
        $query_hero->the_post();
        $background_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    endwhile;

    wp_reset_postdata();
endif;

// Image par défaut au cas où aucune image n'est trouvée
$background_image_url = $background_image_url ?? get_template_directory_uri() . '/assets/images/default-hero.webp';
?>
<div class="home-content">
    <div class="hero" style="background-image: url('<?php echo esc_url($background_image_url); ?>');">
        <div class="hero-content">
            <h1>Photographe Event</h1>
        </div>
    </div>

<?php
// liste des photos
$args_photo_list = array(
    'post_type' => 'photos',
    'posts_per_page' => 8, // Afficher les 8 premières photos
    'paged' => 1,
    'orderby' => 'date',
    'order' => 'DESC',
);

$query_photo_list = new WP_Query($args_photo_list);

if ($query_photo_list->have_posts()) :
    echo '<div class="photos-list">';
    echo '<div class="photo-gallery" id="photo-gallery">';

    while ($query_photo_list->have_posts()) : $query_photo_list->the_post();
        get_template_part('template-parts/photo_block');
    endwhile;

    echo '</div>'; // .photo-gallery
    echo '<button id="load-more" data-page="2">Charger plus</button>'; // Bouton charger plus
    echo '</div>'; // .photo-list

    wp_reset_postdata();

else :
    echo '<p>Aucune photo disponible.</p>';
endif;
?>


</div>

<?php
get_footer();
