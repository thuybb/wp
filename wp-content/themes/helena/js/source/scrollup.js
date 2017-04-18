jQuery(document).ready(function(){
	jQuery(function () {
		
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 100) {
				jQuery('#fixed-header').addClass('float-header');
				jQuery('#scrollup').fadeIn('slow');
				jQuery("#scrollup").show();
			} else {
				jQuery('#fixed-header').removeClass('float-header');
				jQuery('#scrollup').fadeOut('slow');
				jQuery("#scrollup").hide();
			}
		});
		jQuery('#scrollup').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 500);
			return false;
		});
	});
});