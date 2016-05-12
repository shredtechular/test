<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) die( LCSP_HACK_MSG );

/**
 * Registers Shortcode
 */
function lcsp_carousel_shortcode( $atts, $content = null ) {

	ob_start();

		$atts = shortcode_atts(
			array(
				'id' => "",
				), $atts);

	wp_enqueue_style( 'lcsp-owl-carousel-style' );
	wp_enqueue_style( 'lcsp-owl-theme-style' );
	wp_enqueue_style( 'lcsp-owl-transitions' );
	wp_enqueue_style( 'lcsp-tooltipster-style' );
	wp_enqueue_style( 'lcsp-custom-style' );
	wp_enqueue_script( 'lcsp-owl-carousel-js' );
	wp_enqueue_script( 'lcsp-tooltipster-js' );

	$post_id = $atts['id'];
	$lcsp_random_tooltip_id = rand();
	$lcsp_random_carousel_wrapper_id = rand();

	$lcspLogoType = get_post_meta( $post_id, 'lcsp_logo_type', true );
    $lcsp_logos_byid = get_post_meta( $post_id, 'lcsp_logos_byid', true );
    $lcsp_logos_from_year = get_post_meta( $post_id, 'lcsp_logos_from_year', true );
    $lcsp_logos_from_month = get_post_meta( $post_id, 'lcsp_logos_from_month', true );
    $lcsp_logos_from_month_year = get_post_meta( $post_id, 'lcsp_logos_from_month_year', true );
	$lcsp_taxonomy_terms =  get_post_meta( $post_id, 'lcsp_taxonomy_terms', true );
	$lcspSliderTitle = get_post_meta( $post_id, 'lcsp_slider_title', true );
	$lcspDisplayNavArr = get_post_meta( $post_id, 'lcsp_dna', true );
	$lcspNavPosition = get_post_meta( $post_id, 'lcsp_nap', true );
	$lcspLogoTitleDisplay = get_post_meta( $post_id, 'lcsp_dlt', true );
	$lcspLogoBorderDisplay = get_post_meta( $post_id, 'lcsp_dlb', true );
	$lcspLogoHoverEffect = get_post_meta( $post_id, 'lcsp_lhe', true );
	$lcspImageCrop = get_post_meta( $post_id, 'lcsp_ic', true );
	$lcspImageCropWidth = get_post_meta( $post_id, 'lcsp_iwfc', true );
	$lcspImageCropHeight = get_post_meta( $post_id, 'lcsp_ihfc', true );
	$lcspLogoLinkOpenWindow = get_post_meta( $post_id, 'lcsp_llow', true );
	$lcspAutoPlay = get_post_meta( $post_id, 'lcsp_ap', true );
	$lcspAutoPlaySpeed = get_post_meta( $post_id, 'lcsp_aps', true );
	$lcspStopOnHover = get_post_meta( $post_id, 'lcsp_soh', true );
	$lcspDesktopLogoItems = get_post_meta( $post_id, 'lcsp_li_desktop', true );
	$lcspDesktopSmallLogoItems = get_post_meta( $post_id, 'lcsp_li_desktop_small', true );
	$lcspTabletLogoItems = get_post_meta( $post_id, 'lcsp_li_tablet', true );
	$lcspMobileLogoItems = get_post_meta( $post_id, 'lcsp_li_mobile', true );
	$lcspSlideSpeed = get_post_meta( $post_id, 'lcsp_ss', true );
	$lcspScrolling = get_post_meta( $post_id, 'lcsp_spp', true );
	$lcspPagination = get_post_meta( $post_id, 'lcsp_pagination', true );
	$lcspNumbersInPagination = get_post_meta( $post_id, 'lcsp_nip', true );
	$lcspSliderTitleFontSize = get_post_meta( $post_id, 'lcsp_stfs', true );
	$lcspSliderTitleFontColor = get_post_meta( $post_id, 'lcsp_stfc', true );
	$lcspNavArrBgColor = get_post_meta( $post_id, 'lcsp_nabc', true );
	$lcspNavArrborderColor = get_post_meta( $post_id, 'lcsp_nabdc', true );
	$lcspNavArrColor = get_post_meta( $post_id, 'lcsp_nac', true );
	$lcspNavArrHvBgColor = get_post_meta( $post_id, 'lcsp_nahbc', true );
	$lcspNavArrHvborderColor = get_post_meta( $post_id, 'lcsp_nahbdc', true );
	$lcspNavArrHvColor = get_post_meta( $post_id, 'lcsp_nahc', true );
	$lcspLogoBorderColor = get_post_meta( $post_id, 'lcsp_lbc', true );
	$lcspLogoBorderHoverColor = get_post_meta( $post_id, 'lcsp_lbhc', true );
	$lcspLogoTitleFontSize = get_post_meta( $post_id, 'lcsp_ltfs', true );
	$lcspLogoTitleFontColor = get_post_meta( $post_id, 'lcsp_ltfc', true );
	$lcspLogoTitleFontHoverColor = get_post_meta( $post_id, 'lcsp_ltfhc', true );
	$lcspTooltipBgColor = get_post_meta( $post_id, 'lcsp_tbc', true );
	$lcspTooltipFontColor = get_post_meta( $post_id, 'lcsp_tfc', true );
	$lcspTooltipFontSize = get_post_meta( $post_id, 'lcsp_tfs', true );
	$lcspPaginationColor = get_post_meta( $post_id, 'lcsp_pc', true );


	$common_args = array(
		'post_type'      => 'logocarouselpro',
		'posts_per_page' => -1,
	);

	if ($lcspLogoType == "latest") {
		$args = $common_args;
	}

	elseif ($lcspLogoType == "category") {
		$category_args = array(
			'tax_query' => array(
					array(
		               'taxonomy' => 'lcsp_category',
		               'field' => 'term_id',
		               'terms' => $lcsp_taxonomy_terms
					)
				)
			);
		$args = array_merge($common_args, $category_args);
	}

	elseif ($lcspLogoType == "older") {
		$older_args = array(
			'orderby'     => 'date',
			'order'       => 'ASC'
			);
		$args = array_merge($common_args, $older_args);
	}

	elseif ($lcspLogoType == "logosbyid") {
		$logosbyid_args = array( 
			'post__in' => ($lcsp_logos_byid ? explode(',', $lcsp_logos_byid) : null)
			);
		$args = array_merge($common_args, $logosbyid_args);
	}

	elseif ($lcspLogoType == "logosbyyear") {
		$logosbyyear_args = array( 
			'year' => $lcsp_logos_from_year 
			);
		$args = array_merge($common_args, $logosbyyear_args);
	}

	elseif ($lcspLogoType == "logosbymonth") {
		$logosbymonth_args = array( 
			'monthnum' => $lcsp_logos_from_month,
			'year' 	   => $lcsp_logos_from_month_year 
			);
		$args = array_merge($common_args, $logosbymonth_args);
	}

	else {
		 $args = $common_args;
	}

	$loop = new WP_Query( $args );
	if ( $loop->have_posts() ): ?>

	<style type="text/css">
		<?php if ($lcspNavPosition == 'topRight') {?>
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider .owl-buttons { position: absolute; right: 0; top: -34px; } 
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider .owl-buttons div { background: <?php echo $lcspNavArrBgColor; ?>; border-radius: 2px; margin: 2px; padding: 0; width: 27px; height: 27px; line-height: 20px; font-size: 22px; opacity: 1; color: <?php echo $lcspNavArrColor; ?>; border: 1px solid <?php echo $lcspNavArrborderColor; ?>; z-index: 999; -moz-transition: all 0.3s linear; -o-transition: all 0.3s linear; -webkit-transition: all 0.3s linear; transition: all 0.3s linear; }
		<?php } else { ?>
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider .owl-buttons .owl-next { position: absolute; top: 25%; right: -7px; -moz-transition: all 0.5s linear; -o-transition: all 0.5s linear; -webkit-transition: all 0.5s linear; transition: all 0.5s linear; } 
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider .owl-buttons .owl-prev { position: absolute; top: 25%; left: -7px; -moz-transition: all 0.5s linear; -o-transition: all 0.5s linear; -webkit-transition: all 0.5s linear; transition: all 0.5s linear; } 
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider .owl-buttons div { background: <?php echo $lcspNavArrBgColor; ?>; border-radius: 2px; margin: 2px; padding: 0; width: 27px; height: 27px; line-height: 20px; font-size: 22px; color: <?php echo $lcspNavArrColor; ?>; border: 1px solid <?php echo $lcspNavArrborderColor; ?>; opacity: 0; z-index: 999; -moz-transition: all 0.3s linear; -o-transition: all 0.3s linear; -webkit-transition: all 0.3s linear; transition: all 0.3s linear; }
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> .owl-theme .owl-controls { margin-top: 6px; }
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider:hover .owl-prev,  #lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider:hover .owl-next { opacity: 1; }
		<?php } ?>
		<?php if ($lcspLogoBorderDisplay == 'yes') {?>
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> .lcsp_logo_container a.lcsp_logo_link { border: 1px solid <?php echo $lcspLogoBorderColor; ?>; }
		<?php } ?>
		<?php if ($lcspLogoHoverEffect == 'yes') {?>
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> .lcsp_logo_container a.lcsp_logo_link:hover { border: 1px solid <?php echo $lcspLogoBorderHoverColor; ?>; }
			#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> .lcsp_logo_container a:hover img { -moz-transform: scale(1.05,1.05); -webkit-transform: scale(1.05,1.05); -o-transform: scale(1.05,1.05); -ms-transform: scale(1.05,1.05); transform: scale(1.05,1.05); }
		<?php } ?>
		#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider .owl-buttons div:hover { background: <?php echo $lcspNavArrHvBgColor; ?>; color: <?php echo $lcspNavArrHvColor; ?>; border: 1px solid <?php echo $lcspNavArrHvborderColor; ?>; }
		#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> h2.lcsp_logo_carousel_slider_title { font-size: <?php echo $lcspSliderTitleFontSize; ?>; color: <?php echo $lcspSliderTitleFontColor; ?>; }
		#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> h3.lcsp_logo_title { font-size: <?php echo $lcspLogoTitleFontSize; ?>!important; color: <?php echo $lcspLogoTitleFontColor; ?>!important; }
		#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> h3.lcsp_logo_title:hover { color: <?php echo $lcspLogoTitleFontHoverColor; ?>!important; }
		.tooltipster-lcsp-<?php echo $lcsp_random_tooltip_id; ?> { border-radius: 3px; color: <?php echo $lcspTooltipFontColor; ?>!important; background-color: <?php echo $lcspTooltipBgColor; ?>!important; }
		.tooltipster-lcsp-<?php echo $lcsp_random_tooltip_id; ?> .tooltipster-content { font-family: Arial, sans-serif; font-size: 14px; line-height: 16px; padding: 8px 12px; font-size: <?php echo $lcspTooltipFontSize; ?>!important; }
		#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider .owl-controls .owl-page span { background: <?php echo $lcspPaginationColor; ?>!important; }
		#lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?> #lcsp_logo_carousel_slider .owl-controls .owl-page span.owl-numbers { background: <?php echo $lcspPaginationColor; ?>!important; }
	</style>

	<div id="lcsp_wrapper_<?php echo $lcsp_random_carousel_wrapper_id; ?>">

		<?php if(!empty($lcspSliderTitle)) { ?>
			<h2 class="lcsp_logo_carousel_slider_title"><?php echo $lcspSliderTitle; ?></h2>
		<?php } ?>

		<div id="lcsp_logo_carousel_slider" class="owl-carousel lcsp_logo_carousel_slider_<?php echo $lcsp_random_carousel_wrapper_id; ?>">
		    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
		        <?php 
		        $post_id = get_the_ID();
		        $lcsp_tooltip_text = get_post_meta( $post_id, 'lcsp_tooltip_text', true );
		        $lcsp_logo_link = get_post_meta( $post_id, 'lcsp_logo_link', true );

				$lcsp_logo_id = get_post_thumbnail_id();
				$lcsp_logo_url = wp_get_attachment_image_src($lcsp_logo_id,'full',true);
				$lcsp_logo_mata = get_post_meta($lcsp_logo_id,'_wp_attachment_image_alt',true);
				$lcsp_logo = aq_resize( $lcsp_logo_url[0], $lcspImageCropWidth, $lcspImageCropHeight, true );
		    	?>
	        	<div class="lcsp_logo_container">
	        	  <?php if(!empty($lcsp_logo_link)) { ?>
		            <a href="<?php echo $lcsp_logo_link; ?>" class="lcsp_logo_link" target="<?php echo $lcspLogoLinkOpenWindow; ?>">
		            	<?php 
		            	if ( $lcspImageCrop == "yes" ) {
		            		echo '<img src="'.$lcsp_logo.'" alt="'. $lcsp_logo_mata . '" class="lcsp_tooltip_'.$lcsp_random_tooltip_id.'"' . ( $lcsp_tooltip_text ? 'title="'. $lcsp_tooltip_text .'"' : "" ).'  />'; 
						} else {
							echo '<img src="'.$lcsp_logo_url[0].'" alt="'. $lcsp_logo_mata . '" class="lcsp_tooltip_'.$lcsp_random_tooltip_id.'"' . ( $lcsp_tooltip_text ? 'title="'. $lcsp_tooltip_text .'"' : "" ).'  />';
						}
		            	?>
		            </a>
		          <?php } else { ?>
		            <a class="lcsp_logo_link not_active">
		            	<?php 
		            	if ( $lcspImageCrop == "yes" ) {
		            		echo '<img src="'.$lcsp_logo.'" alt="'. $lcsp_logo_mata . '" class="lcsp_tooltip_'.$lcsp_random_tooltip_id.'"' . ( $lcsp_tooltip_text ? 'title="'. $lcsp_tooltip_text .'"' : "" ).'  />'; 
						} else {
							echo '<img src="'.$lcsp_logo_url[0].'" alt="'. $lcsp_logo_mata . '" class="lcsp_tooltip_'.$lcsp_random_tooltip_id.'"' . ( $lcsp_tooltip_text ? 'title="'. $lcsp_tooltip_text .'"' : "" ).'  />';
						}
		            	?>
		            </a>
		          <?php } ?>
		          <?php if( $lcspLogoTitleDisplay == "yes" ) { ?>
			          <?php if(!empty($lcsp_logo_link)) { ?>
			            	<a href="<?php echo $lcsp_logo_link; ?>" target="<?php echo $lcspLogoLinkOpenWindow; ?>"><h3 class="lcsp_logo_title"><?php echo get_the_title() ?></h3></a>
			          <?php } else { ?>
			           	    <h3 class="lcsp_logo_title"><?php echo get_the_title() ?></h3>
					  <?php } ?>
		          <?php } ?>
	            </div> 	            
		    <?php endwhile; wp_reset_postdata(); ?>
		    <?php else: 
			_e('No logos found', 'logo-carousel-slider-pro');
		    endif; ?>
		</div> <!-- End lcsp_logo_carousel_slider -->
	</div> <!-- End lcsp_wrapper -->


	<?php 
	$lcsp_rtl_direction = '';
	if ( is_rtl() ) {
		$lcsp_rtl_direction = "direction:'rtl'";
	}

	$lcspAutoPlayRun = ($lcspAutoPlay == "yes") ? $lcspAutoPlaySpeed : "false";

	echo '<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery(".lcsp_logo_carousel_slider_'.$lcsp_random_carousel_wrapper_id.'").owlCarousel({
				autoPlay: '.$lcspAutoPlayRun.', 
				items : '.$lcspDesktopLogoItems.',
				itemsDesktop: [1199,'.$lcspDesktopSmallLogoItems.'],
				itemsTablet : [768,'.$lcspTabletLogoItems.'],
				itemsMobile : [479,'.$lcspMobileLogoItems.'],
				slideSpeed : '.$lcspSlideSpeed.',				
				stopOnHover : '.$lcspStopOnHover.',
				pagination : '.$lcspPagination.',
				paginationNumbers: '.$lcspNumbersInPagination.',
				scrollPerPage: '.$lcspScrolling.',
				navigation : '.$lcspDisplayNavArr.',
				navigationText : ["‹","›"],		
				'.$lcsp_rtl_direction.'
		  });
		  jQuery(".lcsp_tooltip_'.$lcsp_random_tooltip_id.'").tooltipster({
			   theme: "tooltipster-lcsp-'.$lcsp_random_tooltip_id.'",
			   animation: "grow",
			   delay: 200,
			   trigger: "hover"
		  });
		});
	</script>';
$carousel_content = ob_get_clean();
return $carousel_content;
}

add_shortcode("logo_carousel_slider_pro", "lcsp_carousel_shortcode");

