<?php
/**
 * Add Promotion Settings in Customizer
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

$wp_customize->add_section( 'helena_promotion_headline_options', array(
	'priority'    => 800,
	'title'   	 	=> esc_html__( 'Promotion Headline', 'helena' ),
) );

$wp_customize->add_setting( 'promotion_headline_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['promotion_headline_option'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'promotion_headline_option', array(
	'choices'  	=> helena_featured_section_enable_options(),
	'label'    	=> esc_html__( 'Enable on', 'helena' ),
	'section'  	=> 'helena_promotion_headline_options',
	'type'	  	=> 'select',
) );

$wp_customize->add_setting( 'promotion_headline_type', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['promotion_headline_type'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'promotion_headline_type', array(
	'active_callback' => 'helena_is_promotion_headline_active',
	'choices'         => helena_promotion_headline_types(),
	'label'           => esc_html__( 'Type', 'helena' ),
	'section'         => 'helena_promotion_headline_options',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'promotion_headline_show', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['promotion_headline_show'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'promotion_headline_show', array(
	'active_callback' => 'helena_is_demo_promotion_headline_inactive',
	'choices'         => helena_featured_content_show(),
	'label'           => esc_html__( 'Display Content', 'helena' ),
	'section'         => 'helena_promotion_headline_options',
	'type'            => 'select',
) );

//page content
$wp_customize->add_setting( 'promotion_headline_page', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback'	=> 'helena_sanitize_page',
) );

$wp_customize->add_control( 'promotion_headline_page', array(
	'active_callback' => 'helena_is_demo_promotion_headline_inactive',
	'label'           => esc_html__( 'Select Page', 'helena' ),
	'section'         => 'helena_promotion_headline_options',
	'type'            => 'dropdown-pages',
) );