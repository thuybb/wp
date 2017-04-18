<?php
/**
 * Add Hero Content Settings in Customizer
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

$wp_customize->add_section( 'helena_hero_content', array(
	'priority' => 500,
	'title'    => esc_html__( 'Hero Content', 'helena' ),
) );

$wp_customize->add_setting( 'hero_content_option', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['hero_content_option'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'hero_content_option', array(
	'choices'  => helena_featured_section_enable_options(),
	'label'    => esc_html__( 'Enable Hero Content on', 'helena' ),
	'section'  => 'helena_hero_content',
	'settings' => 'hero_content_option',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'hero_content_type', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['hero_content_type'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'hero_content_type', array(
	'active_callback' => 'helena_is_hero_content_active',
	'choices'         => helena_hero_content_types(),
	'label'           => esc_html__( 'Select Content Type', 'helena' ),
	'section'         => 'helena_hero_content',
	'settings'        => 'hero_content_type',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'hero_content_number', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['hero_content_number'],
	'sanitize_callback' => 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'hero_content_number' , array(
		'active_callback' => 'helena_is_demo_hero_content_inactive',
		'description'     => esc_html__( 'Save and refresh the page if No. of Hero Content is changed (Max no of Hero Content is 20)', 'helena' ),
		'input_attrs'     => array(
			'style' => 'width: 45px;',
			'min'   => 0,
			'max'   => 20,
			'step'  => 1,
		),
		'label'           => esc_html__( 'No of Hero Content', 'helena' ),
		'section'         => 'helena_hero_content',
		'settings'        => 'hero_content_number',
		'type'            => 'number',
		)
);

$wp_customize->add_setting( 'hero_content_enable_title', array(
		'default'           => $defaults['hero_content_enable_title'],
		'sanitize_callback' => 'helena_sanitize_checkbox',
	) );

$wp_customize->add_control(  'hero_content_enable_title', array(
	'active_callback' => 'helena_is_demo_hero_content_inactive',
	'label'           => esc_html__( 'Check to Enable Title', 'helena' ),
	'section'         => 'helena_hero_content',
	'settings'        => 'hero_content_enable_title',
	'type'            => 'checkbox',
) );

$wp_customize->add_setting( 'hero_content_show', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['hero_content_show'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'hero_content_show', array(
	'active_callback' => 'helena_is_demo_hero_content_inactive',
	'choices'         => helena_featured_content_show(),
	'label'           => esc_html__( 'Display Content', 'helena' ),
	'section'         => 'helena_hero_content',
	'settings'        => 'hero_content_show',
	'type'            => 'select',
) );

$number = apply_filters( 'helena_get_option', 'hero_content_number' );
for ( $i=1; $i <= $number ; $i++ ) {
	//page content
	$wp_customize->add_setting( 'hero_content_page_'. $i, array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'helena_sanitize_page',
	) );

	$wp_customize->add_control( 'hero_content_page_'. $i, array(
		'active_callback' => 'helena_is_demo_hero_content_inactive',
		'label'           => esc_html__( 'Page', 'helena' ) . ' ' . $i ,
		'section'         => 'helena_hero_content',
		'settings'        => 'hero_content_page_'. $i,
		'type'            => 'dropdown-pages',
	) );
}