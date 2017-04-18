jQuery( document ).ready(function( $ ) {

	if( ! wp || ! wp.customize )
		return;
		
	var api = wp.customize;
	
	var s_id = 0;
	get_ajax();
				
	$(document).on( "change", ".change-count", function() {
		var arrName = $(this).attr('class').split( ' ' );
		var widget_id = arrName[2];
		var count = parseInt( $(this).val() );
		if ( count <= 0 ) {
			$(this).val( 1 );
			count = 1; 			
		} else if ( count >= 4 ) {
			$(this).val( 4 ); 
			count = 4;
		}
		
		var size = 100 / count;
		
		for( i = 0; i < count; i++ ) {
			$( '#widget-' + widget_id + '-width_' + i ).val( size );
			$( '#widget-' + widget_id + '-sidebar_id_' + i + '_hide' ).css( 'display', 'block' );	
		}
		
		for( i = count; i < 4; i++ ) {		
			$( '#widget-' + widget_id + '-sidebar_id_' + i + '_hide' ).css( 'display', 'none' );
			$( '#widget-' + widget_id + '-width_' + i ).val( 0 );
		}
			 
		/* refresh */
		if ( wp ) { 
			if ( wp.customize ) {
				if ( wp.customize.Widgets.getWidgetFormControlForWidget( widget_id ) ) {
					wp.customize.Widgets.getWidgetFormControlForWidget( widget_id ).updateWidget();
				}
			}
		}

	});
	
	$(document).on( "click", ".add-sidebar-button", function() {	

		var arrName = $(this).attr('class').split( ' ' );
		var widget_id = arrName[2];
		var count = parseInt( $( '#widget-' + widget_id + '-count' ).val() );
		
		if ( count <= 0 )
			return;
			
		var id = $(this).attr('id').replace( ( new RegExp('_b' + '$') ), '');
		

		id = id.substr( 0, id.indexOf( 'sidebar_id_' ) + 11 );
		
		$( '#' + id + '0_wrap' ).toggle( 'active-class' );
		$( '#' + id + '0_b' ).toggle( 'active-class' );
				 
		var width = 100 / count;

		for( i = 0; i < 4; i++ ) {
			$( '#' + id + i ).val( s_id++ );			
			$( '#widget-' + widget_id + '-width_' + i ).val( width );			
			if ( i >= count ) {
				$( '#' + id + i + '_hide' ).css( 'display', 'none' );	
				$( '#widget-' + widget_id + '-width_' + i ).val( 0 );							
			}
		}
		SetControlVal( 'max_id', s_id);
			 
		/* refresh */
		if ( wp ) { 
			if ( wp.customize ) {
				if ( wp.customize.Widgets.getWidgetFormControlForWidget( widget_id ) ) {
					wp.customize.Widgets.getWidgetFormControlForWidget( widget_id ).updateWidget();
				}
			}
		}

	});  
	
	function GetControlVal(name) {
	    var control = api.control(name); 
		var rez = '';
		if( control ){
			rez = control.setting.get();
		}
		return rez;
	}
	
	function SetControlVal(name, newVal) {
	    var control = api.control(name); 
		if( control ){
			control.setting.set( newVal );
		}
		return;
	}
	
	function get_ajax() {

		data = {
			'action': 'sgwindow_get_id',
		};
			
		$.post( ajaxurl, data, function( response ) {
			
			s_id = parseInt( response );
			
		});

	}
	
});