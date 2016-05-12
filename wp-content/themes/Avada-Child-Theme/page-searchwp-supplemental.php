<?php

/* Template Name: SearchWP Supplemental Search Results */

global $post;

// retrieve our search query if applicable
$query = isset( $_REQUEST['swpquery'] ) ? sanitize_text_field( $_REQUEST['swpquery'] ) : '';

// retrieve our pagination if applicable
$swppg = isset( $_REQUEST['swppg'] ) ? absint( $_REQUEST['swppg'] ) : 1;

if ( class_exists( 'SWP_Query' ) ) {

	$engine = 'faq'; // taken from the SearchWP settings screen

	$swp_query = new SWP_Query(
		// see all args at https://searchwp.com/docs/swp_query/
		array(
			's'      => $query,
			'engine' => $engine,
			'page'   => $swppg,
		)
	);

	// set up pagination
	$pagination = paginate_links( array(
		'format'  => '?swppg=%#%',
		'current' => $swppg,
		'total'   => $swp_query->max_num_pages,
	) );
}

get_header(); ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php if ( ! empty( $query ) ) : ?>
						<?php printf( __( 'Top Results For Your Search: %s', 'twentyfifteen' ), $query ); ?>
					<?php else : ?>
						Top Results For Your Search
					<?php endif; ?>
				</h1>

				<!-- begin search form -->
				<div class="search-box">
					<form role="search" method="get" class="search-form" action="<?php echo esc_html( get_permalink( 2777 ) ); ?>">
						<label>
							<span class="screen-reader-text">Search for:</span>
							<input type="search" class="search-field" placeholder="Search …" value="" name="swpquery" title="Search for:">
						</label>
					</form>
				</div>
				<!-- end search form -->

			</header><!-- .page-header -->

<div style="margin: 10px 15%;padding-top: 30px;"><h3 class="widget-title" style="border-bottom: 4px solid #2E3236;color: #2E3236;font-weight: normal;font-size: 20px;">Top Results For Your Search</h3>

			<?php if ( ! empty( $query ) && isset( $swp_query ) && ! empty( $swp_query->posts ) ) {
				foreach ( $swp_query->posts as $post ) {
					setup_postdata( $post );
					// output the result
get_template_part('hkb-templates/hkb-content', 'article');
//					get_template_part( 'content', 'search' );
//					get_template_part( 'templates/blog', 'layout' );
				}

echo '</div>';
				
				wp_reset_postdata();

				// pagination
				if ( $swp_query->max_num_pages > 1 ) { ?>
					<div class="navigation pagination" role="navigation">
						<h2 class="screen-reader-text">Posts navigation</h2>
						<div class="nav-links">
							<?php echo wp_kses_post( $pagination ); ?>
						</div>
					</div>
				<?php }
			} else {
				get_template_part( 'content', 'none' );
			} ?>

<?php get_footer();