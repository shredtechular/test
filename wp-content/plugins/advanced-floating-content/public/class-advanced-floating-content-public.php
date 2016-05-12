<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.codetides.com/
 * @since      3.0.3
 *
 * @package    Advanced_Floating_Content
 * @subpackage Advanced_Floating_Content/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Floating_Content
 * @subpackage Advanced_Floating_Content/public
 * @author     Code Tides <contact@codetides.com>
 */
class Advanced_Floating_Content_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-floating-content-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-floating-content-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/*
	* Display Floating Content
	*/
	public function load_floating_content()
	{
        global $wpdb;
        if(is_home() || is_front_page()){              
            
            $args = array(
                'posts_per_page' => -1,
                    'post_type'     => 'ct_afc',
                    'post_status'   => 'publish',
                    'meta_query' => array(
                        array(
                            'key' => 'ct_afc_show_on_homepage',
                            'value' => "1",
                            'compare' => '='
                        )
                    )
                );
          $posts =   get_posts($args);
        }  
        if(is_search()){
            
            $args = array(
                'posts_per_page' => -1,
                    'post_type'     => 'ct_afc',
                    'post_status'   => 'publish',
                    'meta_query' => array(
                        array(
                            'key' => 'ct_afc_show_on_search',
                            'value' => "1",
                            'compare' => '='
                        )
                    )
                );
          $posts =   get_posts($args);
        }
        if(is_single()){            
            $id_post = get_the_ID();
        
            
            $search = ':"'.$id_post.'";';
            $args = array(
                'posts_per_page' => -1,
                    'post_type'     => 'ct_afc',
                    'post_status'   => 'publish',
                    'meta_query' => array(                      
                        'relation' => 'OR', 
                        array(
                            'key' => 'ct_afc_show_on_posts',
                            'value' => "1",
                            'compare' => '='
                        ),
                        array(
                            'key' => 'ct_afc_selective_posts',
                            'value' => $search,
                            'compare' => 'LIKE'
                        )
                    )
                );          
            
          $posts =   get_posts($args);
          
        }
        if(is_page()) {
            $id_page = get_the_ID();          
            
            $search = ':"'.$id_page.'";';
            $args = array(
                'posts_per_page' => -1,
                    'post_type'     => 'ct_afc',
                    'post_status'   => 'publish',
                    'meta_query' => array(                      
                        'relation' => 'OR', 
                        array(
                            'key' => 'ct_afc_show_on_pages',
                            'value' => "1",
                            'compare' => '='
                        ),
                        array(
                            'key' => 'ct_afc_selective_pages',
                            'value' => $search,
                            'compare' => 'LIKE'
                        )
                    )
                );
            
            
          $posts = get_posts($args);
            
       
             
        }
        if(is_category()){
		  $id_cat = the_category_ID($echo = false);            
		  
            $search = ':"'.$id_cat.'";';
            $args = array(
                'posts_per_page' => -1,
                    'post_type'     => 'ct_afc',
                    'post_status'   => 'publish',
                    'meta_query' => array(                      
                        'relation' => 'OR', 
                        array(
                            'key' => 'ct_afc_show_on_categories',
                            'value' => "1",
                            'compare' => '='
                        ),
                        array(
                            'key' => 'ct_afc_selective_categories',
                            'value' => $search,
                            'compare' => 'LIKE'
                        )
                    )
                );
            $posts =   get_posts($args);
           
	   }
        
        $builtin_cpts = array('post','page','attachment','revision','nav_menu_item','product');
        $post_type = get_post_type( get_the_ID() );
        $is_cpts="";
        if(!in_array($post_type, $builtin_cpts) && $post_type!="")
        {
            $is_cpts = 1;
        }
        if($is_cpts == 1){
            
            
            $search = ':"'.$post_type.'";';
            $args = array(
                'posts_per_page' => -1,
                    'post_type'     => 'ct_afc',
                    'post_status'   => 'publish',
                    'meta_query' => array(                      
                        'relation' => 'OR', 
                        array(
                            'key' => 'ct_afc_show_on_cpts',
                            'value' => "1",
                            'compare' => '='
                        ),
                        array(
                            'key' => 'ct_afc_selective_cpts',
                            'value' => $search,
                            'compare' => 'LIKE'
                        )
                    )
                );
            $posts =   get_posts($args);            
            
        } 
        $post_type = get_post_type( get_the_ID() );
        if($post_type=="product") {
            if($id_post == "") $id_post = get_the_ID();
            
            $search = ':"'.$id_post.'";';
            $args = array(
                'posts_per_page' => -1,
                    'post_type'     => 'ct_afc',
                    'post_status'   => 'publish',
                    'meta_query' => array(                      
                        'relation' => 'OR', 
                        array(
                            'key' => 'ct_afc_show_on_wooCommerce',
                            'value' => "1",
                            'compare' => '='
                        ),
                        array(
                            'key' => 'ct_afc_selective_woocommerce',
                            'value' => $search,
                            'compare' => 'LIKE'
                        )
                    )
                );
            $posts = get_posts($args);                    
        }
        
        if(!$posts){
            return;
        }
        
        foreach($posts as $post)
        {
          
            $impressions = get_post_meta( $post->ID, 'ct_afc_impressions', true );
	        
				/* If no impressions is found, output a default message. */
				if ( empty( $impressions ) )
					$impressions = 1;
                else
                    $impressions = $impressions + 1;
                
            update_post_meta($post->ID, 'ct_afc_impressions', $impressions);
            
            $meta_ips = get_post_meta($post->ID, "ip_control_impressions");
             
            $ip = $this->get_ip();
            $ctr_imp = ""; 
              if ( count( $meta_ips ) != 0 ) {
                $ctr_imp = $meta_ips[0];
              }               
              if ( !is_array( $ctr_imp ) )
                $ctr_imp = array();
              if ( array_key_exists( $ip, $ctr_imp ) ) 
                  continue ;

            
            if(get_post_meta( $post->ID, 'ct_afc_control_impression', true )=="0"){$cdata = 'data="'.$post->ID.'"';} else {$cdata ="";}
            $out="";
            $out .='
            <div class="advanced_floating_content" id="advanced_floating_content_'.$post->ID.'" '.$cdata.'>';
                if( get_post_meta( $post->ID, 'ct_afc_close_button', true ) =="yes" ) {
                $out .='<div class="floating_content_close_button">                
                    <a href="javascript:void(0);"><img src="'.plugin_dir_url( __FILE__ ).'images/advanced_floating_close_button.png" /></a>
                </div>';
                }
                $out .='<div class="floating_content_full_details">
                '.$this->do_shortcode_output($post->post_content).'
                </div>                            
            </div>'."\n";
            $out .='<style type="text/css">'.$this->floating_content_styling($post->ID).'
                    </style>'."\n";
            $out .='<script type="text/javascript">
                (function ($) {
		          '.$this->hide_on_certain_width($post->ID).$this->jQuery_control_impressions($post->ID).$this->display_on_certain_height($post->ID).'
                })(jQuery);            
                    </script>'."\n";
            
        } 
        echo $out;
      
        
	}
	
	
	public function floating_content_styling($id_afc) {
		          $margin = get_post_meta( $id_afc, 'ct_afc_margin_top', true ).'px '.get_post_meta( $id_afc, 'ct_afc_margin_right', true ).'px '.get_post_meta( $id_afc, 'ct_afc_margin_bottom', true ).'px '.get_post_meta( $id_afc, 'ct_afc_margin_left', true ).'px';
                  
                  $padding = get_post_meta( $id_afc, 'ct_afc_padding_top', true ).'px '.get_post_meta( $id_afc, 'ct_afc_padding_right', true ).'px '.get_post_meta( $id_afc, 'ct_afc_padding_bottom', true ).'px '.get_post_meta( $id_afc, 'ct_afc_padding_left', true ).'px';
                  
                  $border = get_post_meta( $id_afc, 'ct_afc_border_top', true ).'px '.get_post_meta( $id_afc, 'ct_afc_border_right', true ).'px '.get_post_meta( $id_afc, 'ct_afc_border_bottom', true ).'px '.get_post_meta( $id_afc, 'ct_afc_border_left', true ).'px';
        
        
                  $position_y = get_post_meta( $id_afc, 'ct_afc_position_y', true );
				  $position_x = get_post_meta( $id_afc, 'ct_afc_position_x', true );
        
        
                  $styling = "#advanced_floating_content_".$id_afc."{";
                  if(get_post_meta( $id_afc, 'ct_afc_show_on_certain_height', true )=="1") {        
			         $styling .="display:none;";
                  }
		          $styling .="width:".get_post_meta( $id_afc, 'ct_afc_width', true ).get_post_meta( $id_afc, 'ct_afc_width_unit', true ).";";          
                  $styling .="background:".get_post_meta( $id_afc, 'ct_afc_background_color', true ).";";
                  $styling .="position:".get_post_meta( $id_afc, 'ct_afc_position_place', true ).";";   
                  $styling .="margin:".$margin.';';
                  $styling .="padding:".$padding.';';
                  $styling .="z-index:999999;";
                  if($position_y=="top") {
					$styling .="top:0px;";
					}
					if($position_y=="bottom") {
					$styling .="bottom:0px;";
					}
					if($position_x=="left") {
					$styling .="left:0px;";
					}
					if($position_x=="right") {
					$styling .="right:0px;";
					}
                    $styling .="border-style: ".get_post_meta( $id_afc, 'ct_afc_border_type', true ).";";
                    $styling .="border-width: ".$border.";";
                    $styling .="border-color: ".get_post_meta( $id_afc, 'ct_afc_border_color', true ).";";
                    if(get_post_meta( $id_afc, 'ct_afc_border_radius', true )==1)
                    {
                        $styling .="border-radius:".get_post_meta( $id_afc, 'ct_afc_border_radius_size', true )."px;";
                        $styling .="-moz-border-radius:".get_post_meta( $id_afc, 'ct_afc_border_radius_size', true )."px;";
                        $styling .="-webkit-border-radius:".get_post_meta( $id_afc, 'ct_afc_border_radius_size', true )."px;";
                    }
                  $styling .="font-size:".get_post_meta( $id_afc, 'ct_afc_font_size', true )."px;";
                  $styling .="color:".get_post_meta( $id_afc, 'ct_afc_font_color', true )."";
                  $styling .= "}"."\n";
                    
                $styling .="#advanced_floating_content_".$id_afc." .floating_content_close_button{position:absolute; top:0px; right:0px; height: 25px; width: 25px; background:".get_post_meta( $id_afc, 'ct_afc_border_color', true ).";}"."\n".".floating_content_close_button a{display:block;margin-top:-1px;}.floating_content_close_button a img{/*margin-top:-6px !important;*/}.advanced_floating_content iframe{width:100% !important;}"."\n";
        
                $styling .= get_post_meta( $id_afc, 'ct_afc_css', true )."\n";
                $styling .= $this->floating_content_responsive($id_afc);
					return $styling;
	}
	
	public function do_shortcode_output($content) {
	  global $shortcode_tags;
	
	  if ( false === strpos( $content, '[' ) ) {
		return $content;
	  }
	
	  if (empty($shortcode_tags) || !is_array($shortcode_tags))
		return $content;
	
	  $pattern = get_shortcode_regex();
	  return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $content );
	}
    
    public function floating_content_responsive($id_afc){
        if(get_post_meta( $id_afc, 'ct_afc_control_devices', true )==1){
            $responsive_css = '@media only screen and (min-device-width: 0px) and (max-device-width: 720px) {'."\n".'#advanced_floating_content_'.$id_afc.'{width:100% !important;}'."\n".'}';
        }
        if(get_post_meta( $id_afc, 'ct_afc_control_devices', true )==2){
           $useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
            $responsive_css = '@media only screen and (min-device-width: 0px) and (max-device-width: 720px) {'."\n";
            $responsive_css .= "#advanced_floating_content_".$id_afc."{";
			$responsive_css .= "display:none !important";
			$responsive_css .="}"."\n";            
            $responsive_css .="}"."\n";            
}
        }
        
        return $responsive_css;
        
    }
    
    public function jQuery_control_impressions($id_afc){
        if( get_post_meta( $id_afc, 'ct_afc_close_button', true ) =="yes" ) {
        $control_impressions = '$(".floating_content_close_button a").click(function(){
            var attr = jQuery(this).closest("div").parent().attr("data");
            jQuery.post("'.site_url().'/wp-admin/admin-ajax.php", 
                {
                    action:"controlImpressions",
                    data:attr
                }, 
                function(response){
                   
                });
            
			$("#advanced_floating_content_'.$id_afc.'").hide();
            
		});';
            return $control_impressions;
        }
    }
    
	 public function hide_on_certain_width($id_afc){
         if(get_post_meta( $id_afc, 'ct_afc_control_devices', true )=="3") {                
                 $jquery_hide = '  
                 jQuery(window).resize(function() {
  if (jQuery(this).width() < '.get_post_meta( $id_afc, 'ct_afc_certain_width', true ).') {

    jQuery("#advanced_floating_content_'.$id_afc.'").hide();

  } else {

    jQuery("#advanced_floating_content_'.$id_afc.'").show();

    }

});';            
         return $jquery_hide;}
     }
    
    public function display_on_certain_height($id_afc){
        $jquery_show="";
        if(get_post_meta( $id_afc, 'ct_afc_show_on_certain_height', true )=="1") {        			
                $jquery_show .= "\n".'jQuery(document).scroll(function () {
    var y = jQuery(this).scrollTop();   
    if (y > '.get_post_meta( $id_afc, 'ct_afc_certain_height', true ).') {
        jQuery("#advanced_floating_content_'.$id_afc.'").fadeIn();
    } else {
        jQuery("#advanced_floating_content_'.$id_afc.'").fadeOut();
    }
});';
			}
        return $jquery_show;
    }
    
    
   public function controlImpressions() {
		extract($_POST);        
		$ip = $this->get_ip();
        $post_id = $data;
        $meta_IP = get_post_meta($post_id, "ip_control_impressions",true);
        $ctr_imp_IP = $meta_IP;
       
        if(!is_array($ctr_imp_IP))
            $ctr_imp_IP = array();
        
       $ctr_imp_IP[$ip] = time();        
        update_post_meta($post_id, "ip_control_impressions", $ctr_imp_IP);      
        
		die;
	}
    
    public function get_ip() {
        if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
        }
       // $ip = filter_var( $ip, FILTER_VALIDATE_IP );
        $ip = ( $ip === false ) ? '0.0.0.0' : $ip;
        return $ip;
    } // sl_get_ip()
}
