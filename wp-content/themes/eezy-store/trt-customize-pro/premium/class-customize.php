<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Eezy_Store_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function eezy_store_get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->eezy_store_setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function eezy_store_setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'eezy_store_sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'eezy_store_enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function eezy_store_sections( $eezy_store_manager ) {

		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . 'trt-customize-pro/premium/section-pro.php' );
		
		// Register custom section types.
		$eezy_store_manager->register_section_type( 'Eezy_Store_Customize_Section_Pro' );

		// Register sections.
		$eezy_store_manager->add_section(
			new Eezy_Store_Customize_Section_Pro(
				$eezy_store_manager,
				'eezy_store_pro',
				array(
					'title'    => esc_html__( 'Eezy Store Pro', 'eezy-store' ),
					'pro_text' => esc_html__( 'Go Pro',         'eezy-store' ),
					'pro_url'  => 'https://www.phoeniixx.com/product/eezy-store/',
					'priority' => 11,
					
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function eezy_store_enqueue_control_scripts() {

		wp_enqueue_script( 'eezy-store-customize-controls', trailingslashit( get_template_directory_uri() ) . 'trt-customize-pro/premium/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'eezy-store-customize-controls', trailingslashit( get_template_directory_uri() ) . 'trt-customize-pro/premium/customize-controls.css' );
	}
}

// Doing this customizer thang!
Eezy_Store_Customize::eezy_store_get_instance();
