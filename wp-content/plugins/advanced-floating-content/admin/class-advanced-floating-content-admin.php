<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.codetides.com/
 * @since      3.0
 *
 * @package    Advanced_Floating_Content
 * @subpackage Advanced_Floating_Content/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Floating_Content
 * @subpackage Advanced_Floating_Content/admin
 * @author     Code Tides <contact@codetides.com>
 */
class Advanced_Floating_Content_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
    
    public $options;
    
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->options = get_option( 'ct_afc_options' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Floating_Content_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Floating_Content_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-floating-content-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Floating_Content_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Floating_Content_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-floating-content-admin.js', array( 'wp-color-picker' ), $this->version, true );

	}
	
	/*
	*	Register CPT 
	*/
	
	public function register_cpt_floating_content()
	{
		$labels = array(
            'name'                => _x( 'Advanced Floating Content', 'Post Type General Name', 'advanced-floating-content' ),
            'singular_name'       => _x( 'Advanced Floating Content', 'Post Type Singular Name', 'advanced-floating-content' ),
            'menu_name'           => __( 'Advanced Floating Content', 'advanced-floating-content' ),
            'name_admin_bar'      => __( 'Advanced Floating Content', 'advanced-floating-content' ),
            'parent_item_colon'   => __( 'Parent Advanced Floating Content:', 'advanced-floating-content' ),
            'all_items'           => __( 'All Advanced Floating Content', 'advanced-floating-content' ),
            'add_new_item'        => __( 'Add New Floating Content', 'advanced-floating-content' ),
            'add_new'             => __( 'Add New', 'advanced-floating-content' ),
            'new_item'            => __( 'New Advanced Floating Content', 'advanced-floating-content' ),
            'edit_item'           => __( 'Edit Floating Content', 'advanced-floating-content' ),
            'update_item'         => __( 'Update Advanced Floating Content', 'advanced-floating-content' ),
            'view_item'           => __( 'View Advanced Floating Content', 'advanced-floating-content' ),
            'search_items'        => __( 'Search Advanced Floating Content', 'advanced-floating-content' ),
            'not_found'           => __( 'Not found', 'advanced-floating-content' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'advanced-floating-content' ),
        );
        $args = array(
            'label'               => __( 'Advanced Floating Content', 'advanced-floating-content' ),
            'description'         => __( 'Another Flexible Advanced Floating Content', 'advanced-floating-content' ),      
			'labels'              => $labels,     
            'supports'            => array('title','editor'),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 10,
            'menu_icon'           => 'dashicons-admin-site',
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'ct_afc', apply_filters( 'ct_afc_register_arguments', $args) );
        
	}
	
	/*
 	* Adds a options details.
	*/
	public function add_meta_box() {
		add_meta_box(
			'advanced_floating_content_position',
			__( 'Position Your Floating Content', 'advanced-floating-content' ),
			array($this,'meta_box_print_position'),
			'ct_afc'
		);
        add_meta_box(
			'advanced_floating_content_theme',
			__( 'Build Your Theme For Floating Content', 'advanced-floating-content' ),
			array($this,'meta_box_print_theme'),
			'ct_afc'
		);
        add_meta_box(
			'advanced_floating_content_custom_css',
			__( 'Custom Css For Your Floating Content', 'advanced-floating-content' ),
			array($this,'meta_box_print_css'),
			'ct_afc'
		);
	}
    /*
	* Prints the box content.
	*/
	public function meta_box_print_position( $post ) {
	
		require_once plugin_dir_path( __FILE__ ). 'views/advanced-floating-content-position-options.php';
	}
	/*
	* Prints the box content.
	*/
	public function meta_box_print_theme( $post ) {
	
		require_once plugin_dir_path( __FILE__ ). 'views/advanced-floating-content-theme-options.php';
	}
	public function meta_box_print_css( $post ) {
	
		require_once plugin_dir_path( __FILE__ ). 'views/advanced-floating-content-css-options.php';
	}
	
    
	/*
 	* Adds a options details for premium users.
	*/
	public function add_meta_box_premium() {
		add_meta_box(
			'advanced_floating_content_premium_meta_box',
			__( 'Floating Content Controlling Options', 'advanced-floating-content' ),
			array($this,'meta_box_premium_print'),
			'ct_afc'
		);
	}
	/*
	* Prints the box content for premium users.
	*/
	public function meta_box_premium_print( $post ) {
	
		require_once plugin_dir_path( __FILE__ ). 'views/advanced-floating-content-premium-display.php';
	}
	
	
	/*
	*	Save the post content
	*/
	
	public function save_meta_box( $post_id ) {
 
    /* If we're not working with a 'post' post type or the user doesn't have permission to save,
     * then we exit the function.
     */
	 	
		if ( ! $this->is_valid_post_type() || ! $this->user_can_save( $post_id, 'advanced_floating_content_nonce', 'advanced_floating_content_save' ) ) {
			return;
		}	
		
		foreach($_POST as $key => $value)
		{
			if (0 === strpos($key, 'ct_afc_')) {
				update_post_meta( $post_id, $key, $value );
			}
		}
		
		
 
	}
	
	private function is_valid_post_type() {
		
		return ! empty( $_POST['post_type'] ) && 'ct_afc' == $_POST['post_type'];
	}
	
	private function user_can_save( $post_id, $nonce_action, $nonce_id ) {
 
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ $nonce_action ] ) && wp_verify_nonce( $_POST[ $nonce_action ], $nonce_id ) );
	 
		// Return true if the user is able to save; otherwise, false.
		return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;
	 
	}
	
	/*
	* Hide quick edit in Fun Facts Pro the box content.
	*/
	public function replace_submit_meta_box() 
      {

          remove_meta_box('submitdiv', 'ct_afc', 'core'); // $item represents post_type
          add_meta_box('submitdiv', 'Advanced Floating Content' , array($this,'submit_meta_box'), 'ct_afc', 'side', 'low');
		  add_meta_box('ct_information', 'Code Tides' , array($this,'ct_meta_box'), 'ct_afc', 'side', 'low');
      }
	  
	  public function ct_meta_box()
	  {
			echo '<div class="ct_info" style="margin-left:-20px;"><iframe frameborder="0" width="300" height="1270" src="http://www.codetides.com/free_plugin_right_side.php"></iframe></div>'; 
	   }
	  
	  
	 public function submit_meta_box() {
        global $action, $post;
       
        $post_type = $post->post_type; // get current post_type
        $post_type_object = get_post_type_object($post_type);
        $can_publish = current_user_can($post_type_object->cap->publish_posts);
       
        ?>
        <div class="submitbox" id="submitpost">
         <div id="major-publishing-actions">
         <?php
         do_action( 'post_submitbox_start' );
         ?>
         <div id="delete-action">
         <?php
         if ( current_user_can( "delete_post", $post->ID ) ) {
           if ( !EMPTY_TRASH_DAYS )
                $delete_text = __('Delete Permanently');
           else
                $delete_text = __('Move to Trash');
         ?>
         <a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo $delete_text; ?></a><?php
         } //if ?>
        </div>
         <div id="publishing-action">
         <span class="spinner"></span>
         <?php
         if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) {
              if ( $can_publish ) : ?>
                <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Add Tab') ?>" />
                <?php submit_button( sprintf( __( 'Add %' ), 'advanced-floating-content' ), 'primary button-large', 'publish', false, array( 'accesskey' => 'p' ) ); ?>
         <?php   
              endif; 
         } else { ?>
                <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Update ') . $item; ?>" />
                <input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?php esc_attr_e('Update ') . 'advanced-floating-content'; ?>" />
         <?php
         } //if ?>
         </div>
         <div class="clear"></div>
         </div>
         </div>
        <?php
      }  	
	 
	 
	 public function floating_content_custom_messages( $messages ) {
	  global $post, $post_ID;
	
	  $messages['ct_afc'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __('Flotaing content successfully updated.','advanced-floating-content'),
		2 => __('Custom field updated.','advanced-floating-content'),
		3 => __('Flotaing content successfully deleted.','advanced-floating-content'),
		4 => __('Flotaing content successfully updated.','advanced-floating-content'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Flotaing content restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => __('Flotaing content successfully added.','advanced-floating-content'),
		7 => __('Flotaing content has been saved.','advanced-floating-content'),
		8 => __('Flotaing content has been submitted.','advanced-floating-content'),	
	  );
	
	  return $messages;
	}
	 
	 
	public function duplicate_floating_content($actions, $post)
	{
		if ($post->post_type=='ct_afc')
    	{
			$actions['duplicate'] = '<a href="admin.php?action=floating_content_duplicate_post&post=' . $post->ID . '" title="Duplicate floating content" rel="permalink">Duplicate</a>';
			//$actions['trash'] = '<a href="admin.php?action=floating_content_duplicate_post&post=' . $post->ID . '" title="Duplicate floating content" rel="permalink">Delete</a>';
		}
		return $actions;
	} 
	 
	public function floating_content_duplicate_post(){
		
		
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post']) || ( isset($_REQUEST['action']) && 'floating_content_duplicate_post' == $_REQUEST['action'] ) ) ) {
			wp_die('No post to duplicate has been supplied!');
		}
 		
		 /*
		 * get the original post id
		 */
 		$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
		 /*
		 * and all the original post data then
		 */
		 $post = get_post( $post_id );
 
		 /*
		 * if you don't want current user to be the new post author,
		 * then change next couple of lines to this: $new_post_author = $post->post_author;
		 */
		 
 		$current_user = wp_get_current_user();
 		$new_post_author = $current_user->ID;
 
		/*
		* if post data exists, create the post duplicate
		*/
		if (isset( $post ) && $post != null) {
		
			/*
			* new post data array
			*/
			$args = array(
			'comment_status' => $post->comment_status,
			'ping_status' => $post->ping_status,
			'post_author' => $new_post_author,
			'post_content' => $post->post_content,
			'post_excerpt' => $post->post_excerpt,
			'post_name' => $post->post_name,
			'post_parent' => $post->post_parent,
			'post_password' => $post->post_password,
			'post_status' => 'publish',
			'post_title' => $post->post_title,
			'post_type' => $post->post_type,
			'to_ping' => $post->to_ping,
			'menu_order' => $post->menu_order
			);
 
			/*
			* insert the post by wp_insert_post() function
			*/
			$new_post_id = wp_insert_post( $args );
 
			/*
			* get all current post terms ad set them to the new post draft
			*/
			$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}
 
			/*
			* duplicate all post meta
			*/
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}	
			
			/*
			* finally, redirect to the edit post screen for the new draft
			*/
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
			exit;
			} else {
				wp_die('Duplicating Post failed, could not find original post: ' . $post_id);
			}
	}
	
	
	public function floating_content_customized_quick_edit() 
	{    
			
		global $current_screen;		
		if( 'edit-ct_afc' != $current_screen->id )
			return;
		?>
		<script type="text/javascript">         
			jQuery(document).ready( function($) {
				$('span:contains("Slug")').each(function (i) {
					$(this).parent().remove();
				});
				$('span:contains("Password")').each(function (i) {
					$(this).parent().parent().remove();
				});
				/*$('span:contains("Date")').each(function (i) {
					$(this).parent().remove();
				});*/
				$('.inline-edit-date').each(function (i) {
					$(this).remove();
				});
			});    
		</script>
		<?php
	}
	
	
	public function floating_content_columns($columns) {		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title','advanced-floating-content' ),
			'impressions' => __( 'Impressions','advanced-floating-content' ),
			'date' => __( 'Date','advanced-floating-content' )
		);	
		return $columns;
	}
	
	
	public function floating_content_columns_data( $column, $post_id ) {
		global $post;
	
		switch( $column ) {
	
			/* If displaying the 'impressions' column. */
			case 'impressions' :
	
				/* Get the post meta. */
				$impressions = get_post_meta( $post_id, 'ct_afc_impressions', true );
	
				/* If no impressions is found, output a default message. */
				if ( empty( $impressions ) )
					echo __( '0 impressions','advanced-floating-content' );
	
				/* If there is a impressions, append 'impressions' to the text string. */
				else
					printf( __( '%s impressions' ), $impressions );
	
				break;
			
	
			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}
	
	public function update_notice_status_javascript(){
        $html = '<script type="text/javascript">         
            jQuery(document).on( "click", "#afc_notice .notice-dismiss", function() {               
                data = { action: "update_notice_status", avalue: "1"};
                jQuery.post(ajaxurl, data, function(response){
                    //alert(response);
                });
            });
        </script>';        
        echo $html;
    }
    
    
    
	public function update_notice_status(){        
        update_option('hide_notice_advanced_floating_content', '1');        
        die();
    }
	
	public function floating_content_admin_notice(){        
        if(get_option('hide_notice_advanced_floating_content')==0) {
        ?>
        <div class="error settings-error notice is-dismissible" id="afc_notice">
        <div class="afc_banner">		

<div class="button_div"><a class="button" target="_blank" href="http://codecanyon.net/item/advanced-floating-content/9945856?ref=CodeTides">Rate now</a>
</div>		

<div class="text">If you like <strong>Advanced Floating Content</strong> please let the world know that you do. Thanks for your support!
    <br>
    <span>If you have questions, suggestions or something else that doesn't belong in a review, please <a href="mailto:contact@codetides.com">get in touch!</a></span>
</div>

	
</div>
            
    </div>
    <?php
        }
    }
    
    
    
    
   /*
        Add Settings Page
    */
    
    public function add_submenu_pages() {        
        add_submenu_page(
			'edit.php?post_type=ct_afc',			
			__( 'License Settings', 'advanced-floating-content' ),
			__( 'License Settings', 'advanced-floating-content' ),
			'manage_options',
            'license_settings_page',
			array($this,'display_settings_page')
		);
        
    }
    
    public function display_settings_page() {
        ?>
        <!-- Create a header in the default WordPress 'wrap' container -->
        <div class="wrap">			
            <h2><?php _e( 'Advanced Floating Content License Checker', 'advanced_floating_content' ); ?></h2>			
            <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
            <?php  settings_errors(); ?>
            <?php 
            
                $license_manager = new envatoAPI();
                $license_checker = $license_manager->initialize_license_checker(
                    //item id
                    isset($this->options['ct_afc_item_id']) ? "9945856":'',
                    // buyer email id
                    isset($this->options['ct_afc_email'])? $this->options['ct_afc_email']:'',                    
                    //buyer username
                    isset($this->options['ct_afc_user_name'])? $this->options['ct_afc_user_name']:'',
                    //buyer purchase code
                    isset($this->options['ct_afc_key'])? $this->options['ct_afc_key']:''
                );
               // print_r($license_checker);
                if($license_checker['type']=='success')
			    {
                    echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible below-h2"> 
<p>'.$license_checker['message'].'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                }
                else
                {
                    echo '<div id="setting-error-settings_updated" class="error settings-error notice is-dismissible below-h2"> 
<p>'.$license_checker['message'].'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                }
                
            ?>
            <!-- Create the form that will be used to render our options -->
            <form method="post" action="options.php">
                <?php settings_fields( 'ct_afc_options' ); ?>
                <?php do_settings_sections( 'ct_afc_options' ); ?>
                <?php submit_button(); ?>
            </form>
        </div><!-- /.wrap -->
        <?php
    }
    
      /**
     * Initialize settings page
     */
    public function initialize_afc_options(){

        // create plugin options if not exist
        if( false == $this->options ) {
            add_option( 'ct_afc_options' );
            add_option('verified_purchase', '0');
        }
		
		
		
		
        /**
         * Section
         */
		 
		 
		 
        add_settings_section(
            'ct_afc_license_fields',                                                       // ID used to identify this section and with which to register options
            __( 'Plugin License Key', 'advanced_floating_content'),                           // Title to be displayed on the administration page
            array( $this, 'ct_plugin_description'),                            // Callback used to render the description of the section
            'ct_afc_options'                                               // Page on which to add this section of options
        );
		
		/**
         * Fields
         */
        
        add_settings_field(
            'ct_afc_email',
            __( 'Email ID', 'advanced_floating_content' ),
            array( $this, 'text_option_field' ),
            'ct_afc_options',
            'ct_afc_license_fields',
            array(
				'id' => 'ct_afc_email',				
				'description' => __( 'Please enter your email id', 'advanced_floating_content' ),
				'class' =>'regular-text',
				'default'=>get_option( 'admin_email' )
			)			
        );
		add_settings_field(
            'ct_afc_user_name',
            __( 'Envato User Name', 'advanced_floating_content' ),
            array( $this, 'text_option_field' ),
            'ct_afc_options',
            'ct_afc_license_fields',
            array(
				'id' => 'ct_afc_user_name',				
				'description' => __( 'Please enter your envato username', 'advanced_floating_content' ),
				'class' =>'regular-text',
				'default'=>''
			)			
        ); 
		add_settings_field(
            'ct_afc_key',
            __( 'License key', 'advanced_floating_content' ),
            array( $this, 'text_option_field' ),
            'ct_afc_options',
            'ct_afc_license_fields',
            array(
				'id' => 'ct_afc_key',				
				'description' => __( 'Please enter your license key to validate', 'advanced_floating_content' ),
				'class' =>'regular-text',
				'default'=>''
			)
			
        );        
		add_settings_field(
            'ct_afc_get_key',
            __( 'Get Your License key', 'advanced_floating_content' ),
            array( $this, 'label_option_field' ),
            'ct_afc_options',
            'ct_afc_license_fields',
            array(
				'id' => 'ct_afc_get_key',				
				'description' => __( '<a href="'.$this->rest_plugin_info().'?ref=CodeTides" target="_blank" class="afc_ancher">Click here to get your license key</a>', 'advanced_floating_content' ),
				'class' =>'regular-text',
				'default'=>''
			)
			
        );
        
        add_settings_field(
            'ct_afc_item_id',
            __( '', 'advanced_floating_content' ),
            array( $this, 'hidden_option_field' ),
            'ct_afc_options',
            'ct_afc_license_fields',
            array(
				'id' => 'ct_afc_item_id',				
				'description' => '',
				'class' =>'regular-text',
				'default'=>'9945856'
			)
			
        );

        /**
         * Register Settings
         */
        register_setting( 'ct_afc_options', 'ct_afc_options' );
    }
    
    public function ct_plugin_description() {
        echo '<p>'. __( 'Insert your license information to enable plugin.', 'advanced_floating_content' ) . '</p>';
    }
	
	/**
     * Re-usable text options field for settings
     *
     * @param $args array   field arguments
     */
    public function text_option_field( $args ) {
        $field_id = $args['id'];
        if( $field_id ) {
            $val = ( isset( $this->options[ $field_id ] ) ) ? $this->options[ $field_id ] : $args['default'];
            echo '<input type="text" name="ct_afc_options['.$field_id.']" value="' . $val . '" class="'.$args['class'].'" >
			<br/>
            <label>'.$args['description'].'</label>';
        } else {
            _e( 'Field id is missing!', 'advanced_floating_content' );
        }
    }
    
    
    
    
	/**
     * Re-usable hidden options field for settings
     *
     * @param $args array   field arguments
     */
    public function hidden_option_field( $args ) {
        
        $field_id = $args['id'];
        if( $field_id ) {
            $val = ( isset( $this->options[ $field_id ] ) ) ? $this->options[ $field_id ] : $args['default'];
            echo '<input type="hidden" name="ct_afc_options['.$field_id.']" value="' . $val . '" class="'.$args['class'].'" >
			<br/>
            <label>'.$args['description'].'</label>';
        } else {
            _e( 'Field id is missing!', 'advanced_floating_content' );
        }
    }
    
    
    /**
     * Re-usable label field for settings
     *
     * @param $args array   field arguments
     */
    
    public function label_option_field( $args ) {
        $field_id = $args['id'];
        if( $field_id ) {
            echo '<label>'.$args['description'].'</label>';
        } else {
            _e( 'Field id is missing!', 'advanced_floating_content' );
        }
    }
	
	
	/**
     * Get Plugin Url
     *
     * @param $args array   field arguments
     */
	 
	 public function rest_plugin_info()
	 {
	 
	 	//$unparsed_json = file_get_contents("http://codetides.com/api/rest_product_api.php?p=Advanced%20Floating%20Content");
		//$json_object = json_decode($unparsed_json);
		return "http://codecanyon.net/item/advanced-floating-content/9945856";
	 }
	 
    /**
     * Get Plugin Url
     *
     * @param $args array   field arguments
     */
	 
	 public function rest_plugin_item_id()
	 {
	 
	 	//$unparsed_json = file_get_contents("http://codetides.com/api/rest_product_api.php?p=Advanced%20Floating%20Content");
		//$json_object = json_decode($unparsed_json);
		return "9945856";
	 }
    
    
    public function afc_admin_notice(){
        if(get_option( 'verified_purchase' )==1) {
        ?>
        <div class="error settings-error notice is-dismissible ">
        <p>Hows going your experince with Advanced Floating Content, If you like the plugin then get your license to work this plugin properly. <a href="<?php echo $this->rest_plugin_info();?>?ref=codetides" class="learnmore button">Learn More</a><a href="<?php echo $this->rest_plugin_info();?>?ref=codetides" class="buynow button">Buy Now</a></p>
    </div>
    <?php
        }
    }
    
}
