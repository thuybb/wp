jQuery( document ).ready(function( $ ) {

	var scroll = false;
	var timer = null;

	$( '#sidebar-1 > .widget-area > .widget' ).each( function( index ) {

		var nav = $( '.one-page-nav li' ).eq(  $( this ).index() );
		if ( 'undefined' == nav )
			return;
			
		var title = $( this ).find( '> .widget-title' ).text();
		
		if ( '' == title) {
			title = $( this ).find( '.entry-header' ).eq( 0 ).text();
		}		
		if ( '' == title) {
			title = $( this ).find( 'h1' ).eq( 0 ).text();
		}
		
		if ( '' == title) {
			title = $( this ).find( 'h2' ).eq( 0 ).text();
		}
		
		if ( '' == title) {
			title = $( this ).find( 'h3' ).eq( 0 ).text();
		}

		if ( '' != title) {
		
			nav.text( title );
			
		} else {
		
			nav.addClass( 'invisible' );

		}

	});
	
	 $('body').on( 'click', '.one-page-nav li', function( event ) {
		var adm = 0;
		scroll = true;
		if( parseInt( $( '#wpadminbar') ) != 'undefined' )
			adm = parseInt( $( '#wpadminbar' ).css( 'height' ) );
		if ( isNaN( adm ) )
			adm = 0;
		
		$('.one-page-nav li').removeClass('current');
		
		var id = $( this ).attr( 'class' );
		
		$( '.cloned-nav li' ).eq( $( this ).index() ).addClass( 'current' );
		$( '.original-nav li' ).eq( $( this ).index() ).addClass( 'current' );
		
		var offset = $( '#sidebar-1 > .widget-area > .widget' ).eq( id ).offset();
		
		if( 'undefined' == typeof offset )
			return;
			
		offset = offset.top - adm - $( '.one-page-nav' ).height();
		
		$( 'html, body' ).animate( {scrollTop : offset}, 1000 );

		scroll = true;
		setTimeout(function() {
			scroll = false;
		}, 1400 );
	});
	
	$(window).scroll(function () {
		stickIt();
		if (timer) {
			clearTimeout(timer);
			timer = null;
		}
		timer = setTimeout(function() {
			if ( scroll == false ) { 
				greenIt();
			}
		}, 100 );
	});
	$(window).resize( function(){
		resizeIt();
		greenIt();

	});
	
	var adm = 0;
	if(parseInt($('#wpadminbar')) != 'undefined')
		adm = parseInt($('#wpadminbar').css('height'));
		
	if ( isNaN( adm ) )
		adm = 0;
	
	$('.nav-one-page')
	.addClass('original-nav')
	.clone()
	.insertAfter('.nav-one-page')
	.addClass('cloned-nav')
	.css('position','fixed')
	.css('top','0')
	.css('margin-top',adm)
	.css('margin-left','0')
	.css('z-index','500')
	.removeClass('original-nav')
	.hide();

	function greenIt() {
	
		var orgElement = $('.original-nav');
		if( orgElement.size() <= 0)
			return;

		var orgElementPos = $('.original-nav').offset();
		var orgElementTop = orgElementPos.top;          
		var height = $('.original-nav').height();          
		var top_sidebar_offset = $( '#sidebar-1' ).offset().top + $( '#sidebar-1' ).height();

		if ( $(window).scrollTop() + adm > ( orgElementTop ) && parseInt($(window).width()) > 450 && $(window).scrollTop() + height <= top_sidebar_offset  )  {
		
			$( '#sidebar-1 > .widget-area > .widget' ).each( function( index ) {
				var offsettop = $( this ).offset().top; 
				var height_widget = $( this ).height();
				//current element
				if ( $( window ).scrollTop()> offsettop && $( window ).scrollTop() < offsettop + height_widget ) {
				
					if ( $( window ).scrollTop() + height > offsettop && $( window ).scrollTop() + height < offsettop + height_widget ) {			
						$( '.one-page-nav li' ).removeClass( 'current' );
						$( '.original-nav li' ).eq( $( this ).index() ).addClass( 'current' );
						$( '.cloned-nav li' ).eq( $( this ).index() ).addClass( 'current' );
					} else {
						$( '.one-page-nav li' ).removeClass( 'current' );
						$( '.original-nav li' ).eq( $( this ).index() + 1 ).addClass( 'current' );
						$( '.cloned-nav li' ).eq( $( this ).index() + 1 ).addClass( 'current' );
					}
				}
			});
			
		}
		else {
			$( '.one-page-nav li' ).removeClass( 'current' );
		}
	}

	
	function stickIt() {

		var orgElement = $('.original-nav');
		if( orgElement.size() <= 0)
			return;

		var orgElementPos = $('.original-nav').offset();
		var orgElementTop = orgElementPos.top;          
		var height = $('.original-nav').height();          
		var top_sidebar_offset = $( '.sidebar-top-full' ).offset().top + $( '.sidebar-top-full' ).height();

		if ($(window).scrollTop() + adm > (orgElementTop) && parseInt($(window).width()) > 450 && $(window).scrollTop() + height < top_sidebar_offset + 9999  )  {

			if ( $('.cloned-nav').hasClass( 'on-sceen' ) )
				return;
				
			var coordsOrgElement = orgElement.offset();
			var leftOrgElement = coordsOrgElement.left;  
			var widthOrgElement = parseInt(orgElement.css('width'));

			$('.cloned-nav')
				.css('left',leftOrgElement+'px')
				.css('top',0)
				.css('width',widthOrgElement)
				.show()
				.addClass( 'on-sceen' );
		
			$('.original-nav')
				.css('height', $('.original-nav').css('height'))
				.css('visibility','hidden');
			$('.original-nav .one-page-nav')
				.css('display', 'none');				

		} else {
			$('.original-nav')
				.css('visibility','visible')	
				.css('height', 'auto')				
			$('.cloned-nav')
				.hide()
				.removeClass( 'on-sceen' );
			$('.original-nav .one-page-nav')
				.css('display', 'block');
		}
	}
	function resizeIt() {
		var orgElement = $('.original-nav');
		if( orgElement.size() <= 0)
			return;
		var orgElementPos = $('.original-nav').offset();
		var orgElementTop = orgElementPos.top;               

		if ( $(window).scrollTop() + adm > (orgElementTop) && parseInt( $(window).width() ) > 450  ) {

			var coordsOrgElement = orgElement.offset();
			var leftOrgElement = coordsOrgElement.left;  
			var widthOrgElement = parseInt(orgElement.css('width'));

			$('.cloned-nav')
				.css('left',leftOrgElement+'px')
				.css('top',0)
				.css('width',widthOrgElement)
				.show()
				.addClass( 'on-sceen' );
				
			$('.original-nav')
				.css('height', $('.original-nav').css('height'))				
				.css('visibility','hidden');
			$('.original-nav .one-page-nav')
				.css('display', 'none');

		} else {
			$('.original-nav')
				.css('height', 'auto')
				.css('visibility','visible');
			$('.cloned-nav')
				.hide()
				.removeClass( 'on-sceen' );
			$('.original-nav .one-page-nav')
				.css('display', 'block');
		}
	}
	
});