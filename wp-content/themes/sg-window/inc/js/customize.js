jQuery( document ).ready(function( $ ) {

	$('body').on( 'click', '.section-toggle', function( event ) {
		$id = $( this ).attr('class').split( ' ' )[1];
		$( '.widget-section.' + $id ).toggle( 'active-class' );
		return false;
	});
	
	$('body').on( 'click', '.section-main-toggle', function( event ) {
		$id = $( this ).attr('class').split( ' ' )[1];
		$( '.widget-main-section.' + $id  ).toggle( 'active-main-class' );
		return false;
	});
});

jQuery( document ).ready(function( $ ) {
/*
	if ( ! wp || ! wp.customize )
		return;
		
	var ids = []
		
	var control_check = wp.customize.control( 'are_we_saved' );
	
	if ( ! control_check )
		return;
	
	control_check.setting.set( '1' );
	*/
});
