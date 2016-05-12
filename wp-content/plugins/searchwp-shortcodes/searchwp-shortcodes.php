<?php
/*
Plugin Name: SearchWP Shortcodes
Plugin URI: https://searchwp.com/
Description: Provides Shortcodes that generate both search forms and results pages for SearchWP search engines
Version: 1.5.3
Author: Jonathan Christopher
Author URI: https://searchwp.com/

Copyright 2014-2016 Jonathan Christopher

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

if ( ! defined( 'SEARCHWP_SHORTCODES_VERSION' ) ) {
	define( 'SEARCHWP_SHORTCODES_VERSION', '1.5.3' );
}

/**
 * instantiate the updater
 */
if ( ! class_exists( 'SWP_Shortcodes_Updater' ) ) {
	// load our custom updater
	include_once( dirname( __FILE__ ) . '/vendor/updater.php' );
}

// set up the updater
function searchwp_shortcodes_update_check(){

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

	if ( ! defined( 'SEARCHWP_SHORTCODES_VERSION' ) ) {
		return false;
	}

	// retrieve stored license key
	$license_key = trim( get_option( SEARCHWP_PREFIX . 'license_key' ) );
	$license_key = sanitize_text_field( $license_key );

	// instantiate the updater to prep the environment
	$searchwp_shortcodes_updater = new SWP_Shortcodes_Updater( SEARCHWP_EDD_STORE_URL, __FILE__, array(
			'item_id' 	=> 33253,
			'version'   => SEARCHWP_SHORTCODES_VERSION,
			'license'   => $license_key,
			'item_name' => 'Shortcodes',
			'author'    => 'Jonathan Christopher',
			'url'       => site_url(),
		)
	);

	return $searchwp_shortcodes_updater;
}

add_action( 'admin_init', 'searchwp_shortcodes_update_check' );

class SearchWP_Shortcodes {

	public $query   = '';
	public $page    = 1;
	public $results = array();
	public $engine  = 'default';

	function __construct() {
		$this->page     = isset( $_REQUEST['swppg'] ) ? absint( $_REQUEST['swppg'] ) : 1;

		add_shortcode( 'searchwp_search_form',                      array( $this, 'search_form_output' ) );
		add_shortcode( 'searchwp_search_results_pagination',        array( $this, 'search_results_pagination_output' ) );
		add_shortcode( 'searchwp_search_results_paginate_links',    array( $this, 'search_results_paginate_links' ) );
		add_shortcode( 'searchwp_search_results_none',              array( $this, 'search_results_none_output' ) );
		add_shortcode( 'searchwp_search_results',                   array( $this, 'search_results_output' ) );
		add_shortcode( 'searchwp_search_result_link',               array( $this, 'search_result_link_output' ) );
		add_shortcode( 'searchwp_search_result_excerpt',            array( $this, 'search_result_excerpt_output' ) );
		add_shortcode( 'searchwp_search_result_excerpt_global',     array( $this, 'search_result_excerpt_global_output' ) );
		add_shortcode( 'searchwp_search_result_excerpt_document',   array( $this, 'search_result_excerpt_document_output' ) );
	}

	function maybe_set_search_query( $var = 'swpquery' ) {
		if ( empty( $this->query ) ) {
			$var = sanitize_text_field( $var );
			$this->query = isset( $_REQUEST[ $var ] ) ? sanitize_text_field( $_REQUEST[ $var ] ) : '';
		}
	}

