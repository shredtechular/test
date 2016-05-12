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
        <label for="bafckground_color"><?php _e('Position','advanced-floating-content')?></label>
        <select style="width:22%;" name="ct_afc_position_place" id="ct_afc_position_place">
                <?php
                    $options = array('fixed'=>'Fixed','absolute'=>'Absolute');
                    foreach($options as $key => $value) { 
                    ?>
                    <option value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_position_place','fixed')) {?> selected="selected" <?php } ?>><?php echo $value;?></option>
                    <?php } ?>
            </select>
        <select style="width:22%;" name="ct_afc_position_y" id="ct_afc_position_y">
                <?php
                    $options = array('top'=>'Top','bottom'=>'Bottom');
                    foreach($options as $key => $value) { 
                    ?>
                    <option value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_position_y','yes')) {?> selected="selected" <?php } ?>><?php echo $value;?></option>
                    <?php } ?>
            </select>
           <select style="width:22%;" name="ct_afc_position_x" id="ct_afc_position_x">
                <?php
                    $options = array('left'=>'Left','right'=>'Right');
                    foreach($options as $key => $value) { 
                ?>
                <option value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_position_x','yes')) {?> selected="selected" <?php } ?>><?php echo $value;?></option>
                <?php } ?>
            </select>     
        
    </div>
    <div class="afc-panel-div">
        <label for="margin"><?php _e('Margin','advanced-floating-content')?></label>
        <div class="control-input">
            <span>
                <input type="text" name="ct_afc_margin_top" id="ct_afc_margin_top" value="<?php echo get_text_value(get_the_ID(),'ct_afc_margin_top',0)?>" class="" style="width:34%;">
                <label>Top</label>
            </span>
            <span>
                <input type="text" name="ct_afc_margin_right" id="ct_afc_margin_right" value="<?php echo get_text_value(get_the_ID(),'ct_afc_margin_right',0)?>" class="" style="width:34%;">
                <label>Right</label>
            </span>
            <span>
            <input type="text" name="ct_afc_margin_bottom" id="ct_afc_margin_bottom" value="<?php echo get_text_value(get_the_ID(),'ct_afc_margin_bottom',0)?>" class="" style="width:34%;">
                <label>Bottom</label>                
            </span>
            <span>    
            <input type="text" name="ct_afc_margin_left" id="ct_afc_margin_left" value="<?php echo get_text_value(get_the_ID(),'ct_afc_margin_left',0)?>" class="" style="width:34%;">
                <label>Left</label>
            </span>
        </div>            
    </div>
    
    
</div>
<div id="advanced-floating-content-meta-box-nonce" class="hidden">
  <?php wp_nonce_field( 'advanced_floating_content_save', 'advanced_floating_content_nonce' ); ?>
</div>