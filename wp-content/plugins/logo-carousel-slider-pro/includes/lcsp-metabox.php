<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) die( LCSP_HACK_MSG );

/**
 * Registers logo carousel slider post type.
 */
function lcsp_init() {
    $labels = array(
        'name'               => _x( 'Logos', 'logo-carousel-slider-pro' ),
        'singular_name'      => _x( 'Logo', 'logo-carousel-slider-pro' ),
        'menu_name'          => _x( 'Logo Carousel', 'logo-carousel-slider-pro' ),
        'all_items'          => __( 'All Logos', 'logo-carousel-slider-pro' ),
        'add_new'            => _x( 'Add New Logo', 'logo-carousel-slider-pro' ),
        'add_new_item'       => __( 'Add New Logo', 'logo-carousel-slider-pro' ),
        'new_item'           => __( 'New Logo', 'logo-carousel-slider-pro' ),
        'edit_item'          => __( 'Edit Logo', 'logo-carousel-slider-pro' ),
        'view_item'          => __( 'View Logo', 'logo-carousel-slider-pro' ),
        'name_admin_bar'     => __( 'Logo Carousel Slider', 'logo-carousel-slider-pro' ),
        'search_items'       => __( 'Search Logo', 'logo-carousel-slider-pro' ),
        'parent_item_colon'  => __( 'Parent Logos:', 'logo-carousel-slider-pro' ),
        'not_found'          => __( 'No Logo found.', 'logo-carousel-slider-pro' ),
        'not_found_in_trash' => __( 'No Logo found in Trash.', 'logo-carousel-slider-pro' )
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_ui'             => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'logo' ),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array( 'title', 'thumbnail' ),
        'show_in_nav_menus'   => false,
        'menu_icon'           => 'dashicons-images-alt2'
    );

    register_post_type( 'logocarouselpro', $args );
}

add_action( 'init', 'lcsp_init' );


function create_logo_taxonomies() {
    $labels = array(
        'name'              => _x( 'Logo Categories', 'logo-carousel-slider-pro' ),
        'singular_name'     => _x( 'Logo Category', 'logo-carousel-slider-pro' ),
        'search_items'      => __( 'Search Logo Categories' ),
        'all_items'         => __( 'All Logo Categories' ),
        'parent_item'       => __( 'Parent Logo Category' ),
        'parent_item_colon' => __( 'Parent Logo Category:' ),
        'edit_item'         => __( 'Edit Logo Category' ),
        'update_item'       => __( 'Update Logo Category' ),
        'add_new_item'      => __( 'Add New Logo Category' ),
        'new_item_name'     => __( 'New Logo Category Name' ),
        'menu_name'         => __( 'Logo Categories' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'category' ),
    );

    register_taxonomy( 'lcsp_category', 'logocarouselpro', $args );
}

add_action( 'init', 'create_logo_taxonomies', 0 );

/**
 * Registers logo carousel slider shortcode generator post type.
 */
function lcsp_sg_init() {
    $labels = array(
        'name'               => _x( 'All Generated Shortcodes', 'logo-carousel-slider-pro' ),
        'singular_name'      => _x( 'Shortcode Generator', 'logo-carousel-slider-pro' ),
        'menu_name'          => _x( 'Shortcode Generator', 'logo-carousel-slider-pro' ),
        'all_items'          => __( 'Shortcode Generator', 'logo-carousel-slider-pro' ),
        'add_new'            => _x( 'Generate New Shortcode', 'logo-carousel-slider-pro' ),
        'add_new_item'       => __( 'Generate New Shortcode', 'logo-carousel-slider-pro' ),
        'new_item'           => __( 'Generate New Shortcode', 'logo-carousel-slider-pro' ),
        'edit_item'          => __( 'Edit Generated Shortcode', 'logo-carousel-slider-pro' ),
        'view_item'          => __( 'View Generated Shortcode', 'logo-carousel-slider-pro' ),
        'name_admin_bar'     => __( 'Logo Carousel Shortcode', 'logo-carousel-slider-pro' ),
        'search_items'       => __( 'Search Generated Shortcode', 'logo-carousel-slider-pro' ),
        'parent_item_colon'  => __( 'Parent Generated Shortcodes:', 'logo-carousel-slider-pro' ),
        'not_found'          => __( 'No Generated Shortcode found.', 'logo-carousel-slider-pro' ),
        'not_found_in_trash' => __( 'No Generated Shortcode found in Trash.', 'logo-carousel-slider-pro' )
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_ui'             => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'shortcode' ),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array( 'title' ),
        'show_in_nav_menus'   => false,
        'show_in_menu'        => 'edit.php?post_type=logocarouselpro',   
        'menu_icon'           => 'dashicons-images-alt2'
    );

    register_post_type( 'lcsp_sgenerator', $args );
}

add_action( 'init', 'lcsp_sg_init' );

/**
 * Customizes messages of logo carousel slider post type.
 */
