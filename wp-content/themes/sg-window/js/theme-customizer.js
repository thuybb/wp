( function( $ ) {
	
	var api = parent.wp.customize;
//font size
	wp.customize( 'body_font_size', function( value ) {
		value.bind( function( to ) {
			$( '.site .content' ).css('font-size', to + 'px');
		} );
	} );
//range
	wp.customize( 'width_site_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_site', to);
		} );
	} );

//max site width
	wp.customize( 'width_site', function( value ) {
		value.bind( function( to ) {
			$( '.site' ).css('maxWidth', to + 'px');
		} );
	} );
	
//range
	wp.customize( 'width_main_wrapper_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_main_wrapper', to);
		} );
	} );
//max content wrapper width
	wp.customize( 'width_main_wrapper', function( value ) {
		value.bind( function( to ) {
			$( '.main-wrapper' ).css('maxWidth', to + 'px');
		} );
	} );
	
//range
	wp.customize( 'width_image_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_image', to);
		} );
	} );
//max content wrapper width
	wp.customize( 'width_image', function( value ) {
		value.bind( function( to ) {
			$( '.header-wrap' ).css('maxWidth', to + 'px');
		} );
	} );
	
//range
	wp.customize( 'size_image_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('size_image', to);
		} );
	} );
//max content wrapper width
	wp.customize( 'size_image', function( value ) {
		value.bind( function( to ) {
			$( '.image-wrapper' ).css('maxWidth', to + 'px');
		} );
	} );
	
//range
	wp.customize( 'width_top_widget_area_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_top_widget_area', to);
		} );
	} );
//max top, footer wrapper width
	wp.customize( 'width_top_widget_area', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-before-footer .widget > div' ).css('maxWidth', to + 'px');
			$( '.sidebar-before-footer .widget-area .widget > ul' ).css('maxWidth', to + 'px');
			$( '.sidebar-top-full .widget-area .widget > div' ).css('maxWidth', to + 'px');
			$( '.sidebar-top-full .widget-area .widget > ul' ).css('maxWidth', to + 'px');
		} );
	} );
	
//range
	wp.customize( 'width_top_title_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_top_title', to);
		} );
	} );
//max top and footer sidebars widget title width
	wp.customize( 'width_top_title', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top-full .widgettitle' ).css('maxWidth', to + 'px');
			$( '.sidebar-top-full .widget-title' ).css('maxWidth', to + 'px');
			$( '.sidebar-before-footer .widgettitle' ).css('maxWidth', to + 'px');
			$( '.sidebar-before-footer .widget-title' ).css('maxWidth', to + 'px');
		} );
	} );
	
//range
	wp.customize( 'width_column_1_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_column_1', to);
		} );
	} );
//first column width
	wp.customize( 'width_column_1', function( value ) {
		value.bind( function( to ) {
			$( '.two-sidebars .sidebar-1' ).css('flex-basis', to + 'px');
		} );
	} );
	
//range %
	wp.customize( 'width_column_1_range_rate', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_column_1_rate', to);
		} );
	} );
//first column width %
	wp.customize( 'width_column_1_rate', function( value ) {
		value.bind( function( to ) {
			$( '.two-sidebars .sidebar-1' ).css('width', to + '%');
			$( '.two-sidebars .site-content' ).css('width', ( 100 - to - GetControlVal('width_column_2_rate') ) + '%');
		} );
	} );
	
//range px
	wp.customize( 'width_column_2_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_column_2', to);
		} );
	} );
//second column width px
	wp.customize( 'width_column_2', function( value ) {
		value.bind( function( to ) {
			$( '.two-sidebars .sidebar-2' ).css('flex-basis', to + 'px');
		} );
	} );
	
//range %
	wp.customize( 'width_column_2_range_rate', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_column_2_rate', to);
		} );
	} );
//second column width %
	wp.customize( 'width_column_2_rate', function( value ) {
		value.bind( function( to ) {
			$( '.two-sidebars .sidebar-2' ).css('width', to + '%');
			$( '.two-sidebars .site-content' ).css('width', ( 100 - to - GetControlVal('width_column_1_rate') ) + '%');
		} );
	} );
	
