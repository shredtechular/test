<?php
/*
Plugin Name: Logo Carousel Slider Pro
Plugin URI:  http://adlplugins.com/plugin/logo-carousel-slider-pro
Description: This plugin allows you to easily create logo carousel slider to display logos of clients, partners, sponsors, affiliates etc. in a beautiful carousel slider.
Version:     2.1
Author:      ADL Plugins
Author URI:  http://adlplugins.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages/
Text Domain: logo-carousel-slider-pro
*/

/**
 * Protect direct access
 */
if( ! defined( 'LCSP_HACK_MSG' ) ) define( 'LCSP_HACK_MSG', __( 'Sorry! This is not your place!', 'logo-carousel-slider-pro' ) );
if ( ! defined( 'ABSPATH' ) ) die( LCSP_HACK_MSG );

/**
 * Defining constants
 */
if( ! defined( 'LCSP_PLUGIN_DIR' ) ) define( 'LCSP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if( ! defined( 'LCSP_PLUGIN_URI' ) ) define( 'LCSP_PLUGIN_URI', plugins_url( '', __FILE__ ) );

require_once LCSP_PLUGIN_DIR . 'includes/lcsp-metabox-overrider.php';
require_once LCSP_PLUGIN_DIR . 'includes/lcsp-metabox.php';
require_once LCSP_PLUGIN_DIR . 'includes/lcsp-img-resizer.php';
require_once LCSP_PLUGIN_DIR . 'includes/lcsp-shortcodes.php';

/**
 * Registers scripts and stylesheets
 */
function lcsp_frontend_scripts_and_styles() {
	wp_register_style( 'lcsp-owl-carousel-style', LCSP_PLUGIN_URI . '/css/owl.carousel.css' );
	wp_register_style( 'lcsp-owl-theme-style', LCSP_PLUGIN_URI . '/css/owl.theme.css' );
	wp_register_style( 'lcsp-owl-transitions', LCSP_PLUGIN_URI . '/css/owl.transitions.css' );
	wp_register_style( 'lcsp-custom-style', LCSP_PLUGIN_URI . '/css/lcsp-styles.css' );
	wp_register_style( 'lcsp-tooltipster-style', LCSP_PLUGIN_URI . '/css/tooltipster.css' );
	wp_register_script( 'lcsp-owl-carousel-js', LCSP_PLUGIN_URI . '/js/owl.carousel.js', array('jquery'),'1.3.1', true );
	wp_register_script( 'lcsp-tooltipster-js', LCSP_PLUGIN_URI . '/js/jquery.tooltipster.min.js', array('jquery'),'3.3.0', true );
}
add_action( 'wp_enqueue_scripts', 'lcsp_frontend_scripts_and_styles' );

function lcsp_admin_scripts_and_styles() {
	global $typenow;	
	if ( ($typenow == 'logocarouselpro' || $typenow == 'lcsp_sgenerator') ) {
		wp_enqueue_style( 'lcsp_custom_wp_admin_css', LCSP_PLUGIN_URI . '/css/lcsp-admin-styles.css' );
		wp_enqueue_style( 'lcsp_meta_fields_css', LCSP_PLUGIN_URI . '/css/cmb2.min.css' );
		wp_enqueue_script( 'lcsp_custom_wp_admin_js', LCSP_PLUGIN_URI . '/js/lcsp-admin-script.js', array('jquery'), '', true );
		wp_enqueue_style( 'wp-color-picker' );
	    wp_enqueue_script( 'lcsp-wp-color-picker', LCSP_PLUGIN_URI . '/js/lcsp-color-picker.js', array( 'wp-color-picker' ), false, true );  
	}	
}
add_action( 'admin_enqueue_scripts', 'lcsp_admin_scripts_and_styles' );

/**
 * Enables shortcode for Widget
 */
add_filter('widget_text', 'do_shortcode');