function lcsp_updated_messages( $messages ) {
    global $post;
    $messages['logocarouselpro'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => __( 'Logo Updated.', 'logo-carousel-slider-pro' ),
        2  => __( 'Logo field updated.', 'logo-carousel-slider-pro' ),
        3  => __( 'Logo field deleted.', 'logo-carousel-slider-pro' ),
        4  => __( 'Logo updated.', 'logo-carousel-slider-pro' ),
        5  => isset( $_GET['revision'] ) ? sprintf( __( 'Logo restored to revision from %s', 'logo-carousel-slider-pro' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => __( 'Logo published.', 'logo-carousel-slider-pro' ),
        7  => __( 'Logo saved.', 'logo-carousel-slider-pro' ),
        8  => __( 'Logo submitted.', 'logo-carousel-slider-pro' ),
        9  => sprintf(
            __( 'Logo scheduled for: <strong>%1$s</strong>.', 'logo-carousel-slider-pro' ),
            date_i18n( __( 'M j, Y @ G:i', 'logo-carousel-slider-pro' ), strtotime( $post->post_date ) )
        ),
        10 => __( 'Logo draft updated.', 'logo-carousel-slider-pro' )
    );

    return $messages;
}

add_filter( 'post_updated_messages', 'lcsp_updated_messages' );

/**
 * Customizes messages of logo carousel slider shortcode generator post type.
 */
function lcsp_sg_updated_messages( $messages ) {
    global $post;
    $messages['lcsp_sgenerator'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => __( 'Updated.', 'logo-carousel-slider-pro' ),
        2  => __( 'Field updated.', 'logo-carousel-slider-pro' ),
        3  => __( 'Field deleted.', 'logo-carousel-slider-pro' ),
        4  => __( 'Updated.', 'logo-carousel-slider-pro' ),
        5  => isset( $_GET['revision'] ) ? sprintf( __( 'Restored to revision from %s', 'logo-carousel-slider-pro' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => __( 'Published.', 'logo-carousel-slider-pro' ),
        7  => __( 'Saved.', 'logo-carousel-slider-pro' ),
        8  => __( 'Submitted.', 'logo-carousel-slider-pro' ),
        9  => sprintf(
            __( 'Scheduled for: <strong>%1$s</strong>.', 'logo-carousel-slider-pro' ),
            date_i18n( __( 'M j, Y @ G:i', 'logo-carousel-slider-pro' ), strtotime( $post->post_date ) )
        ),
        10 => __( 'Draft updated.', 'logo-carousel-slider-pro' )
    );

    return $messages;
}

add_filter( 'post_updated_messages', 'lcsp_sg_updated_messages' );

/**
 * Changes default meta box location of logo
 */
function lcsp_meta_box_position() {
    remove_meta_box( 'postimagediv', 'logocarouselpro', 'side' );
    add_meta_box( 'postimagediv', __('Logo'), 'post_thumbnail_meta_box', 'logocarouselpro', 'normal', 'high' );
}
add_action('do_meta_boxes', 'lcsp_meta_box_position');

/**
 * Adds two boxes to the main column on the logo carousel slider post type and a box to shortcode generator post type edit screens.
 */
function lcsp_add_meta_box() {
    add_meta_box( 'lcsp_metabox', __( 'URL','logo-carousel-slider-pro' ), 'lcsp_meta_box_content_output', 'logocarouselpro', 'normal' );
    add_meta_box( 'lcsp_tooltip_metabox', __( 'Tooltip','logo-carousel-slider-pro' ), 'tooltip_pro_meta_box_content_output', 'logocarouselpro', 'normal' );
    add_meta_box( 'lcsp_sg_metabox', __( 'Shortcode Generator and Settings','logo-carousel-slider-pro' ), 'lcsp_sg_meta_box_content_output', 'lcsp_sgenerator', 'normal' );
}
add_action( 'add_meta_boxes', 'lcsp_add_meta_box' ); 

/**
 * Prints the boxes content.
 */
function lcsp_meta_box_content_output( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'lcsp_save_meta_box_data', 'lcsp_meta_box_nonce' );

    $lcsp_logo_link = get_post_meta( $post->ID, 'lcsp_logo_link', true );

    ?>

    <div class="lcsp-row">
        <div class="lcsp-th">
            <label for="lcsp_logo_link"><?php _e('Logo link', 'logo-carousel-slider-pro'); ?></label>
        </div>
        <div class="lcsp-td">
            <input type="text" class="lcsp-text-input" name="lcsp_logo_link" id="lcsp_logo_link" value="<?php if(isset($lcsp_logo_link)) { echo $lcsp_logo_link; } else { echo ''; } ?>">
        </div>
    </div>

<?php }


function tooltip_pro_meta_box_content_output ( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'lcsp_tooltip_save_meta_box_data', 'lcsp_tooltip_meta_box_nonce' );

    $lcsp_tooltip_text = get_post_meta( $post->ID, 'lcsp_tooltip_text', true );

    ?>

    <div class="lcsp-row">
        <div class="lcsp-th">
            <label for="lcsp_tooltip_text"><?php _e('Tooltip Text', 'logo-carousel-slider-pro'); ?></label>
        </div>
        <div class="lcsp-td">
            <input type="text" class="lcsp-text-input" name="lcsp_tooltip_text" id="lcsp_tooltip_text" value="<?php if(isset($lcsp_tooltip_text)) { echo $lcsp_tooltip_text; } else { echo ''; } ?>">
        </div>
    </div>

<?php }


function lcsp_sg_meta_box_content_output ( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'lcsp_sg_save_meta_box_data', 'lcsp_sg_meta_box_nonce' );

    $lcspLogoType = get_post_meta( $post->ID, 'lcsp_logo_type', true );
    $lcsp_logos_byid = get_post_meta( $post->ID, 'lcsp_logos_byid', true );
    $lcsp_logos_from_year = get_post_meta( $post->ID, 'lcsp_logos_from_year', true );
    $lcsp_logos_from_month = get_post_meta( $post->ID, 'lcsp_logos_from_month', true );
    $lcsp_logos_from_month_year = get_post_meta( $post->ID, 'lcsp_logos_from_month_year', true );
    $lcsp_taxonomy_terms = get_post_meta( $post->ID, 'lcsp_taxonomy_terms', true );
    $lcspSliderTitle = get_post_meta( $post->ID, 'lcsp_slider_title', true );
    $lcspDisplayNavArr = get_post_meta( $post->ID, 'lcsp_dna', true );
    $lcspNavPosition = get_post_meta( $post->ID, 'lcsp_nap', true );
    $lcspLogoTitleDisplay = get_post_meta( $post->ID, 'lcsp_dlt', true );
    $lcspLogoBorderDisplay = get_post_meta( $post->ID, 'lcsp_dlb', true );
    $lcspLogoHoverEffect = get_post_meta( $post->ID, 'lcsp_lhe', true );
    $lcspImageCrop = get_post_meta( $post->ID, 'lcsp_ic', true );
    $lcspImageCropWidth = get_post_meta( $post->ID, 'lcsp_iwfc', true );
    $lcspImageCropHeight = get_post_meta( $post->ID, 'lcsp_ihfc', true );
    $lcspLogoLinkOpenWindow = get_post_meta( $post->ID, 'lcsp_llow', true );
    
    $lcspAutoPlay = get_post_meta( $post->ID, 'lcsp_ap', true );
    $lcspAutoPlaySpeed = get_post_meta( $post->ID, 'lcsp_aps', true );
    $lcspStopOnHover = get_post_meta( $post->ID, 'lcsp_soh', true );
    $lcspDesktopLogoItems = get_post_meta( $post->ID, 'lcsp_li_desktop', true );
    $lcspDesktopSmallLogoItems = get_post_meta( $post->ID, 'lcsp_li_desktop_small', true );
    $lcspTabletLogoItems = get_post_meta( $post->ID, 'lcsp_li_tablet', true );
    $lcspMobileLogoItems = get_post_meta( $post->ID, 'lcsp_li_mobile', true );
    $lcspSlideSpeed = get_post_meta( $post->ID, 'lcsp_ss', true );
    $lcspScrolling = get_post_meta( $post->ID, 'lcsp_spp', true );
    $lcspPagination = get_post_meta( $post->ID, 'lcsp_pagination', true );
    $lcspNumbersInPagination = get_post_meta( $post->ID, 'lcsp_nip', true );
    
    $lcspSliderTitleFontSize = get_post_meta( $post->ID, 'lcsp_stfs', true );
    $lcspSliderTitleFontColor = get_post_meta( $post->ID, 'lcsp_stfc', true );
    $lcspNavArrBgColor = get_post_meta( $post->ID, 'lcsp_nabc', true );
    $lcspNavArrborderColor = get_post_meta( $post->ID, 'lcsp_nabdc', true );
    $lcspNavArrColor = get_post_meta( $post->ID, 'lcsp_nac', true );
    $lcspNavArrHvBgColor = get_post_meta( $post->ID, 'lcsp_nahbc', true );
    $lcspNavArrHvborderColor = get_post_meta( $post->ID, 'lcsp_nahbdc', true );
    $lcspNavArrHvColor = get_post_meta( $post->ID, 'lcsp_nahc', true );
    $lcspLogoBorderColor = get_post_meta( $post->ID, 'lcsp_lbc', true );
    $lcspLogoBorderHoverColor = get_post_meta( $post->ID, 'lcsp_lbhc', true );
    $lcspLogoTitleFontSize = get_post_meta( $post->ID, 'lcsp_ltfs', true );
    $lcspLogoTitleFontColor = get_post_meta( $post->ID, 'lcsp_ltfc', true );
    $lcspLogoTitleFontHoverColor = get_post_meta( $post->ID, 'lcsp_ltfhc', true );
    $lcspTooltipBgColor = get_post_meta( $post->ID, 'lcsp_tbc', true );
    $lcspTooltipFontColor = get_post_meta( $post->ID, 'lcsp_tfc', true );
    $lcspTooltipFontSize = get_post_meta( $post->ID, 'lcsp_tfs', true );
    $lcspPaginationColor = get_post_meta( $post->ID, 'lcsp_pc', true );



    function lcsp_product_categories_checkbox(){                       
        global $post;
        $lcsp_taxonomy_terms = get_post_meta( $post->ID, 'lcsp_taxonomy_terms', true );

        if(empty($lcsp_taxonomy_terms)) {
            $lcsp_taxonomy_terms =array();            
        }

        $terms = get_terms('lcsp_category');      

        echo '<div class="lcsp-checkbox-wrapper">';

        if(empty($terms)) {
            echo "No categories found!";            
        }

        echo '<ul class="cmb2-list">';  

        foreach ( $terms as $term ) {
            if(array_search( $term->term_id, $lcsp_taxonomy_terms )) {
                echo '<li class='.$term->term_id.'> <input class="lcsp_taxonomy_terms" id="lcsp_taxonomy_terms_'.$term->name.'" type="checkbox" checked name="lcsp_taxonomy_terms['.$term->term_id.']" 
                value ="'.$term->term_id.'" /><label for="lcsp_taxonomy_terms_'.$term->name.'">'.$term->name.'</label ></li>';
            } else {
                echo '<li class='.$term->term_id.'> <input class="lcsp_taxonomy_terms" id="lcsp_taxonomy_terms_'.$term->name.'" type="checkbox" name="lcsp_taxonomy_terms['.$term->term_id.']" 
                value ="'.$term->term_id.'" /><label for="lcsp_taxonomy_terms_'.$term->name.'">'.$term->name.'</label ></li>';
            }
        }
         echo '</ul></div>';                                           
    }

?>
    <div id="lcsp-tabs-container">

        <ul class="lcsp-tabs-menu">
            <li class="current"><a href="#lcsp-tab-1"><?php _e('General Settings', 'logo-carousel-slider-pro'); ?></a></li>
            <li><a href="#lcsp-tab-2"><?php _e('Slider Settings', 'logo-carousel-slider-pro'); ?></a></li>
            <li><a href="#lcsp-tab-3"><?php _e('Style Settings', 'logo-carousel-slider-pro'); ?></a></li>
            <li><a href="#lcsp-tab-4"><?php _e('Support', 'logo-carousel-slider-pro'); ?></a></li>
        </ul>

        <div class="lcsp-tab">

            <div id="lcsp-tab-1" class="lcsp-tab-content">
                <div class="cmb2-wrap form-table">
                    <div id="cmb2-metabox" class="cmb2-metabox cmb-field-list">


                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_slider_title"><?php _e('Slider Title', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-medium" name="lcsp_slider_title" id="lcsp_slider_title" value="<?php if(empty($lcspSliderTitle)) { echo ""; } else { echo $lcspSliderTitle; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_dna"><?php _e('Display Navigation Arrows', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_dna" id="lcsp_dna1" value="true" <?php if($lcspDisplayNavArr=="true") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_dna1"><?php _e('Yes', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_dna" id="lcsp_dna2" value="false" <?php if($lcspDisplayNavArr=="false") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_dna2"><?php _e('No', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_nap"><?php _e('Navigation Arrows Position', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_nap" id="lcsp_nap1" value="topRight" <?php if($lcspNavPosition=="topRight") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_nap1"><?php _e('Top Right', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_nap" id="lcsp_nap2" value="middle" <?php if($lcspNavPosition=="middle") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_nap2"><?php _e('Middle (on hover visible)', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-multicheck lcscbw">
                            <div class="cmb-th">
                                <label for="wpcs_products_type"><?php _e('Logo Type', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">
                                    <li><input type="radio" class="cmb2-option" name="lcsp_logo_type" id="lcsp_logo_type1" value="latest" <?php if($lcspLogoType == "latest") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_logo_type1"><?php _e('Display Logos from Latest Published', 'logo-carousel-slider-pro'); ?></label></li>   
                                    <li><input type="radio" class="cmb2-option" name="lcsp_logo_type" id="lcsp_logo_type2" value="older" <?php if($lcspLogoType == "older") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_logo_type2"><?php _e('Display Logos from Older Published', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_logo_type" id="lcsp_logo_type3" value="category" <?php if($lcspLogoType == "category") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_logo_type3"><?php _e('Display Logos from Category', 'logo-carousel-slider-pro'); ?></label></li><?php lcsp_product_categories_checkbox() ?> 
                                    <li><input type="radio" class="cmb2-option" name="lcsp_logo_type" id="lcsp_logo_type4" value="logosbyid" <?php if($lcspLogoType == "logosbyid") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_logo_type4"><?php _e('Display Logos by ID ', 'logo-carousel-slider-pro'); ?></label></li>                                        
                                        <input type="text" class="cmb2-text-medium" name="lcsp_logos_byid" id="lcsp_logos_byid" value="<?php if(!empty($lcsp_logos_byid)) { echo $lcsp_logos_byid; } else { echo ''; } ?>" placeholder="e.g. 10, 11, 18">
                                    <li><input type="radio" class="cmb2-option" name="lcsp_logo_type" id="lcsp_logo_type5" value="logosbyyear" <?php if($lcspLogoType == "logosbyyear") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_logo_type5"><?php _e('Display Logos by Year', 'logo-carousel-slider-pro'); ?></label></li>
                                        <input type="text" class="cmb2-text-small" name="lcsp_logos_from_year" id="lcsp_logos_from_year" value="<?php if(!empty($lcsp_logos_from_year)) { echo $lcsp_logos_from_year; } else { echo ''; } ?>" placeholder="e.g. 2016">
                                    <li><input type="radio" class="cmb2-option" name="lcsp_logo_type" id="lcsp_logo_type6" value="logosbymonth" <?php if($lcspLogoType == "logosbymonth") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_logo_type6"><?php _e('Display Logos by Month', 'logo-carousel-slider-pro'); ?></label></li>
                                        <input type="text" class="cmb2-text-small lfm" name="lcsp_logos_from_month" id="lcsp_logos_from_month" value="<?php if(!empty($lcsp_logos_from_month)) { echo $lcsp_logos_from_month; } else { echo ''; } ?>" placeholder="e.g. 11">
                                        <input type="text" class="cmb2-text-small lfm" name="lcsp_logos_from_month_year" id="lcsp_logos_from_month_year" value="<?php if(!empty($lcsp_logos_from_month_year)) { echo $lcsp_logos_from_month_year; } else { echo ''; } ?>"placeholder="2016">              
                                </ul>
                                <p class="cmb2-metabox-description"><?php _e('What type of logos to display in the carousel slider', 'logo-carousel-slider-pro'); ?></p>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_dlt"><?php _e('Display Logo Title', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_dlt" id="lcsp_dlt1" value="yes" <?php if($lcspLogoTitleDisplay=="yes") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_dlt1"><?php _e('Yes', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_dlt" id="lcsp_dlt2" value="no" <?php if($lcspLogoTitleDisplay=="no") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_dlt2"><?php _e('No', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_dlb"><?php _e('Display Logo Border', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_dlb" id="lcsp_dlb1" value="yes" <?php if($lcspLogoBorderDisplay=="yes") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_dlb1"><?php _e('Yes', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_dlb" id="lcsp_dlb2" value="no" <?php if($lcspLogoBorderDisplay=="no") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_dlb2"><?php _e('No', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_lhe"><?php _e('Logo Hover Effect', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_lhe" id="lcsp_lhe1" value="yes" <?php if($lcspLogoHoverEffect=="yes") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_lhe1"><?php _e('Yes', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_lhe" id="lcsp_lhe2" value="no" <?php if($lcspLogoHoverEffect=="no") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_lhe2"><?php _e('No', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_ic"><?php _e('Image Crop', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_ic" id="lcsp_ic1" value="yes" <?php if($lcspImageCrop=="yes") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_ic1"><?php _e('Yes', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_ic" id="lcsp_ic2" value="no" <?php if($lcspImageCrop=="no") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_ic2"><?php _e('No', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                                <p class="cmb2-metabox-description"><?php _e('If logos are not in the same size, this feature is helpful. It automatically resizes and crops.', 'logo-carousel-slider-pro'); ?></p>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_iwfc"><?php _e('Image Width', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_iwfc" id="lcsp_iwfc" value="<?php if(empty($lcspImageCropWidth)) { echo 185; } else { echo $lcspImageCropWidth; } ?>">
                                <p class="cmb2-metabox-description"><?php _e('Image cropping width', 'logo-carousel-slider-pro'); ?></p>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_ihfc"><?php _e('Image Height', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_ihfc" id="lcsp_ihfc" value="<?php if(empty($lcspImageCropHeight)) { echo 119; } else { echo $lcspImageCropHeight; } ?>">
                                <p class="cmb2-metabox-description"><?php _e('Image cropping height', 'logo-carousel-slider-pro'); ?></p>
                            </div>
                        </div> 

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_llow"><?php _e('Open Logo Link in', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_llow" id="lcsp_llow1" value="_blank" <?php if($lcspLogoLinkOpenWindow=="_blank") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_llow1"><?php _e('New Window or Tab', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_llow" id="lcsp_llow2" value="_self" <?php if($lcspLogoLinkOpenWindow=="_self") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_llow2"><?php _e('Same Window or Tab', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div>                 

                    </div> <!-- end cmb2-metabox -->
                </div> <!-- end cmb2-wrap -->
            </div> <!-- end lcsp-tab-1 -->


            <div id="lcsp-tab-2" class="lcsp-tab-content">
                <div class="cmb2-wrap form-table">
                    <div id="cmb2-metabox" class="cmb2-metabox cmb-field-list">

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_ap"><?php _e('Auto Play', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_ap" id="lcsp_ap1" value="yes" <?php if($lcspAutoPlay=="yes") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_ap1"><?php _e('Yes', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_ap" id="lcsp_ap2" value="no" <?php if($lcspAutoPlay=="no") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_ap2"><?php _e('No', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_aps"><?php _e('Speed', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_aps" id="lcsp_aps" value="<?php if(empty($lcspAutoPlaySpeed)) { echo 4000; } else { echo $lcspAutoPlaySpeed; } ?>">
                            </div>
                        </div> 

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_soh"><?php _e('Stop on Hover', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_soh" id="lcsp_soh1" value="true" <?php if($lcspStopOnHover=="true") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_soh1"><?php _e('Yes', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_soh" id="lcsp_soh2" value="false" <?php if($lcspStopOnHover=="false") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_soh2"><?php _e('No', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div> 

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_li_desktop"><?php _e('Logo items (on Desktop, screen larger than 1198px)', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_li_desktop" id="lcsp_li_desktop" value="<?php if(empty($lcspDesktopLogoItems)) { echo 5; } else { echo $lcspDesktopLogoItems; } ?>">
                                <p class="cmb2-metabox-description"><?php _e('Maximum amount of items to display at a time on Desktop that screen size larger than 1198px', 'logo-carousel-slider-pro'); ?></p>

                            </div>
                        </div>

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_li_desktop_small"><?php _e('Logo items (on Desktop, screen larger than 978px)', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_li_desktop_small" id="lcsp_li_desktop_small" value="<?php if(empty($lcspDesktopSmallLogoItems)) { echo 4; } else { echo $lcspDesktopSmallLogoItems; } ?>">
                                <p class="cmb2-metabox-description"><?php _e('Maximum amount of items to display at a time on Desktop that screen size larger than 978px', 'logo-carousel-slider-pro'); ?></p>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_li_tablet"><?php _e('Logo items (on Tablet)', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_li_tablet" id="lcsp_li_tablet" value="<?php if(empty($lcspTabletLogoItems)) { echo 3; } else { echo $lcspTabletLogoItems; } ?>">
                                <p class="cmb2-metabox-description"><?php _e('Maximum amount of items to display at a time on Tablet', 'logo-carousel-slider-pro'); ?></p>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_li_mobile"><?php _e('Logo items (on Mobile)', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_li_mobile" id="lcsp_li_mobile" value="<?php if(empty($lcspMobileLogoItems)) { echo 2; } else { echo $lcspMobileLogoItems; } ?>">
                                <p class="cmb2-metabox-description"><?php _e('Maximum amount of items to display at a time on Mobile', 'logo-carousel-slider-pro'); ?></p>
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_ss"><?php _e('Slide Speed', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_ss" id="lcsp_ss" value="<?php if(empty($lcspSlideSpeed)) { echo 800; } else { echo $lcspSlideSpeed; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_spp"><?php _e('Scroll', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">  
                                    <li><input type="radio" class="cmb2-option" name="lcsp_spp" id="lcsp_spp1" value="false" <?php if($lcspScrolling=="false") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_spp1"><?php _e('Per Item', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_spp" id="lcsp_spp2" value="true" <?php if($lcspScrolling=="true") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_spp2"><?php _e('Per Page', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div>  

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_pagination"><?php _e('Pagination', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">
                                    <li><input type="radio" class="cmb2-option" name="lcsp_pagination" id="lcsp_pagination2" value="false" <?php if($lcspPagination=="false") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_pagination2"><?php _e('No', 'logo-carousel-slider-pro'); ?></label></li> 
                                    <li><input type="radio" class="cmb2-option" name="lcsp_pagination" id="lcsp_pagination1" value="true" <?php if($lcspPagination=="true") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_pagination1"><?php _e('Yes', 'logo-carousel-slider-pro'); ?></label></li>
                                </ul>
                            </div>
                        </div> 

                        <div class="cmb-row cmb-type-radio">
                            <div class="cmb-th">
                                <label for="lcsp_nip"><?php _e('Numbers inside Pagination', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <ul class="cmb2-radio-list cmb2-list">
                                    <li><input type="radio" class="cmb2-option" name="lcsp_nip" id="lcsp_nip2" value="false" <?php if($lcspNumbersInPagination=="false") {echo "checked"; } else { echo "checked"; } ?>> <label for="lcsp_nip2"><?php _e('No', 'logo-carousel-slider-pro'); ?></label></li>
                                    <li><input type="radio" class="cmb2-option" name="lcsp_nip" id="lcsp_nip1" value="true" <?php if($lcspNumbersInPagination=="true") {echo "checked"; } else { echo ""; } ?>> <label for="lcsp_nip1"><?php _e('Yes', 'logo-carousel-slider-pro'); ?></label></li>                                </ul>
                            </div>
                        </div> 

                    </div> <!-- end cmb2-metabox -->
                </div> <!-- end cmb2-wrap -->
            </div> <!-- end lcsp-tab-2 -->


            <div id="lcsp-tab-3" class="lcsp-tab-content">
                <div class="cmb2-wrap form-table">
                    <div id="cmb2-metabox" class="cmb2-metabox cmb-field-list">


                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_stfs"><?php _e('Slider Title Font Size', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_stfs" id="lcsp_stfs" value="<?php if(empty($lcspSliderTitleFontSize)) { echo "18px"; } else { echo $lcspSliderTitleFontSize; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_stfc"><?php _e('Slider Title Font Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_stfc" id="lcsp_stfc" value="<?php if(!empty($lcspSliderTitleFontColor)) { echo $lcspSliderTitleFontColor; } else { echo "#444"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_nabc"><?php _e('Navigation Arrows Background Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_nabc" id="lcsp_nabc" value="<?php if(!empty($lcspNavArrBgColor)) { echo $lcspNavArrBgColor; } else { echo "#ffffff"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_nabdc"><?php _e('Navigation Arrows Border Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_nabdc" id="lcsp_nabdc" value="<?php if(!empty($lcspNavArrborderColor)) { echo $lcspNavArrborderColor; } else { echo "#ccc"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_nac"><?php _e('Navigation Arrows Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_nac" id="lcsp_nac" value="<?php if(!empty($lcspNavArrColor)) { echo $lcspNavArrColor; } else { echo "#ccc"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_nahbc"><?php _e('Navigation Arrows Hover Background Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_nahbc" id="lcsp_nahbc" value="<?php if(!empty($lcspNavArrHvBgColor)) { echo $lcspNavArrHvBgColor; } else { echo "#ffffff"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_nahbdc"><?php _e('Navigation Arrows Hover Border Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_nahbdc" id="lcsp_nahbdc" value="<?php if(!empty($lcspNavArrHvborderColor)) { echo $lcspNavArrHvborderColor; } else { echo "#A0A0A0"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_nahc"><?php _e('Navigation Arrows Hover Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_nahc" id="lcsp_nahc" value="<?php if(!empty($lcspNavArrHvColor)) { echo $lcspNavArrHvColor; } else { echo "#A0A0A0"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_lbc"><?php _e('Logo Border Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_lbc" id="lcsp_lbc" value="<?php if(!empty($lcspLogoBorderColor)) { echo $lcspLogoBorderColor; } else { echo "#d6d4d4"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_lbhc"><?php _e('Logo Border Hover Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_lbhc" id="lcsp_lbhc" value="<?php if(!empty($lcspLogoBorderHoverColor)) { echo $lcspLogoBorderHoverColor; } else { echo "#A0A0A0"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_ltfs"><?php _e('Logo Title Font Size', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_ltfs" id="lcsp_ltfs" value="<?php if(!empty($lcspLogoTitleFontSize)) { echo $lcspLogoTitleFontSize; } else { echo "14px"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_ltfc"><?php _e('Logo Title Font Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_ltfc" id="lcsp_ltfc" value="<?php if(!empty($lcspLogoTitleFontColor)) { echo $lcspLogoTitleFontColor; } else { echo "#444"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_ltfhc"><?php _e('Logo Title Font Hover Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_ltfhc" id="lcsp_ltfhc" value="<?php if(!empty($lcspLogoTitleFontHoverColor)) { echo $lcspLogoTitleFontHoverColor; } else { echo "#808080"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_tbc"><?php _e('Tooltip Background Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_tbc" id="lcsp_tbc" value="<?php if(!empty($lcspTooltipBgColor)) { echo $lcspTooltipBgColor; } else { echo "#666666"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_tfc"><?php _e('Tooltip Font Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_tfc" id="lcsp_tfc" value="<?php if(!empty($lcspTooltipFontColor)) { echo $lcspTooltipFontColor; } else { echo "#ffffff"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-text-medium">
                            <div class="cmb-th">
                                <label for="lcsp_tfs"><?php _e('Tooltip Font Size', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_tfs" id="lcsp_tfs" value="<?php if(!empty($lcspTooltipFontSize)) { echo $lcspTooltipFontSize; } else { echo "14px"; } ?>">
                            </div>
                        </div>

                        <div class="cmb-row cmb-type-colorpicker">
                            <div class="cmb-th">
                                <label for="lcsp_pc"><?php _e('Pagination Color', 'logo-carousel-slider-pro'); ?></label>
                            </div>
                            <div class="cmb-td">
                                <input type="text" class="cmb2-text-small" name="lcsp_pc" id="lcsp_pc" value="<?php if(!empty($lcspPaginationColor)) { echo $lcspPaginationColor; } else { echo "#666666"; } ?>">
                            </div>
                        </div>

                    </div> <!-- end cmb2-metabox -->
                </div> <!-- end cmb2-wrap -->
            </div> <!-- end lcsp-tab-3 -->


            <div id="lcsp-tab-4" class="lcsp-tab-content">
                <div class="cmb2-wrap form-table">
                    <div id="cmb2-metabox" class="cmb2-metabox cmb-field-list">

                        <h2>Usage</h2>
                        <p>Plugin usage guideline: <a href="http://adlplugins.com/logo-carousel-slider-pro-documentation" target="_blank">http://adlplugins.com/logo-carousel-slider-pro-documentation</a></p><br /><br />

                        <h2>Support Forum</h2>
                        <p>If you need any helps, please don't hesitate to post it on our <a href="http://adlplugins.com/support" target="_blank">Support Forum</a>.</p><br /><br />

                        <h2>Further help</h2>
                        <p>Do you need to customize or add new feature(s) in the plugin? <a href="http://adlplugins.com/hire" " target="_blank">Hire Us</a>.</p>

                    </div> <!-- end cmb2-metabox -->
                </div> <!-- end cmb2-wrap -->
            </div> <!-- end lcsp-tab-4 -->


        </div> <!-- end lcsp-tab -->
    </div> <!-- end lcsp-tabs-container -->

    <div class="lcsp_shortcode">
        <h2><?php _e('Shortcode', 'logo-carousel-slider-pro'); ?> </h2> 
        <p><?php _e('Use following shortcode to display the Carousel Slider anywhere:', 'logo-carousel-slider-pro'); ?></p>
        <textarea cols="40" rows="1" onClick="this.select();" >[logo_carousel_slider_pro <?php echo 'id="'.$post->ID.'"';?>]</textarea> <br />

        <p><?php _e('If you need to put the shortcode in code/theme file, use this:', 'logo-carousel-slider-pro'); ?></p>
        <textarea cols="65" rows="1" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[logo_carousel_slider_pro id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea> </p>
    </div>

<?php }

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function lcsp_save_meta_box_data( $post_id ) {
/*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['lcsp_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['lcsp_meta_box_nonce'], 'lcsp_save_meta_box_data' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    $lcsp_logo_link_value = "";

    if(isset($_POST["lcsp_logo_link"])) {
        $lcsp_logo_link_value = sanitize_text_field( $_POST["lcsp_logo_link"] );
    }   
    update_post_meta($post_id, "lcsp_logo_link", $lcsp_logo_link_value);
}

add_action( 'save_post', 'lcsp_save_meta_box_data' );


function lcsp_tooltip_save_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['lcsp_tooltip_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['lcsp_tooltip_meta_box_nonce'], 'lcsp_tooltip_save_meta_box_data' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    $lcsp_tooltip_text_value = "";

    if(isset($_POST["lcsp_tooltip_text"])) {
        $lcsp_tooltip_text_value = sanitize_text_field( $_POST["lcsp_tooltip_text"] );
    }   
    update_post_meta($post_id, "lcsp_tooltip_text", $lcsp_tooltip_text_value);
}

add_action( 'save_post', 'lcsp_tooltip_save_meta_box_data' );


function lcsp_sg_save_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['lcsp_sg_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['lcsp_sg_meta_box_nonce'], 'lcsp_sg_save_meta_box_data' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }


    $lcsp_logo_type_value = "";
    $lcsp_logos_byid_value   = "";
    $lcsp_logos_from_year_value = "";
    $lcsp_logos_from_month_value = "";
    $lcsp_logos_from_month_year_value = "";
    $lcsp_taxonomy_terms_value = "";
    $lcsp_slider_title_value = "";
    $lcsp_dna_value = "";
    $lcsp_nap_value = "";
    $lcsp_dlt_value = "";
    $lcsp_dlb_value = "";
    $lcsp_lhe_value = "";
    $lcsp_iwfc_value = "";
    $lcsp_ihfc_value = "";
    $lcsp_llow_value = "";
    $lcsp_ap_value = "";
    $lcsp_aps_value = "";
    $lcsp_soh_value = "";
    $lcsp_li_desktop_value = "";
    $lcsp_li_desktop_small_value = "";
    $lcsp_li_tablet_value = "";
    $lcsp_li_mobile_value = "";
    $lcsp_ss_value = "";
    $lcsp_spp_value = "";
    $lcsp_pagination_value = "";
    $lcsp_nip_value = "";
    $lcsp_stfs_value = "";
    $lcsp_stfc_value = "";
    $lcsp_nabc_value = "";
    $lcsp_nabdc_value = "";
    $lcsp_nac_value = "";
    $lcsp_nahbc_value = "";
    $lcsp_nahbdc_value = "";
    $lcsp_nahc_value = "";
    $lcsp_lbc_value = "";
    $lcsp_lbhc_value = "";
    $lcsp_ltfs_value = "";
    $lcsp_ltfc_value = "";
    $lcsp_ltfhc_value = "";
    $lcsp_tbc_value = "";
    $tlcsp_tfc_value = "";
    $lcsp_tfs_value = "";
    $lcsp_pc_value = "";


    if(isset($_POST["lcsp_logo_type"])) {
        $lcsp_logo_type_value = sanitize_text_field( $_POST["lcsp_logo_type"] );
    }   
    update_post_meta($post_id, "lcsp_logo_type", $lcsp_logo_type_value);


    if(isset($_POST["lcsp_logos_byid"]))
    {
        $lcsp_logos_byid_value = sanitize_text_field( $_POST["lcsp_logos_byid"] );
    }   
    update_post_meta($post_id, "lcsp_logos_byid", $lcsp_logos_byid_value);


    if(isset($_POST["lcsp_logos_from_year"]))
    {
        $lcsp_logos_from_year_value = sanitize_text_field( $_POST["lcsp_logos_from_year"] );
    }   
    update_post_meta($post_id, "lcsp_logos_from_year", $lcsp_logos_from_year_value);


    if(isset($_POST["lcsp_logos_from_month"]))
    {
        $lcsp_logos_from_month_value = sanitize_text_field( $_POST["lcsp_logos_from_month"] );
    }   
    update_post_meta($post_id, "lcsp_logos_from_month", $lcsp_logos_from_month_value);


    if(isset($_POST["lcsp_logos_from_month_year"]))
    {
        $lcsp_logos_from_month_year_value = sanitize_text_field( $_POST["lcsp_logos_from_month_year"] );
    }   
    update_post_meta($post_id, "lcsp_logos_from_month_year", $lcsp_logos_from_month_year_value);


   if(isset($_POST["lcsp_taxonomy_terms"])) {
       $lcsp_taxonomy_terms_value = stripslashes_deep( $_POST["lcsp_taxonomy_terms"] );
    }   
    update_post_meta($post_id, "lcsp_taxonomy_terms", $lcsp_taxonomy_terms_value);


    if(isset($_POST["lcsp_slider_title"])) {
        $lcsp_slider_title_value = sanitize_text_field( $_POST["lcsp_slider_title"] );
    }   
    update_post_meta($post_id, "lcsp_slider_title", $lcsp_slider_title_value);


    if(isset($_POST["lcsp_dna"])) {
        $lcsp_dna_value = sanitize_text_field( $_POST["lcsp_dna"] );
    }   
    update_post_meta($post_id, "lcsp_dna", $lcsp_dna_value);


    if(isset($_POST["lcsp_nap"])) {
        $lcsp_nap_value = sanitize_text_field( $_POST["lcsp_nap"] );
    }   
    update_post_meta($post_id, "lcsp_nap", $lcsp_nap_value);


    if(isset($_POST["lcsp_dlt"])) {
        $lcsp_dlt_value = sanitize_text_field( $_POST["lcsp_dlt"] );
    }   
    update_post_meta($post_id, "lcsp_dlt", $lcsp_dlt_value);


    if(isset($_POST["lcsp_dlb"])) {
        $lcsp_dlb_value = sanitize_text_field( $_POST["lcsp_dlb"] );
    }   
    update_post_meta($post_id, "lcsp_dlb", $lcsp_dlb_value);


    if(isset($_POST["lcsp_lhe"])) {
        $lcsp_lhe_value = sanitize_text_field( $_POST["lcsp_lhe"] );
    }   
    update_post_meta($post_id, "lcsp_lhe", $lcsp_lhe_value);


    if(isset($_POST["lcsp_ic"])) {
        $lcsp_ic_value = sanitize_text_field( $_POST["lcsp_ic"] );
    }   
    update_post_meta($post_id, "lcsp_ic", $lcsp_ic_value);  


    if(isset($_POST["lcsp_iwfc"])) {
        $lcsp_iwfc_value = sanitize_text_field( $_POST["lcsp_iwfc"] );
    }   
    update_post_meta($post_id, "lcsp_iwfc", $lcsp_iwfc_value); 


    if(isset($_POST["lcsp_ihfc"])) {
        $lcsp_ihfc_value = sanitize_text_field( $_POST["lcsp_ihfc"] );
    }   
    update_post_meta($post_id, "lcsp_ihfc", $lcsp_ihfc_value);  


    if(isset($_POST["lcsp_llow"])) {
        $lcsp_llow_value = sanitize_text_field( $_POST["lcsp_llow"] );
    }   
    update_post_meta($post_id, "lcsp_llow", $lcsp_llow_value);  


    if(isset($_POST["lcsp_ap"])) {
        $lcsp_ap_value = sanitize_text_field( $_POST["lcsp_ap"] );
    }   
    update_post_meta($post_id, "lcsp_ap", $lcsp_ap_value); 


    if(isset($_POST["lcsp_aps"])) {
        $lcsp_aps_value = sanitize_text_field( $_POST["lcsp_aps"] );
    }   
    update_post_meta($post_id, "lcsp_aps", $lcsp_aps_value); 


    if(isset($_POST["lcsp_soh"])) {
        $lcsp_soh_value = sanitize_text_field( $_POST["lcsp_soh"] );
    }   
    update_post_meta($post_id, "lcsp_soh", $lcsp_soh_value); 


    if(isset($_POST["lcsp_li_desktop"])) {
        $lcsp_li_desktop_value = sanitize_text_field( $_POST["lcsp_li_desktop"] );
    }   
    update_post_meta($post_id, "lcsp_li_desktop", $lcsp_li_desktop_value); 


    if(isset($_POST["lcsp_li_desktop_small"])) {
        $lcsp_li_desktop_small_value = sanitize_text_field( $_POST["lcsp_li_desktop_small"] );
    }   
    update_post_meta($post_id, "lcsp_li_desktop_small", $lcsp_li_desktop_small_value); 


    if(isset($_POST["lcsp_li_tablet"])) {
        $lcsp_li_tablet_value = sanitize_text_field( $_POST["lcsp_li_tablet"] );
    }   
    update_post_meta($post_id, "lcsp_li_tablet", $lcsp_li_tablet_value);  


    if(isset($_POST["lcsp_li_mobile"])) {
        $lcsp_li_mobile_value = sanitize_text_field( $_POST["lcsp_li_mobile"] );
    }   
    update_post_meta($post_id, "lcsp_li_mobile", $lcsp_li_mobile_value);  


    if(isset($_POST["lcsp_ss"])) {
        $lcsp_ss_value = sanitize_text_field( $_POST["lcsp_ss"] );
    }   
    update_post_meta($post_id, "lcsp_ss", $lcsp_ss_value);  


    if(isset($_POST["lcsp_spp"])) {
        $lcsp_spp_value = sanitize_text_field( $_POST["lcsp_spp"] );
    }   
    update_post_meta($post_id, "lcsp_spp", $lcsp_spp_value);  


    if(isset($_POST["lcsp_pagination"])) {
        $lcsp_pagination_value = sanitize_text_field( $_POST["lcsp_pagination"] );
    }   
    update_post_meta($post_id, "lcsp_pagination", $lcsp_pagination_value);  


    if(isset($_POST["lcsp_nip"])) {
        $lcsp_nip_value = sanitize_text_field( $_POST["lcsp_nip"] );
    }   
    update_post_meta($post_id, "lcsp_nip", $lcsp_nip_value);  


    if(isset($_POST["lcsp_stfs"])) {
        $lcsp_stfs_value = sanitize_text_field( $_POST["lcsp_stfs"] );
    }   
    update_post_meta($post_id, "lcsp_stfs", $lcsp_stfs_value);  


    if(isset($_POST["lcsp_stfc"])) {
        $lcsp_stfc_value = sanitize_text_field( $_POST["lcsp_stfc"] );
    }   
    update_post_meta($post_id, "lcsp_stfc", $lcsp_stfc_value);  


    if(isset($_POST["lcsp_nabc"])) {
        $lcsp_nabc_value = sanitize_text_field( $_POST["lcsp_nabc"] );
    }   
    update_post_meta($post_id, "lcsp_nabc", $lcsp_nabc_value);  


    if(isset($_POST["lcsp_nabdc"])) {
        $lcsp_nabdc_value = sanitize_text_field( $_POST["lcsp_nabdc"] );
    }   
    update_post_meta($post_id, "lcsp_nabdc", $lcsp_nabdc_value);  


    if(isset($_POST["lcsp_nac"])) {
        $lcsp_nac_value = sanitize_text_field( $_POST["lcsp_nac"] );
    }   
    update_post_meta($post_id, "lcsp_nac", $lcsp_nac_value);  


    if(isset($_POST["lcsp_nahbc"])) {
        $lcsp_nahbc_value = sanitize_text_field( $_POST["lcsp_nahbc"] );
    }   
    update_post_meta($post_id, "lcsp_nahbc", $lcsp_nahbc_value);  


    if(isset($_POST["lcsp_nahbdc"])) {
        $lcsp_nahbdc_value = sanitize_text_field( $_POST["lcsp_nahbdc"] );
    }   
    update_post_meta($post_id, "lcsp_nahbdc", $lcsp_nahbdc_value);  


    if(isset($_POST["lcsp_nahc"])) {
        $lcsp_nahc_value = sanitize_text_field( $_POST["lcsp_nahc"] );
    }   
    update_post_meta($post_id, "lcsp_nahc", $lcsp_nahc_value);  


    if(isset($_POST["lcsp_lbc"])) {
        $lcsp_lbc_value = sanitize_text_field( $_POST["lcsp_lbc"] );
    }   
    update_post_meta($post_id, "lcsp_lbc", $lcsp_lbc_value);  


    if(isset($_POST["lcsp_lbhc"])) {
        $lcsp_lbhc_value = sanitize_text_field( $_POST["lcsp_lbhc"] );
    }   
    update_post_meta($post_id, "lcsp_lbhc", $lcsp_lbhc_value);  


    if(isset($_POST["lcsp_ltfs"])) {
        $lcsp_ltfs_value = sanitize_text_field( $_POST["lcsp_ltfs"] );
    }   
    update_post_meta($post_id, "lcsp_ltfs", $lcsp_ltfs_value);  


    if(isset($_POST["lcsp_ltfc"])) {
        $lcsp_ltfc_value = sanitize_text_field( $_POST["lcsp_ltfc"] );
    }   
    update_post_meta($post_id, "lcsp_ltfc", $lcsp_ltfc_value);  


    if(isset($_POST["lcsp_ltfhc"])) {
        $lcsp_ltfhc_value = sanitize_text_field( $_POST["lcsp_ltfhc"] );
    }   
    update_post_meta($post_id, "lcsp_ltfhc", $lcsp_ltfhc_value);  


    if(isset($_POST["lcsp_tbc"])) {
        $lcsp_ic_value = sanitize_text_field( $_POST["lcsp_tbc"] );
    }   
    update_post_meta($post_id, "lcsp_tbc", $lcsp_ic_value);  


    if(isset($_POST["lcsp_tfc"])) {
        $lcsp_tfc_value = sanitize_text_field( $_POST["lcsp_tfc"] );
    }   
    update_post_meta($post_id, "lcsp_tfc", $lcsp_tfc_value);  


    if(isset($_POST["lcsp_tfs"])) {
        $lcsp_tfs_value = sanitize_text_field( $_POST["lcsp_tfs"] );
    }   
    update_post_meta($post_id, "lcsp_tfs", $lcsp_tfs_value);  


    if(isset($_POST["lcsp_pc"])) {
        $lcsp_pc_value = sanitize_text_field( $_POST["lcsp_pc"] );
    }   
    update_post_meta($post_id, "lcsp_pc", $lcsp_pc_value);    

}
add_action( 'save_post', 'lcsp_sg_save_meta_box_data' );