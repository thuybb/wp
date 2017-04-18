/* global localizeData */
(function ($) {
    //Scroll to top script
    var scrollup = $('#scrollup');

    if ( scrollup.length ) {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                scrollup.fadeIn('slow');
                scrollup.show();
            } else {
                scrollup.fadeOut('slow');
                scrollup.hide();
            }
        });

        scrollup.click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
    }
    //Scroll to top script end


    //Load Menu
    /**
     * Contains handlers for navigation
     */

    var body, masthead, menuToggle, siteNavigation, siteHeaderMenu, resizeTimer;

    function initMainNavigation( container ) {

        // Add dropdown toggle that displays child menu items.
        var dropdownToggle = $( '<button />', {
            'class': 'dropdown-toggle',
            'aria-expanded': false
        } ).append( $( '<span />', {
            'class': 'screen-reader-text',
            text: localizeData.screenReaderText.expand
        } ) );

        container.find( '.menu-item-has-children > a' ).after( dropdownToggle );

        // Toggle buttons and submenu items with active children menu items.
        container.find( '.current-menu-ancestor > button' ).addClass( 'toggled-on' );
        container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

        // Add menu items with submenus to aria-haspopup="true".
        container.find( '.menu-item-has-children' ).attr( 'aria-haspopup', 'true' );

        /* Support Default Page Menu */
        container.find( '.page_item_has_children > a' ).after( dropdownToggle );
        container.find( '.current-page-ancestor > button' ).addClass( 'toggled-on' );
        container.find( '.current-page-ancestor > .children' ).addClass( 'toggled-on' );
        container.find( '.page_item_has_children' ).attr( 'aria-haspopup', 'true' );

        container.find( '.dropdown-toggle' ).click( function( e ) {
            var _this            = $( this ),
                screenReaderSpan = _this.find( '.screen-reader-text' );

            e.preventDefault();
            _this.toggleClass( 'toggled-on' );
            _this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

            // jscs:disable
            _this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
            // jscs:enable
            screenReaderSpan.text( screenReaderSpan.text() === localizeData.screenReaderText.expand ? localizeData.screenReaderText.collapse : localizeData.screenReaderText.expand );
        } );
    }
    initMainNavigation( $( '.main-navigation' ) );

    menuToggle       = $( '#menu-toggle' );
    siteHeaderMenu   = $( '#site-header-menu' );
    siteNavigation   = $( '#site-navigation' );

    // Enable menuToggle.
    ( function() {

        // Return early if menuToggle is missing.
        if ( ! menuToggle.length ) {
            return;
        }

        // Add an initial values for the attribute.
        menuToggle.add( siteNavigation ).attr( 'aria-expanded', 'false' );

        menuToggle.on( 'click.helena', function() {
            $( this ).add( siteHeaderMenu ).toggleClass( 'toggled-on' );

            // jscs:disable
            $( this ).add( siteNavigation ).attr( 'aria-expanded', $( this ).add( siteNavigation ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
            // jscs:enable
        } );
    } )();

    // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
    ( function() {
        if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
            return;
        }

        // Toggle `focus` class to allow submenu access on tablets.
        function toggleFocusClassTouchScreen() {
            if ( window.innerWidth >= 910 ) {
                $( document.body ).on( 'touchstart.helena', function( e ) {
                    if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
                        $( '.main-navigation li' ).removeClass( 'focus' );
                    }
                } );
                siteNavigation.find( '.menu-item-has-children > a' ).on( 'touchstart.helena', function( e ) {
                    var el = $( this ).parent( 'li' );

                    if ( ! el.hasClass( 'focus' ) ) {
                        e.preventDefault();
                        el.toggleClass( 'focus' );
                        el.siblings( '.focus' ).removeClass( 'focus' );
                    }
                } );
            } else {
                siteNavigation.find( '.menu-item-has-children > a' ).unbind( 'touchstart.helena' );
            }
        }

        if ( 'ontouchstart' in window ) {
            $( window ).on( 'resize.helena', toggleFocusClassTouchScreen );
            toggleFocusClassTouchScreen();
        }

        siteNavigation.find( 'a' ).on( 'focus.helena blur.helena', function() {
            $( this ).parents( '.menu-item' ).toggleClass( 'focus' );
        } );
    } )();

    /*
     * Comment placeholders
     * (Localized via wp_localize_script in functions file)
     */
    $( '#author' ).attr( 'placeholder', localizeData.placeholder.author );
    $( '#email' ).attr( 'placeholder', localizeData.placeholder.email );
    $( '#url' ).attr( 'placeholder', localizeData.placeholder.url );
    $( '#comment' ).attr( 'placeholder', localizeData.placeholder.comment );

    /*
     * Search Toggle
     */
    var jQueryheader_search = jQuery( '#search-toggle' );
    jQueryheader_search.click( function() {
        var jQueryform_search = jQuery("div").find( '#search-container' );

        if ( jQueryform_search.hasClass( 'displaynone' ) ) {
            jQueryform_search.removeClass( 'displaynone' ).addClass( 'displayblock' ).animate( { opacity : 1 }, 300 );
        } else {
            jQueryform_search.removeClass( 'displayblock' ).addClass( 'displaynone' ).animate( { opacity : 0 }, 300 );
        }
    });
})(jQuery);