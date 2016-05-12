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

<div id="content" class="fusion-faqs width-100" <?php Avada()->layout->add_style( 'content_style' ); ?>>

	<?php
	// Get the content of the faq page itself
	while ( have_posts() ): the_post();

		ob_start();
		post_class();
		$post_classes = ob_get_clean();

		echo sprintf( '<div id="post-%s" %s>', get_the_ID(), $post_classes );
			// Get rich snippets of the faq page
			echo avada_render_rich_snippets_for_pages();

			// Get featured images of the faq page
			echo avada_featured_images_for_pages();

			// Render the content of the faq page
			echo '<div class="post-content">';
				the_content();
				avada_link_pages();
			echo '</div>';
		echo '</div>';
	endwhile;
?>


<div style="margin: 0px 15%;">


	<h3 class="widget-title" style="border-bottom: 4px solid #233e94;color:#233e94;font-weight: normal;font-size: 20px;padding-top: 40px;">
		<?php if ( ! empty( $query ) ) : ?>
						<?php printf( __( 'Top Results For Your Search: %s', 'twentyfifteen' ), $query ); ?>
					<?php else : ?>
						Top Results For Your Search
					<?php endif; ?>
	</h3>

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
				echo "<div style='padding-bottom:50px'><strong>No items found</strong></div>";
			} ?>

</div>

<?php get_footer();

