<?php
/**
 * Helena Theme Customizer.
 *
 * @package Helena
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function helena_customize_register( $wp_customize ) {
	//Include Custom Controls
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/custom-controls.php';

	$defaults = helena_get_default_theme_options();

	$wp_customize->get_setting( 'blogname' )->transport              = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport       = 'postMessage';
	$wp_customize->get_control( 'blogdescription' )->active_callback = 'helena_blog_description_active_callback';
	$wp_customize->get_setting( 'header_textcolor' )->transport      = 'postMessage';

	$wp_customize->add_setting( 'disable_tagline_header', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['disable_tagline_header'],
		'sanitize_callback' => 'helena_sanitize_checkbox',
		'transport'			=> 'refresh',
	) );

	$wp_customize->add_control( 'disable_tagline_header', array(
		'label'    => esc_html__( 'Check to disable Tagline', 'helena' ),
		'section'  => 'title_tagline',
		'settings' => 'disable_tagline_header',
		'type'     => 'checkbox',
	) );

	$wp_customize->add_setting( 'disable_tagline_footer', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['disable_tagline_footer'],
		'sanitize_callback' => 'helena_sanitize_checkbox',
		'transport'			=> 'refresh',
	) );

	$wp_customize->add_control( 'disable_tagline_footer', array(
		'label'    => esc_html__( 'Check to disable Tagline in footer', 'helena' ),
		'section'  => 'title_tagline',
		'settings' => 'disable_tagline_footer',
		'type'     => 'checkbox',
	) );

	$wp_customize->add_setting( 'move_title_tagline', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['move_title_tagline'],
		'sanitize_callback' => 'helena_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'move_title_tagline', array(
		'active_callback' => 'has_custom_logo',
		'label'           => esc_html__( 'Check to move Site Title and Tagline before logo', 'helena' ),
		'section'         => 'title_tagline',
		'settings'        => 'move_title_tagline',
		'type'            => 'checkbox',
	) );

	//Include Header Options
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/header-options.php';

	// Color Options
	$wp_customize->add_setting( 'color_scheme', array(
		'capability' 		=> 'edit_theme_options',
		'default'    		=> $defaults['color_scheme'],
		'sanitize_callback' => 'helena_sanitize_select',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'choices'  => helena_color_schemes(),
		'label'    => esc_html__( 'Color Scheme', 'helena' ),
		'priority' => 5,
		'section'  => 'colors',
		'settings' => 'color_scheme',
		'type'     => 'radio',
	) );

	//Include Theme Options
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/theme-options.php';

	//Include Header Highlights
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/header-highlight-content.php';

	//Include Featured Content
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/featured-content.php';

	//Include Featured Slider
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/featured-slider.php';

	//Include Hero Content
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/hero-content.php';

	//Include Logo Slider
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/logo-slider.php';

	//Include portfolio
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/portfolio.php';

	//Include promotion headline
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/promotion-headline.php';

	// Reset all settings to default
	$wp_customize->add_section( 'helena_reset_all_settings', array(
		'description'	=> esc_html__( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'helena' ),
		'priority' 		=> 900,
		'title'    		=> esc_html__( 'Reset all settings', 'helena' ),
	) );

	$wp_customize->add_setting( 'reset_all_settings', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['reset_all_settings'],
		'sanitize_callback' => 'helena_sanitize_checkbox',
		'transport'			=> 'postMessage',
	) );

	$wp_customize->add_control( 'reset_all_settings', array(
		'label'    => esc_html__( 'Check to reset all settings to default', 'helena' ),
		'section'  => 'helena_reset_all_settings',
		'settings' => 'reset_all_settings',
		'type'     => 'checkbox',
	) );
	// Reset all settings to default end

	$wp_customize->add_section( 'important_links', array(
		'priority' 		=> 999,
		'title'   	 	=> esc_html__( 'Important Links', 'helena' ),
	) );

	/**
	 * Has dummy Sanitizaition function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'important_links', array(
		'sanitize_callback'	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( new helena_important_links( $wp_customize, 'important_links', array(
        'label'   	=> esc_html__( 'Important Links', 'helena' ),
        'section'  	=> 'important_links',
        'settings' 	=> 'important_links',
        'type'     	=> 'important_links',
    ) ) );
    //Important Links End
 }
add_action( 'customize_register', 'helena_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function helena_customize_preview_js() {
	wp_enqueue_script( 'helena_customizer', get_template_directory_uri() . '/js/customizer.min.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'helena_customize_preview_js' );

/**
 * Custom scripts and styles on customize.php for helena.
 *
 * @since Helena 0.2
 */
function helena_customize_scripts() {
	wp_enqueue_script( 'helena_customizer_custom', get_template_directory_uri() . '/js/customizer-custom-scripts.min.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20160620', true );

	$helena_data = array(
		'helena_color_list' => helena_color_list(),
		'reset_message'     => esc_html__( 'Refresh the customizer page after saving to view reset effects', 'helena' )
	);

	// Send list of color variables as object to custom customizer js
	wp_localize_script( 'helena_customizer_custom', 'helena_data', $helena_data );
}
add_action( 'customize_controls_enqueue_scripts', 'helena_customize_scripts');

/**
 * Returns list of color keys of array with default values for each color scheme as index
 *
 * @since Helena 0.2
 */
function helena_color_list() {
	// Get default color scheme values
	$default 		= helena_get_default_theme_options();

	// Get default dark color scheme valies
	$default_dark 	= helena_default_dark_color_options();

	$color_list['background_color']['light'] = $default['background_color'];
	$color_list['background_color']['dark']  = $default_dark['background_color'];

	$color_list['header_textcolor']['light'] = $default['header_textcolor'];
	$color_list['header_textcolor']['dark']  = $default_dark['header_textcolor'];

	return $color_list;
}

/**
 * Function to reset date with respect to condition
 */
function helena_reset_data() {
	$reset_all  = apply_filters( 'helena_get_option', 'reset_all_settings' );
    if ( $reset_all ) {
    	remove_theme_mods();

        // Flush out all transients	on reset
        helena_flush_transients();

        return;
    }
}
add_action( 'customize_save_after', 'helena_reset_data' );


//Active Callback functions for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/active-callbacks.php';

//Sanitize functions for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/sanitize-functions.php';

// Add Upgrade to Pro Button.
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/upgrade-button/class-customize.php';