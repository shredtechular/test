<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.codetides.com/
 * @since      3.0
 *
 * @package    Advanced_Floating_Content
 * @subpackage Advanced_Floating_Content/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      3.0
 * @package    Advanced_Floating_Content
 * @subpackage Advanced_Floating_Content/includes
 * @author     Code Tides <contact@codetides.com>
 */
class Advanced_Floating_Content_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {       

	}
    
    public static function upgrade_old_to_new_version(){
        global $wpdb;
        $table = $wpdb->prefix . 'afc';
        $table_backup = $wpdb->prefix . 'afc_backup';
        update_option('hide_notice_advanced_floating_content', '0');
        
        
        
        $qry_backup = "CREATE TABLE `".$table_backup."` LIKE `".$table."`";
        $execute = $wpdb->query($qry_backup);  
        
        $qry_backup = "INSERT INTO `$table_backup` SELECT * from `$table`";
        $execute = $wpdb->query($qry_backup);  
        
        
        $qry = 'select 1 from '.$table.' LIMIT 1';
        $data = $wpdb->get_row($qry, ARRAY_A);
        if($data !== FALSE)
        {
           $qry_all = "SELECT * FROM `".$table."` where 1=1 and afc_status=1 order by id_afc desc";
	       $results = $wpdb->get_results($qry_all, ARRAY_A);
           global $user_ID;
           foreach($results as $data) {
               $new_post = array(
                                'post_title' => $data['afc_title'],
                                'post_content' => $data['afc_content'],
                                'post_status' => 'publish',
                                'post_date' => date('Y-m-d H:i:s'),
                                'post_author' => $user_ID,
                                'post_type' => 'ct_afc'
                            );
                $post_id = wp_insert_post($new_post);
               
                $meta_key="ct_afc_css";
                $new_meta_value=$data['afc_css'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
                
                $meta_key="ct_afc_css_mobile";
                $new_meta_value=$data['afc_css_mobile'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_position_place";
                $new_meta_value=$data['afc_position_content'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_position_y";
                $new_meta_value=$data['afc_position_y'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_position_x";
                $new_meta_value=$data['afc_position_x'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_margin_top";
                $new_meta_value=$data['afc_margin_top'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_margin_bottom";
                $new_meta_value=$data['afc_margin_bottom'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_margin_right";
                $new_meta_value=$data['afc_margin_right'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_margin_left";
                $new_meta_value=$data['afc_margin_left'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );  
               
                $meta_key="ct_afc_close_button";
                $new_meta_value=$data['afc_close'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_width";
                $new_meta_value=$data['afc_width'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_width_unit";
                $new_meta_value=$data['afc_width_unit'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_padding_top";
                $new_meta_value=0;
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_padding_right";
                $new_meta_value=0;
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_padding_bottom";
                $new_meta_value=0;
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_padding_left";
                $new_meta_value=0;
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_background_color";
                $new_meta_value="#".$data['afc_bg_color'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
               
                $px_border = explode(',',$data['afc_border_pixels']);
               
                $meta_key="ct_afc_border_top";
                $new_meta_value=$px_border[0];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_border_right";
                $new_meta_value=$px_border[3];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_border_bottom";
                $new_meta_value=$px_border[1];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_border_left";
                $new_meta_value=$px_border[2];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
               
                $type_border = explode(',',$data['afc_border_type']);
			    $color_border = explode(',',$data['afc_border_color']);
			    $round_border = explode(',',$data['afc_border_rounded']);
               
                $meta_key="ct_afc_border_type";
                $new_meta_value=$type_border[0];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_border_color";
                $new_meta_value="#".$color_border[0];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_border_radius";
                $new_meta_value=$round_border[0];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
               
               
                $meta_key="ct_afc_show_on_homepage";
                $new_meta_value=$data['afc_cpts_home'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_show_on_posts";
                $new_meta_value=$data['afc_cpts_posts'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_selective_posts";
                $new_meta_value=$data['afc_slected_posts'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_show_on_pages";
                $new_meta_value=$data['afc_cpts_pages'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_selective_pages";
                $new_meta_value=$data['afc_slected_pages'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
               
                $meta_key="ct_afc_show_on_categories";
                $new_meta_value=$data['afc_cpts_category'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_selective_categories";
                $new_meta_value=$data['afc_slected_category'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_show_on_cpts";
                $new_meta_value=$data['afc_cpts_cpts'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_selective_cpts";
                $new_meta_value=$data['afc_slected_cpts'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_show_on_wooCommerce";
                $new_meta_value=$data['afc_cpts_woocommerce'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_selective_woocommerce";
                $new_meta_value=$data['afc_slected_woocommerce'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_control_impression";
                $new_meta_value=$data['afc_impression_control'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_control_devices";
                $new_meta_value=$data['afc_control_devices'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_certain_height";
                $new_meta_value=$data['afc_certain_height'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
                $meta_key="ct_afc_certain_width";
                $new_meta_value=$data['afc_certain_width'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
               
                $meta_key="ct_afc_impressions";
                $new_meta_value=$data['afc_impression'];
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );
               
               
               $dsql = "DELETE FROM `".$table."` where id_afc = ".(int) $data['id_afc'];				
                if($wpdb->query($dsql) === FALSE)
                {			
                    
                }
                else
                {
                    			
                }
               
               
           }
            
             
            
            
            
            
        }
        else
        {
            
        }
        
    }
}
