<?php
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

// Créer un Menu personnalisé
function register_top_menu() {
    register_nav_menu( 'main-menu', __( 'Menu principal', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'register_top_menu' );

function register_footer_menu() {
    register_nav_menu( 'footer-menu', __( 'Menu bas de page', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'register_footer_menu' );

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


