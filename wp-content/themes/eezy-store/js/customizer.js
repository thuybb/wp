/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
	
	// Whether a header image is available.
	function hasHeaderImage() {
		var image = wp.customize( 'header_image' )();
		return '' !== image && 'remove-header' !== image;
	}
	
	// Toggle a body class if a custom header exists.
	$.each( [ 'external_header_video', 'header_image', 'header_video' ], function( index, settingId ) {
		wp.customize( settingId, function( setting ) {
			setting.bind(function() {
				if ( hasHeaderImage() ) {
					$( document.body ).addClass( 'has-header-image' );
				} else {
					$( document.body ).removeClass( 'has-header-image' );
				}

				if ( ! hasHeaderVideo() ) {
					$( document.body ).removeClass( 'has-header-video' );
				}
			} );
		} );
	} );
	// for banner image 1
	wp.customize("bnr_img1", function(value) {
		value.bind(function(newval) {
			$("#bnr_img1").html(newval);
		} );
	});
	
	// for banner on off option
	wp.customize("bnr_on_off", function(value) {
		value.bind(function(newval) {
			$("#bnr_on_off").html(newval);
		} );
	});
	
	// for banner image 1 heading
	wp.customize("bnr_img1_heading", function(value) {
		value.bind(function(newval) {
			$("#bnr_img1_heading").html(newval);
		} );
	});
	
	// for banner image 1 Description text
	wp.customize("bnr_img1_descrp", function(value) {
		value.bind(function(newval) {
			$("#bnr_img1_descrp").html(newval);
		} );
	});
	
	// for banner image 2
	wp.customize("bnr_img2", function(value) {
		value.bind(function(newval) {
			$("#bnr_img2").html(newval);
		} );
	});
	
	// for banner image 2 heading text
	wp.customize("bnr_img2_heading", function(value) {
		value.bind(function(newval) {
			$("#bnr_img2_heading").html(newval);
		} );
	});
	
	// for banner image 2 description text
	wp.customize("bnr_img2_descrp", function(value) {
		value.bind(function(newval) {
			$("#bnr_img2_descrp").html(newval);
		} );
	});
	
	// for banner image shop now text
	wp.customize("bnr_img_shop_btn", function(value) {
		value.bind(function(newval) {
			$("#bnr_img_shop_btn").html(newval);
		} );
	});
	
	// for banner 1 shop now btn link address
	wp.customize("banner1_shop_btn_link", function(value) {
		value.bind(function(newval) {
			$("#banner1_shop_btn_link").html(newval);
		} );
	});
	
	// for banner 2 shop now btn link address
	wp.customize("banner2_shop_btn_link", function(value) {
		value.bind(function(newval) {
			$("#banner2_shop_btn_link").html(newval);
		} );
	});
	
	// for home product options
	wp.customize("home_product_opt", function(value) {
		value.bind(function(newval) {
			$("#home_product_opt").html(newval);
		} );
	});
	
	// for home product options
	wp.customize("large_prdct1_img", function(value) {
		value.bind(function(newval) {
			$("#large_prdct1_img").html(newval);
		} );
	});
	
	// for home product on off option
	wp.customize("home_prdct_on_off", function(value) {
		value.bind(function(newval) {
			$("#home_prdct_on_off").html(newval);
		} );
	});
	
	// for home large product 1 first heading
	wp.customize("large_prdct1_first_head", function(value) {
		value.bind(function(newval) {
			$("#large_prdct1_first_head").html(newval);
		} );
	});
	
	// for home large product 1 second heading
	wp.customize("large_prdct1_scnd_head", function(value) {
		value.bind(function(newval) {
			$("#large_prdct1_scnd_head").html(newval);
		} );
	});
	
	// for home large product 1 description text
	wp.customize("large_prdct1_descr", function(value) {
		value.bind(function(newval) {
			$("#large_prdct1_descr").html(newval);
		} );
	});
	
	// for home large product shop now text
	wp.customize("large_prdct_shop_btn", function(value) {
		value.bind(function(newval) {
			$("#large_prdct_shop_btn").html(newval);
		} );
	});
	
	// for home small product 1 image
	wp.customize("small_prdct1_img", function(value) {
		value.bind(function(newval) {
			$("#small_prdct1_img").html(newval);
		} );
	});
	
	// for home small product 1 name
	wp.customize("small_prdct1_name", function(value) {
		value.bind(function(newval) {
			$("#small_prdct1_name").html(newval);
		} );
	});
	
	// for home small product 2 image
	wp.customize("small_prdct2_img", function(value) {
		value.bind(function(newval) {
			$("#small_prdct2_img").html(newval);
		} );
	});
	
	// for home small product 2 name
	wp.customize("small_prdct2_name", function(value) {
		value.bind(function(newval) {
			$("#small_prdct2_name").html(newval);
		} );
	});
	
	// for large product 2 image
	wp.customize("large_prdct2_img", function(value) {
		value.bind(function(newval) {
			$("#large_prdct2_img").html(newval);
		} );
	});
	
	// for large product 2 first heading
	wp.customize("large_prdct2_first_head", function(value) {
		value.bind(function(newval) {
			$("#large_prdct2_first_head").html(newval);
		} );
	});
	
	// for large product 2 second heading
	wp.customize("large_prdct2_scnd_head", function(value) {
		value.bind(function(newval) {
			$("#large_prdct2_scnd_head").html(newval);
		} );
	});
	
	// for large product 2 description
	wp.customize("large_prdct2_descr", function(value) {
		value.bind(function(newval) {
			$("#large_prdct2_descr").html(newval);
		} );
	});
	
	// for large product 1 link address
	wp.customize("large_prdct1_link", function(value) {
		value.bind(function(newval) {
			$("#large_prdct1_link").html(newval);
		} );
	});
	
	// for large product 2 link address
	wp.customize("large_prdct2_link", function(value) {
		value.bind(function(newval) {
			$("#large_prdct2_link").html(newval);
		} );
	});
	
	// for small product 1 link address
	wp.customize("small_prdct1_link", function(value) {
		value.bind(function(newval) {
			$("#small_prdct1_link").html(newval);
		} );
	});
	
	// for small product 2 link address
	wp.customize("small_prdct2_link", function(value) {
		value.bind(function(newval) {
			$("#small_prdct2_link").html(newval);
		} );
	});
	
	// for home product heading options
	wp.customize("home_product_heading", function(value) {
		value.bind(function(newval) {
			$("#home_product_heading").html(newval);
		} );
	});
	
	// for featured product 
	wp.customize("top_feature_prdct", function(value) {
		value.bind(function(newval) {
			$("#top_feature_prdct").html(newval);
		} );
	});
	
	// for new arrivals product 
	wp.customize("new_arvls_prdct", function(value) {
		value.bind(function(newval) {
			$("#new_arvls_prdct").html(newval);
		} );
	});
	
	// for top rated product
	wp.customize("top_rated_prdct", function(value) {
		value.bind(function(newval) {
			$("#top_rated_prdct").html(newval);
		} );
	});
	
	// for top seller product
	wp.customize("top_seller_prdct", function(value) {
		value.bind(function(newval) {
			$("#top_seller_prdct").html(newval);
		} );
	});
	
	// for footer section options
	wp.customize("footer_opt", function(value) {
		value.bind(function(newval) {
			$("#footer_opt").html(newval);
		} );
	});
	
	// for copyright text
	wp.customize("footer_copyrght_txt", function(value) {
		value.bind(function(newval) {
			$("#footer_copyrght_txt").html(newval);
		} );
	});
	
} )( jQuery );