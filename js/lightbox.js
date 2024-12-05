jQuery(document).ready(function ($) {
    const lightboxLinks = $('.open-lightbox');
    const lightbox = $('#lightbox');
    const lightboxImage = $('#lightbox .lightbox-image');
    const lightboxReference = $('#lightbox .lightbox-reference');
    const lightboxCategories = $('#lightbox .lightbox-categories');
    
    let currentPhotoId = null; // ID de la photo actuelle

    // Stocker les données passées depuis PHP
    //const allPhotoData = window.photoData; // Les données complètes des photos
    //const allPhotoIds = allPhotoData.map(photo => photo.id); // Extraire les IDs pour la navigation

    // Fonction pour récupérer les données d'une photo par ID
    function getPhotoDataById(photoId) {
        return allPhotoData.find(photo => photo.id === photoId);
    }


    // Gérer les clics sur les liens vers la lightbox
    lightboxLinks.on('click', function (event) {
        event.preventDefault();
        
        currentPhotoId = $(this).data('photo-id');
        console.log('ID de la photo courante :', currentPhotoId)
        let thumbnailUrl = $(this).data('thumbnail');
        let reference = $(this).data('reference');
        let categories = $(this).data('categories');
        
        lightboxImage.attr('src', thumbnailUrl);
        lightboxImage.attr('alt', reference);
        lightboxReference.text('Référence : ' + reference);
        lightboxCategories.text('Catégories : ' + categories);

        lightbox.addClass('show');
        $('body').addClass('lightbox-open');
    });

    // Navigation vers la photo précédente
    $('.lightbox-link-prev').on('click', function (e) {
        e.preventDefault();
        let currentIndex = allPhotoIds.indexOf(currentPhotoId);
        let prevIndex = (currentIndex - 1 + allPhotoIds.length) % allPhotoIds.length; // Utilisation de modulo pour boucle infinie
        currentPhotoId = allPhotoIds[prevIndex];

        updateLightboxWithPhoto(currentPhotoId);
    });

    // Navigation vers la photo suivante
    $('.lightbox-link-next').on('click', function (e) {
        e.preventDefault();
        let currentIndex = allPhotoIds.indexOf(currentPhotoId);
        let nextIndex = (currentIndex + 1) % allPhotoIds.length; // Utilisation de modulo pour boucle infinie
        currentPhotoId = allPhotoIds[nextIndex];

        updateLightboxWithPhoto(currentPhotoId);
    });

    // Fonction pour mettre à jour la lightbox avec les informations de la nouvelle photo
    function updateLightboxWithPhoto(photoId) {
        const photoData = getPhotoDataById(photoId); // Fonction à définir pour récupérer les données (url, référence, catégories)

        lightboxImage.attr('src', photoData.thumbnailUrl);
        lightboxImage.attr('alt', photoData.reference);
        lightboxReference.text('Référence : ' + photoData.reference);
        lightboxCategories.text('Catégories : ' + photoData.categories);
    }

    // Fermer la lightbox lorsqu'on clique sur le bouton de fermeture ou l'overlay
    $('.lightbox-close, .lightbox-overlay').on('click', function () {
        lightbox.removeClass('show');
        $('body').removeClass('lightbox-open');
    });
});

