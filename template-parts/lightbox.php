<?php
/**
 * Template-part pour la lightbox
 *
 * @package WordPress
 * @subpackage motaphoto
 * @since 1.0
 */

 // Champs utiles
 $reference = get_post_meta( get_the_ID(), 'reference', true );
 $category = get_the_terms( get_the_ID(), 'categories' ); 
 $category_names = ! empty( $category ) && ! is_wp_error( $category ) ? wp_list_pluck( $category, 'name' ) : [];

 //Récupération de l'id et de l'url	
 $id = get_the_ID();
 $url = get_permalink();

 //Flèches précédent et suivant
 $nextPost = get_next_post();
 $previousPost = get_previous_post();
?>

<?php
$images = array(); // tableau vide pour stocker les URL des images
$image_index = 0; // indice d'image à 0

// La boucle ci-dessous récupère les images du contenu et les ajoute au tableau d'images
while (have_posts()) {
 the_post();
 $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); // Récupère l'URL de l'image à partir de la miniature de publication
 $reference = get_post_meta( get_the_ID(), 'reference', true ); // Récupère la référence de l'image
 $category = get_the_terms( get_the_ID(), 'categories' );  // Récupère la catégorie de l'image

 if ($thumbnail_url) {
     // Si une URL d'image est disponible, l'ajoute au tableau d'images avec la référence et la catégorie
     $images[] = array(
         'url' => $thumbnail_url,
         'reference' => $reference,
         'categories' => $category_names
     );
 }
}


?>

<div class="lightbox" id="lightbox">
    <div class="lightbox-overlay"></div>
    <div class="lightbox-close">&times;</div>
    <div class="lightbox-navigation">
        <a href="#" class="lightbox-link-prev" data-prev-id="">
            <i class="fa-solid fa-arrow-left-long"></i> Précédente  <!-- Flèche gauche -->
        </a>
        <a href="#" class="lightbox-link-next" data-next-id="">
            Suivante <i class="fa-solid fa-arrow-right-long"></i>  <!-- Flèche droite -->
        </a>
    </div>
    <div class="lightbox-container">
        <img class="lightbox-image" src="" alt="">
        <p class="photo-data-ref lightbox-reference"></p>
        <p class="photo-data-cat lightbox-categories"></p>
    </div>

</div>

<div data-image-array="<?php echo json_encode($images); ?>" data-image-index="<?php echo $image_index; ?>"></div>

