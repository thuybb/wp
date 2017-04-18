<?php
/**
 * Add new fields to customizer for the theme layout.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since SG Window 1.0.0
 */
 
add_action( 'customize_register', 'sgwindow_create_section_layout', 20 );

function sgwindow_create_section_layout( $wp_customize ) {
	$defaults = sgwindow_get_defaults();
		
	$wp_customize->add_panel( 'layout', array(
		'priority'       => 1,
		'title'          => __( 'Customize Layout', 'sg-window' ),
		'description'    => __( 'In this section you can choose layout settings.', 'sg-window' ),
	) );

	$section_priority = 10;
	$priority = 1;
	
	$wp_customize->add_section( 'size', array(
		'priority'       => $section_priority++,
		'title'          => __( 'Site size', 'sg-window' ),
		'description'    => __( 'You can control main dimensions of your website from this section', 'sg-window' ),
		'panel'  => 'layout',
	) );
//site width range + text
	$wp_customize->add_setting( 'width_site_range', array(
		'type'			 => 'empty',
		'default'        => sgwindow_get_theme_mod('width_site'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_site_range', array(
		'label'      => __( '(px)', 'sg-window' ),
		'section'    => 'size',
		'settings'   => 'width_site_range',
		'type'       => 'range',
		'input_attrs' => array(
			'min'   => 960,
			'max'   => 2200,
			'step'  => 1,),
		'priority' => $priority++,
	));
	
	$wp_customize->add_setting( 'width_site', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_site'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'sgwindow_sanitize_range_width'
	) );

	$wp_customize->add_control( 'width_site', array(
		'label'      => __( 'Width of the site', 'sg-window' ),
		'section'    => 'size',
		'settings'   => 'width_site',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	
//Content full width
	
	$wp_customize->add_setting( 'width_content_no_sidebar', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_content_no_sidebar'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_range_content'
	) );

	$wp_customize->add_control( 'width_content_no_sidebar', array(
		'label'      => __( 'Max width of the content area (no columns layout)', 'sg-window' ),
		'section'    => 'size',
		'settings'   => 'width_content_no_sidebar',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
//content area width range + text
	$wp_customize->add_setting( 'width_main_wrapper_range', array(
		'type'			 => 'empty',
		'default'        => sgwindow_get_theme_mod('width_main_wrapper'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_main_wrapper_range', array(
		'label'      => __( '(px)', 'sg-window' ),
		'section'    => 'size',
		'settings'   => 'width_main_wrapper_range',
		'type'       => 'range',
		'priority' => $priority++,
		'input_attrs' => array(
			'min'   => 600,
			'max'   => 2200,
			'step'  => 1,
	) ));
	
	$wp_customize->add_setting( 'width_main_wrapper', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_main_wrapper'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'sgwindow_sanitize_range_content'
	) );

	$wp_customize->add_control( 'width_main_wrapper', array(
		'label'      => __( 'Width of the content area (including columns)', 'sg-window' ),
		'section'    => 'size',
		'settings'   => 'width_main_wrapper',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'content_style', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['content_style'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_header_style'
	) );

	$wp_customize->add_control( 'content_style', array(
		'label'   => __( 'Content style', 'sg-window' ),
		'section' => 'size',
		'settings'   => 'content_style',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => array ('boxed' => __('Boxed', 'sg-window'),
								'full' => __('Full Width', 'sg-window'))
	) );
	
	
//Featured Image

	$wp_customize->add_section( 'post_thumbnail_size', array(
		'priority'       => $section_priority++,
		'title'          => __( 'Featured Image', 'sg-window' ),
		'description'    => __( 'Image Size', 'sg-window' ),
		'panel'  => 'layout',
	) );	
	
	$wp_customize->add_setting( 'post_thumbnail_size', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['post_thumbnail_size'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'post_thumbnail_size', array(
		'label'      => __( 'Width of the Featured Image (Images should be updated with Regenerate Thumbnails plugin).', 'sg-window' ),
		'section'    => 'post_thumbnail_size',
		'settings'   => 'post_thumbnail_size',
		'type'       => 'number',
		'priority'       => $priority++,
	) );

	
//Columns width

	$wp_customize->add_section( 'columns', array(
		'priority'       => $section_priority++,
		'title'          => __( 'Columns', 'sg-window' ),
		'description'    => __( 'You can set the size of columns in this section', 'sg-window' ),
		'panel'  => 'layout',
	) );	
	
	$wp_customize->add_setting( 'unit', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['unit'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'unit', array(
		'label'   => __( 'Unit', 'sg-window' ),
		'section' => 'columns',
		'settings'   => 'unit',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => array( __('%', 'sg-window')),
	) );

	
//in %

	$wp_customize->add_setting( 'width_column_1_range_rate', array(
		'type'			 => 'empty',
		'default'        => sgwindow_get_theme_mod('width_column_1_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_column_1_range_rate', array(
		'label'      => __( '(%)', 'sg-window' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_range_rate',
		'type'       => 'range',
		'priority' => $priority++,
		'input_attrs' => array(
			'min'   => 10,
			'max'   => 50,
			'step'  => 1,
	) ));
	
	$wp_customize->add_setting( 'width_column_1_rate', array(
		'type'			 => 'theme_mod',
		'default'        => sgwindow_get_theme_mod('width_column_1_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'sgwindow_sanitize_range_column_rate'
	) );
	
	$wp_customize->add_control( 'width_column_1_rate', array(
		'label'      => __( 'Width of the first column (two sidebars layout)', 'sg-window' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_rate',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'width_column_2_range_rate', array(
		'type'			 => 'empty',
		'default'        => sgwindow_get_theme_mod('width_column_2_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_column_2_range_rate', array(
		'label'      => __( '(%)', 'sg-window' ),
		'section'    => 'columns',
		'settings'   => 'width_column_2_range_rate',
		'type'       => 'range',
		'priority' => $priority++,
		'input_attrs' => array(
			'min'   => 10,
			'max'   => 50,
			'step'  => 1,
	) ));
	
	$wp_customize->add_setting( 'width_column_2_rate', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_column_2_rate'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'sgwindow_sanitize_range_column_rate'
	) );
	
	$wp_customize->add_control( 'width_column_2_rate', array(
		'label'      => __( 'Width of the second column (two sidebars layout)', 'sg-window' ),
		'section'    => 'columns',
		'settings'   => 'width_column_2_rate',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	
	$wp_customize->add_setting( 'width_column_1_left_range_rate', array(
		'type'			 => 'empty',
		'default'        => sgwindow_get_theme_mod('width_column_1_left_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_column_1_left_range_rate', array(
		'label'      => __( '(%)', 'sg-window' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_left_range_rate',
		'type'       => 'range',
		'priority' => $priority++,
		'input_attrs' => array(
			'min'   => 10,
			'max'   => 50,
			'step'  => 1,
	) ));
	
	$wp_customize->add_setting( 'width_column_1_left_rate', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_column_1_left_rate'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'sgwindow_sanitize_range_column_rate'
	) );
	
	$wp_customize->add_control( 'width_column_1_left_rate', array(
		'label'      => __( 'Width of the first column (left sidebar layout)', 'sg-window' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_left_rate',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'width_column_1_right_range_rate', array(
		'type'			 => 'empty',
		'default'        => sgwindow_get_theme_mod('width_column_1_right_rate'),
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'width_column_1_right_range_rate', array(
		'label'      => __( '(%)', 'sg-window' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_right_range_rate',
		'type'       => 'range',
		'priority' => $priority++,
		'input_attrs' => array(
			'min'   => 10,
			'max'   => 50,
			'step'  => 1,
	) ));
	
	$wp_customize->add_setting( 'width_column_1_right_rate', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['width_column_1_right_rate'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'postMessage',
		'sanitize_callback' => 'sgwindow_sanitize_range_column_rate'
	) );
	
	$wp_customize->add_control( 'width_column_1_right_rate', array(
		'label'      => __( 'Width of the second column (right sidebar layout)', 'sg-window' ),
		'section'    => 'columns',
		'settings'   => 'width_column_1_right_rate',
		'type'       => 'text',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'front_page_style', array(
		'default'        => $defaults['front_page_style'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'sgwindow_is_show_top_menu', array(
		'label'      => __( 'Check mark to display content on the static front page', 'sg-window' ),
		'section'    => 'layout_home',
		'settings'   => 'front_page_style',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	

/* layout_post */

	$wp_customize->add_section( 'layout_post', array(
		'priority'       => $section_priority++,
		'title'          => __( 'Post', 'sg-window' ),
		'description'    => __( 'Customize posts', 'sg-window' ),
		'panel'  => 'layout',
	) );	
	
	$wp_customize->add_setting( 'single_style', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['single_style'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_display_choices'
	) );

	$wp_customize->add_control( 'single_style', array(
		'label'   => __( 'Post style', 'sg-window' ),
		'section' => 'layout_blog',
		'settings'   => 'single_style',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => sgwindow_display_choices(),
	) );
	
	$wp_customize->add_setting( 'is_display_post_image', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_post_image'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_post_image', array(
		'label'      => __( 'Display Featured Image', 'sg-window' ),
		'section'    => 'layout_post',
		'settings'   => 'is_display_post_image',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_post_title', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_post_title'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_post_title', array(
		'label'      => __( 'Display Title', 'sg-window' ),
		'section'    => 'layout_post',
		'settings'   => 'is_display_post_title',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_post_cat', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_post_cat'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_post_cat', array(
		'label'      => __( 'Display Category List', 'sg-window' ),
		'section'    => 'layout_post',
		'settings'   => 'is_display_post_cat',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_post_tags', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_post_tags'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_post_tags', array(
		'label'      => __( 'Display Tag List', 'sg-window' ),
		'section'    => 'layout_post',
		'settings'   => 'is_display_post_tags',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );

/* layout_page */
	
	$wp_customize->add_setting( 'page_style', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['page_style'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitizeis_display_post_image'
	) );

	$wp_customize->add_control( 'page_style', array(
		'label'   => __( 'Page style', 'sg-window' ),
		'section' => 'layout_blog',
		'settings'   => 'page_style',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => sgwindow_display_choices(),
	) );
	
	$wp_customize->add_setting( 'is_display_page_image', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_page_image'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );
	
	$wp_customize->add_control( 'is_display_page_image', array(
		'label'      => __( 'Display Featured Image', 'sg-window' ),
		'section'    => 'layout_page',
		'settings'   => 'is_display_page_image',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_page_title', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_page_title'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_page_title', array(
		'label'      => __( 'Display Title', 'sg-window' ),
		'section'    => 'layout_page',
		'settings'   => 'is_display_page_title',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );


	/* layout_portfolio_page */

	$wp_customize->add_setting( 'portfolio_style', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['portfolio_style'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_display_choices'
	) );

	$wp_customize->add_control( 'portfolio_style', array(
		'label'   => __( 'Portfolio Archive/Index style', 'sg-window' ),
		'section' => 'layout_portfolio',
		'settings'   => 'portfolio_style',
		'type'       => 'select',
		'priority'   => $priority++,
		'choices'	 => sgwindow_display_choices(),
	) );
	
	$wp_customize->add_setting( 'is_display_portfolio_image', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_portfolio_image'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_portfolio_image', array(
		'label'      => __( 'Display Featured Image', 'sg-window' ),
		'section'    => 'layout_portfolio_page',
		'settings'   => 'is_display_portfolio_image',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_portfolio_title', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_portfolio_title'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_portfolio_title', array(
		'label'      => __( 'Display Title', 'sg-window' ),
		'section'    => 'layout_portfolio_page',
		'settings'   => 'is_display_portfolio_title',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_portfolio_project', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_portfolio_project'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_portfolio_project', array(
		'label'      => __( 'Display Project', 'sg-window' ),
		'section'    => 'layout_portfolio_page',
		'settings'   => 'is_display_portfolio_project',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
	$wp_customize->add_setting( 'is_display_portfolio_tags', array(
		'type'			 => 'theme_mod',
		'default'        => $defaults['is_display_portfolio_tags'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'is_display_portfolio_tags', array(
		'label'      => __( 'Display Tag List', 'sg-window' ),
		'section'    => 'layout_portfolio_page',
		'settings'   => 'is_display_portfolio_tags',
		'type'       => 'checkbox',
		'priority'       => $priority++,
	) );
	
}

/**
 * Return how to display content in archive
 *
 * @return array choices.
 * @since SG Window 1.0.0
 */
function sgwindow_display_choices() {
	return array ('excerpt' => __('Excerpt', 'sg-window'),
			'content' => __('Content', 'sg-window'),
			'none' => __('No Content', 'sg-window'),
			);
}
/**
 * Sanitize display layouts
 *
 * @return array choices.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_display_choices( $value) {
	return ( array_key_exists( $value, sgwindow_display_choices() ) ? $value : 'none' );
}

/**
 * Return all possible layouts
 *
 * @return array choices.
 * @since SG Window 1.0.0
 */
function sgwindow_layout_choices() {
	$choices = array ('no-sidebar' => __('Full Width', 'sg-window'),
			'left-sidebar' => __('Left Column', 'sg-window'),
			'right-sidebar' => __('Right Column', 'sg-window'),
			'two-sidebars' => __('Two Columns', 'sg-window'));
			
	return apply_filters( 'sgwindow_layouts', $choices);
}

/**
 * Return all possible layouts
 *
 * @return array choices.
 * @since SG Window 1.0.0
 */
function sgwindow_layout_choices_content() {
	$choices = array ('default' => __('Default (1 column)', 'sg-window'),
			'flex-layout-1' => __('1 column', 'sg-window'),
			'flex-layout-2' => __('2 columns', 'sg-window'),
			'flex-layout-3' => __('3 columns', 'sg-window'),
			'flex-layout-4' => __('4 columns', 'sg-window'));
			
	return apply_filters( 'sgwindow_layouts', $choices);
}
/**
 * Sanitize sidebar layouts
 *
 * @return array choices.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_layout_choices( $value) {
	return ( array_key_exists( $value, sgwindow_layout_choices() ) ? $value : 'no-columns' );
}

/**
 * Sanitize content layouts 
 *
 * @return array choices.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_layout_choices_content( $value) {
	return ( array_key_exists( $value, sgwindow_layout_choices_content() ) ? $value : 'no-columns' );
}
/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_range_content( $value ) {
	$defaults = sgwindow_get_defaults();
	return sgwindow_sanitize_range($value, 600, 2200, $defaults['width_image']);
} 

/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_range_image( $value ) {
	$defaults = sgwindow_get_defaults();
	return sgwindow_sanitize_range($value, 50, 2200, $defaults['width_image']);
} 

/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_range_column_rate( $value ) {
	$defaults = sgwindow_get_defaults();
	return sgwindow_sanitize_range($value, 10, 50, $defaults['width_column_1_rate']);
} 
/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_range_width( $value ) {
	$defaults = sgwindow_get_defaults();
	return sgwindow_sanitize_range($value, 960, 2200, $defaults['width_site']);
} 
/**
 * Sanitize range.
 *
 * @param string $value Value to sanitize. 
 * @param int $min minimal value. 
 * @param int $max maximal value. 
 * @param int $def default value. 
 * @return int sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_range( $value, $min, $max, $def ) {
	$x = absint( $value );
	return ( $x >= $min && $x <= $max ? $x : $def );
} 
/**
 * Return string Sanitized header style
 *
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_header_style( $value ) {
	$defaults = sgwindow_get_defaults();
	$possible_values = array( 'boxed', 'full');
	return ( in_array( $value, $possible_values ) ? $value : $defaults['header_style'] );
}

/**
 * Class to store and create layouts for different types of pages
 *
 * @since SG Window 1.0.0
 */

class sgwindow_Layout_Class {

	private $layout = array();
	private $curr_layout = null;
	private $curr_content_layout = null;
	
	function __construct() {
		$i = 0;
	
		$this->layout[$i]['name'] = 'layout_home';
		$this->layout[$i]['callback'] = 'is_front_page';
		$this->layout[$i]['val'] = 'no-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = 'flex-layout-1';
		$this->layout[$i]['text'] = __('Home', 'sg-window');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_blog';
		$this->layout[$i]['callback'] = 'is_home';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = true;
		$this->layout[$i]['content_val'] = 'flex-layout-4';
		$this->layout[$i]['text'] = __('Blog', 'sg-window');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_category';
		$this->layout[$i]['callback'] = 'is_category';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = true;
		$this->layout[$i]['content_val'] = 'flex-layout-3';
		$this->layout[$i]['text'] = __('Category', 'sg-window');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_tag';
		$this->layout[$i]['callback'] = 'is_tag';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = true;
		$this->layout[$i]['content_val'] = 'flex-layout-3';
		$this->layout[$i]['text'] = __('Tag', 'sg-window');

		$i++;
		$this->layout[$i]['name'] = 'layout_archive';
		$this->layout[$i]['callback'] = 'is_archive';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = true;
		$this->layout[$i]['content_val'] = 'flex-layout-3';
		$this->layout[$i]['text'] = __('Archive', 'sg-window');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_search';
		$this->layout[$i]['callback'] = 'is_search';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = true;
		$this->layout[$i]['content_val'] = 'flex-layout-3';
		$this->layout[$i]['text'] = __('Search', 'sg-window');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_shop';
		$this->layout[$i]['callback'] = 'sgwindow_is_shop';
		$this->layout[$i]['val'] = 'left-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = 'flex-layout-3';
		$this->layout[$i]['text'] = __('Shop', 'sg-window');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_shop_page';
		$this->layout[$i]['callback'] = 'sgwindow_is_shop_page';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = '';
		$this->layout[$i]['text'] = __('Shop Page', 'sg-window');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_page';
		$this->layout[$i]['callback'] = 'is_page';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = 'flex-layout-1';
		$this->layout[$i]['text'] = __('Page', 'sg-window');		
		
		$i++;
		$this->layout[$i]['name'] = 'layout_portfolio';
		$this->layout[$i]['callback'] = 'sgwindow_is_portfolio';
		$this->layout[$i]['val'] = 'left-sidebar';
		$this->layout[$i]['is_has_content_section'] = true;
		$this->layout[$i]['content_val'] = 'flex-layout-3';
		$this->layout[$i]['text'] = __('Portfolio (Archive)', 'sg-window');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_portfolio_page';
		$this->layout[$i]['callback'] = 'sgwindow_is_portfolio_page';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = '';
		$this->layout[$i]['text'] = __('Portfolio (Page)', 'sg-window');
		
		$i++;
		$this->layout[$i]['name'] = 'layout_default';
		$this->layout[$i]['callback'] = '';
		$this->layout[$i]['val'] = 'right-sidebar';
		$this->layout[$i]['is_has_content_section'] = false;
		$this->layout[$i]['content_val'] = 'flex-layout-1';
		$this->layout[$i]['text'] = __('Default', 'sg-window');
			
		add_action( 'customize_register', array( $this, 'sgwindow_create_layout_controls' ), 21 );
		add_action( 'sgwindow_option_defaults', array( $this, 'sgwindow_add_defaults' ) );

	}
	
	/* Set current layouts into variables */
	
	function find_layout() {
		foreach( $this->layout as $id => $values ) {

		if( '' == $values['callback']) {
				$this->curr_layout = get_theme_mod($values['name'], $values['val']);
				$this->curr_content_layout = get_theme_mod($values['name'].'_content', $values['content_val']);
				break;
			}
			else if( call_user_func( $values['callback'] ) ) {
				$this->curr_layout = get_theme_mod($values['name'], $values['val']);
				$this->curr_content_layout = get_theme_mod($values['name'].'_content', $values['content_val']);
				break;
			}
			
		}
	}
	
	/* Return current layout */
	
	public function get_layout( ) {
		
		if( isset($this->curr_layout) )
			return $this->curr_layout;
	
		$this->find_layout();

		return $this->curr_layout;
	}
	
	/* Return current content layout */
	
	public function get_content_layout( ) {
		
		if( isset($this->curr_content_layout) )
			return $this->curr_content_layout;
		
		$this->find_layout();

		return $this->curr_layout;
	}
	
	/* Add values to defaults array */
	
	function sgwindow_add_defaults( $defaults ) {
	
		foreach( $this->layout as $id => $values ) {

			$defaults[ $values['name'] ] = $values['val'];
			$defaults[ $values['name'].'_content' ] = $values['content_val'];
			
		}

		return $defaults;
	}
	
	/* Create all sections and controls in the Customizer for layouts */
	
	function sgwindow_create_layout_controls( $wp_customize ) {
	
		$section_priority = 99; //add to the end of the layout panel
		
		foreach( $this->layout as $id => $values ) {
			$priority = 1;
			$section_priority++;
		
			$wp_customize->add_section( $values['name'], array(
				'priority'       => $section_priority,
				'title'          => $values['text'],
				'description'    => __( 'Layout settings for ', 'sg-window' ).$values['text'],
				'panel'  => 'layout',
			) );	

			$wp_customize->add_setting( $values['name'], array(
				'type'			 => 'theme_mod',
				'default'        => $values['val'],
				'capability'     => 'edit_theme_options',
				'sanitize_callback' => 'sgwindow_sanitize_layout_choices'
			) );

			$wp_customize->add_control( $values['name'], array(
				'label'   => $values['text'].__( ' layout', 'sg-window' ),
				'section' => $values['name'],
				'settings'   => $values['name'],
				'type'       => 'select',
				'priority'   => $priority++,
				'choices'	 => sgwindow_layout_choices(),
			) );
			
			if( $values['is_has_content_section'] ) {
			
				$wp_customize->add_setting( $values['name'].'_content', array(
					'type'			 => 'theme_mod',
					'default'        => $values['content_val'],
					'capability'     => 'edit_theme_options',
					'sanitize_callback' => 'sgwindow_sanitize_layout_choices_content'
				) );

				$wp_customize->add_control( $values['name'].'_content', array(
					'label'   =>  $values['text'].__( ' layout (content)', 'sg-window' ),
					'section' => $values['name'],
					'settings'   => $values['name'].'_content',
					'type'       => 'select',
					'priority'   => $priority++,
					'choices'	 => sgwindow_layout_choices_content(),
				) );
			}
		}
	}
}