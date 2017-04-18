<?php
/**
 * Add Logo Slider Options in Customizer
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

//Logo Slider
$wp_customize->add_section( 'helena_logo_slider', array(
	'priority' => 800,
	'title'    => esc_html__( 'Logo Slider', 'helena' ),
) );

$wp_customize->add_setting( 'logo_slider_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_option'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'logo_slider_option', array(
	'choices'  => helena_featured_section_enable_options(),
	'label'    => esc_html__( 'Enable Logo Slider on', 'helena' ),
	'section'  => 'helena_logo_slider',
	'settings' => 'logo_slider_option',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'logo_slider_type', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_type'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'logo_slider_type', array(
	'active_callback' => 'helena_is_logo_slider_active',
	'choices'         => helena_logo_slider_types(),
	'label'           => esc_html__( 'Logo Slider Type', 'helena' ),
	'section'         => 'helena_logo_slider',
	'settings'        => 'logo_slider_type',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'logo_slider_transition_delay', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_transition_delay'],
	'sanitize_callback'	=> 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'logo_slider_transition_delay' , array(
	'active_callback' => 'helena_is_logo_slider_active',
	'description'     => esc_html__( 'seconds(s)', 'helena' ),
	'input_attrs'     => array(
		'style' => 'width: 100px;'
		),
	'label'           => esc_html__( 'Transition Delay', 'helena' ),
	'section'         => 'helena_logo_slider',
	'settings'        => 'logo_slider_transition_delay',
) );

$wp_customize->add_setting( 'logo_slider_transition_length', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_transition_length'],
	'sanitize_callback'	=> 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'logo_slider_transition_length' , array(
		'active_callback' => 'helena_is_logo_slider_active',
		'description'     => esc_html__( 'seconds(s)', 'helena' ),
		'input_attrs'     => array(
			'style' => 'width: 100px;'
		),
		'label'           => esc_html__( 'Transition Length', 'helena' ),
		'section'         => 'helena_logo_slider',
		'settings'        => 'logo_slider_transition_length',
	)
);

$wp_customize->add_setting( 'logo_slider_title', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_title'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'logo_slider_title' , array(
	'active_callback' => 'helena_is_demo_logo_slider_inactive',
	'label'           => esc_html__( 'Title', 'helena' ),
	'section'         => 'helena_logo_slider',
	'settings'        => 'logo_slider_title',
) );

$wp_customize->add_setting( 'logo_slider_number', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_number'],
	'sanitize_callback'	=> 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'logo_slider_number' , array(
	'active_callback' => 'helena_is_demo_logo_slider_inactive',
	'description'     => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'helena' ),
	'input_attrs'     => array(
	'style'           => 'width: 45px;',
		'min'  => 0,
		'max'  => 20,
		'step' => 1,
	),
	'label'           => esc_html__( 'No of Items', 'helena' ),
	'section'         => 'helena_logo_slider',
	'settings'        => 'logo_slider_number',
	'type'            => 'number',
	)
);

$wp_customize->add_setting( 'logo_slider_visible_items', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_visible_items'],
	'sanitize_callback' => 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'logo_slider_visible_items', array(
	'active_callback' => 'helena_is_demo_logo_slider_inactive',
	'input_attrs'     => array(
	'style'           => 'width: 45px;',
		'min'  => 0,
		'max'  => 5,
		'step' => 1,
	),
	'label'           => esc_html__( 'No of visible items', 'helena' ),
	'section'         => 'helena_logo_slider',
	'settings'        => 'logo_slider_visible_items',
	'type'            => 'number',
) );

//loop for featured post sliders
$number = apply_filters( 'helena_get_option', 'logo_slider_number' );
for ( $i=1; $i <= $number ; $i++ ) {
	//page content
	$wp_customize->add_setting( 'logo_slider_page_'. $i, array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'helena_sanitize_page',
	) );

	$wp_customize->add_control( 'helena_logo_slider_page_'. $i, array(
		'active_callback' => 'helena_is_demo_logo_slider_inactive',
		'label'           => esc_html__( 'Page', 'helena' ) . ' ' . $i ,
		'section'         => 'helena_logo_slider',
		'settings'        => 'logo_slider_page_'. $i,
		'type'            => 'dropdown-pages',
	) );
}
// Logo Slider End