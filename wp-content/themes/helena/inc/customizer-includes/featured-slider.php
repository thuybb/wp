<?php
/**
 * Add Featured Slider Options in Customizer
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

//Featured Slider
$wp_customize->add_section( 'helena_featured_slider', array(
	'priority'		=> 400,
	'title'			=> esc_html__( 'Featured Slider', 'helena' ),
) );

$wp_customize->add_setting( 'featured_slider_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_option'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'featured_slider_option', array(
	'choices'  => helena_featured_section_enable_options(),
	'label'    => esc_html__( 'Enable Slider on', 'helena' ),
	'section'  => 'helena_featured_slider',
	'settings' => 'featured_slider_option',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'featured_slider_transition_effect', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_transition_effect'],
	'sanitize_callback'	=> 'helena_sanitize_select',
) );

$wp_customize->add_control( 'featured_slider_transition_effect' , array(
	'active_callback' => 'helena_is_slider_active',
	'choices'         => helena_featured_slider_transition_effects(),
	'label'           => esc_html__( 'Transition Effect', 'helena' ),
	'section'         => 'helena_featured_slider',
	'settings'        => 'featured_slider_transition_effect',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'featured_slider_transition_delay', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_transition_delay'],
	'sanitize_callback'	=> 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'featured_slider_transition_delay' , array(
	'active_callback' => 'helena_is_slider_active',
	'description'     => esc_html__( 'seconds(s)', 'helena' ),
	'input_attrs'     => array(
		'style' => 'width: 100px;'
		),
	'label'           => esc_html__( 'Transition Delay', 'helena' ),
	'section'         => 'helena_featured_slider',
	'settings'        => 'featured_slider_transition_delay',
) );

$wp_customize->add_setting( 'featured_slider_transition_length', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_transition_length'],
	'sanitize_callback'	=> 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'featured_slider_transition_length' , array(
		'active_callback' => 'helena_is_slider_active',
		'description'     => esc_html__( 'seconds(s)', 'helena' ),
		'input_attrs'     => array(
			'style' => 'width: 100px;'
		),
		'label'           => esc_html__( 'Transition Length', 'helena' ),
		'section'         => 'helena_featured_slider',
		'settings'        => 'featured_slider_transition_length',
	)
);

$wp_customize->add_setting( 'featured_slider_image_loader', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['featured_slider_image_loader'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'featured_slider_image_loader', array(
	'active_callback' => 'helena_is_slider_active',
	'description'     => esc_html__( 'True: Fixes the height overlap issue. Slideshow will start as soon as two slider are available. Slide may display in random, as image is fetch. Wait: Fixes the height overlap issue. Slideshow will start only after all images are available.', 'helena' ),
	'choices'         => helena_featured_slider_image_loader(),
	'label'           => esc_html__( 'Image Loader', 'helena' ),
	'section'         => 'helena_featured_slider',
	'settings'        => 'featured_slider_image_loader',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'featured_slider_type', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_type'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'featured_slider_type', array(
	'active_callback' => 'helena_is_slider_active',
	'choices'         => helena_featured_slider_types(),
	'label'           => esc_html__( 'Select Slider Type', 'helena' ),
	'section'         => 'helena_featured_slider',
	'settings'        => 'featured_slider_type',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'featured_slider_number', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_number'],
	'sanitize_callback'	=> 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'featured_slider_number' , array(
	'active_callback' => 'helena_is_demo_slider_inactive',
	'description'     => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'helena' ),
	'input_attrs'     => array(
	'style'           => 'width: 45px;',
		'min'  => 0,
		'max'  => 20,
		'step' => 1,
	),
	'label'           => esc_html__( 'No of Slides', 'helena' ),
	'section'         => 'helena_featured_slider',
	'settings'        => 'featured_slider_number',
	'type'            => 'number',
	)
);

$number = apply_filters( 'helena_get_option', 'featured_slider_number' );
for ( $i=1; $i <= $number ; $i++ ) {
	$wp_customize->add_setting( 'featured_slider_page_'. $i, array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback'	=> 'helena_sanitize_page',
	) );

	$wp_customize->add_control( 'featured_slider_page_'. $i, array(
		'active_callback' => 'helena_is_demo_slider_inactive',
		'label'           => esc_html__( 'Featured Page', 'helena' ) . ' # ' . $i ,
		'section'         => 'helena_featured_slider',
		'settings'        => 'featured_slider_page_'. $i,
		'type'            => 'dropdown-pages',
	) );
}
// Featured Slider End