	function search_form_output( $atts ) {
		extract( shortcode_atts( array(
			'target'        => '',
			'engine'        => 'default',
			'var'           => 'swpquery',
			'placeholder'   => 'placeholder',
			'button_text'   => __( 'Search' )
		), $atts ) );

		/** @noinspection PhpUndefinedVariableInspection */
		$engine         = esc_attr( $engine );
		/** @noinspection PhpUndefinedVariableInspection */
		$var            = esc_attr( $var );
		/** @noinspection PhpUndefinedVariableInspection */
		$button_text    = esc_attr( $button_text );
		/** @noinspection PhpUndefinedVariableInspection */
		$target         = esc_url( $target );

		$this->maybe_set_search_query( $var );
		$query = esc_attr( $this->query );

		// allow developers to filter the engine at runtime
		$engine = apply_filters( 'searchwp_shortcodes_engine', $engine );

		ob_start(); ?>
		<?php do_action( 'searchwp_shortcodes_before_wrapper' ); ?>
		<div class="searchwp-search-form searchwp-supplemental-search-form">
			<?php do_action( 'searchwp_shortcodes_before_form' ); ?>
			<form role="search" method="get" id="searchform" class="searchform seach-form" action="<?php echo esc_url( $target ); ?>">
				<div class="search-table">
					<div class="search-field">
						<?php do_action( 'searchwp_shortcodes_before_label' ); ?>
						<label class="screen-reader-text" for="swpquery"><?php _e( 'Search for:' ); ?></label>
						<?php do_action( 'searchwp_shortcodes_after_label' ); ?>
						<?php do_action( 'searchwp_shortcodes_before_input' ); ?>
						<!--suppress HtmlFormInputWithoutLabel -->
						<input type="text" value="<?php echo esc_attr( $query ); ?>" name="<?php echo esc_attr( $var ); ?>" id="<?php echo esc_attr( $var ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" style="height:40px;font-size:18px;font-family:'Open Sans', Arial, Helvetica, sans-serif;font-weight:400">
						<?php do_action( 'searchwp_shortcodes_after_input' ); ?>
						<input type="hidden" name="engine" value="<?php echo esc_attr( $engine ); ?>" style="font-size: 15px;letter-spacing: 1px;font-family: 'Open Sans', Arial, Helvetica, sans-serif;"/>
						<?php do_action( 'searchwp_shortcodes_before_button' ); ?>
	<!--					<input type="submit" id="searchsubmit" value="<?php echo esc_attr( $button_text ); ?>"> -->
					</div>
				  <div class="search-button">
						<input type="submit" class="searchsubmit" value="&#xf002;" style="font-size: 18px;height: 40px;width: 40px;" />
					</div>
					<?php do_action( 'searchwp_shortcodes_after_button' ); ?>
				</div>
			</form>
			<?php do_action( 'searchwp_shortcodes_after_form' ); ?>
		</div>
		<?php do_action( 'searchwp_shortcodes_after_wrapper' ); ?>
		<?php return ob_get_clean();
	}

	function search_results_output( $atts, $content = null ) {
		global $post, $searchwp, $searchwp_shortcodes_posts_per_page;

		extract( shortcode_atts( array(
			'engine'            => 'default',
			'posts_per_page'    => 10,
			'var'               => 'swpquery',
		), $atts ) );

		/** @noinspection PhpUndefinedVariableInspection */
		$searchwp_shortcodes_posts_per_page = absint( $posts_per_page );

		/** @noinspection PhpUndefinedVariableInspection */
		$this->maybe_set_search_query( $var );
		$query = esc_attr( $this->query );

		// allow developers to filter the engine at runtime
		$engine = apply_filters( 'searchwp_shortcodes_engine', $engine );

		if ( class_exists( 'SearchWP' ) ) {
			/** @noinspection PhpUndefinedVariableInspection */
			$supplementalSearchEngineName = sanitize_text_field( $engine );

			// set up custom posts per page
			function searchwp_shortcodes_posts_per_page() {
				global $searchwp_shortcodes_posts_per_page;

				return absint( $searchwp_shortcodes_posts_per_page );
			}
			add_filter( 'searchwp_posts_per_page', 'searchwp_shortcodes_posts_per_page' );

			// perform the search
			$this->results = $searchwp->search( $supplementalSearchEngineName, $query, $this->page );
		}

		ob_start();
		if ( ! empty( $query ) && ! empty( $this->results ) ) {
			foreach ( $this->results as $post ) {
				setup_postdata( $post );
				echo do_shortcode( $content );
			}
			wp_reset_postdata();
		}
		return ob_get_clean();
	}

	function search_result_link_output( $atts ) {
		global $post;

		extract( shortcode_atts( array(
			'direct' => 'true',
		), $atts ) );

		/** @noinspection PhpUndefinedVariableInspection */
		$direct = 'true' != strtolower( (string) $direct ) ? false : true;

		if ( $direct && isset( $post->post_type ) && 'attachment' == $post->post_type ) {
			$permalink = wp_get_attachment_url( $post->ID );
		} else {
			$permalink = get_permalink();
		}

		ob_start();
		echo '<a href="' . esc_url( $permalink ) . '">' . wp_kses_post( get_the_title() ) . '</a>';

		return ob_get_clean();
	}

	function search_result_excerpt_output() {
		/** @noinspection PhpUnusedLocalVariableInspection */
		global $post;

		ob_start();
		the_excerpt();
		return ob_get_clean();
	}

	function search_result_excerpt_global_output() {
		/** @noinspection PhpUnusedLocalVariableInspection */
		global $post;

		ob_start();
		if ( function_exists( 'searchwp_term_highlight_the_excerpt_global' ) ) {
			searchwp_term_highlight_the_excerpt_global( $post->ID, null, $this->query );
		} else {
			the_excerpt();
		}
		return ob_get_clean();
	}