//right column range px
	wp.customize( 'width_column_1_right_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_column_1_right', to);
		} );
	} );
//right column width px
	wp.customize( 'width_column_1_right', function( value ) {
		value.bind( function( to ) {
			$( '.right-sidebar .sidebar-2' ).css('flex-basis', to + 'px');
		} );
	} );
	
//range %
	wp.customize( 'width_column_1_right_range_rate', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_column_1_right_rate', to);
		} );
	} );
//right column width %
	wp.customize( 'width_column_1_right_rate', function( value ) {
		value.bind( function( to ) {
			$( '.right-sidebar .sidebar-2' ).css('width', to + '%');
			$( '.right-sidebar .site-content' ).css('width', ( 100 - to ) + '%');
		} );
	} );
	
//left column range px
	wp.customize( 'width_column_1_left_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_column_1_left', to);
		} );
	} );
//left column width px
	wp.customize( 'width_column_1_left', function( value ) {
		value.bind( function( to ) {
			$( '.left-sidebar .sidebar-1' ).css('flex-basis', to + 'px');
		} );
	} );
	
//range %
	wp.customize( 'width_column_1_left_range_rate', function( value ) {
		value.bind( function( to ) {
			SetControlVal('width_column_1_left_rate', to);
		} );
	} );
//left column width %
	wp.customize( 'width_column_1_left_rate', function( value ) {
		value.bind( function( to ) {
			$( '.left-sidebar .sidebar-1' ).css('width', to + '%');
			$( '.left-sidebar .site-content' ).css('width', ( 100 - to ) + '%');
		} );
	} );

	// Site title and description.	
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
			$( '.wide .column-1 .element.effect-17 .entry-title' ).text( to );
			$( '.wide .column-1 .element.effect-18 .entry-title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description h2' ).text( to );
			$( '.wide .column-1 .element.effect-17 p' ).text( to );
			$( '.wide .column-1 .element.effect-18 p' ).text( to );
		} );
	} );
//description
	wp.customize( 'description_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-description h2' ).css( 'color', to);	
		} );
	} );

//header text background
	wp.customize( 'site_name_back', function( value ) {
		value.bind( function( to ) {
			$( '.sg-site-header-1' ).css( 'background-color', to_rgba(to,  GetControlVal('site_name_back_opacity') ));
		} );
	} );
	
	wp.customize( 'site_name_back_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.sg-site-header-1' ).css( 'background-color', to_rgba(GetControlVal('site_name_back'), to));
		} );
	} );
	
	wp.customize( 'site_name_back_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('site_name_back_opacity', parseInt(to)/10);
		} );
	} );	
	// Header text color
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );	
				$( '.site-title, .site-title a' ).css( {
					'color': to,
				} );
			}
		} );
	} );
	
//link
	wp.customize( 'link_color', function( value ) {
		value.bind( function( to ) {
			$( '.content article .entry-content a, .content article footer a' ).css( 'color', to);	
			$( '.widget.sgwindow_recent_posts .content article footer a, .content article footer a, .content-container article .entry-content a, .comments-link a, .category-list a, .featured-post, .logged-in-as a, .site .edit-link, .jetpack-widget-tag-nav, .jetpack-widget-nav, .content footer' ).css( 'color', to);	
			
			
		} );
	} );
//link
	wp.customize( 'heading_link', function( value ) {
		value.bind( function( to ) {
			$( '.entry-header .entry-title a' ).css( 'color', to);
		} );
	} );
//headers
	wp.customize( 'heading_color', function( value ) {
		value.bind( function( to ) {
			$( '.widget h1' ).css( 'color', to);
			$( '.content h1' ).css( 'color', to);
			$( '.content h2' ).css( 'color', to);
			$( '.content h3' ).css( 'color', to);
			$( '.content h4' ).css( 'color', to);
			$( '.content h5' ).css( 'color', to);
			$( '.content h6' ).css( 'color', to);	
		} );
	} );
		

//widget buttons 

