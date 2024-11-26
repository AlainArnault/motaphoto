document.addEventListener('DOMContentLoaded', function () {
    const loadMoreButton = document.getElementById('load-more');

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
                        const gallery = document.getElementById('photo-gallery');
                        gallery.insertAdjacentHTML('beforeend', data.data.html);

                        // Mettre à jour la pagination
                        loadMoreButton.dataset.page = data.data.page;

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
});
