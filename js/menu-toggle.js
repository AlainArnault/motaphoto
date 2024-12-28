document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.querySelector('.menu');
    const menuIcon = document.getElementById('menu-icon');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('active'); // Ajoute ou enlève la classe 'active'

        // Change l'image du bouton burger
        if (menu.classList.contains('active')) {
            menuIcon.src = `${menuIcon.src.replace('burger.png', 'burger_croix.png')}`;
        } else {
            menuIcon.src = `${menuIcon.src.replace('burger_croix.png', 'burger.png')}`;
        }
    });
});




