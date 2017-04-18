 /*
 * Frontpage/Archive Masonry
 */
(function ($) {
	var $container;

	function helena_trigger_masonry() {
	    // don't proceed if $grid has not been selected
	    if ( !$container ) {
	        return;
	    }
	    // init Masonry
	    $container.imagesLoaded(function(){
	        $container.masonry({
	            // options
	            itemSelector: '.grid-item',
	            stamp: '.stamp',
	            percentPosition: true,
	        });

	        // Fade blocks in after images are ready (prevents jumping and re-rendering)
			$(".grid-item").fadeIn("slow");

	    });
	}

	$(window).resize(function () { setTimeout( function() { helena_trigger_masonry(); }, 500); });

	$(window).load(function(){
	    $container = $('.site-main'); // this is the grid container

	    helena_trigger_masonry();

	    // Triggers re-layout on infinite scroll
	    $( document.body ).on( 'post-load', function () {

	        // I removed the infinite_count code
	        var $selector = $('.infinite-wrap');
	        var $elements = $selector.find('.grid-item');

	        /* here is the idea which is to catch the selector whether it contain element or not, if it's move it to the masonry grid. */
	        if( $selector.children().length > 0 ) {
	            $container.append( $elements ).masonry( 'appended', $elements, true );
	            helena_trigger_masonry();
	        }

	    });
	});
})(jQuery);