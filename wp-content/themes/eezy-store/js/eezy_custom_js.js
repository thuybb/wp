jQuery( document ).ready( function($) {


    // Quantity buttons
    $( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).append( '<input type="button" value="-" class="minus" />' );

    // Target quantity inputs on product pages
    $( 'input.qty:not(.product-quantity input.qty)' ).each( function() {
        var min = parseFloat( $( this ).attr( 'min' ) );

        if ( min && min > 0 && parseFloat( $( this ).val() ) < min ) {
            $( this ).val( min );
        }
    });

    $( document ).on( 'click', '.plus, .minus', function() {

        // Get values
        var $qty		= $( this ).closest( '.quantity' ).find( '.qty' ),
            currentVal	= parseFloat( $qty.val() ),
            max			= parseFloat( $qty.attr( 'max' ) ),
            min			= parseFloat( $qty.attr( 'min' ) ),
            step		= $qty.attr( 'step' );

        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

        // Change the value
        if ( $( this ).is( '.plus' ) ) {

            if ( max && ( max == currentVal || currentVal > max ) ) {
                $qty.val( max );
            } else {
                $qty.val( currentVal + parseFloat( step ) );
            }

        } else {

            if ( min && ( min == currentVal || currentVal < min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( currentVal - parseFloat( step ) );
            }

        }

        // Trigger change event
        $qty.trigger( 'change' );
    });

    /* end add quanitity button */
    var calc_shipping_dropdown = $('.woocommerce table.shop_table.shipping p select');
    if($.isFunction(calc_shipping_dropdown.select2)) {
        calc_shipping_dropdown.select2();
    }
	
	//search icon 
	jQuery(".eezy-search-icon a").click(function(){
		$(".eezy-search-form").slideToggle();
	});
	
	// for adding icon-updown in widget on shop page 
	jQuery('<span class="icon-updown"></span>').appendTo('.widget li.cat-parent');
			
	jQuery('.icon-updown').click(function(){
		
			jQuery(this).closest('.cat-parent').children('.children').animate({
				
				height: "toggle"
				
			},300,'linear');
			
	});
	
	// for sidebar toggle on shop page
	if(jQuery(window).width()<768){ 
		
		jQuery("#sidebar1").hide();
		
		jQuery(".filter-area").click(function(){
			
			jQuery("#sidebar1").slideToggle();
		
		});

	}
	
	// for submneu toggle on click on tab and mobile
	if(jQuery(window).width()<=1024){ 
		
		$( ".main-navigation ul li.menu-item-has-children" ).prepend( '<span class="fa fa-angle-down"></span>' );
		
		$('.main-navigation ul li.menu-item-has-children .fa.fa-angle-down').click(function(){
			
			$(this).next().next().slideToggle();
			
			$(this).toggleClass("fa-angle-down fa-angle-up");
			
		});
 
	}
	
	jQuery( ".woocommerce-result-count" ).wrap( "<div class='pho-custom-pagination'></div>" );
	
	jQuery(".woocommerce-ordering").appendTo('.pho-custom-pagination');
	

});