<?php
/**
 * Register postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since SG Window 1.0.0
 */
 
function sgwindow_customize_register( $wp_customize ) {	

	$wp_customize->add_panel( 'background', array(
		'priority'       => 105,
		'title'          => __( 'Customize Background', 'sg-window' ),
		'description'    => __( 'Background.', 'sg-window' ),
	) );	
	
	$wp_customize->add_panel( 'navigation', array(
		'priority'       => 106,
		'title'          => __( 'Customize Menu', 'sg-window' ),
		'description'    => __( 'Navigation settings.', 'sg-window' ),
	) );
	
//Sets postMessage support
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	$wp_customize->get_section( 'colors' )->panel = 'custom_colors';	
	$wp_customize->get_section( 'colors' )->priority = '1';		
	$wp_customize->get_section( 'background_image' )->panel = 'background';	
	$wp_customize->get_section( 'background_image' )->priority = '10';
	$wp_customize->get_section( 'background_image' )->priority = '10';
	
}
add_action( 'customize_register', 'sgwindow_customize_register' );
 
 /**
 * Add custom styles to the header.
 *
 * @since SG Window 1.0.0
*/
function sgwindow_hook_css() {
	$defaults = sgwindow_get_defaults();
		
	$position = sgwindow_column_dir();
	$top = get_theme_mod('top', $defaults['top']);

?>
	<style type="text/css"> 	
		<?php if ( ! display_header_text() ) : ?>
			.site-title,
			.site-description {
				clip: rect(1px 1px 1px 1px); /* IE7 */
				clip: rect(1px, 1px, 1px, 1px);
				position: absolute;
			}
		<?php endif; ?>
		
		<?php if ( '1' != sgwindow_get_theme_mod( 'blog_is_entry_meta' ) ) : ?>
		
			.flex .entry-meta,
			.flex .entry-meta a {
				font-size: 0;
			}
		
		<?php else: ?>
		
			.flex .entry-meta,
			.flex .entry-meta a {
				font-size: 12px;
			}
			
		<?php endif; ?>
		
		.site-title h1,
		.site-title a {
			color: #<?php echo esc_attr( get_header_textcolor() ); ?>;
		}
		
		.background-fixed {
			bckground: repeat  <?php echo esc_attr($top); ?> center fixed;
			background-image: url(<?php echo esc_url(sgwindow_get_theme_mod('column_background_url')); ?>);		
		}
		
		.site-content {
			-ms-flex-order: <?php echo $position['content']; ?>;     
			-webkit-order: <?php echo $position['content']; ?>;     
			order: <?php echo $position['content']; ?>;
		}
		
		.sidebar-1 {
			-ms-flex-order: <?php echo $position['column-1']; ?>;     
			-webkit-order:  <?php echo $position['column-1']; ?>;  
			order:  <?php echo $position['column-1']; ?>;
		}

		.sidebar-2 {
			-ms-flex-order: <?php echo $position['column-2']; ?>; 
			-webkit-order:  <?php echo $position['column-2']; ?>;  
			order:  <?php echo $position['column-2']; ?>;
		}
		
		<?php if ( '1' != sgwindow_get_theme_mod( 'is_mobile_column_1' ) ) : ?>
			.sidebar-1 {
				display: none;
			}
		<?php endif;
		
		if ( '1' != sgwindow_get_theme_mod( 'is_mobile_column_2' ) ) : ?>
			.sidebar-2 {
				display: none;
			}
		<?php endif;  ?>
		
		
		.sidebar-before-footer,
		.header-wrap {
			max-width: <?php echo esc_attr(sgwindow_get_theme_mod('width_image')); ?>px;
		}
		
		.sidebar-before-footer,
		.header-wrap,
		.site {		
			max-width: <?php echo esc_attr(get_theme_mod('width_site', $defaults['width_site'])); ?>px;
		}	

		.main-wrapper.no-sidebar {
			max-width: <?php echo esc_attr(sgwindow_get_theme_mod('width_content_no_sidebar')); ?>px;
		}	
		
		@media screen and (min-width: <?php echo esc_attr(sgwindow_get_theme_mod('size_image')); ?>px) {
			.image-wrapper {
				max-width: <?php echo esc_attr(sgwindow_get_theme_mod('size_image')); ?>px;
			}
		}
				
		.sidebar-footer .widget-area,
		.wide .widget > input,
		.wide .widget > form,
		.sidebar-before-footer .widget > div,
		.sidebar-before-footer .widget-area .widget > ul,
		.sidebar-top-full .widget-area .widget > div,
		.sidebar-top-full .widget-area .widget > ul {
			max-width: <?php echo esc_attr(sgwindow_get_theme_mod('width_top_widget_area')); ?>px;
			margin-left: auto;
			margin-right: auto;
		}
		
		.site .wide .widget-area .main-wrapper.no-sidebar {
			margin: 0 auto;
			max-width: <?php echo esc_attr(sgwindow_get_theme_mod('width_main_wrapper')); ?>px;
		}
		
		.sidebar-footer .widget-area,
		.wide .widget > input,
		.wide .widget > form,
		.sidebar-before-footer .widget > div,
		.sidebar-before-footer .widget-area .widget > ul,
		.sidebar-top-full .widget-area .widget > div,
		.sidebar-top-full .widget-area .widget > ul,
		.widget.sgwindow_side_bar .widget-title,
		.widget.sgwindow_side_bar .widgettitle,
		.text-container,
		.main-wrapper {
			max-width: <?php echo esc_attr(sgwindow_get_theme_mod('width_main_wrapper')); ?>px;
		}
		
		.my-image {
			height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' )/4 ); ?>px;
		}
		
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_main_wrapper' )/3.5 ); ?>px) {		
			.my-image {
				height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' )/3.5 ); ?>px;
			}
		}
		
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_main_wrapper' )/3 ); ?>px) {		
			.my-image {
				height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' )/3 ); ?>px;
			}
		}
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_main_wrapper' )/2.5 ); ?>px) {		
			.my-image {
				height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' )/2.5); ?>px;
			}
		}
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_main_wrapper' )/2 ); ?>px) {		
			.my-image {
				height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' )/2); ?>px;
			}
		}
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_main_wrapper' )/1.5 ); ?>px) {		
			.my-image {
				height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' )/1.5 ); ?>px;
			}
		}
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_main_wrapper' )/1.2 ); ?>px) {		
			.my-image {
				height: <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_height' ) ); ?>px;
			}
		}
		
		/* set width of column in px */
		@media screen and (min-width: <?php echo esc_attr(sgwindow_get_theme_mod('width_mobile_switch')); ?>px) {
	
			.content {
				-ms-flex-order: 1;     
				-webkit-order: 1;  
				order: 1;
			}

			.sidebar-1 {
				-ms-flex-order: 2;     
				-webkit-order: 2;  
				order: 2;
			}

			.sidebar-2 {
				-ms-flex-order: 3;     
				-webkit-order: 3;  
				order: 3;
			}
		
			.main-wrapper {
				-webkit-flex-flow: nowrap;
				-ms-flex-flow: nowrap;
				flex-flow: nowrap;
			}
			
			.sidebar-1,
			.sidebar-2 {
				display: block;
			}
	
			.sidebar-1 .column {
				padding: 0 20px 0 0;
			}
			
			.sidebar-2 .column {
				padding: 0 0 0 20px;
			}
				
			.site-content {
				-ms-flex-order: 2;     
				-webkit-order: 2;  
				order: 2;
			}
	
			.sidebar-1 {
				-ms-flex-order: 1;     
				-webkit-order: 1;  
				order: 1;
			}

			.sidebar-2 {
				-ms-flex-order: 3;     
				-webkit-order: 3;  
				order: 3;
			}
			
			.two-sidebars .sidebar-1 {
				width: <?php echo esc_attr(sgwindow_get_theme_mod('width_column_1_rate')); ?>%;
			}

			.two-sidebars .sidebar-2 {
				width: <?php echo esc_attr(sgwindow_get_theme_mod('width_column_2_rate')); ?>%;
			}
			.two-sidebars .site-content {
				width: <?php echo esc_attr(100 - sgwindow_get_theme_mod('width_column_2_rate') - sgwindow_get_theme_mod('width_column_1_rate')); ?>%;
			}
			
			.left-sidebar .sidebar-1 {
				width: <?php echo esc_attr(sgwindow_get_theme_mod('width_column_1_left_rate')); ?>%;
			}
			.left-sidebar .site-content {
				width: <?php echo esc_attr(100 - sgwindow_get_theme_mod('width_column_1_left_rate')); ?>%;
			}
			
			.right-sidebar .sidebar-2 {
				width: <?php echo esc_attr(sgwindow_get_theme_mod('width_column_1_right_rate')); ?>%;
			}	
			.right-sidebar .site-content {
				width: <?php echo esc_attr(100 - sgwindow_get_theme_mod('width_column_1_right_rate')); ?>%;
			}	
		
			/* widget-sidebar */
			.sidebar-footer-content,
			.site .widget-sidebar-wrapper {

				-webkit-flex-flow: nowrap;
				-ms-flex-flow: nowrap;
				flex-flow: nowrap;
			}
			.my-sidebar-layout {
				margin: 20px 20px 20px 0;
				border: 1px solid #ccc;
			}
			.my-sidebar-layout:first-child {
				margin: 20px;
			}
			
		}
		
		@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod( 'width_main_wrapper' ) ); ?>px) {
			
			/* image widget */

			.wide .small.flex-column-2 .column-4 .element .entry-title,
			.wide .small.flex-column-2 .column-4 .element p,
			.wide .small.flex-column-2 .column-4 .element a,
			.wide .small.flex-column-2 .column-3 .element .entry-title,
			.wide .small.flex-column-2 .column-3 .element p,
			.wide .small.flex-column-2 .column-3 .element a {
				font-size: 14px;
			}
			
			.wide .small.flex-column-2 .column-2 .element .entry-title,
			.wide .small.flex-column-2 .column-1 .element .entry-title {
				display: block;
				font-size: 14px;
			}

			.wide .small.flex-column-2 .column-2 .element p,
			.wide .small.flex-column-2 .column-2 .element a,
			.wide .small.flex-column-2 .column-1 .element p,
			.wide .small.flex-column-2 .column-1 .element a {
				display: block;
				font-size: 14px;
			}
			
			.wide .small.flex-column-4 .column-2 .element .entry-title,
			.wide .small.flex-column-4 .column-1 .element .entry-title,
			.wide .small.flex-column-3 .column-2 .element .entry-title,
			.wide .small.flex-column-3 .column-2 .element .entry-title,
			.wide .small.flex-column-2 .column-2 .element .entry-title,
			.wide .small.flex-column-2 .column-1 .element .entry-title {
				display: block;
				font-size: 14px;
			}

			.wide .small.flex-column-4 .column-2 .element p,
			.wide .small.flex-column-4 .column-1 .element p,
			.wide .small.flex-column-3 .column-2 .element p,
			.wide .small.flex-column-3 .column-1 .element p {
				display: block;
				font-size: 12px;
			}
			
			.wide .small.flex-column-1 .column-4 .element .entry-title,
			.wide .small.flex-column-1 .column-3 .element .entry-title,
			.wide .small.flex-column-1 .column-4 .element .link,
			.wide .small.flex-column-1 .column-3 .element .link,
			.wide .small.flex-column-1 .column-4 .element p,
			.wide .small.flex-column-1 .column-3 .element p {
				font-size: 16px;
			}
			
			.wide .small.flex-column-1 .column-2 .element .entry-title,
			.wide .small.flex-column-1 .column-1 .element .entry-title,
			.wide .small.flex-column-1 .column-2 .element .link,
			.wide .small.flex-column-1 .column-1 .element .link,
			.wide .small.flex-column-1 .column-2 .element p,
			.wide .small.flex-column-1 .column-1 .element p {
				font-size: 18px;
			}
			
			.my-sidebar-layout {
				margin: 20px 20px 20px 0;
				border: 1px solid #ccc;
			}
			.my-sidebar-layout:first-child {
				margin: 20px 20px 20px 0;
			}
			.my-sidebar-layout:last-child {
				margin: 20px 0 20px 0;
			}
						
		}
		
	 }

	</style>
	<?php
}
add_action('wp_head', 'sgwindow_hook_css');

 /**
 * Add custom css styles for the Customizer screen.
 *
 * @since SG Window 1.0.0
*/
function sgwindow_customize_controls_enqueue_scripts() {
	wp_enqueue_style( 'sgwindow-customize-css', get_template_directory_uri() . '/inc/css/customize.css', array(), null );
	wp_enqueue_script( 'sgwindow-customize-control-js', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery' ), false, true );
	wp_enqueue_style( 'sgwindow-genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '2015' );
}
add_action('customize_controls_enqueue_scripts', 'sgwindow_customize_controls_enqueue_scripts');

/**
 * Transform hex color to rgba
 *
 * @param string $color hex color. 
 * @param int $opacity opacity. 
 * @return string rgba color.
 * @since SG Window 1.0.0
 */
function sgwindow_hex_to_rgba( $color, $opacity ) {

	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	$hex = array('ffffff');
	
	if ( 6 == strlen($color) ) {
			$hex = array( $color[0].$color[1], $color[2].$color[3], $color[4].$color[5] );
	} elseif ( 3 == strlen( $color ) ) {
			$hex = array( $color[0].$color[0], $color[1].$color[1], $color[2].$color[2] );
	}

	$rgb =  array_map('hexdec', $hex);

	return 'rgba('.implode(",",$rgb).','.$opacity.')';
}

/**
 * Return string Sanitized post thumbnail type
 *
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_post_thumbnail( $value ) {
	$possible_values = array( 'large', 'big', 'small');
	return ( in_array( $value, $possible_values ) ? $value : 'big' );
}

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_customize_preview_js() {
	wp_enqueue_script( 'sgwindow-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), time() . '14.12.2020', true );
}
add_action( 'customize_preview_init', 'sgwindow_customize_preview_js', 99 );

 /**
 * Sanitize bool value.
 *
 * @param string $value Value to sanitize. 
 * @return int 1 or 0.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_checkbox( $value ) {	
	return ( $value == '1' ? '1' : '' );
} 
 /**
 * Sanitize url value.
 *
 * @param string $value Value to sanitize. 
 * @return string sanitizes url.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_url( $value ) {	
	return esc_url( $value );
}
 /**
 * Sanitize url value.
 *
 * @param string $value Value to sanitize. 
 * @return string sanitizes url.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_background_url( $value ) {	
	$value = esc_url( $value );
	return ( $value == '' ? 'none' : $value );
}
/**
 * Sanitize integer.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @uses absint()
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_int( $value ) {
	return absint( $value );
} 
/**
 * Sanitize text field.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @uses sanitize_text_field()
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_text( $value ) {
	return sanitize_text_field( $value );
}
/**
 * Sanitize hex color.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @uses sanitize_hex_color()
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_hex_color( $value ) {
	return sanitize_hex_color( $value );
}
/**
 * Sanitizehtext.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_kses( $value ) {
	return wp_kses( $value, array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			)
			);
}
/**
 * Sanitize hex color.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_content_width( $value ) {
	$value = absint($value);
	$value = ($value > 1349 ? 1349 : ($value < 500 ? 500 : $value));
	return $value;
}
/**
 * Sanitize scroll button.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_scroll_button( $value ) {
	$possible_values = array( 'none', 'right', 'left', 'center');
	return ( in_array( $value, $possible_values ) ? $value : 'right' );
}

/**
 * Sanitize scroll css3 effect.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_scroll_effect( $value ) {
	$possible_values = array( 'none', 'move');
	return ( in_array( $value, $possible_values ) ? $value : 'move' );
}
/**
 * Sanitize opacity.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_opacity( $value ) {
	$possible_values = array ( '0',
							   '0.1', 
							   '0.2', 
							   '0.3', 
							   '0.4', 
							   '0.5',
							   '0.6', 
							   '0.7',
							   '0.8',
							   '0.9',
							   '1');
	return ( in_array( $value, $possible_values ) ? $value : '0.3' );
}
/**
 * Return string Sanitized background position
 *
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_background_position( $value ) {
	$possible_values = array( 'top', 'center', 'bottom');
	return ( in_array( $value, $possible_values ) ? $value : 'top' );
}