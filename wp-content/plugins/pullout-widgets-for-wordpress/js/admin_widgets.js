var widget_id = '';
var current_pow_id = '';
var current_pow_wrap_id = '';
var current_dialog = null;
jQuery(document).ready(function(){

    jQuery(document).on('click', '.pow_dialog', function(){
        var pow_id      = jQuery(this).attr('rel');
        widget_id   = pow_id.replace('pow_', '');
        current_pow_id  = '#' + pow_id;

        //generate dialog on link click
        pow_dialog();

        current_pow_wrap_id = '#wrap-' + jQuery(this).attr('rel');
        //check if pow_id inside the widget, that means that
        //widget was just placed into the sidebar and the dialog wasn't activated
        //upon it
        if( jQuery('.widget-inside ' + current_pow_id) ){
            //activate the dialog for this pow
            pow_dialog();
        }
        jQuery( current_pow_id ).dialog( "open" );
        jQuery(this).removeClass('pow_hide');

        return false;
    });

});

function pow_dialog(){

    jQuery( current_pow_id ).dialog({
        dialogClass   : 'wp-dialog pow-dialog',
        modal         : true,
        autoOpen      : false,
        closeOnEscape : true,
        minWidth      : 430,
        height        : 610,
        title         : 'Pullout Widget Options',
        open          : function(event, ui) {
            jQuery(this).pow_init_icon_selector();
            pow_init_color_picker(widget_id);
            jQuery(current_pow_id + ' .pow-accordion').accordion();

            jQuery('#'+widget_id +' [id$="-pow_show_on"]').change(function(){ pow_toggle_fields(); } );
            jQuery('#'+widget_id +' [id$="-pow_show_on"]').trigger('change');
        },
        close         : function(event, ui) {
            //move the dialog fields back into the widget
            jQuery(this).pow_dialog_put_back();
            current_dialog = this;
            //regenerate dialog since the value should be unchanged

        },
        buttons: [
        {
            text: "Save Options",
            click: function() {
                jQuery(this).pow_dialog_save();
            }
        }]
    });
}

function pow_hide_all(){
    var el = ['pow_element', 'pow_timer', 'pow_n_pages'];
    for(i in el){
        jQuery('#'+widget_id+' .'+el[i]).hide();
    }
}

function pow_show(id){
    pow_hide_all();
    jQuery('#'+widget_id+' .'+id).show();
}

function pow_toggle_fields(){
    var widget_id = current_pow_wrap_id.replace('#wrap-pow-', '');
    var selected = jQuery('#widget-'+widget_id+'-pow_show_on').val();

    switch(selected){
        case "appear":
        case "appear_once":
            pow_show('pow_element');
        break;
        case "timer":
        case "timer_once":
            pow_show('pow_timer');
        break;
        case "n_pages":
        case "n_pages_once":
            pow_show('pow_n_pages');
        break;
        case "click":
        case "mouseover":
            pow_hide_all();
        break;
    }
    return false;
}

jQuery.fn.pow_dialog_save = function() {
    //move the dialog fields back into the widget
    jQuery(this).pow_dialog_put_back();
    //save the widget
    var widget_id = current_pow_wrap_id.replace('#wrap-pow-', '');
    jQuery('#widget-'+widget_id+'-savewidget').trigger('click');
}


jQuery.fn.pow_dialog_put_back = function() {
    jQuery(this).dialog('destroy');
    //append the current dialog back inside the widget
    jQuery(current_pow_id).appendTo(current_pow_wrap_id).hide();
    //regenerate the dialog
    jQuery(this).ajaxComplete(function(){
        if( jQuery(this).is(':data(dialog)') ){
            jQuery(this).dialog('destroy');
            pow_dialog(current_pow_id);
        }
    });
}

jQuery.fn.pow_init_icon_selector = function() {
    jQuery(document).on('click', current_pow_id + ' .pow_icon', function() {
        var widget_id = current_pow_id.replace('#pow-', '');
        var icon_field_id = jQuery(this).attr('rel');

        var selected_icon = jQuery(this).attr('id');
        jQuery('#' + icon_field_id).val(
            selected_icon
        );
        jQuery('#icons_'+widget_id+' .pow_icon').removeClass('pow_icon_selected');
        jQuery(this).addClass('pow_icon_selected');
        pow_icon_preview(widget_id, selected_icon);
    });
}

function pow_icon_preview(widget_id, icon) {
    var coord = icon.split('_');
    var preview = jQuery('#wrap-pow-'+widget_id + ' .pow_icon_preview');
    var grid = 36;
    var x = grid*(-1) * parseInt(coord[0]) + 7;
    var y = grid*(-1) * parseInt(coord[1]) + 7;

    jQuery('#pow-'+widget_id + ' .pow_icon_preview').css({
            'background-position' : x + 'px ' + ' ' +y+'px'
        });
}

function pow_init_color_picker(widget_id) {
    jQuery('#' + widget_id + ' .pow_color').each(function(){
        var colorpicker_field_id = jQuery(this).attr('id');
        var colorpicker = jQuery('#colorpicker-' + colorpicker_field_id);
        colorpicker.hide();
        colorpicker.farbtastic('#' + colorpicker_field_id);

        jQuery('#' + colorpicker_field_id).click(function() {
            colorpicker.fadeIn();
        });

        jQuery(document).mousedown(function() {
            colorpicker.each(function() {
                var display = jQuery(this).css('display');
                if ( display == 'block' )
                    jQuery(this).fadeOut();
            });
        });

    });
}