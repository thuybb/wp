jQuery(document).ready(function($) {
	var frame;
	var id;

	// Build the choose from library frame.
	$(document).on("click", ".upload_image_button", function() {
		id = $(this).attr('id').replace('_b', '');	
		
		if ( frame ) {
			frame.open();
			return;
		}

		// Create the media frame.
		frame = wp.media({
			// Tell the modal to show only images.
			library: {
				type: 'image',
			},
		});

		// When an image is selected, run a callback.
		frame.on( 'select', function() {
			// Grab the selected attachment.
			attachment = frame.state().get('selection').first().toJSON();
			$('#' + id).val(attachment.url);
		});
		
		frame.open();
		
		});
		
	$(document).on("click", ".upload_id_button", function() {
		id = $( this ).attr('id').replace('_b', '');	
		var arrName = $( this ).attr('class').split( ' ' );
		widget_id = arrName[0];
		$(this).attr('id').replace('[', '').replace(']', '');
		
		if ( frame ) {
			frame.open();
			return;
		}

		// Create the media frame.
		frame = wp.media({
			// Tell the modal to show only images.
			library: {
				type: 'image',
			},
		});

		// When an image is selected, run a callback.
		frame.on( 'select', function() {
			// Grab the selected attachment.
			attachment = frame.state().get('selection').first();
			$('#' + id).val(attachment.id);
			
			attachment = frame.state().get('selection').first().toJSON();
			$('.' + id + '_url').attr( 'src', attachment.url);
			
			/* refresh */
			if ( wp ) { 
				if ( wp.customize ) {
					wp.customize.Widgets.getWidgetFormControlForWidget( widget_id ).updateWidget();
				}
			}
	
		});
		
		frame.open();
		
		});
});