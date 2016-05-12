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
        <label for="width"><?php _e('Custom CSS','advanced-floating-content')?></label>
        <div class="control-input">
        	<textarea class="" id="ct_afc_css" name="ct_afc_css" rows="10" cols="10"><?php echo get_text_value(get_the_ID(),'ct_afc_css','')?></textarea>          
        </div>        
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Custom Mobile CSS','advanced-floating-content')?></label>
        <div class="control-input">
        	<textarea class="" id="ct_afc_css_mobile" name="ct_afc_css_mobile" rows="10" cols="10"><?php echo get_text_value(get_the_ID(),'ct_afc_css_mobile','')?></textarea>          
        </div>        
    </div>	      
</div>