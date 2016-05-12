<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-fafcing aspects of the plugin.
 *
 * @link       http://www.codetides.com/
 * @since      3.0
 *
 * @pafckage    Advanced_Floating_Content
 * @subpafckage Advanced_Floating_Content/admin/views
 */
?>
<div class="afc-panel">	
	<div class="afc-panel-div">
        <label for="width"><?php _e('Show on HomePage','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '1'=>'Yes',
                    '0'=>'No'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_show_on_homepage" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_show_on_homepage','1')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>        
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Show on Search Page','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '1'=>'Yes',
                    '0'=>'No'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_show_on_search" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_show_on_search','1')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>        
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Show on Posts','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '1'=>'All Posts',
                    '0'=>'Only Selected Posts'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_show_on_posts" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_show_on_posts','1')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>
    </div>
    <div class="afc-panel-div" id="selective_posts" style=" <?php if(get_text_value(get_the_ID(),'ct_afc_show_on_posts','1')==0) {echo "display:block;";} ?>">
        <label for="width">&nbsp;</label>
        <div class="control-select">
         <?php              
			  echo get_all_posts(get_the_ID(),'ct_afc_selective_posts');
		?>	  
        </div>
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Show on Pages','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '1'=>'All Pages',
                    '0'=>'Only Selected Pages'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_show_on_pages" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_show_on_pages','1')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>        
    </div>
    <div class="afc-panel-div" id="selective_pages" style=" <?php if(get_text_value(get_the_ID(),'ct_afc_show_on_pages','1')==0) {echo "display:block;";} ?>">
        <label for="width">&nbsp;</label>
        <div class="control-select">
         <?php              
			  echo get_all_pages(get_the_ID(),'ct_afc_selective_pages');
		?>	  
        </div>
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Show on Categories','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '1'=>'All Categories',
                    '0'=>'Only Selected Categories'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_show_on_categories" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_show_on_categories','1')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>        
    </div>
    <div class="afc-panel-div" id="selective_categories" style=" <?php if(get_text_value(get_the_ID(),'ct_afc_show_on_categories','1')==0) {echo "display:block;";} ?>">
        <label for="width">&nbsp;</label>
        <div class="control-select">
         <?php              
			  echo get_all_categories(get_the_ID(),'ct_afc_selective_categories');
		?>	  
        </div>
    </div>
    
    <div class="afc-panel-div">
        <label for="width"><?php _e('Show on Custom Post Types','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '1'=>'All Custom Post Types',
                    '0'=>'Only Selected Custom Post Types'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_show_on_cpts" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_show_on_cpts','1')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>        
    </div>
    <div class="afc-panel-div" id="selective_cpts" style=" <?php if(get_text_value(get_the_ID(),'ct_afc_show_on_cpts','1')==0) {echo "display:block;";} ?>">
        <label for="width">&nbsp;</label>
        <div class="control-select">
         <?php              
			  echo get_all_cpts(get_the_ID(),'ct_afc_selective_cpts');
		?>	  
        </div>
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Show on WooCommerce','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '1'=>'All WooCommerce Products',
                    '0'=>'Only Selected WooCommerce Products'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_show_on_wooCommerce" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_show_on_wooCommerce','1')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>        
    </div>
    <div class="afc-panel-div" id="selective_wooCommerce" style=" <?php if(get_text_value(get_the_ID(),'ct_afc_show_on_wooCommerce','1')==0) {echo "display:block;";} ?>">
        <label for="width">&nbsp;</label>
        <div class="control-select">
         <?php              
			  echo get_all_woocommerce(get_the_ID(),'ct_afc_selective_woocommerce');
		?>	  
        </div>
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Show on Certain Height','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '0'=>'No Display Normally',
                    '1'=>'Yes Display on Certain Height'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_show_on_certain_height" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_show_on_certain_height','0')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>        
    </div>
    <div class="afc-panel-div" id="certain_height_area" style=" <?php if(get_text_value(get_the_ID(),'ct_afc_show_on_certain_height','0')==1) {echo "display:block;";} ?>">
        <label for="width">&nbsp;</label>
        <input type="text" name="ct_afc_certain_height" id="ct_afc_certain_height" value="<?php echo get_text_value(get_the_ID(),'ct_afc_certain_height',0)?>" class="" style="width:34%;"> px
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Control Impression','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '0'=>'Yes',
                    '1'=>'No'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_control_impression" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_control_impression','1')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>        
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Control Other Devices','advanced-floating-content')?></label>
        <div class="control-radio">
         <?php
                $options = array(
                    '1'=>'Responsive',
                    '2'=>'Hide on Mobile Devices',
                    '3'=>'Hide on Certain Width'
                );
                foreach($options as $key => $value) { 
                ?>
                <label><input type="radio" name="ct_afc_control_devices" value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_control_devices','1')) {?> checked="checked" <?php } ?> /><?php echo $value;?></label>
                <?php } ?>
        </div>        
    </div>
    <div class="afc-panel-div" id="certain_width_area" style=" <?php if(get_text_value(get_the_ID(),'ct_afc_control_devices','1')==3) {echo "display:block;";} ?>">
        <label for="width">&nbsp;</label>
        <input type="text" name="ct_afc_certain_width" id="ct_afc_certain_width" value="<?php echo get_text_value(get_the_ID(),'ct_afc_certain_width',0)?>" class="" style="width:34%;"> px
    </div>
</div>