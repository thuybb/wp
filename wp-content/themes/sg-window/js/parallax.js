(function( $ ){
	var $window = $(window);
	var windowHeight = $window.height();

	$window.resize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function() {
		var $this = $(this);
		var getHeight;
		var firstTop = new Array;
		var speedFactor = new Array;
		var parentHeight = new Array;
		var paddingTop = new Array;

		//get the starting position of each element to have parallax applied to it		
		function init() {
			$this.each(function( index ){
				var arrName = $(this).attr('class').split( ' ' );
				parentHeight[ index ] = $(this).parent().height() + ( $(this).parent().width() * arrName[2]/ 100 ) + ( $(this).parent().width() * arrName[3]/ 100 ) + 20;							
				paddingTop[ index ] = ( $(this).parent().width()/100 * arrName[2] ) / $(this).parent().height() * 100;
				firstTop[ index ] = $(this).parent().offset().top;							
				speedFactor[ index ] = arrName[1];	
				$(this).css('height', parentHeight[ index ] * ( ( windowHeight + parentHeight[ index ] ) / windowHeight * speedFactor[ index ] /100 + 1 ) );				
			});
		}
		init();
		getHeight = function( el ) {
			return el.outerHeight(true);
		};
		
		// function to be called whenever the window is scrolled or resized
		function update(){
			var pos = $window.scrollTop();		
			var pos2 = $window.scrollTop() + windowHeight;		

			$this.each(function( index ){
				if ( 'fixed' == $( this ).css( 'position' ) )
					return;

				var $element = $(this);
				var top = $element.parent().offset().top;
				var height = getHeight($element);
			
				// Check if totally above or totally below viewport
				if ( top + height < pos || top > pos + windowHeight || speedFactor[ index ] <= 0 ) {
					return;
				}
				$element.css('top', Math.round( ( (firstTop[ index ] - pos2) / windowHeight * speedFactor[ index ] )) + '%' );
			});
		}
		$window.resize(init);
		$window.bind('scroll', update).resize(update);
		update();
	};
})(jQuery);

//Parallax
jQuery(function($) {
	$(".parallax-image").parallax();	
});