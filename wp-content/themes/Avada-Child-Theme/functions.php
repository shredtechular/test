<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/style.css' );

    if ( ! is_admin() ) {
		wp_register_script( 'searchScript', get_stylesheet_directory_uri() . '/js/' . 'searchSidebar.js', 'jquery', false );
		wp_enqueue_script( 'searchScript' );
	}

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

function sfws_unique_connection_types_name() {
 p2p_register_connection_type( array(
 'name' => 'author_to_posts', //Give it a name that you can reference
 'from' => 'post', // This can be the slug name of your CPT as well
 'to' => 'multi-author' // This can be the slug name of your CPT as well
 ) );
}
add_action( 'p2p_init', 'sfws_unique_connection_types_name' );

function sfws_p2p_connected_id_shortcode($atts) {
    global $post;
    $connected = get_posts(array(
        'connected_type' => $atts['type'],
        'connected_items' => $post->ID,
	'nopaging' => true,

    ) );
    return implode(',', wp_list_pluck($connected, 'ID'));
}
add_shortcode('wpv-post-p2p-id', 'sfws_p2p_connected_id_shortcode');

add_filter('widget_text', 'do_shortcode');

function get_url() {
return get_permalink($post->ID);
}
add_shortcode('GetURL', 'get_url');

require_once( 'includes/avada-functions.php' );
require_once( 'includes/class-fusion-breadcrumbs.php' );

//<!-- Load the slider with "blog-three" alias only on the single post pages only -->
//<?php putRevSlider("blog-three", "single.php") ?>