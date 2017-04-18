( function( api ) {
    // Extends our custom "upgrade_button" section.
    api.sectionConstructor['upgrade_button'] = api.Section.extend( {

        // No events for this type of section.
        attachEvents: function () {},

        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );
} )( wp.customize );

/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 */

( function( api ) {
   wp.customize( 'reset_all_settings', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: helena_data.reset_message
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );

    api.controlConstructor.radio = api.Control.extend( {
        ready: function() {
            if ( 'color_scheme' === this.id ) {
                this.setting.bind( 'change', function( color_scheme ) {
                    jQuery.each( helena_data.helena_color_list, function( index, value ) {
                        if ( 'light' == color_scheme ) {
                            api( index ).set( value.light );
                            api.control( index ).container.find( '.color-picker-hex' )
                            .data( 'data-default-color', value.light )
                            .wpColorPicker( 'defaultColor', value.light );
                        }
                        else if ( 'dark' == color_scheme ) {
                            api( index ).set( value.dark );
                            api.control( index ).container.find( '.color-picker-hex' )
                            .data( 'data-default-color', value.dark )
                            .wpColorPicker( 'defaultColor', value.dark );
                        }
                    });
                });
            }
        }
    });
} )( wp.customize );