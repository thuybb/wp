<?php
/**
 * Add new fields to customizer, create panel 'Other' and register postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since SG Window 1.0.0
 */
 
function sgwindow_customize_register_other( $wp_customize ) {

	$defaults = sgwindow_get_defaults();
	
	$wp_customize->add_panel( 'other', array(
		'priority'       =>106,
		'title'          => __( 'Customize Other Settings', 'sg-window' ),
		'description'    => __( 'All other settings.', 'sg-window' ),
	) );

	$section_priority = 10;
	
//New section in customizer: Logotype
	$wp_customize->add_section( 'sgwindow_theme_logotype', array(
		'title'          => __( 'Logotype', 'sg-window' ),
		'priority'       => $section_priority++,
		'panel'  => 'other',
	) );
	
//New setting in Logotype section: Logo Image
	$wp_customize->add_setting( 'logotype_url', array(
		'default'        => get_template_directory_uri().'/img/logo.png',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_url'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'logotype_url', array(
		'label'      => __('Logotype Image', 'sg-window'),
		'section'    => 'sgwindow_theme_logotype',
		'settings'   => 'logotype_url',
		'priority'   => '1',
	) ) );
	
//New section in customizer: Fixed Background
	$wp_customize->add_section( 'column_background_url', array(
		'title'          => __( 'Fixed Background', 'sg-window' ),
		'priority'       => $section_priority++,
		'panel'  => 'background',
	) );
//column background image
	$wp_customize->add_setting( 'column_background_url', array(
		'default'        => $defaults['column_background_url'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_background_url'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'column_background_url', array(
		'label'      => __('Site Background', 'sg-window'),
		'section'    => 'column_background_url',
		'settings'   => 'column_background_url',
		'priority'   => 1,
	) ) );
	
