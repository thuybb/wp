<?php
/**
* Add additional theme options in Customizer
*
* @package Catch Themes
* @subpackage Helena
* @since Helena 0.1
*/

$wp_customize->add_panel( 'helena_theme_options', array(
    'description'    => esc_html__( 'Basic theme Options', 'helena' ),
    'capability'     => 'edit_theme_options',
    'priority'       => 200,
    'title'    		 => esc_html__( 'Theme Options', 'helena' ),
) );

// Breadcrumb Option
$wp_customize->add_section( 'helena_breadcrumb_options', array(
	'description'	=> esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance. You can enable/disable them on homepage and entire site.', 'helena' ),
	'panel'			=> 'helena_theme_options',
	'title'    		=> esc_html__( 'Breadcrumb Options', 'helena' ),
	'priority' 		=> 201,
) );

$wp_customize->add_setting( 'breadcrumb_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcrumb_option'],
	'sanitize_callback' => 'helena_sanitize_checkbox'
) );

$wp_customize->add_control( 'breadcrumb_option', array(
	'label'    => esc_html__( 'Check to enable Breadcrumb', 'helena' ),
	'section'  => 'helena_breadcrumb_options',
	'settings' => 'breadcrumb_option',
	'type'     => 'checkbox',
) );

$wp_customize->add_setting( 'breadcrumb_on_homepage', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcrumb_on_homepage'],
	'sanitize_callback' => 'helena_sanitize_checkbox'
) );

$wp_customize->add_control( 'breadcrumb_on_homepage', array(
	'label'    => esc_html__( 'Check to enable Breadcrumb on Homepage', 'helena' ),
	'section'  => 'helena_breadcrumb_options',
	'settings' => 'breadcrumb_on_homepage',
	'type'     => 'checkbox',
) );

$wp_customize->add_setting( 'breadcrumb_seperator', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcrumb_seperator'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'breadcrumb_seperator', array(
	'input_attrs' => array(
    		'style' => 'width: 100px;'
		),
	'label'    	=> esc_html__( 'Separator between Breadcrumbs', 'helena' ),
	'section' 	=> 'helena_breadcrumb_options',
	'settings' 	=> 'breadcrumb_seperator',
	'type'     	=> 'text'
	)
);
	// Breadcrumb Option End

/**
 *  Remove Custom CSS option from WordPress 4.7 onwards
 *  //@remove Remove if block and custom_css when WordPress 5.0 is released
 */
if ( !function_exists( 'wp_update_custom_css_post' ) ) {
	// Custom CSS Option
	$wp_customize->add_section( 'helena_custom_css', array(
		'description'	=> esc_html__( 'Custom/Inline CSS', 'helena'),
		'panel'  		=> 'helena_theme_options',
		'priority' 		=> 203,
		'title'    		=> esc_html__( 'Custom CSS Options', 'helena' ),
	) );

	$wp_customize->add_setting( 'custom_css', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['custom_css'],
		'sanitize_callback' => 'helena_sanitize_custom_css',
	) );

	$wp_customize->add_control( 'custom_css', array(
			'label'		=> esc_html__( 'Enter Custom CSS', 'helena' ),
	        'priority'	=> 1,
			'section'   => 'helena_custom_css',
	        'settings'  => 'custom_css',
			'type'		=> 'textarea',
	) );
	// Custom CSS End
}

	// Excerpt Options
$wp_customize->add_section( 'helena_excerpt_options', array(
	'panel'  	=> 'helena_theme_options',
	'priority' 	=> 204,
	'title'    	=> esc_html__( 'Excerpt Options', 'helena' ),
) );

$wp_customize->add_setting( 'excerpt_length', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['excerpt_length'],
	'sanitize_callback' => 'helena_sanitize_number_range',
) );

$wp_customize->add_control( 'excerpt_length', array(
	'description' => esc_html__( 'Excerpt length. Default is 40 words', 'helena'),
	'input_attrs' => array(
        'min'   => 10,
        'max'   => 200,
        'step'  => 5,
        'style' => 'width: 60px;'
        ),
    'label'    => esc_html__( 'Excerpt Length (words)', 'helena' ),
	'section'  => 'helena_excerpt_options',
	'settings' => 'excerpt_length',
	'type'	   => 'number',
	)
);

$wp_customize->add_setting( 'excerpt_more_text', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['excerpt_more_text'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'excerpt_more_text', array(
	'label'    => esc_html__( 'Read More Text', 'helena' ),
	'section'  => 'helena_excerpt_options',
	'settings' => 'excerpt_more_text',
	'type'	   => 'text',
) );
// Excerpt Options End

//Homepage / Frontpage Options
$wp_customize->add_section( 'helena_homepage_options', array(
	'description'	=> esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'helena' ),
	'panel'			=> 'helena_theme_options',
	'priority' 		=> 209,
	'title'   	 	=> esc_html__( 'Homepage / Frontpage Options', 'helena' ),
) );

$wp_customize->add_setting( 'front_page_category', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['front_page_category'],
	'sanitize_callback'	=> 'helena_sanitize_category_list',
) );

