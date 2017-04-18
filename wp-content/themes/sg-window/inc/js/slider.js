//load main functions
jQuery( document ).ready(function( $ ) {

    slider();
	
	function slider() {
		$( '.sgwindow-slider-content' ).each( function( index ) {
		
			var arrName = $(this).attr('class').split( ' ' );
			var is_autoplay = arrName[0];
			var slidespeed = parseInt( arrName[1] );
			var delayspeed = parseInt( arrName[2] );
			var timerId;
			var animtype = 4;
			var disabled = false;
			
			var slider = $( this );
			var slide = $(this).find( '.sgwindow-slide' );
			var size = slide.size();
			
			var currindex = 0;
			var newindex = 0;
			var previndex = size - 1;
			
			if ( 0 == size ) {
			
				slider.css( 'display', 'none' );
				return;
				
			}
			
			if ( size < 4 ) {
				for( i = size; i < 4; i++) {
					$(this).find( '.sgwindow-slide:first-child' )
								.clone()
								.insertBefore( $(this).find( '.sgwindow-slide:first-child' ) )
				}
				slide = $(this).find( '.sgwindow-slide' );
				size = slide.size();
			}
			
			var menuitem = $( this ).parent().find( '.sgwindow-slider-buttons li' );
			var next = $( this ).parent().find( '.sgwindow-next-button' );
			var prev = $( this ).parent().find( '.sgwindow-prev-button' );
			
			if ( '1' == is_autoplay ) {
				autoplay();
			}
			
			next.click(function( event ) {	
				if ( disabled )
					return false;
				disabled = true;
				
				newindex = ( newindex + 1 >= size ? 0 : newindex + 1 );
				
				slide.eq(currindex - 1).stop(true, true);
				slide.eq(currindex + 1).stop(true, true);
				slide.eq(currindex).stop(true, true);
				slide.eq(previndex).stop(true, true);
				
				animtype = 4;
				previndex = currindex - 1;
				if ( previndex < 0 )
					previndex = size - 1;
				
				switchSlide();
				
				slider.parent().find( '.sgwindow-slider-buttons li' ).removeClass( 'current' );
				slider.parent().find( '.sgwindow-slider-buttons li' ).eq( newindex ).addClass( 'current' );
				
				return false;
			});
			
			prev.click(function( event ) {

				if ( disabled )
					return false;
				disabled = true;
				
				newindex = ( newindex - 1 >= 0 ? newindex - 1 : size - 1 );
				
				slide.eq(currindex - 1 ).stop(true, true);
				slide.eq(currindex + 1).stop(true, true);
				slide.eq(currindex).stop(true, true);
				slide.eq(previndex).stop(true, true);
				
				animtype = 3;
				previndex = newindex - 1;
				
				switchSlide();
				
				slider.parent().find( '.sgwindow-slider-buttons li' ).removeClass( 'current' );
				slider.parent().find( '.sgwindow-slider-buttons li' ).eq( newindex ).addClass( 'current' );
				
				return false;
			});
			
			menuitem.click(function( event ) {
			
				var next_b = menuitem.index( this );
				if ( next_b == currindex )
					return;
					
				slider.parent().find( '.sgwindow-slider-buttons li' ).removeClass( 'current' );
				$( this ).addClass( 'current' );
				slider.eq( currindex ).stop(true, true);
				slider.eq( previndex ).stop(true, true);
				
				var prevspeed = slidespeed;
				var slidetomove = ( next_b - currindex > 0 ? next_b - currindex : currindex - next_b );
				slidespeed = slidespeed / slidetomove;
				var timeout = slidespeed;
				
				var button = ( next_b > currindex ? next : prev );
											
				moveit( false, 400, button, slidetomove - 1, prevspeed );
		});
		
		function moveit( flag, timeout, button, index, prevspeed ) {
		
			if ( false === flag ) {
				setTimeout( function() { 
					moveit( true, timeout, button, index, prevspeed );
				}, timeout );
			} else {
				button.click();
	
				if ( index > 0 ) {
					index--;
					moveit( false, timeout, button, index, prevspeed );
				} else {
					slidespeed = prevspeed;
				}
			}
		}
					
		slider.mouseover(function( event ) {
			if ( is_autoplay ) {
				clearInterval( timerId );
			}
		});

		slider.mouseleave(function( event ) {
			if ( is_autoplay ){
				clearInterval( timerId );
				autoplay();
			}
		});
		
		function autoplay() { 
			timerId = setInterval( function (){
				next.click();
			}, delayspeed );
		}
		function switchSlide() {
			animslide(currindex, newindex);

			previndex = currindex;
			currindex = newindex;		
		}

		function animslide(currindex, newindex) {
				
			switch ( animtype ) {
				case 3: //move right
				
					slide.eq( previndex )
						.css( 'display', 'block' )
						.css( 'left', '-200%' )
						.css( 'right', '200%' )
						.animate({
							'left':'-100%', 'right':'100%'}, {
							duration: slidespeed,
							queue: false,
							always: function() { 
						} 
					});

					slide.eq( currindex )
						.css( 'display', 'block' )
						.css( 'left', '0' )
						.css( 'right', '0' )
						.animate({
							'left':'100%', 'right':'-100%'}, {
							duration: slidespeed,
							queue: false,
							always: function() { 
								enabled();
						} 
					});	
							
					slide.eq( newindex )
						.css( 'display', 'block' )
						.css( 'left', '-100%' )
						.css( 'right', '100%' )
						.animate({
							'left':'0', 'right':'0'}, {
							duration: slidespeed, 
							queue: false,
							always: function() { 
						} 
					});
					
					if ( size == currindex + 1 ) {
						slide.eq( 0 )
							.css( 'display', 'block' )
							.css( 'left', '100%' )
							.css( 'right', '-100%' )
							.animate({
								'left':'200%', 'right':'-200%'}, {
								duration: slidespeed, 
								queue: false,
								always: function() { 
							} 
						});
					} else {
						slide.eq( currindex + 1 )
							.css( 'display', 'block' )
							.css( 'left', '100%' )
							.css( 'right', '-100%' )
							.animate({
								'left':'200%', 'right':'-200%'}, {
								duration: slidespeed, 
								queue: false,
								always: function() { 
							} 
						});
					}
					
				break;
				case 4:	//move left
					
					slide.eq( previndex )
						.css( 'display', 'block' )
						.css( 'left', '-100%' )
						.css( 'right', '100%' )
						.animate({
							'left':'-200%', 'right':'200%'}, {
							duration: slidespeed,
							queue: false,
							always: function() { 
								} 
							});

					slide.eq( currindex )
						.css( 'display', 'block' )
						.css( 'left', '0' )
						.css( 'right', '0' )
						.animate({
							'left':'-100%', 'right':'100%'}, {
							duration: slidespeed,
							queue: false,
							always: function() { 
								enabled();
								} 
							});
							
					slide.eq( newindex )
						.css( 'display', 'block' )
						.css( 'left', '100%' )
						.css( 'right', '-100%' )
						.animate({
							'left':'0', 'right':'0'}, {
							duration: slidespeed, 
							queue: false
					});

					if( size == newindex + 1 ) {
						slide.eq( 0 )
							.css( 'display', 'block' )
							.css( 'left', '200%' )
							.css( 'right', '-200%' )
							.animate({
								'left':'100%', 'right':'-100%'}, {
								duration: slidespeed, 
								queue: false
						});
					} else {
						slide.eq( newindex + 1 )
							.css( 'display', 'block' )
							.css( 'left', '200%' )
							.css( 'right', '-200%' )
							.animate({
								'left':'100%', 'right':'-100%'}, {
								duration: slidespeed, 
								queue: false
						});
					}			

				break;
			};
		}
		
		function hideslide( obj ) {
			obj.css( 'display', 'none' ); 
		}		
		
		function enabled() {
			disabled = false; 
		}
		
	});
	}
});