//background
	wp.customize( 'buttons_color', function( value ) {
		value.bind( function( to ) {
			$( '.widget.sgwindow_widget_button' ).css( 'background-color', to_rgba(to, GetControlVal('buttons_color_opacity') ));
		} );
	} );

	wp.customize( 'buttons_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.widget.sgwindow_widget_button' ).css( 'background-color', to_rgba(GetControlVal('buttons_color'), to));
		} );
	} );
	
	wp.customize( 'buttons_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('buttons_color_opacity', parseInt(to)/10);
		} );
	} );		
//button
	wp.customize( 'buttons_button', function( value ) {
		value.bind( function( to ) {
			$( '.widget.sgwindow_widget_button .sgwindow-link' ).css( 'background-color', to_rgba(to, GetControlVal('buttons_button_opacity') ));
		} );
	} );

	wp.customize( 'buttons_button_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.widget.sgwindow_widget_button .sgwindow-link' ).css( 'background-color', to_rgba(GetControlVal('buttons_button'), to));
		} );
	} );
	
	wp.customize( 'buttons_button_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('buttons_button_opacity', parseInt(to)/10);
		} );
	} );
//link
	wp.customize( 'buttons_link', function( value ) {
		value.bind( function( to ) {
			$( '.widget.sgwindow_widget_button a' ).css( 'color', to);
		} );
	} );	
//border
	wp.customize( 'buttons_border', function( value ) {
		value.bind( function( to ) {
			$( '.widget.sgwindow_widget_button .sgwindow-link' ).css( 'border-color', to_rgba(to,  GetControlVal('buttons_border_opacity') ));
		} );
	} );

	wp.customize( 'buttons_border_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.widget.sgwindow_widget_button .sgwindow-link' ).css( 'border-color', to_rgba(GetControlVal('buttons_border'), to));
		} );
	} );
	
	wp.customize( 'buttons_border_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('buttons_border_opacity', parseInt(to)/10);
		} );
	} );
	
//content
	wp.customize( 'content_color', function( value ) {
		value.bind( function( to ) {
			$( '.flex .content-container, #woocommerce-wrapper, .header-wrapper, .nothing-found, .archive-header, .content-search,.comments-area, .nav-link, .pagination.loop-pagination, .content-container' ).css( 'background-color', to_rgba(to,  GetControlVal('content_color_opacity') ));
		} );
	} );

	wp.customize( 'content_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.flex .content-container, #woocommerce-wrapper, .header-wrapper, .nothing-found, .archive-header, .content-search,.comments-area, .nav-link, .pagination.loop-pagination, .content-container' ).css( 'background-color', to_rgba(GetControlVal('content_color'), to));
		} );
	} );
	
	wp.customize( 'content_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('content_color_opacity', parseInt(to)/10);
		} );
	} );
	
//border
	wp.customize( 'content_border', function( value ) {
		value.bind( function( to ) {
			$( '.archive-header, .nothing-found, .content-container' ).css( 'border-color', to_rgba(to,  GetControlVal('content_border_opacity') ));
			$( '.site-content .entry-title' ).css( 'border-bottom-color', to_rgba(to,  GetControlVal('content_border_opacity') ));
		} );
	} );

	wp.customize( 'content_border_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.archive-header, .nothing-found, .content-container' ).css( 'border-color', to_rgba(GetControlVal('content_border'), to));
		} );
	} );
	
	wp.customize( 'content_border_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('content_border_opacity', parseInt(to)/10);
		} );
	} );
	
//text		
	wp.customize( 'content_text', function( value ) {
		value.bind( function( to ) {
			$( '.flex .content-container, #woocommerce-wrapper, .header-wrapper, .nothing-found, .archive-header, .content-search,.comments-area, .nav-link, .pagination.loop-pagination, .content-container' ).css( 'color', to );
		} );
	} );	
	
//menu background		
	wp.customize( 'menu1_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-1-navigation' ).css( 'background-color', to_rgba(to, GetControlVal('menu1_color_opacity')));
		} );
	} );	
	
	wp.customize( 'menu1_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.top-1-navigation' ).css( 'background-color', to_rgba(GetControlVal('menu1_color'), to));
		} );
	} );
	wp.customize( 'menu1_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('menu1_color_opacity', parseInt(to)/10);
		} );
	} );
	
	wp.customize( 'menu1_link', function( value ) {
		value.bind( function( to ) {
			$( '.top-1-navigation a' ).css( 'color', to);
		} );
	} );	

