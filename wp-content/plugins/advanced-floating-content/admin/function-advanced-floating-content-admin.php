<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.codetides.com/
 * @since      3.0
 *
 * @package    Advanced Floating Content
 * @subpackage /admin/functions
 */
 
 		
	function get_text_value($id, $input_name, $default_value='')
	{
		if(get_post_meta( $id, $input_name, true )!="")
			return get_post_meta( $id, $input_name, true );
		else
			return $default_value;
	}	
	function get_checkbox_value($id, $input_name)
	{
		if(get_post_meta( $id, $input_name, true )!="")
			return 'checked="checked"';
		else
			return "";
	}	
	function get_all_posts($id, $input_name)
	{
		$all_posts = get_posts( array('post_status'=>'publish','orderby'=>'post_title','posts_per_page'=> -1));
		$selected_posts = get_post_meta( $id, $input_name, true );
        if(empty($selected_posts)) $select='selected="selected"';
		$output = '<select name="'.$input_name.'[]" id="'.$input_name.'" multiple="multiple" style="width:75%; height:150px;">';		
        $output .= '<option value="" '.$select.'>Please Select Post(s)</option>';
			foreach ( $all_posts as $post ) {
				if(@in_array($post->ID, $selected_posts)) { $selected = 'selected="selected"'; }else {$selected = '';}
				$output .= '<option value="'.$post->ID.'" '.$selected.'>'.$post->post_title.'</option>';		
			}
		$output .= '</select>';
		return $output;
	}
	function get_all_pages($id, $input_name)
	{
		$all_pages = get_pages( array('post_status'=>'publish','post_type' => 'page','sort_column' => 'post_title','posts_per_page'=> -1));
		$selected_pages = get_post_meta( $id, $input_name, true );		        
		$output = '<select name="'.$input_name.'[]" id="'.$input_name.'" multiple="multiple" style="width:75%; height:150px;">';
        if(empty($selected_pages)) $select='selected="selected"';
        $output .= '<option value="" '.$select.'>Please Select Page(s)</option>';
			foreach ( $all_pages as $page ) {
				if(@in_array($page->ID, $selected_pages)) { $selected = 'selected="selected"'; } else {$selected = '';}
				$output .= '<option value="'.$page->ID.'" '.$selected.'>'.$page->post_title.'</option>';		
			}
		$output .= '</select>';
		return $output;
	}
	function get_all_categories($id, $input_name)
	{
		$all_categories = get_categories( array('orderby'=>'name','taxonomy'=>'category'));
		$selected_categories = get_post_meta( $id, $input_name, true );		
         if(empty($selected_categories)) $select='selected="selected"';
		$output = '<select name="'.$input_name.'[]" id="'.$input_name.'" multiple="multiple" style="width:75%; height:150px;">';	
        $output .= '<option value="" '.$select.'>Please Select Categories</option>';
			foreach ( $all_categories as $category ) {
				if(@in_array($category->cat_ID, $selected_categories)) { $selected = 'selected="selected"'; }else {$selected = '';}
				$output .= '<option value="'.$category->cat_ID.'" '.$selected.'>'.$category->cat_name.'</option>';		
			}
		$output .= '</select>';
		return $output;
	}
	function get_all_cpts($id, $input_name)
	{
		$args = array(
		   'public'   => true,
		   '_builtin' => false
		);
		$output = 'names'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'
		$all_cpts = get_post_types($args, $output, $operator );		
		$selected_cpts = get_post_meta( $id, $input_name, true );
        if(empty($selected_cpts)) $select='selected="selected"';
		$output = '<select name="'.$input_name.'[]" id="'.$input_name.'" multiple="multiple" style="width:75%; height:150px;">';
        $output .= '<option value="" '.$select.'>Please Select Custom Post Types</option>';
			foreach ( $all_cpts as $cpts ) {
				if(@in_array($cpts, $selected_cpts)) { $selected = 'selected="selected"'; }else {$selected = '';}
				$output .= '<option value="'.$cpts.'" '.$selected.'>'.$cpts.'</option>';
			}
		$output .= '</select>';
		return $output;
		
	}
	function get_all_woocommerce($id, $input_name)
	{
		$all_woocommerce = get_posts( array('post_status'=>'publish','post_type' => 'product','sort_column' => 'post_title','posts_per_page'=> -1));
		$selected_woo = get_post_meta( $id, $input_name, true );
        if(empty($selected_woo)) $select='selected="selected"';
		$output = '<select name="'.$input_name.'[]" id="'.$input_name.'" multiple="multiple" style="width:75%; height:150px;">';
        $output .= '<option value="" '.$select.'>Please Select WooCommerce Products</option>';
			foreach ( $all_woocommerce as $woo ) {
				if(@in_array($woo, $selected_woo)) { $selected = 'selected="selected"'; }else {$selected = '';}
				$output .= '<option value="'.$woo->ID.'" '.$selected.'>'.$woo->post_title.'</option>';
			}
		$output .= '</select>';
		return $output;
		
	}
?>