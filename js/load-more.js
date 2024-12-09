document.addEventListener('DOMContentLoaded', function () {
    const loadMoreButton = document.getElementById('load-more');
    const gallery = document.getElementById('photo-gallery');

    // Fonction pour réattacher les événements de la lightbox
    function attachLightboxEvents() {
        const lightboxLinks = document.querySelectorAll('.open-lightbox');
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.querySelector('#lightbox .lightbox-image');
        const lightboxReference = document.querySelector('#lightbox .lightbox-reference');
        const lightboxCategories = document.querySelector('#lightbox .lightbox-categories');

        lightboxLinks.forEach((link) => {
            link.removeEventListener('click', handleLightboxClick); // Évite les doublons
            link.addEventListener('click', handleLightboxClick);
        });

        function handleLightboxClick(event) {
            event.preventDefault();

            const currentPhotoId = this.dataset.photoId;
            const thumbnailUrl = this.dataset.thumbnail;
            const reference = this.dataset.reference;
            const categories = this.dataset.categories;

            lightboxImage.setAttribute('src', thumbnailUrl);
            lightboxImage.setAttribute('alt', reference);
            lightboxReference.textContent = `Référence : ${reference}`;
            lightboxCategories.textContent = `Catégories : ${categories}`;

            lightbox.classList.add('show');
            document.body.classList.add('lightbox-open');
        }

        // Gérer la fermeture de la lightbox
        const closeButtons = document.querySelectorAll('.lightbox-close, .lightbox-overlay');
        closeButtons.forEach((btn) => {
            btn.removeEventListener('click', closeLightbox); // Évite les doublons
            btn.addEventListener('click', closeLightbox);
        });

        function closeLightbox() {
            lightbox.classList.remove('show');
            document.body.classList.remove('lightbox-open');
        }
    }

    // Si le bouton "Charger plus" existe
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function () {
            const page = this.dataset.page;
            const nonce = loadMore.nonce;

            // Désactiver le bouton pendant le chargement
            this.setAttribute('disabled', 'true');
            this.textContent = 'Chargement...';

            // Requête AJAX
            fetch(loadMore.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                },
                body: new URLSearchParams({
                    action: 'load_more_photos',
                    page: page,
                    nonce: nonce,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Ajouter le contenu chargé à la galerie
                        gallery.insertAdjacentHTML('beforeend', data.data.html);

                        // Appeler updatePhotoData directement après l'ajout
                        window.updatePhotoData(); // Met à jour les tableaux allPhotoData et allPhotoIds

                        // Mettre à jour la pagination
                        loadMoreButton.dataset.page = data.data.page;

                        // Réattacher les événements lightbox
                        attachLightboxEvents();

                        // Déclencher un événement personnalisé pour signaler le chargement de nouvelles photos
                        const newPhotosEvent = new Event("newPhotosLoaded");
                        document.dispatchEvent(newPhotosEvent);

                        // Réactiver le bouton
                        this.removeAttribute('disabled');
                        this.textContent = 'Charger plus';
                    } else {
                        // Masquer le bouton si plus de photos
                        this.style.display = 'none';
                    }
                })
                .catch((error) => {
                    console.error('Erreur de chargement :', error);
                });
        });
    }

    // Ajout de la pagination infinie
    let isLoading = false;
    window.addEventListener('scroll', function () {
        if (isLoading) return;

        // Vérifie si on est près du bas de la page
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
            const page = loadMoreButton.dataset.page;
            const nonce = loadMore.nonce;

            // Désactive la pagination infinie jusqu'à ce que le chargement soit terminé
            isLoading = true;

            // Requête AJAX pour charger plus de photos
            fetch(loadMore.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                },
                body: new URLSearchParams({
                    action: 'load_more_photos',
                    page: page,
                    nonce: nonce,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Ajouter le contenu à la galerie
                        gallery.insertAdjacentHTML('beforeend', data.data.html);

                        // Appeler updatePhotoData directement après l'ajout
                        window.updatePhotoData(); // Met à jour les tableaux allPhotoData et allPhotoIds

                        // Mettre à jour la pagination
                        loadMoreButton.dataset.page = data.data.page;

                        // Réattacher les événements lightbox
                        attachLightboxEvents();
                    } else {
                        // Si plus de contenu, désactiver la pagination infinie
                        window.removeEventListener('scroll', arguments.callee);
                    }
                })
                .catch((error) => {
                    console.error('Erreur de chargement :', error);
                })
                .finally(() => {
                    isLoading = false; // Réactive le chargement
                });
        }
    });

    // Appel initial pour activer les événements sur les premières photos
    attachLightboxEvents();
});
