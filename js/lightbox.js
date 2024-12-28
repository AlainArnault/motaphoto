document.addEventListener("DOMContentLoaded", function () {
    let allPhotoData = []; // Tableau pour stocker les données des photos
    let allPhotoIds = []; // Tableau des IDs des photos
    const lightbox = document.getElementById("lightbox");
    const body = document.body;

    // Fonction pour extraire les données des photos et les ajouter au tableau
    function updatePhotoData() {
        // Réinitialiser les tableaux pour inclure toutes les photos actuelles
        allPhotoData = [];
        allPhotoIds = [];
    
        const lightboxLinks = document.querySelectorAll(".open-lightbox"); // Sélectionner tous les liens de la lightbox
    
        lightboxLinks.forEach(link => {
            const photoId = link.dataset.photoId; // Récupérer les attributs data-*
            const thumbnailUrl = link.dataset.thumbnail;
            const reference = link.dataset.reference;
            const categories = link.dataset.categories;
    
            // Ajouter toutes les photos, puisqu'on réinitialise les tableaux
            allPhotoData.push({
                id: photoId,
                thumbnailUrl: thumbnailUrl,
                reference: reference,
                categories: categories,
            });
            allPhotoIds.push(photoId);
        });
    
        // DEBUG : Afficher les données mises à jour
        console.log("Mise à jour des données des photos :", allPhotoData);
        console.log("Mise à jour des IDs :", allPhotoIds);
    }

    // Fonction pour mettre à jour la lightbox avec les informations de la photo
    function updateLightboxWithPhoto(photoId) {
        const photoData = allPhotoData.find(photo => photo.id === photoId);

        if (photoData) {
            const lightboxImage = lightbox.querySelector(".lightbox-image");
            const lightboxReference = lightbox.querySelector(".lightbox-reference");
            const lightboxCategories = lightbox.querySelector(".lightbox-categories");

            lightboxImage.src = photoData.thumbnailUrl;
            lightboxImage.alt = photoData.reference;
            lightboxReference.textContent = "Référence : " + photoData.reference;
            lightboxCategories.textContent = "Catégories : " + photoData.categories;
        }
    }

    // Fonction pour gérer les clics sur les liens de la lightbox
    function attachLightboxEvents() {
        const lightboxLinks = document.querySelectorAll(".open-lightbox");

        lightboxLinks.forEach(link => {
            link.addEventListener("click", function (event) {
                event.preventDefault();

                // Récupérer l'ID de la photo actuelle
                const currentPhotoId = link.dataset.photoId;

                // Mettre à jour le contenu de la lightbox
                updateLightboxWithPhoto(currentPhotoId);

                // Ouvrir la lightbox
                lightbox.classList.add("show");
                body.classList.add("lightbox-open");
            });
        });
    }

    // Initialiser les données et les événements
    updatePhotoData();
    attachLightboxEvents();

    // Navigation dans la lightbox
    let currentPhotoId = null;

    // Navigation vers la photo précédente
    document.querySelector(".lightbox-link-prev").addEventListener("click", function (e) {
        e.preventDefault();
        const currentIndex = allPhotoIds.indexOf(currentPhotoId);
        const prevIndex = (currentIndex - 1 + allPhotoIds.length) % allPhotoIds.length; // Boucle infinie
        currentPhotoId = allPhotoIds[prevIndex];

        updateLightboxWithPhoto(currentPhotoId);
    });

    // Navigation vers la photo suivante
    document.querySelector(".lightbox-link-next").addEventListener("click", function (e) {
        e.preventDefault();
        const currentIndex = allPhotoIds.indexOf(currentPhotoId);
        const nextIndex = (currentIndex + 1) % allPhotoIds.length; // Boucle infinie
        currentPhotoId = allPhotoIds[nextIndex];

        updateLightboxWithPhoto(currentPhotoId);
    });

    // Fermer la lightbox
    document.querySelectorAll(".lightbox-close, .lightbox-overlay").forEach(element => {
        element.addEventListener("click", function () {
            lightbox.classList.remove("show");
            body.classList.remove("lightbox-open");
        });
    });

    // Réagir après le chargement de nouvelles photos
    document.addEventListener("newPhotosLoaded", function () {
        updatePhotoData(); // Mettre à jour les données avec les nouvelles photos
        attachLightboxEvents(); // Réattacher les événements de la lightbox
    });

    window.updatePhotoData = updatePhotoData; // Rendre accessible la fonction aux scripts de la page
});