//menu (top) background		
	wp.customize( 'menu2_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-navigation' ).css( 'background', to_rgba(to, GetControlVal('menu2_color_opacity')));
		} );
	} );	
	
	wp.customize( 'menu2_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.top-navigation' ).css( 'background-color', to_rgba(GetControlVal('menu2_color'), to));
		} );
	} );
	wp.customize( 'menu2_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('menu2_color_opacity', parseInt(to)/10);
		} );
	} );
	
	wp.customize( 'menu2_link', function( value ) {
		value.bind( function( to ) {
			$( '.top-navigation a' ).css( 'color', to);
		} );
	} );	
	
//menu background		
	wp.customize( 'menu3_color', function( value ) {
		value.bind( function( to ) {
			$( '#footer-navigation' ).css( 'background-color', to_rgba(to, GetControlVal('menu3_color_opacity')));
		} );
	} );	
	
	wp.customize( 'menu3_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '#footer-navigation' ).css( 'background-color', to_rgba(GetControlVal('menu3_color'), to));
		} );
	} );
	wp.customize( 'menu3_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('menu3_color_opacity', parseInt(to)/10);
		} );
	} );
	
	wp.customize( 'menu3_link', function( value ) {
		value.bind( function( to ) {
			$( '#footer-navigation a' ).css( 'color', to);
		} );
	} );	
	
//menu widget		
	wp.customize( 'menu4_color', function( value ) {
		value.bind( function( to ) {
			$( '.wide .widget.widget_nav_menu' ).css( 'background-color', to_rgba(to, GetControlVal('menu4_color_opacity')));
		} );
	} );	
	
	wp.customize( 'menu4_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.wide .widget.widget_nav_menu' ).css( 'background-color', to_rgba(GetControlVal('menu4_color'), to));
		} );
	} );
	wp.customize( 'menu4_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('menu4_color_opacity', parseInt(to)/10);
		} );
	} );
	
	wp.customize( 'menu4_link', function( value ) {
		value.bind( function( to ) {
			$( '.wide .widget.widget_nav_menu .menu li ul li a' ).css( 'color', to);
		} );
	} );
	wp.customize( 'menu4_top', function( value ) {
		value.bind( function( to ) {
			$( '.wide .widget.widget_nav_menu .menu > li a' ).css( 'color', to);
		} );
	} );
	wp.customize( 'menu4_border', function( value ) {
		value.bind( function( to ) {
			$( '.wide .widget.widget_nav_menu > div > .menu > li > a' ).css( 'border-bottom-color', to);
		} );
	} );

//menu widget		
	wp.customize( 'widget1_color', function( value ) {
		value.bind( function( to ) {
			$( '.wide .widget.sgwindow_recent_posts' ).css( 'background-color', to_rgba(to, GetControlVal('widget1_color_opacity')));
		} );
	} );	
	
	wp.customize( 'widget1_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.wide .widget.sgwindow_recent_posts' ).css( 'background-color', to_rgba(GetControlVal('widget1_color'), to));
		} );
	} );
	wp.customize( 'widget1_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('widget1_color_opacity', parseInt(to)/10);
		} );
	} );
	
//footer sidebar background		
	wp.customize( 'sidebar2_color', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-footer' ).css( 'background-color', to_rgba(to, GetControlVal('sidebar2_color_opacity')));
		} );
	} );
	wp.customize( 'sidebar2_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-footer' ).css( 'background-color', to_rgba(GetControlVal('sidebar2_color'), to));
		} );
	} );
	
	wp.customize( 'sidebar2_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('sidebar2_color_opacity', parseInt(to)/10);
		} );
	} );
//footer sidebar text
	wp.customize( 'sidebar2_text', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-footer .widget' ).css( 'color', to);
			$( '.sidebar-footer .widget .widgettitle' ).css( 'color', to);
			$( '.sidebar-footer .widget .widget-title' ).css( 'color', to);
		} );
	} );
	
//footer sidebar link
	wp.customize( 'sidebar2_link', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-footer  .widget a' ).css( 'color', to);
		} );
	} );
	
