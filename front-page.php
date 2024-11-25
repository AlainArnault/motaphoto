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
$args = array(
    'post_type' => 'photos',
    'posts_per_page' => 1,
    'orderby' => 'rand',     // Trier aléatoirement
);

$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) :
        $query->the_post();
        $background_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    endwhile;

    wp_reset_postdata();
endif;

// Si aucune image n'est trouvée, utiliser une image par défaut
$background_image_url = $background_image_url ?? get_template_directory_uri() . '/assets/images/default-hero.webp';
?>
<div class="home-content">
    <div class="hero" style="background-image: url('<?php echo esc_url($background_image_url); ?>');">
        <div class="hero-content">
            <h1>Photographe Event</h1>
        </div>
    </div>

    <!-- Sections personnalisées -->
    <?php get_template_part('template-parts/featured-photos'); ?>
    <?php get_template_part('template-parts/related-photos'); ?>
    <!-- Ajouter d'autres blocs ici -->
</div>

<?php
get_footer();
