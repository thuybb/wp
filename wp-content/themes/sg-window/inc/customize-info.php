<?php
/**
 * Add new fields to customizer, create panel 'Info'
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since SG Window 1.0.0
 */
 
function sgwindow_customize_register_info( $wp_customize ) {

	class SGWindow_Customize_Button_Control extends WP_Customize_Control {
		public $type = 'button';
	 
		/**
		 * Render the control's content.
		 *
		 * Allows the content to be overriden without having to rewrite the wrapper.
		 *
		 * @since SG Window 1.0.0
		 */
		public function render_content() {
			?>
			<form>
			<input type="button" value="<?php echo esc_attr( $this->label ); ?>" onclick="window.open('<?php echo esc_js( $this->value() ); ?>')" />
			</form>
			<?php
		}

	}

	$defaults = sgwindow_get_defaults();
	
	$wp_customize->add_panel( 'info', array(
		'priority'       => 0,
		'title'          => __( 'Info', 'sg-window' ),
		'description'    => __( 'Info and Links.', 'sg-window' ),
	) );

	$section_priority = 10;
	
//New section in customizer: Support
	$wp_customize->add_section( 'support', array(
		'title'          => __( 'Support', 'sg-window' ),
		'description'          => __( 'Got something to say? Need help?', 'sg-window' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
//Support button
	$wp_customize->add_setting( 'support_url', array(
		'type'			 => 'empty',
		'default'        => 'https://wordpress.org/support/theme/sg-window',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_url'
	) );
	
	$wp_customize->add_control( new SGWindow_Customize_Button_Control( $wp_customize, 'support_url', array(
		'label'   => __( 'View Support forum', 'sg-window' ),
		'description'   => __( 'View Support forum', 'sg-window' ),
		'section' => 'support',
		'settings'   => 'support_url',
		'priority'   => 10,
	) ) );
	
//New section in customizer: Rate
	$wp_customize->add_section( 'rate', array(
		'title'          => __( 'Rate on WordPress.org', 'sg-window' ),
		'description'          => __( 'Share your thoughts about this theme. Your opinion is important for further improvement.', 'sg-window' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
// Rate button
	$wp_customize->add_setting( 'rate_url', array(
		'type'			 => 'empty',
		'default'        => 'https://wordpress.org/support/view/theme-reviews/sg-window#postform',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_url'
	) );
	
	$wp_customize->add_control( new SGWindow_Customize_Button_Control( $wp_customize, 'rate_url', array(
		'label'   => __( 'Rate', 'sg-window' ),
		'description'   => __( 'Rate', 'sg-window' ),
		'section' => 'rate',
		'settings'   => 'rate_url',
		'priority'   => 10,
	) ) );
	
// How to use
// New section in customizer: How to use
	$wp_customize->add_section( 'howto', array(
		'title'          => __( 'Help', 'sg-window' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
	$wp_customize->add_setting( 'howto', array(
		'type'			 => 'empty',
		'default'        => 'http://wpblogs.ru/themes/how-to-video-sg-window-theme/',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_url'
	) );
	
	$wp_customize->add_control( new SGWindow_Customize_Button_Control( $wp_customize, 'howto', array(
		'label'   => __( 'How to use (video instruction).', 'sg-window' ),
		'description'   => __( 'Open', 'sg-window' ),
		'section' => 'howto',
		'settings'   => 'howto',
		'priority'   => 10,
	) ) );
	
// Update
if ( ! defined ( 'SGWINDOW' ) ) :

	$wp_customize->add_section( 'pro', array(
		'title'          => __( 'Update to Pro', 'sg-window' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
	$wp_customize->add_setting( 'pro', array(
		'type'			 => 'empty',
		'default'        => 'http://wpblogs.ru/themes/sg-window-pro/',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_url'
	) );
	
	$wp_customize->add_control( new SGWindow_Customize_Button_Control( $wp_customize, 'pro', array(
		'label'   => __( 'Update Now', 'sg-window' ),
		'description'   => __( 'Update Now', 'sg-window' ),
		'section' => 'pro',
		'settings'   => 'pro',
		'priority'   => 10,
	) ) );
	

	$wp_customize->add_section( 'more_colors', array(
		'title'          => __( 'More Colors', 'sg-window' ),
		'priority'       => 100,
		'panel'  => 'custom_colors',
	) );
	
	$wp_customize->add_setting( 'more_colors', array(
		'type'			 => 'empty',
		'default'        => 'http://wpblogs.ru/themes/sg-window-pro/',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sgwindow_sanitize_url'
	) );
	
	$wp_customize->add_control( new SGWindow_Customize_Button_Control( $wp_customize, 'more_colors', array(
		'label'   => __( 'Update to Pro', 'sg-window' ),
		'description'   => __( 'Update Now', 'sg-window' ),
		'section' => 'more_colors',
		'settings'   => '',
		'priority'   => 1,
	) ) );
	
endif;
	
}
add_action( 'customize_register', 'sgwindow_customize_register_info' );