//top sidebar background		
	wp.customize( 'sidebar1_color', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top-full .widget' ).css( 'background-color', to_rgba(to, GetControlVal('sidebar1_color_opacity')));
		} );
	} );
	
	wp.customize( 'sidebar1_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top-full .widget' ).css( 'background-color', to_rgba(GetControlVal('sidebar1_color'), to));
		} );
	} );
	
	wp.customize( 'sidebar1_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('sidebar1_color_opacity', parseInt(to)/10);
		} );
	} );
	
//top sidebar text
	wp.customize( 'sidebar1_text', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top-full .widget' ).css( 'color', to);
		} );
	} );
	
//top sidebar link
	wp.customize( 'sidebar1_link', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top-full .widget a' ).css( 'color', to);
		} );
	} );
	
//top sidebar header text color
	wp.customize( 'sidebar1_header_text', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top-full .widget .widgettitle' ).css( 'color', to);
			$( '.sidebar-top-full .widget .widget-title' ).css( 'color', to);
		} );
	} );	
	
	wp.customize( 'sidebar1_header_color', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top-full .widget .widgettitle' ).css( 'background-color', to_rgba(to, GetControlVal('sidebar1_header_color_opacity')));
			$( '.sidebar-top-full .widget .widget-title' ).css( 'background-color', to_rgba(to, GetControlVal('sidebar1_header_color_opacity')));
		} );
	} );
	
	wp.customize( 'sidebar1_header_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top-full .widget .widgettitle' ).css( 'background-color', to_rgba(GetControlVal('sidebar1_header_color'), to));
			$( '.sidebar-top-full .widget .widget-title' ).css( 'background-color', to_rgba(GetControlVal('sidebar1_header_color'), to));
		} );
	} );
	
	wp.customize( 'sidebar1_header_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('sidebar1_header_color_opacity', parseInt(to)/10);
		} );
	} );
	
//bf footer sidebar
//bf sidebar background		
	wp.customize( 'sidebar4_color', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-before-footer .widget' ).css( 'background-color', to_rgba(to, GetControlVal('sidebar4_color_opacity')));
		} );
	} );
	
	wp.customize( 'sidebar4_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-before-footer' ).css( 'background-color', to_rgba(GetControlVal('sidebar4_color'), to));
		} );
	} );
	
	wp.customize( 'sidebar4_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('sidebar4_color_opacity', parseInt(to)/10);
		} );
	} );
	
//bf sidebar text
	wp.customize( 'sidebar4_text', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-before-footer .widget' ).css( 'color', to);
		} );
	} );
	
//bf sidebar link
	wp.customize( 'sidebar4_link', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-before-footer .widget a' ).css( 'color', to);
		} );
	} );
	
//bf sidebar header text color
	wp.customize( 'sidebar4_header_text', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-before-footer .widget .widgettitle' ).css( 'color', to);
			$( '.sidebar-before-footer .widget .widget-title' ).css( 'color', to);
		} );
	} );
	
	wp.customize( 'sidebar4_header_color', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-before-footer .widget .widgettitle' ).css( 'background-color', to_rgba(to, GetControlVal('sidebar4_header_color_opacity')));
			$( '.sidebar-before-footer .widget .widget-title' ).css( 'background-color', to_rgba(to, GetControlVal('sidebar4_header_color_opacity')));
		} );
	} );
	
	wp.customize( 'sidebar4_header_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-before-footer .widget .widgettitle' ).css( 'background-color', to_rgba(GetControlVal('sidebar4_header_color'), to));
			$( '.sidebar-before-footer .widget .widget-title' ).css( 'background-color', to_rgba(GetControlVal('sidebar4_header_color'), to));
		} );
	} );
	
	wp.customize( 'sidebar4_header_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('sidebar4_header_color_opacity', parseInt(to)/10);
		} );
	} );
	
	
//sidebars background		
	wp.customize( 'column_background_url', function( value ) {
		value.bind( function( to ) {
			$( '.background-fixed' ).css( 'backgroundImage', 'url(' + to + ')');
		} );
	} );
	
	
//column