$wp_customize->add_control( new helena_customize_dropdown_categories_control( $wp_customize, 'front_page_category', array(
    'label'   	=> esc_html__( 'Select Categories', 'helena' ),
    'name'	 	=> 'front_page_category',
	'priority'	=> '6',
    'section'  	=> 'helena_homepage_options',
    'settings' 	=> 'front_page_category',
    'type'     	=> 'dropdown-categories',
) ) );
//Homepage / Frontpage Settings End

// Layout Options
$wp_customize->add_section( 'helena_layout', array(
	'capability'=> 'edit_theme_options',
	'panel'		=> 'helena_theme_options',
	'priority'	=> 211,
	'title'		=> esc_html__( 'Layout Options', 'helena' ),
) );

$wp_customize->add_setting( 'theme_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['theme_layout'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'theme_layout', array(
	'choices'  => helena_layouts(),
	'label'    => esc_html__( 'Default Layout', 'helena' ),
	'section'  => 'helena_layout',
	'settings' => 'theme_layout',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'single_page_post_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['single_page_post_layout'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'single_page_post_layout', array(
	'choices'  => helena_layouts(),
	'label'    => esc_html__( 'Single Page/Post Layout', 'helena' ),
	'section'  => 'helena_layout',
	'settings' => 'single_page_post_layout',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'content_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['content_layout'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'content_layout', array(
	'choices'   => helena_get_archive_content_layout(),
	'label'		=> esc_html__( 'Archive Content Layout', 'helena' ),
	'section'   => 'helena_layout',
	'settings'  => 'content_layout',
	'type'      => 'select',
) );

$wp_customize->add_setting( 'single_post_image_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['single_post_image_layout'],
	'sanitize_callback' => 'helena_sanitize_select',
) );


$wp_customize->add_control( 'single_post_image_layout', array(
	'choices'  	=> helena_single_post_image_layout_options(),
	'label'		=> esc_html__( 'Single Page/Post Image', 'helena' ),
	'section'   => 'helena_layout',
    'settings'  => 'single_post_image_layout',
    'type'	  	=> 'select',
) );
// Layout Options End

// Pagination Options
$pagination_type = apply_filters( 'helena_get_option', 'pagination_type' );

$nav_desc = sprintf(
	wp_kses(
		__( '<a target="_blank" href="%1$s">WP-PageNavi Plugin</a> is recommended for Numeric Option(But will work without it).<br/>Infinite Scroll Options requires <a target="_blank" href="%2$s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'helena' ),
		array(
			'a' => array(
				'href' => array(),
				'target' => array(),
			),
			'br'=> array()
		)
	),
	esc_url( 'https://wordpress.org/plugins/wp-pagenavi' ),
	esc_url( 'https://wordpress.org/plugins/jetpack/' )
);

/**
* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
*/
if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) ) {
if ( ! (class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) ) {
	$nav_desc = sprintf(
		wp_kses(
			__( 'Infinite Scroll Options requires <a target="_blank" href="%s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'helena' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array()
				)
			)
		),
		esc_url( 'https://wordpress.org/plugins/jetpack/' )
	);
}
else {
	$nav_desc = '';
}
}

$wp_customize->add_section( 'helena_pagination_options', array(
	'description'	=> $nav_desc,
	'panel'  		=> 'helena_theme_options',
	'priority'		=> 212,
	'title'    		=> esc_html__( 'Pagination Options', 'helena' ),
) );

$wp_customize->add_setting( 'pagination_type', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['pagination_type'],
	'sanitize_callback' => 'helena_sanitize_select',
) );

$wp_customize->add_control( 'pagination_type', array(
	'choices'  => helena_get_pagination_types(),
	'label'    => esc_html__( 'Pagination type', 'helena' ),
	'section'  => 'helena_pagination_options',
	'settings' => 'pagination_type',
	'type'	   => 'select',
) );
// Pagination Options End

// Scrollup
$wp_customize->add_section( 'helena_scrollup', array(
	'panel'    => 'helena_theme_options',
	'priority' => 215,
	'title'    => esc_html__( 'Scrollup Options', 'helena' ),
) );

$wp_customize->add_setting( 'disable_scrollup', array(
	'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['disable_scrollup'],
	'sanitize_callback' => 'helena_sanitize_checkbox',
) );

$wp_customize->add_control( 'disable_scrollup', array(
	'label'		=> esc_html__( 'Check to disable Scroll Up', 'helena' ),
	'section'   => 'helena_scrollup',
    'settings'  => 'disable_scrollup',
	'type'		=> 'checkbox',
) );
// Scrollup End

// Search Options
$wp_customize->add_section( 'helena_search_options', array(
	'description'=> esc_html__( 'Change default placeholder text in Search.', 'helena'),
	'panel'  => 'helena_theme_options',
	'priority' => 216,
	'title'    => esc_html__( 'Search Options', 'helena' ),
) );

$wp_customize->add_setting( 'search_text', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['search_text'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'search_text', array(
	'label'		=> esc_html__( 'Default Display Text in Search', 'helena' ),
	'section'   => 'helena_search_options',
    'settings'  => 'search_text',
	'type'		=> 'text',
) );
// Search Options End