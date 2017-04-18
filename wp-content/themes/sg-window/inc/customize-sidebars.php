<?php
 /**
 * Add new fields to customizer, create panel 'sidebars'
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since SG Window 1.0.0
 */
add_action( 'customize_register', 'sgwindow_creare_section_sidebars', 11 );
function sgwindow_creare_section_sidebars( $wp_customize ) {
	$defaults = sgwindow_get_defaults();
	
	/* Create default, blog, home, page, shop sections for choosing custom sidebars for different types of pages */
	
	$wp_customize->add_panel( 'sidebars', array(
		'priority'       => 107,
		'title'          => __( 'Customize Sidebars', 'sg-window' ),
		'description'    => __( 'In this section you can add or remove sidebars for particular pages.', 'sg-window' ),
	) );	

	$section_priority = 10;

	foreach( $defaults['defined_sidebars'] as $sidebar_type_id => $sidebar_type) {
		if( 'static' == $sidebar_type_id )
			continue;
	
		$wp_customize->add_section( $sidebar_type_id, array(
			'priority'       => $section_priority++,
			'title'          => $sidebar_type['title'],
			'description'    => ($sidebar_type_id != 'default' ? __( 'You can add custom sidebars for the page(s) "', 'sg-window' ) . ' ' . $sidebar_type['title'] . __( '" by selecting options in this section. Default sidebars won\'t be shown on this page(s).', 'sg-window' ) 
														: __( 'Default sidebars for all pages, post and custom post types.', 'sg-window' )),
			'panel'  => 'sidebars',
		) );	
	
		$priority = 100;
		
		//theme mod names: $defaults['defined_sidebars'][$x]
		$wp_customize->add_setting( $sidebar_type_id, array(
			'type'			 => 'theme_mod',
			'default'        => $sidebar_type['use'],
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sgwindow_sanitize_checkbox'
		) );
		
		if( 'default' == $sidebar_type_id)
			$message = __( 'Register default sidebars for all pages', 'sg-window');
		else
			$message = __( 'Override default sidebars by custom sidebars on ', 'sg-window' ) . ' ' . $sidebar_type['title'] . ' ' . __( ' (must be checked). Please, choose sidebars which you want to use on this page.', 'sg-window' );

		$wp_customize->add_control( $sidebar_type_id, array(
			'label'      => $message,
			'section'    => 'layout_' . $sidebar_type_id,
			'settings'   => $sidebar_type_id,
			'type'       => 'checkbox',
			'priority'       => $priority++,
		) );
		
		//theme mod names: $defaults['theme_sidebars'][$x]['slug']_$defaults['defined_sidebars'][$x]
		foreach( $defaults['theme_sidebars'] as $slug => $sidebars ) {
			if($sidebars['is_constant'] != '1') {

				$wp_customize->add_setting( $slug.'_'.$sidebar_type_id, array(
					'type'			 => 'theme_mod',
					'default'        => $sidebar_type[$slug],
					'capability'     => 'edit_theme_options',
					'sanitize_callback' => 'sgwindow_sanitize_checkbox'
				) );

				$wp_customize->add_control( $slug.'_'.$sidebar_type_id, array(
					'label'      => $sidebars['title'],
					'section'    => 'layout_' . $sidebar_type_id,
					'settings'   => $slug.'_'.$sidebar_type_id,
					'type'       => 'checkbox',
					'priority'       => $priority++,
				) );
			}
		}	
	}

	/* Create sections for every page with custom sidebars */
	$section_priority = 100;
	
	$page_sidebars = ( array )get_theme_mod( 'page_sidebars', null);
	$new_page_sidebars = null;

	foreach( $page_sidebars as $id => $page_id ) {
	/* theme mods names: page_[id] - bool [0:1]; $slug_page_[id]*/
		$name = 'page_'.$page_id;
				
		//delete all theme mods from this section if we don't use it
		if( '1' != get_theme_mod( $name, null )  ) {
			remove_theme_mod( $name );
			
			foreach( $defaults['theme_sidebars'] as $slug => $sidebars ) {
				remove_theme_mod( $slug.'_'.$name );
			}
			
		} else {
		
			$new_page_sidebars[ $id ] = $page_id;

			$wp_customize->add_section( $name, array(
				'priority'       => $section_priority++,
				'title'          => __('Page [', 'sg-window'). get_the_title( $page_id ). ' ('.$page_id.')]',
				'description'    =>  __( 'Per page sidebars for the page [', 'sg-window' ). get_the_title( $page_id ). ']',
				'panel'  => 'sidebars',
			) );	
		
			$priority = 1;
			
		//theme mod names: $defaults['defined_sidebars'][$x]
			$wp_customize->add_setting( $name, array(
				'type'			 => 'theme_mod',
				'default'        => '',
				'capability'     => 'edit_theme_options',
				'sanitize_callback' => 'sgwindow_sanitize_checkbox'
			) );

			$wp_customize->add_control( $name, array(
				'label'      => __( 'Uncheck this mark to remove section and custom sidebars for the page [', 'sg-window' ). get_the_title( $page_id ). ']',
				'section'    => $name,
				'settings'   => $name,
				'type'       => 'checkbox',
				'priority'       => $priority++,
			) );
				
			//theme mod names: $defaults['theme_sidebars'][$x]['slug']_$defaults['defined_sidebars'][$x]
			foreach( $defaults['theme_sidebars'] as $slug => $sidebars ) {
				if($sidebars['is_constant'] == '1')
					continue;

				$wp_customize->add_setting( $slug.'_'.$name, array(
					'type'			 => 'theme_mod',
					'default'        => '',
					'capability'     => 'edit_theme_options',
					'sanitize_callback' => 'sgwindow_sanitize_checkbox'
				) );

				$wp_customize->add_control( $slug.'_'.$name, array(
					'label'      => $sidebars['title'],
					'section'    => $name,
					'settings'   => $slug.'_'.$name,
					'type'       => 'checkbox',
					'priority'       => $priority++,
				) );
			}	
		}
	}
	
	//refresh theme mod
	set_theme_mod( 'page_sidebars', $new_page_sidebars);
		
	/* Create 'per page' section */
	
	$wp_customize->add_section( 'sidebars_custom', array(
		'priority'       => 200,
		'title'          => __( 'Custom sidebars', 'sg-window' ),
		'description'    => __( 'In this section you can create a sidebar for a certain page. Select page and press save. Refresh Customizer to see newly added section for that page.', 'sg-window' ),
		'panel'  => 'sidebars',
	) );
	
	$priority = 1;
	

	$wp_customize->add_setting( 'pages', array(
		'type'			 => 'page_sidebar',
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );


	$wp_customize->add_control( 'pages', array(
		'label'      => __( 'Select a page and save data. Refresh Customizer to customize new section.', 'sg-window' ),
		'section'    => 'sidebars_custom',
		'settings'   => 'pages',
		'type'       => 'dropdown-pages',
		'priority'       => $priority++,
	) );
	
}

/**
 * Create theme mods for a new section in the Customizer for the page with id = $value (setting's type: page_sidebar)
 * 
 * @param $value int page id
 * @param $setting Customizer setting object
 * 
 * @since SG Window 1.0.0
 */
function sgwindow_save_custom_sidebar( $value ) {
	//sanitize
	$value = absint( $value );
	if( 0 == $value )
		return;
		
	if( null === get_post($value) )
		return;
		
	$defaults = sgwindow_get_defaults();

	//save page id in array 'page_sidebars'	
	$page_sidebars = ( array )get_theme_mod( 'page_sidebars', null);
	$new_page_sidebars = null;
	$page_sidebars[ $value ] = $value;
	set_theme_mod( 'page_sidebars', $page_sidebars);
	
	foreach( $defaults['theme_sidebars'] as $slug => $sidebars ) {
		if( '1' == $sidebars['is_constant'] )
			continue;
		// theme mod: sidebar-top_page_1 [slug]_page_[id]
		$name = $slug.'_custom';
		set_theme_mod( $slug.'_page_'.$value, ( '1' == $sidebars['is_checked'] ? '1' : '' ) );
	}
	
	// theme mod: page_[id]
	set_theme_mod( 'page_'.$value,  '1');
}
add_action( 'customize_update_page_sidebar', 'sgwindow_save_custom_sidebar' );

/**
 * Register sidebars and widgetized areas.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_widgets_init() {

	$defaults = sgwindow_get_defaults();

	/* Register Per Page sidebars */
	
	$page_sidebars = ( array )get_theme_mod( 'page_sidebars', null);

	foreach( $page_sidebars as $id => $page_id ) {
	/* theme mods names: page_[id] - bool [0:1]; $slug_page_[id]*/
		$name = 'page_'.$page_id;
				
	//theme mod names: $defaults['theme_sidebars'][$x]['slug']_$defaults['defined_sidebars'][$x]
		foreach( $defaults['theme_sidebars'] as $slug => $sidebars ) {
			if( '1' == $sidebars['is_constant'] )
				continue;
				
			//is this section active?
			if( '1' != get_theme_mod($name, null) )
				continue;			
				
			//is this sidebar active
			if( '1' != get_theme_mod($slug.'_'.$name, null ) )
				continue;
			
			//register sidebar example of the sidebar id: [top-sidebar_page_12]
			register_sidebar( array(
				'name' => __( '[', 'sg-window') . $page_id.__( '] ', 'sg-window') . $sidebars['title'] . ', ' . get_the_title( $page_id ),
				'id' => $slug . '-' . $name,
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => "</aside>",
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );

		}
	}
	
	// Register all sidebars
	foreach( $defaults['defined_sidebars'] as $slug => $defined_sidebars ) {
		foreach( $defaults['theme_sidebars'] as $id => $theme_sidebars ) {
			if( '1' == $theme_sidebars['is_constant'] )
				continue;
			//is this type of sidebars in use
			if( '1' != get_theme_mod( $slug, $defined_sidebars['use'] ) && ! class_exists( 'WP_Customize_Control' ) )
				continue;

			$def = ( isset( $defined_sidebars[ $id ]) ? $defined_sidebars[ $id ] : '');
			
			$is_active = get_theme_mod( $id.'_'.$slug, 'empty' );
						
			if( 'empty' == $is_active ) 
				$is_active = $def;
			
			if( '1' == $is_active || class_exists( 'WP_Customize_Control' ) ) {
			
				register_sidebar( array(
					'name' => $defined_sidebars['title'].' '.$theme_sidebars['title'],
					'id' => $id.'-'.$slug,
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => "</aside>",
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>',
				) );					
			}
		}
	}
	
	// register constant sidebars
	foreach( $defaults['theme_sidebars'] as $id => $theme_sidebars ) {
		if( '1' != $theme_sidebars['is_constant'] )
			continue;
		register_sidebar( array(
			'name' => $theme_sidebars['title'],
			'id' => $id,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );					
	}
}
add_action( 'widgets_init', 'sgwindow_widgets_init' );

/**
 * Return sidebar slug for the current page
 *
 * @return string sidebar slug or null
 * @since SG Window 1.0.0
 */
function sgwindow_get_sidebar_slug() {
	global $sgwindow_sidebar_slug;
	if( isset($sgwindow_sidebar_slug) )
		return $sgwindow_sidebar_slug;

	$defaults = sgwindow_get_defaults();
	
	/* check for per page sidebars */
	
	$page_sidebars = ( array )get_theme_mod( 'page_sidebars', null );
	
	if( is_page() ) {
		$page_object = get_queried_object();
		$page_id     = get_queried_object_id();
		if( isset( $page_sidebars[ $page_id ]) ) {
			$sgwindow_sidebar_slug = apply_filters( 'sg_window_sidebar_slug', 'page_'.$page_id );
			return $sgwindow_sidebar_slug;
		}
	}
		
	foreach( array_reverse( $defaults['defined_sidebars'] ) as $slug => $defined_sidebars ) {
	
		$def = $defined_sidebars['use'];
				
		$is_active_sidebar = get_theme_mod( $slug, '0' );
		
		if( '0' == $is_active_sidebar )
			$is_active_sidebar = $def;
				
		if( '1' != $is_active_sidebar )
			continue;
			
		if( '' == $defined_sidebars['callback'] ) {
			$sgwindow_sidebar_slug = apply_filters( 'sg_window_sidebar_slug', $slug );
			return $sgwindow_sidebar_slug;
		}
		
		if( call_user_func( $defined_sidebars['callback'], $defined_sidebars['param'] ) ) {
			$sgwindow_sidebar_slug = apply_filters( 'sg_window_sidebar_slug', $slug );
			return $sgwindow_sidebar_slug;
		}
	}
	return apply_filters( 'sg_window_sidebar_slug', null );
}

/**
 * Return sidebar slug for the page with given id
 *
 * @return string sidebar slug or null
 * @since SG Window 1.0.0
 */
function sgwindow_get_page_sidebar_slug( $page_id ) {

	$defaults = sgwindow_get_defaults();
	
	/* check for per page sidebars */
	
	$page_sidebars = ( array )get_theme_mod( 'page_sidebars', null );

	if( isset($page_sidebars[ $page_id ]) ) {
		$slug = 'page_'.$page_id;
		return $slug;
	}	
	else { 
	
	/* check for page sidebars */		
		$is_active_sidebar = get_theme_mod( 'page', 'empty' );
			if( 'empty' != $is_active_sidebar )
				$slug = 'page';			
			else
				$slug = 'default';
		
		return $slug;
		
	}
	
	return null;
}
/**
 * Check for WooCommerce pages.
 *
 * @return bool true on success
 * @since SG Window 1.0.0
 */
function sgwindow_is_shop() {
	if( function_exists('is_woocommerce') && is_woocommerce() && ( is_shop() || is_archive() ) )
		return true;
	return false;
}
/**
 * Check for WooCommerce pages.
 *
 * @return bool true on success
 * @since SG Window 1.0.0
 */
function sgwindow_is_shop_page() {
	if( function_exists('is_woocommerce') && is_woocommerce() )
		return true;
	return false;
}
/**
 * Check for both Jetpack's Portfolio archive/index page.
 *
 * @return bool true on success
 * @since SG Window 1.0.0
 */
function sgwindow_is_portfolio() {
	if( is_tax('jetpack-portfolio-type') || ('jetpack-portfolio' == get_post_type() && ! is_singular('jetpack-portfolio')) && ! is_search() )
		return true;
	return false;
}
/**
 * Check for Jetpack's Portfolio singular page.
 *
 * @return bool true on success
 * @since SG Window 1.0.0
 */
function sgwindow_is_portfolio_page() {

	if( is_singular('jetpack-portfolio') ) {
		return true;
	}
	return false;
}