//background		
	wp.customize( 'sidebar3_color', function( value ) {
		value.bind( function( to ) {
			$( '.main-area' ).css( 'background-color', to_rgba(to, GetControlVal('sidebar3_color_opacity')));
		} );
	} );
	
	wp.customize( 'sidebar3_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.main-area' ).css( 'background-color', to_rgba(GetControlVal('sidebar3_color'), to));
		} );
	} );
	
	wp.customize( 'sidebar3_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('sidebar3_color_opacity', parseInt(to)/10);
		} );
	} );
	
//text
	wp.customize( 'sidebar3_text', function( value ) {
		value.bind( function( to ) {
			$( '.column  .widget' ).css( 'color', to);
		} );
	} );
	
//link
	wp.customize( 'sidebar3_link', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget a' ).css( 'color', to);
		} );
	} );
	
//border
	wp.customize( 'column_border', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget' ).css( 'border-color', to);
		} );
	} );
	
//column header background color
	wp.customize( 'column_header_color', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget .widgettitle' ).css( 'background-color', to_rgba(to, GetControlVal('column_header_color_opacity')));
			$( '.column .widget .widget-title' ).css( 'background-color', to_rgba(to, GetControlVal('column_header_color_opacity')));
		} );
	} );
	wp.customize( 'column_header_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget .widgettitle' ).css( 'background-color', to_rgba(GetControlVal('column_header_color'), to));
			$( '.column .widget .widget-title' ).css( 'background-color', to_rgba(GetControlVal('column_header_color'), to));
		} );
	} );
	
	wp.customize( 'column_header_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('column_header_color_opacity', parseInt(to)/10);
		} );
	} );
	
//column header text color
	wp.customize( 'column_header_text', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget .widgettitle' ).css( 'color', to);
			$( '.column .widget .widget-title' ).css( 'color', to);
		} );
	} );
	
	wp.customize( 'column_widget_back', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget' ).css( 'background-color', to_rgba(to, GetControlVal('column_widget_back_opacity')));
		} );
	} );
	
	wp.customize( 'column_widget_back_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget' ).css( 'background-color', to_rgba(GetControlVal('column_widget_back'), to));
		} );
	} );
	
	wp.customize( 'column_widget_back_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal('column_widget_back_opacity', parseInt(to)/10);
		} );
	} );
	
		
//column widget border
	wp.customize( 'border_color', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget' ).css( 'border-color', to);
		} );
	} );
	
	/* layout builder */
	
	wp.customize( 'site_name_back_2', function( value ) {
		value.bind( function( to ) {
			$( '.head-wrapper' ).css( 'background', to_rgba( to,  GetControlVal( 'site_name_back_2_opacity' ) ) );
		} );
	} );
	
	wp.customize( 'site_name_back_2_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.head-wrapper' ).css( 'background-color', to_rgba( GetControlVal('site_name_back_2'), to ) );
		} );
	} );
	
	wp.customize( 'site_name_back_2_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'site_name_back_2_opacity', parseInt( to ) /10 );
		} );
	} );	
	
