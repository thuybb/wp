<?php
/**
* Add Header Highlight Content in Customizer
*
* @package Catch Themes
* @subpackage Helena
* @since Helena 0.1
*/

$wp_customize->add_section( 'helena_header_highlight_content', array(
	'priority' => 600,
	'title'    => esc_html__( 'Header Highlight Content', 'helena' ),
) );

$wp_customize->add_setting( 'header_highlight_content_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['header_highlight_content_option'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'header_highlight_content_option', array(
	'choices'  	=> helena_featured_section_enable_options(),
	'label'    	=> esc_html__( 'Enable Header Highlight Content on', 'helena' ),
	'priority'	=> '1',
	'section'  	=> 'helena_header_highlight_content',
	'settings' 	=> 'header_highlight_content_option',
	'type'	  	=> 'select',
) );

$wp_customize->add_setting( 'header_highlight_content_type', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['header_highlight_content_type'],
	'sanitize_callback'	=> 'helena_sanitize_select',
) );

$wp_customize->add_control( 'header_highlight_content_type', array(
	'active_callback' => 'helena_is_header_highlight_content_active',
	'choices'         => helena_header_highlight_content_types(),
	'label'           => esc_html__( 'Select Content Type', 'helena' ),
	'priority'        => '3',
	'section'         => 'helena_header_highlight_content',
	'settings'        => 'header_highlight_content_type',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'header_highlight_content_headline', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback'	=> 'wp_kses_post',
) );

$wp_customize->add_control( 'header_highlight_content_headline' , array(
	'active_callback'	=> 'helena_is_header_highlight_content_active',
	'description'	=> esc_html__( 'Leave field empty if you want to remove Headline', 'helena' ),
	'label'    		=> esc_html__( 'Headline for Header Highlight Content', 'helena' ),
	'priority'		=> '4',
	'section'  		=> 'helena_header_highlight_content',
	'settings' 		=> 'header_highlight_content_headline',
	'type'	   		=> 'text',
	)
);

$wp_customize->add_setting( 'header_highlight_content_subheadline', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback'	=> 'wp_kses_post',
) );

$wp_customize->add_control( 'header_highlight_content_subheadline' , array(
	'active_callback'	=> 'helena_is_header_highlight_content_active',
	'description'	=> esc_html__( 'Leave field empty if you want to remove Sub-headline', 'helena' ),
	'label'    		=> esc_html__( 'Sub-headline for Header Highlight Content', 'helena' ),
	'priority'		=> '5',
	'section'  		=> 'helena_header_highlight_content',
	'settings' 		=> 'header_highlight_content_subheadline',
	'type'	   		=> 'text',
	)
);

$wp_customize->add_setting( 'header_highlight_content_show', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['header_highlight_content_show'],
	'sanitize_callback'	=> 'helena_sanitize_select',
) );

$wp_customize->add_control( 'header_highlight_content_show', array(
	'active_callback' => 'helena_is_demo_header_highlight_content_inactive',
	'choices'         => helena_featured_content_show(),
	'label'           => esc_html__( 'Display Content', 'helena' ),
	'section'         => 'helena_header_highlight_content',
	'settings'        => 'header_highlight_content_show',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'header_highlight_content_number', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['header_highlight_content_number'],
	'sanitize_callback'	=> 'helena_sanitize_number_range',
	'transport'			=> 'postMessage'
) );

$wp_customize->add_control( 'header_highlight_content_number' , array(
		'active_callback' => 'helena_is_demo_header_highlight_content_inactive',
		'description'     => esc_html__( 'Save and refresh the page if No. of Header Highlight Content is changed', 'helena' ),
		'input_attrs'     => array(
			'style' => 'width: 45px;',
			'min'   => 0,
			'step'  => 1,
		),
		'label'           => esc_html__( 'No of Header Highlight Content', 'helena' ),
		'priority'        => '6',
		'section'         => 'helena_header_highlight_content',
		'settings'        => 'header_highlight_content_number',
		'type'            => 'number',
	)
);

$number = apply_filters( 'helena_get_option', 'header_highlight_content_number' );

//loop for content types
for ( $i=1; $i <= $number ; $i++ ) {
	//Page Content
	$wp_customize->add_setting( 'header_highlight_content_page_'. $i, array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback'	=> 'helena_sanitize_page',
	) );

	$wp_customize->add_control( 'header_highlight_content_page_'. $i, array(
		'active_callback' => 'helena_is_demo_header_highlight_content_inactive',
		'label'           => esc_html__( 'Page', 'helena' ) . ' ' . $i ,
		'section'         => 'helena_header_highlight_content',
		'settings'        => 'header_highlight_content_page_'. $i,
		'type'            => 'dropdown-pages',
	) );
}