	function search_result_excerpt_document_output() {
		/** @noinspection PhpUnusedLocalVariableInspection */
		global $post;

		ob_start();
		if ( function_exists( 'searchwp_term_highlight_the_excerpt_global' ) ) {
			searchwp_term_highlight_the_excerpt_global( $post->ID, 'searchwp_content', $this->query );
		} else {
			the_excerpt();
		}
		return ob_get_clean();
	}

	function search_results_none_output( $atts, $content = null ) {

		if ( isset( $atts ) ) {
			$atts = null;
		}

		ob_start();
		if ( ! empty( $this->query ) && empty( $this->results ) && ! empty( $content ) ) {
			echo $content;
		}
		return ob_get_clean();
	}

	function search_results_paginate_links( $atts ) {
		global $searchwp;

		// defaults based on https://codex.wordpress.org/Function_Reference/paginate_links
		$atts = shortcode_atts( array(
			'base'                  => '%_%',
			'format'                => '?swppg=%#%',
			'total'                 => $searchwp->maxNumPages,
			'current'               => $this->page,
			'show_all'              => false,
			'end_size'              => 1,
			'mid_size'              => 2,
			'prev_next'             => true,
			'prev_text'             => __( '« Previous' ),
			'next_text'             => __( 'Next »' ),
			'type'                  => 'plain',
			'add_args'              => false,
			'add_fragment'          => '',
			'before_page_number'    => '',
			'after_page_number'     => '',
			'engine'                => 'default',
			'var'                   => 'swpquery',
			'big'                   => 999999999,
		), $atts );

		/** @noinspection PhpUndefinedVariableInspection */
		$atts['engine'] = apply_filters( 'searchwp_shortcodes_engine', $atts['engine'] );
		/** @noinspection PhpUndefinedVariableInspection */
		$atts['var'] = esc_attr( $atts['var'] );

		$atts = apply_filters( 'searchwp_shortcodes_paginate_links', $atts );

		ob_start(); ?>
		<?php if ( $searchwp->maxNumPages > 1 ) : ?>
			<div class="searchwp-paginate-links">
				<?php echo paginate_links( $atts ); ?>
			</div>
		<?php endif; ?>
		<?php return ob_get_clean();
	}

	function search_results_pagination_output( $atts, $content ) {
		global $searchwp;

		if ( isset( $content ) ) {
			/** @noinspection PhpUnusedLocalVariableInspection */
			$content = '';
		}

		extract( shortcode_atts( array(
			'engine'    => 'default',
			'direction' => 'prev',
			'link_text' => __( 'More' ),
			'var'       => 'swpquery',
		), $atts ) );

		/** @noinspection PhpUndefinedVariableInspection */
		$engine     = esc_attr( $engine );
		/** @noinspection PhpUndefinedVariableInspection */
		$direction  = esc_attr( $direction );
		/** @noinspection PhpUndefinedVariableInspection */
		$link_text  = esc_attr( $link_text );
		/** @noinspection PhpUndefinedVariableInspection */
		$var        = esc_attr( $var );

		// allow developers to filter the engine at runtime
		$engine = apply_filters( 'searchwp_shortcodes_engine', $engine );

		$this->maybe_set_search_query( $var );
		$query = esc_attr( $this->query );

		if ( 'next' != strtolower( $direction ) ) {
			$direction = 'prev';
		}

		$prevPage = $this->page > 1 ? $this->page - 1 : false;
		$nextPage = $this->page < $searchwp->maxNumPages ? $this->page + 1 : false;

		ob_start(); ?>
		<?php if ( $searchwp->maxNumPages > 1 ) : ?>
			<?php if ( 'prev' == strtolower( $direction ) ) : ?>
				<?php if ( $prevPage ) : ?>
					<div class="nav-previous">
						<?php
						$link = get_permalink() . '?' . $var . '=' . urlencode( $query ) . '&swppg=' . absint( $prevPage ) . '&engine=' . esc_attr( $engine );
						$link = apply_filters( 'searchwp_shortcodes_pagination_prev', $link );
						?>
						<a href="<?php echo esc_url( $link ); ?>"><?php echo wp_kses_post( $link_text ); ?></a>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<?php if ( $nextPage ) : ?>
					<div class="nav-next">
						<?php
						$link = get_permalink() . '?' . $var . '=' . urlencode( $query ) . '&swppg=' . absint( $nextPage ) . '&engine=' . esc_attr( $engine );
						$link = apply_filters( 'searchwp_shortcodes_pagination_next', $link );
						?>
						<a href="<?php echo esc_url( $link ); ?>"><?php echo wp_kses_post( $link_text ); ?></a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
		<?php return ob_get_clean();
	}

}

new SearchWP_Shortcodes();
