<?php
/*
Plugin Name: SearchWP Co-Authors Plus Integration
Plugin URI: https://searchwp.com/
Description: Integrate Co-Authors Plus author information with SearchWP
Version: 1.0b1
Author: Jonathan Christopher
Author URI: https://searchwp.com/

Copyright 2016 Jonathan Christopher

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/>.
*/

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SEARCHWP_COAUTHORSPLUS_VERSION' ) ) {
	define( 'SEARCHWP_COAUTHORSPLUS_VERSION', '1.0b1' );
}

/**
 * instantiate the updater
 */
if ( ! class_exists( 'SWP_CoAuthorsPlus_Updater' ) ) {
	// load our custom updater
	include_once( dirname( __FILE__ ) . '/vendor/updater.php' );
}

// set up the updater
function searchwp_coauthorsplus_update_check() {

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return false;
	}

	// environment check
	if ( ! defined( 'SEARCHWP_PREFIX' ) ) {
		return false;
	}

	if ( ! defined( 'SEARCHWP_EDD_STORE_URL' ) ) {
		return false;
	}

	if ( ! defined( 'SEARCHWP_COAUTHORSPLUS_VERSION' ) ) {
		return false;
	}

	// retrieve stored license key
	$license_key = trim( get_option( SEARCHWP_PREFIX . 'license_key' ) );
	$license_key = sanitize_text_field( $license_key );

	// instantiate the updater to prep the environment
	$searchwp_boolean_updater = new SWP_CoAuthorsPlus_Updater( SEARCHWP_EDD_STORE_URL, __FILE__, array(
			'item_id' 	=> 54834,
			'version'   => SEARCHWP_COAUTHORSPLUS_VERSION,
			'license'   => $license_key,
			'item_name' => 'Co-Authors Plus Integration',
			'author'    => 'Jonathan Christopher',
			'url'       => site_url(),
		)
	);

	return $searchwp_boolean_updater;
}

add_action( 'admin_init', 'searchwp_coauthorsplus_update_check' );

class SearchWPCoAuthorsPlus {

	private $fields = array();

	function __construct() {
		// Define which Author fields to index
		$this->fields = apply_filters( 'searchwp_coauthorsplus_author_fields', array(
			'user_nicename',
			'display_name',
			'nickname',
			'first_name',
			'last_name',
			'description',
		) );

		$this->fields = array_map( 'sanitize_key', $this->fields );

		add_filter( 'searchwp_extra_metadata', array( $this, 'retrieve_coauthor_metadata' ), 10, 2 );
		add_filter( 'searchwp_custom_field_keys', array( $this, 'searchwp_custom_field_keys' ), 10, 2 );
	}

	function get_fields() {
		// we always want to support 'any'
		$fields = array_merge( array( 'any' ), $this->fields );

		return array_unique( $fields );
	}

	function retrieve_coauthor_metadata( $extra_meta, $post_being_indexed ) {
		if ( ! function_exists( 'get_coauthors' ) ) {
			return $extra_meta;
		}

		// retrieve a list of author IDs
		$coauthors = get_coauthors( $post_being_indexed->ID );

		$coauthors = wp_list_pluck( $coauthors, 'ID' );

		if ( empty( $coauthors ) ) {
			$coauthors = array( $post_being_indexed->post_author );
		}

		$coauthors = array_map( 'absint', $coauthors );

		$extra_meta[ 'coauthorsplus_any' ] = array();

		foreach ( $coauthors as $coauthor ) {

			// break out meta per field
			foreach ( $this->get_fields() as $field ) {

				if ( ! is_array( $extra_meta[ 'coauthorsplus_' . $field ] ) ) {
					$extra_meta[ 'coauthorsplus_' . $field ] = array();
				}

				$extra_meta[ 'coauthorsplus_' . $field ][] = get_the_author_meta( $field, $coauthor );

				// the 'any' field is internal
				if ( 'any' !== $field ) {
					$extra_meta[ 'coauthorsplus_any' ][] = get_the_author_meta( $field, $coauthor );
				}
			}

		}

		return $extra_meta;
	}

	function searchwp_custom_field_keys( $keys ) {

		foreach ( $this->get_fields() as $field ) {
			$keys[] = 'coauthorsplus_' . $field;
		}

		return array_unique( $keys );

	}

}

new SearchWPCoAuthorsPlus();
