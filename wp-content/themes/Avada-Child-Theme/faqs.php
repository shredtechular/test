<?php
// Template Name: FAQs

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

			<?php if ( ! empty( $query ) && isset( $swp_query ) && ! empty( $swp_query->posts ) ) {
				echo '<div style="margin: 10px 15%;padding-top: 30px;"><h3 class="widget-title" style="border-bottom: 4px solid #2E3236;color: #2E3236;font-weight: normal;font-size: 20px;">Top Results For Your Search</h3>';
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

<div class="ht-page ht-page--bggrey" style="padding-top: 60px;">

	<!-- .ht-page__container -->
	<div class="ht-page__container" id="faqs-home-page">

	<!-- .ht-page__content -->
	<main class="ht-page__content" role="main" itemtype="http://schema.org/Blog" itemscope="itemscope" itemprop="mainContentOfPage">

	<!-- #ht-kb -->
	<div id="hkb" class="hkb-template-archive">

<!-- .hkb-archive -->
<ul class="hkb-archive hkb-archive--three-cols clearfix">

<?php
		// Get faq terms
		$faq_terms = get_terms( 'faq_category' );

				// Check if the "All" filter should be displayed
//				if ( Avada()->settings->get( 'faq_filters' ) == 'yes' ) {
//					echo sprintf( '<li class="fusion-filter fusion-filter-all fusion-active"><a data-filter="*" href="#">%s</a></li>', apply_filters( 'avada_faq_all_filter_name', __( 'All', 'Avada' ) ) );
//					$first_filter = FALSE;
//				} else {
//					$first_filter = TRUE;
//				}

				// Loop through the terms to setup all filters
				foreach ( $faq_terms as $faq_term ) {

echo sprintf( '<li class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes"><div class="hkb-category"><div class="hkb-category__header" style="border-bottom: 1px solid #fff;padding-bottom: 10px;"><h2 class="hkb-category__title"><a href="/faq_category/%s" title="View all posts in Pre-sales Questions">%s</a></h2></div>', urldecode( $faq_term->slug ), $faq_term->name );
echo sprintf('<ul class="hkb-article-list">');

					// If the "All" filter is disabled, set the first real filter as active
//					if ( $first_filter ) {
//						echo sprintf( '<li class="fusion-filter fusion-active"><a data-filter=".%s" href="#">%s</a></li>', urldecode( $faq_term->slug ), $faq_term->name );

//						$first_filter = FALSE;
//					} else {
//						echo sprintf( '<li class="fusion-filter fusion-hidden"><a data-filter=".%s" href="#">%s</a></li>', urldecode( $faq_term->slug ), $faq_term->name );
//					}


					$args = array(
						'post_type' => 'avada_faq',
						'posts_per_page' => 5,
				    'tax_query' => array(
				        array(
				            'taxonomy' => 'faq_category', // Could be "faq_category_1" or a custom taxonomy
				            'terms' => $faq_term->name,
				            'field' => 'slug'
				        )
				     )
					);
					$faq_items = new WP_Query( $args );
					$count = 0;
					while ( $faq_items->have_posts() ): $faq_items->the_post();

					  if ($count < 2 ) {
							$count++;

							//Get all terms of the post and it as classes; needed for filtering
							$post_classes = '';
							$post_terms = get_the_terms( $post->ID, 'faq_category' );
							if ( $post_terms ) {
								foreach ( $post_terms as $post_term ) {
									$post_classes .= urldecode( $post_term->slug ) . ' ';
								}
							}
							?>

	            <li class="hkb-article-list__format-standard">
	                <a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title(); ?></a>
	            </li>



					<?php 
						}
					endwhile; // loop through faq_items ?>

			</ul>

			<?php echo sprintf('<a class="hkb-category__view-all" href="/faq_category/%s">View all</a>', urldecode( $faq_term->slug ) ); ?>

		</li>

	<?php
	} // password check
echo '</div>';
wp_reset_query();
do_action( 'fusion_after_content' );
?>

</ul>
</div>
</main>
</div>
</div>




<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.
