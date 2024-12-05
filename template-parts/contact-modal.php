<?php
/**
 * Template-part pour l'affichage d'une modale de contact
 *
 * @package WordPress
 * @subpackage motaphoto
 * @since 1.0
 */
?>

<div id="contact-modal" class="modal">
    <div class="modal-overlay"></div> <!-- Overlay ajouté ici -->
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <img src="<?php echo get_template_directory_uri().'/assets/images/Contact-header.svg'; ?>" alt="image contact">
        <?php echo do_shortcode('[contact-form-7 id="c4193af" title="Formulaire de contact 1"]'); ?>
    </div>
</div>


