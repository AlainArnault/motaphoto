document.addEventListener('DOMContentLoaded', function () {
    const loadMoreButton = document.getElementById('load-more');
    const gallery = document.getElementById('photo-gallery');

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

                        // Mettre à jour la pagination
                        loadMoreButton.dataset.page = data.data.page;
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
});
