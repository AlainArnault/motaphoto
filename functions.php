<?php
//Balises Select
function enqueue_select2_assets() {
    // Ajouter le CSS de Select2
    wp_enqueue_style('select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css');

    // Ajouter le JS de Select2
    wp_enqueue_script('select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js', array('jquery'), null, true);

    // Ajouter le script personnalisé
    wp_enqueue_script('custom-select2', get_template_directory_uri() . '/js/filter.js', array('jquery', 'select2-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_select2_assets');

// Ajouter le feuille de Style
function motaphoto_enqueue_styles() {
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri());
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' );
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_styles');

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

// Ajouter les Polices en local
function enqueue_custom_fonts() {
    wp_enqueue_style( 'custom-fonts', get_template_directory_uri() . '/assets/css/fonts.css', [], null );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_fonts' );

// Créer de menus personnalisés
function register_top_menu() {
    register_nav_menu( 'main-menu', __( 'Menu principal', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'register_top_menu' );

function register_footer_menu() {
    register_nav_menu( 'footer-menu', __( 'Menu bas de page', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'register_footer_menu' );

//Script menu burger
function enqueue_menu_script() {
    wp_enqueue_script('menu-toggle', get_template_directory_uri() . '/js/menu-toggle.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_menu_script');



// Ajouter le js de la modale
function ajouter_scripts_modale() {
    wp_enqueue_script(
        'contact-modal-script',
        get_template_directory_uri() . '/js/scripts.js',
        array('jquery'),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'ajouter_scripts_modale');


// Ajout script lightbox
// Charger les scripts et styles nécessaires
function enqueue_lightbox_scripts_with_wp_api() {
    // Charger le script WordPress wp-api
    wp_enqueue_script('wp-api');

    // Charger le script de la lightbox
    wp_enqueue_script(
        'lightbox-js',
        get_template_directory_uri() . '/js/lightbox.js',
        array('jquery'),
        null,
        true
    );

    

}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_scripts_with_wp_api');


// Fonction pour charger plus de photos (bouton et pagination infinie) 
function load_more_photos() {
    // Vérification du nonce pour la sécurité
    check_ajax_referer('load_more_nonce', 'nonce');

    // Récupérer la page demandée
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Définir les arguments de la requête
    $args_load_more = array(
        'post_type' => 'photos',
        'posts_per_page' => 8, // Nombre de photos à charger
        'paged' => $page,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query_load_more = new WP_Query($args_load_more);

    if ($query_load_more->have_posts()) {
        ob_start(); // Commence la capture de la sortie HTML

        while ($query_load_more->have_posts()) {
            $query_load_more->the_post();

            // Inclure le template part pour chaque photo
            get_template_part('template-parts/photo_block');
        }

        $html = ob_get_clean(); // Récupère le HTML généré

        wp_send_json_success(array(
            'html' => $html,
            'page' => $page + 1, // Prépare la page suivante
        ));
    } else {
        wp_send_json_error(); // Si pas de contenu à charger
    }

    wp_die(); // Fin du script pour éviter tout autre contenu
}

// Ajout des hooks pour le callback AJAX
add_action('wp_ajax_load_more_photos', 'load_more_photos'); 
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos'); // Pour les utilisateurs non connectés


// Enregistrement du script JS pour charger plus de photos
function enqueue_load_more_script() {
    wp_enqueue_script(
        'load-more-script',
        get_template_directory_uri() . '/js/load-more.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script('load-more-script', 'loadMore', array(
        'ajax_url' => admin_url('admin-ajax.php'), // URL pour AJAX
        'nonce' => wp_create_nonce('load_more_nonce'), // Génération du nonce
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');



// Filtres et tri
function load_filtered_photos() {
    // Vérification du nonce pour la sécurité
    check_ajax_referer('load_filtered_photos_nonce', 'nonce');

    // Récupérer les paramètres du formulaire
    $category = isset($_POST['category']) ? intval($_POST['category']) : '';
    $format = isset($_POST['format']) ? intval($_POST['format']) : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';

    // Arguments pour WP_Query
    $args_filters = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged' => isset($_POST['page']) ? intval($_POST['page']) : 1,
        'orderby' => 'date',
        'order' => ($date === 'asc') ? 'ASC' : 'DESC',
    );

    if ($category) {
        $args_filters['tax_query'][] = array(
            'taxonomy' => 'categories', // Mise à jour avec la bonne taxonomie
            'field' => 'id',
            'terms' => $category,
            'operator' => 'IN',
        );
    }

    if ($format) {
        $args_filters['tax_query'][] = array(
            'taxonomy' => 'format', // Pas de changement ici si c'est correct
            'field' => 'id',
            'terms' => $format,
            'operator' => 'IN',
        );
    }

    // Exécution de la requête
    $query_filters = new WP_Query($args_filters);

    if ($query_filters->have_posts()) {
        ob_start();
        while ($query_filters->have_posts()) {
            $query_filters->the_post();
            get_template_part('template-parts/photo_block');
        }
        $html = ob_get_clean();

        wp_send_json_success(array(
            'html' => $html,
            'page' => isset($_POST['page']) ? $_POST['page'] + 1 : 2, // Préparer la page suivante
        ));
    } else {
        wp_send_json_error();
    }

    wp_die();
}


// Ajouter l'action AJAX
add_action('wp_ajax_load_filtered_photos', 'load_filtered_photos');
add_action('wp_ajax_nopriv_load_filtered_photos', 'load_filtered_photos');

function enqueue_filter_script() {
    wp_enqueue_script(
        'filter-script',
        get_template_directory_uri() . '/js/filter.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script('filter-script', 'filterParams', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_filtered_photos_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_filter_script');