//background position
	$wp_customize->add_setting( 'top', array(
		'default'        => $defaults['top'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_background_position'
	) );
	$wp_customize->add_control( 'top', array(
		'label'   => __( 'Vertical position', 'sg-window' ),
		'section' => 'column_background_url',
		'settings'   => 'top',
		'type'       => 'select',
		'priority'   => 2,
		'choices'	 => array ('top' => __('Top', 'sg-window'),
								'center' => __('Center', 'sg-window'), 
								'bottom' => __('Bottom', 'sg-window'))
	) );	

//New section in customizer: Navigation Options
	$wp_customize->add_section( 'sgwindow_nav_options', array(
		'title'          => __( 'Navigation menu settings', 'sg-window' ),
		'priority'       => $section_priority++,
		'panel'  => 'navigation',
	) );	
	
//New setting in Navigation section: Switch On First Top Menu
	$wp_customize->add_setting( 'is_show_top_menu', array(
		'default'        => $defaults['is_show_top_menu'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'is_show_top_menu', array(
		'label'      => __( 'Switch On First Top Menu', 'sg-window' ),
		'section'    => 'sgwindow_nav_options',
		'settings'   => 'is_show_top_menu',
		'type'       => 'checkbox',
		'priority'   => $section_priority++,
		'panel'  => 'other',
	) );
	
//New setting in Navigation section: Switch On Second Top Menu
	$wp_customize->add_setting( 'is_show_secont_top_menu', array(
		'default'        => $defaults['is_show_secont_top_menu'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'sgwindow_is_show_secont_top_menu', array(
		'label'      => __( 'Switch On Second Top Menu', 'sg-window' ),
		'section'    => 'sgwindow_nav_options',
		'settings'   => 'is_show_secont_top_menu',
		'type'       => 'checkbox',
		'priority'       => 22,
	) );
	
//New setting in Navigation section: Switch On Footer Menu
	$wp_customize->add_setting( 'is_show_footer_menu', array(
		'default'        => $defaults['is_show_footer_menu'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'sgwindow_is_show_footer_menu', array(
		'label'      => __( 'Switch On Footer Menu', 'sg-window' ),
		'section'    => 'sgwindow_nav_options',
		'settings'   => 'is_show_footer_menu',
		'type'       => 'checkbox',
		'priority'       => 23,
	) );
	
//New section in the customizer: Scroll To Top Button
	$wp_customize->add_section( 'sgwindow_scroll', array(
		'title'          => __( 'Scroll To Top Button', 'sg-window' ),
		'priority'       => $section_priority++,
		'panel'  => 'other',
	) );
	
	$wp_customize->add_setting( 'scroll_button', array(
		'default'        => $defaults['scroll_button'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'refresh',
		'sanitize_callback' => 'sgwindow_sanitize_scroll_button'
	) );
	
	
	$wp_customize->add_control( 'scroll_button', array(
		'label'      => __( 'How to display the scroll to top button', 'sg-window' ),
		'section'    => 'sgwindow_scroll',
		'settings'   => 'scroll_button',
		'type'       => 'select',
		'priority'   => 1,
		'choices'	 => array ('none' => __('None', 'sg-window'),
								'right' => __('Right', 'sg-window'), 
								'left' => __('Left', 'sg-window'),
								'center' => __('Center', 'sg-window'))
	) );
	
	$wp_customize->add_setting( 'scroll_animate', array(
		'default'        => $defaults['scroll_animate'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_scroll_effect'
	) );
	
	$wp_customize->add_control( 'scroll_animate', array(
		'label'      => __( 'How to animate the scroll to top button', 'sg-window' ),
		'section'    => 'sgwindow_scroll',
		'settings'   => 'scroll_animate',
		'type'       => 'select',
		'priority'   => 1,
		'choices'	 => array ('none' => __('None', 'sg-window'),
								'move' => __('Jump', 'sg-window')), 
	) );
	
//New section in the customizer: Favicon
	$wp_customize->add_section( 'sgwindow_favicon', array(
		'title'          => __( 'Favicon', 'sg-window' ),
		'description'    => __( 'You can select an Icon to be shown at the top of browser window by uploading from your computer. (Size: [16X16] px)', 'sg-window' ),
		'priority'       => $section_priority++,
		'panel'  => 'other',
	) );
	
	$wp_customize->add_setting( 'favicon', array(
		'default'        => $defaults['favicon'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_url'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'favicon', array(
		'label'      => __('Favicon', 'sg-window'),
		'section'    => 'sgwindow_favicon',
		'settings'   => 'favicon',
		'priority'   => '1',
	) ) );
	
	sgwindow_create_social_icons_section( $wp_customize );
	
	
	$wp_customize->add_setting( 'is_header_on_front_page_only', array(
		'default'        => $defaults['is_header_on_front_page_only'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );
	

	$wp_customize->add_control( 'is_header_on_front_page_only', array(
		'label'      => __( 'Display Header Image on the Front Page only', 'sg-window' ),
		'section'    => 'header_image',
		'settings'   => 'is_header_on_front_page_only',
		'type'       => 'checkbox',
		'priority'       => 40,
	) );	
	
	$wp_customize->add_setting( 'is_text_on_front_page_only', array(
		'default'        => $defaults['is_text_on_front_page_only'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );
	

	$wp_customize->add_control( 'is_text_on_front_page_only', array(
		'label'      => __( 'Display Header Text on the Front Page only', 'sg-window' ),
		'section'    => 'header_image',
		'settings'   => 'is_text_on_front_page_only',
		'type'       => 'checkbox',
		'priority'       => 41,
	) );
	
	$wp_customize->add_section( 'check', array(
		'title'          => __( '--', 'sg-window' ),
		'priority'       => 200,
		'panel'  => 'other',
	) );
	
	if ( '' == sgwindow_get_theme_mod( 'are_we_saved', '' ) ) {
	
		$wp_customize->add_setting( 'are_we_saved', array(
			'type'			 => 'theme_mod',
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sgwindow_sanitize_checkbox'
		) );

		$wp_customize->add_control( 'are_we_saved', array (
			'label'      => __( '--', 'sg-window' ),
			'section'    => 'check',
			'settings'   => 'are_we_saved',
			'type'       => 'checkbox',
			'priority'   => 1,
		) );

	}
	
	$wp_customize->add_setting( 'max_id', array(
		'type'			 => 'theme_mod',
		'default'        => '0',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'max_id', array (
		'label'      => __( 'Max id', 'sg-window' ),
		'section'    => 'check',
		'settings'   => 'max_id',
		'type'       => 'input',
	) );
	
}
add_action( 'customize_register', 'sgwindow_customize_register_other' );
/**
 * Create icon section in Customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 *
 * @since SG Window 1.0.0
 */

function sgwindow_create_social_icons_section( $wp_customize ){
	$icons = sgwindow_social_icons();
	
//New section in customizer: Featured Image
	$wp_customize->add_section( 'sgwindow_icons', array(
		'title'          => __( 'Social Media Icons', 'sg-window' ),
		'description'          => __( 'Add your Social Media Links. Use widget Social Icons to add icons to your the site.', 'sg-window' ),
		'priority'       => 101,
		'panel'  => 'other',
	) );
	
	$i = 0;
	foreach($icons as $id => $icon ) {
		$wp_customize->add_setting( $id, array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sgwindow_sanitize_url'
		) );
		
		$wp_customize->add_control( 'sgwindow_icons_'.$id, array(
			'label'      => strtoupper($id),
			'section'    => 'sgwindow_icons',
			'settings'   => $id,
			'type'       => 'text',
			'priority'   => $i++,
		) );	
	}
}
/**
 * Return array Default Icons
 *
 * @since SG Window 1.0.0
 */
function sgwindow_social_icons(){
	$icons = array(
					'facebook' => '',
					'twitter' => '',
					'google' => '',
					'wordpress' => '',
					'blogger' => '',
					'yahoo' => '',
					'youtube' => '',
					'myspace' => '',
					'livejournal' => '',
					'linkedin' => '',
					'friendster' => '',
					'friendfeed' => '',
					'digg' => '',
					'delicious' => '',
					'aim' => '',
					'ask' => '',
					'buzz' => '',
					'tumblr' => '',		
					'flickr' => '',						
					'rss' => '',
				  );
	return apply_filters( 'sgwindow_icons', $icons);
}
