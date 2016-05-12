(function( $ ) {
	'use strict';

	if( jQuery().wpColorPicker ) {
		$(function() {
			$(".color-picker-afc").wpColorPicker();
		});
	}
	
	
	jQuery('input[type="radio"]').click(function(){
		var value = jQuery(this).attr("value");
		var name = jQuery(this).attr("name");
		var divid = name.substring(name.lastIndexOf("_") + 1, name.length);		
		if(value==0)
		{
			jQuery("#selective_"+divid).show();
		}
		else
		{
			jQuery("#selective_"+divid).hide();
		}	  
	});
	jQuery('input[name="ct_afc_show_on_certain_height"]').click(function(){
		var value = jQuery(this).attr("value");
		if(value==1)
		{
			jQuery("#certain_height_area").fadeIn();
		}
        else
		{			
            jQuery("#certain_height_area").fadeOut();
		}
	});
	jQuery('input[name="ct_afc_control_devices"]').click(function(){
		var value = jQuery(this).attr("value");
		if(value==3)
		{
			jQuery("#certain_width_area").fadeIn();
		}
        else
		{			
            jQuery("#certain_width_area").fadeOut();
		}
	});
    jQuery('#ct_afc_border_radius').change(function(){
		var value = jQuery(this).attr("value");
		if(value==1)
		{
			jQuery("#border_radious_area").fadeIn();
		}
        else
		{			
            jQuery("#border_radious_area").fadeOut();
		}
	});
	
})( jQuery );
