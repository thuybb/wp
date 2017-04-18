<?php
/**
 * Add Additional Header Option in Customizer
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */


$wp_customize->add_setting( 'enable_header_image', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['enable_header_image'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'enable_header_image', array(
	'choices'  => helena_enable_header_image_options(),
	'label'    => esc_html__( 'Enable Featured Header Image on ', 'helena' ),
	'section'  => 'header_image',
	'settings' => 'enable_header_image',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'featured_image_size', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_image_size'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'featured_image_size', array(
		'choices'  	=> helena_featured_image_size_options(),
		'label'		=> esc_html__( 'Page/Post Featured Image Size', 'helena' ),
		'section'   => 'header_image',
		'settings'  => 'featured_image_size',
		'type'	  	=> 'select',
) );

$wp_customize->add_setting( 'featured_header_title', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_title'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'featured_header_title', array(
		'label'		=> esc_html__( 'Title', 'helena' ),
		'section'   => 'header_image',
        'settings'  => 'featured_header_title',
        'type'	  	=> 'text',
) );

$wp_customize->add_setting( 'featured_header_content', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_content'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'featured_header_content', array(
	'label'		=> esc_html__( 'Content', 'helena' ),
	'section'   => 'header_image',
    'settings'  => 'featured_header_content',
    'type'	  	=> 'textarea',
) );

$wp_customize->add_setting( 'featured_header_button_text', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_button_text'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'featured_header_button_text', array(
	'label'		=> esc_html__( 'Button Text', 'helena' ),
	'section'   => 'header_image',
    'settings'  => 'featured_header_button_text',
    'type'	  	=> 'textarea',
) );

$wp_customize->add_setting( 'featured_header_button_link', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_button_link'],
	'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( 'featured_header_button_link', array(
		'label'		=> esc_html__( 'Link', 'helena' ),
		'section'   => 'header_image',
        'settings'  => 'featured_header_button_link',
        'type'	  	=> 'text',
) );

$wp_customize->add_setting( 'featured_header_button_target', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback' => 'helena_sanitize_checkbox',
) );

$wp_customize->add_control( 'featured_header_button_target', array(
	'label'    	=> esc_html__( 'Check to Open Link in New Window/Tab', 'helena' ),
	'section'  	=> 'header_image',
	'settings' 	=> 'featured_header_button_target',
	'type'     	=> 'checkbox',
) );