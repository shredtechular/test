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
        <label for="button"><?php _e('Show Close Button','advanced-floating-content')?></label>
        <select style="width:71.1%;" name="ct_afc_close_button" id="ct_afc_close_button">
                <?php
                $options = array(
                    'yes'=>'Yes',
                    'no'=>'No'
                );
                foreach($options as $key => $value) { 
                ?>
                <option value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_close_button','yes')) {?> selected="selected" <?php } ?>><?php echo $value;?></option>
                <?php } ?>
            </select>
    </div>
    <div class="afc-panel-div">
        <label for="width"><?php _e('Width','advanced-floating-content')?></label>
        <div class="control-input">
            <input type="text" name="ct_afc_width" id="ct_afc_width" value="<?php echo get_text_value(get_the_ID(),'ct_afc_width',260)?>" class="" style="width:61.4%;">
            <select style="width:30%;" name="ct_afc_width_unit" id="ct_afc_width_unit">
                <?php
                $options = array(
                    'px'=>'Pixels',
                    '%'=>'Percentage'
                );
                foreach($options as $key => $value) { 
                ?>
                <option value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_width_unit','px')) {?> selected="selected" <?php } ?>><?php echo $value;?></option>
                <?php } ?>
            </select>
        </div>        
    </div> 
    <div class="afc-panel-div">
        <label for="border"><?php _e('Padding','advanced-floating-content')?></label>
        <div class="control-input">
            <input type="text" name="ct_afc_padding_top" id="ct_afc_padding_top" value="<?php echo get_text_value(get_the_ID(),'ct_afc_padding_top',3)?>" placeholder="Top Padding" style="width:21%;">
            <input type="text" name="ct_afc_padding_right" placeholder="Right Padding" id="ct_afc_padding_right" value="<?php echo get_text_value(get_the_ID(),'ct_afc_padding_right',0)?>" style="width:21%;">
            <input type="text" name="ct_afc_padding_bottom" placeholder="Bottom Padding" id="ct_afc_padding_bottom" value="<?php echo get_text_value(get_the_ID(),'ct_afc_padding_bottom',0)?>" style="width:21%;">
            <input type="text" name="ct_afc_padding_left" placeholder="Left Padding" id="ct_afc_padding_left" value="<?php echo get_text_value(get_the_ID(),'ct_afc_padding_left',0)?>" style="width:21.3%;">
        </div>            
    </div>        
    <div class="afc-panel-div">
        <label for="border"><?php _e('Border','advanced-floating-content')?></label>
        <div class="control-input">
            <input type="text" name="ct_afc_border_top" placeholder="Top Border" id="ct_afc_border_top" value="<?php echo get_text_value(get_the_ID(),'ct_afc_border_top',3)?>" style="width:21%;">
            <input type="text" name="ct_afc_border_right" placeholder="Right Border" id="ct_afc_border_right" value="<?php echo get_text_value(get_the_ID(),'ct_afc_border_right',0)?>" style="width:21%;">
            <input type="text" name="ct_afc_border_bottom" placeholder="Bottom Border" id="ct_afc_border_bottom" value="<?php echo get_text_value(get_the_ID(),'ct_afc_border_bottom',0)?>" style="width:21%;">
            <input type="text" name="ct_afc_border_left" placeholder="Left Border" id="ct_afc_border_left" value="<?php echo get_text_value(get_the_ID(),'ct_afc_border_left',0)?>" style="width:21.3%;">
        </div>            
    </div>
    <div class="afc-panel-div">
        <label for="border_properties"><?php _e('Border Properties','advanced-floating-content')?></label>
        <div class="control-input">
            <select style="width:35%;" name="ct_afc_border_type" id="ct_afc_border_type">
                <?php
                $options = array(
                    'dotted'=>'dotted',
                    'solid'=>'solid',
					'double'=>'double',
					'dashed'=>'dashed',
					'groove'=>'groove',
					'ridge'=>'ridge',
					'inset'=>'inset',
					'outset'=>'outset'
					
                );
                foreach($options as $key => $value) { 
                ?>
                <option value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_border_type','solid')) {?> selected="selected" <?php } ?>><?php echo $value;?></option>
                <?php } ?>
            </select>
            
            <input type="text" name="ct_afc_border_color" id="ct_afc_border_color" value="<?php echo get_text_value(get_the_ID(),'ct_afc_border_color','#FFFFFF')?>" class="color-picker-afc">
            
            <select style="width:35%;" name="ct_afc_border_radius" id="ct_afc_border_radius">
                <?php
                $options = array(
                    '0'=>'Straight Cornor',
                    '1'=>'Round Cornor'
                );
                foreach($options as $key => $value) { 
                ?>
                <option value="<?php echo $key;?>" <?php if ($key==get_text_value(get_the_ID(),'ct_afc_border_radius','0')) {?> selected="selected" <?php } ?>><?php echo $value;?></option>
                <?php } ?>
            </select>
            
        </div>            
    </div>  
    <div class="afc-panel-div" id="border_radious_area" style=" <?php if(get_text_value(get_the_ID(),'ct_afc_border_radius','0')==1) {echo "display:block;";} ?>">
        <label for="border_properties"><?php _e('&nbsp;','advanced-floating-content')?></label>
        <div class="control-input">
            <input type="text" name="ct_afc_border_radius_size" id="ct_afc_border_radius_size" value="<?php echo get_text_value(get_the_ID(),'ct_afc_border_radius_size','0')?>" /> px
        </div>            
    </div> 
    <div class="afc-panel-div">
        <label for="bafckground_color"><?php _e('Background Color','advanced-floating-content')?></label>
        <div class="control-input">
            <input type="text" name="ct_afc_background_color" id="ct_afc_background_color" value="<?php echo get_text_value(get_the_ID(),'ct_afc_background_color','#FFFFFF')?>" class="color-picker-afc">
        </div>
    </div>
    <div class="afc-panel-div">
        <label for="bafckground_color"><?php _e('Font Color','advanced-floating-content')?></label>
        <div class="control-input">
            <input type="text" name="ct_afc_font_color" id="ct_afc_font_color" value="<?php echo get_text_value(get_the_ID(),'ct_afc_font_color','#FFFFFF')?>" class="color-picker-afc">
        </div>
    </div>
    <div class="afc-panel-div">
        <label for="bafckground_color"><?php _e('Font Size','advanced-floating-content')?></label>
        <div class="control-input">
            <input type="text" name="ct_afc_font_size" id="ct_afc_font_size" value="<?php echo get_text_value(get_the_ID(),'ct_afc_font_size','12')?>" placeholder="Font Size" /> px
        </div>
    </div>
    
</div>
<div id="advanced-floating-content-meta-box-nonce" class="hidden">
  <?php wp_nonce_field( 'advanced_floating_content_save', 'advanced_floating_content_nonce' ); ?>
</div>