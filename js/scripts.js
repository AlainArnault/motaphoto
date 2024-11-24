// Script pour la modale de contact
jQuery(document).ready(function ($) {
    // Cibler tous les liens de contact
    const contactLinks = $('.contactlink a, #contact-photo');
    const modal = $('#contact-modal');
    const photoRefField = $('#photo-ref'); // Champ du formulaire Contact Form 7.

    // Gérer les clics sur les liens de contact
    contactLinks.on('click', function (event) {
        event.preventDefault();

        const ref = $(this).data('ref'); // Récupérer la référence via l'attribut data-ref.
        if (photoRefField.length && ref) {
            photoRefField.val(ref); // Préremplir le champ avec la référence.
        } else if (photoRefField.length) {
            photoRefField.val(''); // Réinitialiser si aucune référence n'est fournie.
        }

        // Afficher la modale
        modal.addClass('show');
        $('body').addClass('modal-open'); // Empêche le scroll.
    });

    // Fermer la modale lorsqu'on clique sur le bouton de fermeture ou l'overlay
    $('.close-btn, .modal-overlay').on('click', function () {
        modal.removeClass('show');
        $('body').removeClass('modal-open'); // Réactive le scroll.
    });
});


// Script pour la navigation entre photos

document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".nav-link");
    const thumbnailPreview = document.getElementById("thumbnail-preview");

    navLinks.forEach(link => {
        link.addEventListener("mouseenter", function () {
            const thumbnailUrl = this.dataset.thumbnail;
            if (thumbnailUrl) {
                thumbnailPreview.style.backgroundImage = `url(${thumbnailUrl})`;
                thumbnailPreview.style.display = "block";
            }
        });

        link.addEventListener("mouseleave", function () {
            thumbnailPreview.style.display = "none";
        });
    });
});



