jQuery(document).ready(function ($) {
    // Fonction commune pour récupérer les filtres et effectuer la requête
    function applyFilters() {
        var category = $('#filter-category').val();
        var format = $('#filter-format').val();
        var date = $('#filter-date').val();
        var page = 1; // Remettre la page à 1 pour chaque changement

        // Envoi de la requête AJAX
        $.ajax({
            url: filterParams.ajax_url,
            method: 'POST',
            data: {
                action: 'load_filtered_photos',
                nonce: filterParams.nonce,
                category: category,
                format: format,
                date: date,
                page: page,
            },
            success: function (response) {
                if (response.success) {
                    // Remplacer le contenu de la galerie par les nouvelles photos
                    $('#photo-gallery').html(response.data.html);
                    $('#load-more').data('page', response.data.page).show(); // Réinitialiser et afficher le bouton
                } else {
                    $('#photo-gallery').html('<p>Aucune photo trouvée.</p>');
                    $('#load-more').hide(); // Masquer le bouton si aucune photo
                }
            },
        });
    }

    // Appliquer les filtres lorsque les champs sont modifiés
    $('#filter-category, #filter-format, #filter-date').on('change', function () {
        applyFilters();
    });

    // Charger plus de photos via AJAX
    $('#load-more').on('click', function () {
        var page = $(this).data('page');
        var category = $('#filter-category').val();
        var format = $('#filter-format').val();
        var date = $('#filter-date').val();

        $.ajax({
            url: filterParams.ajax_url,
            method: 'POST',
            data: {
                action: 'load_filtered_photos',
                nonce: filterParams.nonce,
                category: category,
                format: format,
                date: date,
                page: page,
            },
            success: function (response) {
                if (response.success) {
                    $('#photo-gallery').append(response.data.html); // Ajouter les nouvelles photos
                    $('#load-more').data('page', response.data.page); // Mettre à jour la page
                } else {
                    $('#load-more').hide(); // Masquer le bouton si plus de photos
                }
            },
        });
    });
        // Appliquer Select2 à tous les selects souhaités
        $('#filter-category').select2({
            dropdownCssClass: 'custom-dropdown', // Classe pour personnaliser le dropdown
            placeholder: "Catégories",
            allowClear: true
        });
        $('#filter-format').select2({
            dropdownCssClass: 'custom-dropdown', // Classe pour personnaliser le dropdown
            placeholder: "Format",
            allowClear: true
        });
        $('#filter-date').select2({
            dropdownCssClass: 'custom-dropdown', // Classe pour personnaliser le dropdown
            placeholder: "Trier par",
            allowClear: true
        });
});
