<?php
/**
 * Add Customizer Custom Controls
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

//Custom control for dropdown category multiple select
class helena_customize_dropdown_categories_control extends WP_Customize_Control {
	public $type = 'dropdown-categories';

	public $name;

	public function render_content() {
		$dropdown = wp_dropdown_categories(
			array(
				'name'             => $this->name,
				'echo'             => 0,
				'hide_empty'       => false,
				'show_option_none' => false,
				'hide_if_empty'    => false,
				'show_option_all'  => esc_html__( 'All Categories', 'helena' )
			)
		);

		$dropdown = str_replace('<select', '<select multiple = "multiple" style = "height:95px;" ' . $this->get_link(), $dropdown );

		printf(
			'<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
			$this->label,
			$dropdown
		);

		echo '<p class="description">'. esc_html__( 'Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.', 'helena' ) . '</p>';
	}
}


//Custom control for any note, use label as output description
class helena_note_control extends WP_Customize_Control {
	public $type = 'description';

	public function render_content() {
		echo '<h2 class="description">' . $this->label . '</h2>';
	}
}

//Custom control for dropdown category multiple select
class helena_important_links extends WP_Customize_Control {
    public $type = 'important-links';

    public function render_content() {
    	//Add Theme instruction, Support Forum, Changelog, Donate link, Review, Facebook, Twitter, Google+, Pinterest links
        $important_links = array(
						'theme_instructions' => array(
							'link'	=> esc_url( 'https://catchthemes.com/theme-instructions/helena/' ),
							'text' 	=> esc_html__( 'Theme Instructions', 'helena' ),
							),
						'support' => array(
							'link'	=> esc_url( 'https://catchthemes.com/support/' ),
							'text' 	=> esc_html__( 'Support', 'helena' ),
							),
						'changelog' => array(
							'link'	=> esc_url( 'https://catchthemes.com/changelogs/helena-theme/' ),
							'text' 	=> esc_html__( 'Changelog', 'helena' ),
							),
						);
		foreach ( $important_links as $important_link) {
			echo '<p><a target="_blank" href="' . $important_link['link'] .'" >' . esc_attr( $important_link['text'] ) .' </a></p>';
		}
    }
}
