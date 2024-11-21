document.addEventListener('DOMContentLoaded', () => {
    const contactLink = document.querySelector('.contactlink a');
    const modal = document.getElementById('contact-modal');
    const closeBtn = modal.querySelector('.close-btn');
    const modalOverlay = modal.querySelector('.modal-overlay'); // L'overlay (fond sombre)

    if (contactLink && modal) {
        // Afficher la modale lorsqu'on clique sur le lien
        contactLink.addEventListener('click', (event) => {
            event.preventDefault();
            modal.classList.add('show');
            document.body.classList.add('modal-open'); // Empêche le scroll
        });

        // Fermer la modale lorsqu'on clique sur le bouton de fermeture
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('show');
            document.body.classList.remove('modal-open'); // Réactive le scroll
        });

        // Fermer la modale lorsqu'on clique sur l'overlay (fond sombre)
        modalOverlay.addEventListener('click', () => {
            modal.classList.remove('show');
            document.body.classList.remove('modal-open');
        });
    }
});


