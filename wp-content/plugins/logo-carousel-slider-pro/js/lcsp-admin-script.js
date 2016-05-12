jQuery(document).ready(function($) {

    $(".lcsp-tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".lcsp-tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });

    $('.lcsp-checkbox-wrapper, #lcsp_logos_byid, #lcsp_logos_from_year, #lcsp_logos_from_month, #lcsp_logos_from_month_year').hide();

	$('input[type="radio"]').click(function() {
	   if($(this).attr('id') == 'lcsp_logo_type3') {
	        $('.lcsp-checkbox-wrapper').show();           
	   }
	   else {
	        $('.lcsp-checkbox-wrapper').hide();   
	   }
	});

	$('input[type="radio"]').click(function() {
	   if($(this).attr('id') == 'lcsp_logo_type4') {
	        $('#lcsp_logos_byid').show();           
	   }
	   else {
	        $('#lcsp_logos_byid').hide();   
	   }
	});

	$('input[type="radio"]').click(function() {
	   if($(this).attr('id') == 'lcsp_logo_type5') {
	        $('#lcsp_logos_from_year').show();           
	   }
	   else {
	        $('#lcsp_logos_from_year').hide();   
	   }
	});

	$('input[type="radio"]').click(function() {
	   if($(this).attr('id') == 'lcsp_logo_type6') {
	        $('#lcsp_logos_from_month, #lcsp_logos_from_month_year').show();           
	   }
	   else {
	        $('#lcsp_logos_from_month, #lcsp_logos_from_month_year').hide();   
	   }
	});

	if( $('input[id=lcsp_logo_type3]').is(':checked') ) {
		$('.lcsp-checkbox-wrapper').addClass('lcsp_active');
	}
	if( $('input[id=lcsp_logo_type4]').is(':checked') ) {
		$('#lcsp_logos_byid').addClass('lcsp_active');
	}
	if( $('input[id=lcsp_logo_type5]').is(':checked') ) {
		$('#lcsp_logos_from_year').addClass('lcsp_active');
	}
	if( $('input[id=lcsp_logo_type6]').is(':checked') ) {
		$('#lcsp_logos_from_month, #lcsp_logos_from_month_year').addClass('lcsp_active');
	}

});
