<?php
/**
 * Add Portfolio Settings in Customizer
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

$wp_customize->add_section( 'helena_portfolio', array(
	'priority' => 700,
	'title'    => esc_html__( 'Portfolio', 'helena' ),
) );

$wp_customize->add_setting( 'portfolio_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['portfolio_option'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'portfolio_option', array(
	'choices'  => helena_featured_section_enable_options(),
	'label'    => esc_html__( 'Enable Portfolio on', 'helena' ),
	'section'  => 'helena_portfolio',
	'settings' => 'portfolio_option',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'portfolio_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['portfolio_layout'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'portfolio_layout', array(
	'active_callback' => 'helena_is_portfolio_active',
	'choices'         => helena_featured_content_layout_options(),
	'label'           => esc_html__( 'Select Portfolio Layout', 'helena' ),
	'section'         => 'helena_portfolio',
	'settings'        => 'portfolio_layout',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'portfolio_headline', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['portfolio_headline'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'portfolio_headline' , array(
	'active_callback' => 'helena_is_portfolio_active',
	'description'     => esc_html__( 'Leave field empty if you want to remove Headline', 'helena' ),
	'label'           => esc_html__( 'Headline for Portfolio', 'helena' ),
	'section'         => 'helena_portfolio',
	'settings'        => 'portfolio_headline',
	'type'            => 'text',
	)
);

$wp_customize->add_setting( 'portfolio_subheadline', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['portfolio_subheadline'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'portfolio_subheadline' , array(
	'active_callback' => 'helena_is_portfolio_active',
	'description'     => esc_html__( 'Leave field empty if you want to remove Sub-headline', 'helena' ),
	'label'           => esc_html__( 'Sub-headline for Portfolio', 'helena' ),
	'section'         => 'helena_portfolio',
	'settings'        => 'portfolio_subheadline',
	'type'            => 'text',
	)
);

$wp_customize->add_setting( 'portfolio_type', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['portfolio_type'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'portfolio_type', array(
	'active_callback' => 'helena_is_portfolio_active',
	'choices'         => helena_portfolio_types(),
	'label'           => esc_html__( 'Select Portfolio Type', 'helena' ),
	'section'         => 'helena_portfolio',
	'settings'        => 'portfolio_type',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'portfolio_number', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['portfolio_number'],
	'sanitize_callback' => 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'portfolio_number' , array(
	'active_callback' => 'helena_is_demo_portfolio_inactive',
	'description'     => esc_html__( 'Save and refresh the page if No. of Portfolio is changed (Max no of Portfolio is 20)', 'helena' ),
	'input_attrs'     => array(
		'style' => 'width: 45px;',
		'min'   => 0,
		'max'   => 20,
		'step'  => 1,
	),
	'label'           => esc_html__( 'No of Portfolio', 'helena' ),
	'section'         => 'helena_portfolio',
	'settings'        => 'portfolio_number',
	'type'            => 'number',
	)
);

$number = apply_filters( 'helena_get_option', 'portfolio_number' );
for ( $i=1; $i <= $number ; $i++ ) {
	$wp_customize->add_setting( 'portfolio_page_'. $i, array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'helena_sanitize_page',
	) );

	$wp_customize->add_control( 'helena_portfolio_page_'. $i, array(
		'active_callback' => 'helena_is_demo_portfolio_inactive',
		'label'           => esc_html__( 'Featured Page', 'helena' ) . ' ' . $i ,
		'section'         => 'helena_portfolio',
		'settings'        => 'portfolio_page_'. $i,
		'type'            => 'dropdown-pages',
	) );

	$wp_customize->add_setting( 'portfolio_note_'. $i, array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'sanitize_text_field',
	) );
}