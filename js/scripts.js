// Script pour la modale de contact

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



