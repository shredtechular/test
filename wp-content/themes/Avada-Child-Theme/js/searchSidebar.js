jQuery(document).ready(function(){
    jQuery('.searchandfilter ul li h4').click(function(e){  
          e.preventDefault();
          if (jQuery(this).parent().children('ul:first').is(':visible')) {
               jQuery(this).parent().children('ul:first').slideUp("slow");
          } else {
               jQuery(this).parent().children('ul:first').slideDown("slow");
          }

          if (jQuery(this).parent().children('input:first').is(':visible')) {
               jQuery(this).parent().children('input:first').hide();
          } else {
               jQuery(this).parent().children('input:first').fadeIn('slow');
          }
          jQuery(this).toggleClass('opened');
    });
});