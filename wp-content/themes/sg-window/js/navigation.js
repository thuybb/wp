jQuery( document ).ready(function( $ ) {

	$('.menu-1 .menu-toggle').click( function(){
		$( '.menu-1 ul.nav-horizontal' ).toggle( 'slow' );
		return false;
	});
	
	$('.menu-2 .menu-toggle').click( function(){
		$( '.menu-2 ul.nav-horizontal' ).toggle( 'slow' );
		return false;
	});
	
	$('#menu-4 .menu-toggle').click( function(){
		$( '#menu-4 ul.nav-horizontal' ).toggle( 'slow' );
		return false;
	});
	
	$('.nav-horizontal li').bind('mouseover', sgwindow_openSubMenu);
	var is_scroll = false;

	function sgwindow_openSubMenu() {
		var all = $(window).width();
		var height = $(document).height();
		
		if(parseInt(all) < 680) 
			return;
			
		var left = $(this).offset().left;
		var width = $(this).outerWidth(true);
		
		var offset = all - (left + width + 100);
		if( offset < 0 ) {
			$(this).find( 'ul' ).css('left','auto').css('right','0').css('top','100%').css('width','220');
			$(this).find( 'ul ul' ).css('left','auto').css('right','100%').css('top','-2px').css('width','220');
		}
		
		if( $(this).offset().top + parseInt($(this).height()) + parseInt($(this).find( '> ul' ).height()) > height ) {
			$(this).find( '> ul' ).css('top','-'+parseInt($(this).find( '> ul' ).height())+'px').css('left','auto').css('right','0');
		}
	}
	
	$('.scrollup').click( function(){
		$('html, body').animate({scrollTop : 0}, 1000);
		return false;
	});
	
	var adm = 0;
	if(parseInt($('#wpadminbar')) != 'undefined')
		adm = parseInt($('#wpadminbar').css('height'));
		
	if ( isNaN( adm ) )
		adm = 0;

	$(window).scroll(function () {
		stickIt();
		if ( $(this).scrollTop() > 200 ) {
			if( $('.scrollup').hasClass( 'visible' ) )
				return;
			$('.scrollup').addClass( 'visible' ).fadeIn();
		} else {
			$('.scrollup').removeClass( 'visible' ).fadeOut();
		}
	});

	$(window).resize( function(){
		resizeIt();
		if ( parseInt($(window).width()) > 680 ) 
			$('.menu-2 ul.nav-horizontal').show();
		else 
			$('.menu-2 ul.nav-horizontal').hide();
	});
	
	$('.scrollup').click( function(){
		$('html, body').animate({scrollTop : 0}, 1000);
		return false;
	});
	
	$('.top-menu')
	.addClass('original')
	.clone()
	.insertAfter('.top-menu')
	.addClass('cloned')
	.css('position','fixed')
	.css('top','0')
	.css('margin-top',adm)
	.css('margin-left','0')
	.css('z-index','500')
	.removeClass('original')
	.hide();

	function stickIt() {

		var orgElement = $('.original');
		if( orgElement.size() <= 0)
			return;

		var orgElementPos = $('.original').offset();
		var orgElementTop = orgElementPos.top;               

		if ($(window).scrollTop() + adm > (orgElementTop) && parseInt($(window).width()) > 680 ) {

			if ( $(window).scrollTop() + adm > (orgElementTop) + 100 && ! $('.cloned .small-logo').hasClass( 'on-screen' ) ) {
				$('.cloned .small-logo').addClass( 'on-screen' );
			}
			
			if ( $(window).scrollTop() + adm < (orgElementTop) + 100 ) {
				$('.cloned .small-logo')
					.removeClass( 'on-screen' );
			}
						
			if ( $('.cloned').hasClass( 'on-sceen' ) )
				return;		
				
			var coordsOrgElement = orgElement.offset();
			var leftOrgElement = coordsOrgElement.left;  
			var widthOrgElement = parseInt(orgElement.css('width'));

			$('.cloned')
				.css('left',leftOrgElement+'px')
				.css('top',0)
				.css('width',widthOrgElement)
				.show()
				.addClass( 'on-sceen' );
				
			$('.original .horisontal-navigation')
				.css('visibility','hidden')		
			$('.original')
				.css('visibility','hidden')					

		} else {
			$('.original .horisontal-navigation')
				.css('visibility','visible');
			$('.original')
				.css('visibility','visible')		
			$('.cloned')
				.hide()
				.removeClass( 'on-sceen' );
			$('.cloned .small-logo')
				.removeClass( 'on-screen' );
		}
	}
	function resizeIt() {
		var orgElement = $('.original');
		if( orgElement.size() <= 0)
			return;
		var orgElementPos = $('.original').offset();
		var orgElementTop = orgElementPos.top;               

		if ($(window).scrollTop() + adm > (orgElementTop) && parseInt($(window).width()) > 680 ) {

			var coordsOrgElement = orgElement.offset();
			var leftOrgElement = coordsOrgElement.left;  
			var widthOrgElement = parseInt(orgElement.css('width'));

			$('.cloned')
				.css('left',leftOrgElement+'px')
				.css('top',0)
				.css('width',widthOrgElement)
				.show()
				.addClass( 'on-sceen' );
				
			$('.original .horisontal-navigation')
				.css('visibility','hidden');

		} else {
			$('.original .horisontal-navigation')
				.css('visibility','visible');
			$('.cloned')
				.hide()
				.removeClass( 'on-sceen' );
		}
	}
});