//column background color
	wp.customize( 'sidebar32_back', function( value ) {
		value.bind( function( to ) {	
			$( '#page .sidebar-1, #page .sidebar-2' ).css( 'background-color', to_rgba( to, GetControlVal('sidebar32_back_opacity') ) );		
		} );
	} );
	wp.customize( 'sidebar32_back_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.#page .sidebar-1, #page .sidebar-2' ).css( 'background-color', to_rgba( GetControlVal('sidebar32_back'), to ) );
		} );
	} );
	
	wp.customize( 'sidebar32_back_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'sidebar32_back_opacity', parseInt( to ) /10 );
		} );
	} );	
	
	/* Sidebar Layout */
	
	wp.customize( 'layout_color', function( value ) {
		value.bind( function( to ) {	
			$( '.widget.sgwindow_side_bar' ).css( 'background-color', to_rgba( to, GetControlVal('layout_color_opacity') ) );		
		} );
	} );
	wp.customize( 'layout_color_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.widget.sgwindow_side_bar' ).css( 'background-color', to_rgba( GetControlVal('layout_color'), to ) );
		} );
	} );
	
	wp.customize( 'layout_color_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'layout_color_opacity', parseInt( to ) /10 );
		} );
	} );	
	
	wp.customize( 'layout_content', function( value ) {
		value.bind( function( to ) {	
			$( '.my-sidebar-layout' ).css( 'background-color', to_rgba( to, GetControlVal('layout_content_opacity') ) );		
		} );
	} );
	wp.customize( 'layout_content_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.my-sidebar-layout' ).css( 'background-color', to_rgba( GetControlVal('layout_content'), to ) );
		} );
	} );
	
	wp.customize( 'layout_content_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'layout_content_opacity', parseInt( to ) /10 );
		} );
	} );
	
	//border
	wp.customize( 'layout_border', function( value ) {
		value.bind( function( to ) {	
			$( '.my-sidebar-layout' ).css( 'border-color', to_rgba( to, GetControlVal('layout_border_opacity') ) );		
		} );
	} );
	
	wp.customize( 'layout_border_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.my-sidebar-layout' ).css( 'border-color', to_rgba( GetControlVal('layout_border'), to ) );
		} );
	} );
	
	wp.customize( 'layout_border_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'layout_border_opacity', parseInt( to ) /10 );
		} );
	} );	
	
	//title
	wp.customize( 'layout_title', function( value ) {
		value.bind( function( to ) {	
			$( '#page .widget .my-sidebar-layout .widget .widget-title, #page .widget .my-sidebar-layout .widget .widgettitle' ).css( 'background-color', to_rgba( to, GetControlVal('layout_title_opacity') ) );
		} );
	} );
	
	wp.customize( 'layout_title_opacity', function( value ) {
		value.bind( function( to ) {
			$( '#page .widget .my-sidebar-layout .widget .widget-title, #page .widget .my-sidebar-layout .widget .widgettitle' ).css( 'background-color', to_rgba( GetControlVal('layout_title'), to ) );
		} );
	} );
	
	wp.customize( 'layout_title_opacity_range', function( value ) {
		value.bind( function( to ) {
			SetControlVal( 'layout_title_opacity', parseInt( to ) /10 );
		} );
	} );
		
	function SetColor(cname, newColor) {
		//update colors in picker
	    var control = api.control(cname); 
		if(control){
			control.setting.set(newColor);	
			picker = control.container.find('.color-picker-hex');
			if(picker)
				if(newColor == '')
					picker.val( control.setting() ).wpColorPicker().trigger( 'clear' );
				else
					picker.val( control.setting() ).wpColorPicker().trigger( 'change' );
		}
		return;
	}
	function SetControlVal(name, newVal) {
	    var control = api.control(name); 
		if( control ){
			control.setting.set( newVal );
		}
		return;
	}	
	function GetControlVal(name) {
	    var control = api.control(name); 
		var rez = '';
		if( control ){
			rez = control.setting.get();
		}
		return rez;
	}	
	function hideControl(cname) {
	    var control = api.control(cname); 
		if(control){
			control.container.toggle( 0 );
		}
	}
	function showControl(cname) {
	    var control = api.control(cname); 
		if(control){
			control.container.toggle( 1 );
		}
	}
	function removeHeader(name) {
		var control = api.control(name);
		if( control ) {
			control.removeImage();
		}
	}
	function SetHeader(name, newImage, height, width) {
		var control = api.control(name);
		if( control ) {
			var choice, data = {};
			data.url = newImage;
			data.attachment_id = 0;
			data.thumbnail_url = newImage;
			data.timestamp = _.now();
			if (width) {
				data.width = width;
			}
			if (height) {
				data.height = height;
			}
			choice = new api.HeaderTool.ImageModel({
				header: data,
				choice: newImage.split('/').pop()
			});
			api.HeaderTool.currentHeader.set(choice.toJSON());
			choice.save();
		}
		return;
	}
	
	function to_rgba( color, opacity) {
		var rgbaCol = 'rgba(' + parseInt(color.slice(-6,-4),16)
		+ ',' + parseInt(color.slice(-4,-2),16)
		+ ',' + parseInt(color.slice(-2),16)
		+',' + opacity+')';
		return rgbaCol;
	}	
	
} )( jQuery );