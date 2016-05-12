//hide windows
jQuery(document).ready(function() {
	jQuery('.configure').hide();
	jQuery('#configurebtn').click(function() {
		jQuery('.configure').toggle(400);
		return false;
	});
	jQuery('.instructions').hide();
	jQuery('#instructionsbtn').click(function() {
		jQuery('.instructions').toggle(400);
		return false;
	});
});
//datepicker
jQuery(function() {
	jQuery( ".datepicker" ).datepicker();
});
//confirm record delete
jQuery(function () {
	jQuery(".confirmdelete").click(function () { 
		return confirm('OK to Delete?') 
	});
});
//clear fields not in use
jQuery(function () {
	jQuery(".displaydate").blur(function () { 
		jQuery(".displayweekly").val('');
		jQuery(".displaymonthly").val('');
	});
	jQuery(".displayweekly").blur(function () { 
		jQuery(".displaymonthly").val('');
		jQuery(".displaydate").val('');
		jQuery(".displaydateCB").prop("checked", false);
	});
	jQuery(".displaymonthly").blur(function () { 
		jQuery(".displaydate").val('');
		jQuery(".displaydateCB").prop("checked", false);
		jQuery(".displayweekly").val('');
	});
});