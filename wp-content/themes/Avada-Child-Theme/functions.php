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

function avada_render_blog_post_formats() {
    switch ( get_post_format() ) {
        case 'gallery':
            $format_class = 'images';
            break;
        case 'link':
            $format_class = 'link';
            break;
        case 'image':
            $format_class = 'image';
            break;
        case 'quote':
            $format_class = 'quotes-left';
            break;
        case 'video':
            $format_class = 'film';
            break;
        case 'audio':
            $format_class = 'headphones';
            break;
        case 'chat':
            $format_class = 'bubbles';
            break;
        default:
            $format_class = 'pen';
            break;
    }
    return '<i class="fusion-icon-'.$format_class.'"></i>';
}

add_shortcode( 'display-post-format', 'avada_render_blog_post_formats' );

add_filter('widget_text', 'do_shortcode');

function get_url() {
return get_permalink($post->ID);
}
add_shortcode('GetURL', 'get_url');

require_once( 'includes/avada-functions.php' );
require_once( 'includes/class-fusion-breadcrumbs.php' );

add_filter( 'searchwp_debug', '__return_true' );

function hls_set_query() {
  $query  = attribute_escape(get_search_query());

  if(strlen($query) > 0){
    echo '
      <script type="text/javascript">
        var hls_query  = "'.$query.'";
      </script>
    ';
  }
}

function hls_init_jquery() {
  wp_enqueue_script('jquery');
}

add_action('init', 'hls_init_jquery');
add_action('wp_print_scripts', 'hls_set_query');


/* Embed a widget in a page via a shortcode
 
Usage: [widget_via_shortcode widget_name="your_Widget_Class_Name" widget_option_one="Your value for widget option one" ]
 
*/
function widget_via_shortcode_parser( $atts, $content = null ){
    global $wp_widget_factory;
 
    extract(shortcode_atts(array(
        'widget_name' => FALSE,
        'instance' => ''
    ), $atts));
 
    $widget_name = wp_specialchars($widget_name);
    $instance = str_ireplace("&amp;", '&' ,$instance);
 
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($widget_name));
 
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '
 
'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$widget_name.'</strong>').'
 
';
        else:
            $widget_name = $wp_class;
        endif;
    endif;
 
    ob_start();
    the_widget($widget_name, $instance, null );
    $output .= ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'widget_via_shortcode', 'widget_via_shortcode_parser' );

function adjust_search_query( $args, $class ) {
    if ( $class->is_search && 'post' == $args['post_type'] ) {
        $args['post_type'] = 'any';
    }
    return $args;
}
add_filter( 'facetwp_query_args', 'adjust_search_query', 10, 2 );

function fwp_rename_post( $params, $class ) {
    if ( 'content_type' == $params['facet_name'] && 'post' == $params['facet_value'] ) {
        $params['facet_display_value'] = 'Stories';
    }
    return $params;
}
add_filter( 'facetwp_index_row', 'fwp_rename_post', 10, 2 );

//<!-- Load the slider with "blog-three" alias only on the single post pages only -->
//<?php putRevSlider("blog-three", "single.php") ?>

