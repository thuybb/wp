<?php
/**
 * Class to add custom colors controls
 *
 * @since SG Window 1.0.0
 */

class sgwindow_Colors_Class {

	private $colors = array();
	private $sections = array();
	private $color_schemes = array();
	private $color_scheme = null;
	private $is_use_default_colors = false;
	
	function __construct() {
		$defaults = sgwindow_get_defaults();
	 
		$this->color_scheme = sgwindow_get_theme_mod( 'color_scheme', $defaults['color_scheme'] );
				
		$this->add_scheme(0, __('Blue', 'sg-window'));
		$this->add_scheme(1, __('Green', 'sg-window'));
		$this->add_scheme(2, __('Blue-White', 'sg-window'));
		
		$section_id = 'main_colors';
		$section_priority = 10;
		$p = 10;
		
		$this->add_section($section_id, __('Main Colors', 'sg-window'), __('Main website colors', 'sg-window'), $section_priority++);

	/* colors */
		
		$i = 'link_color';
		
		$this->add_color($i, $section_id, __('Link', 'sg-window'), $p++, false);
		$this->set_color($i, 0, '#1e73be');
		$this->set_color($i, 1, '#b7ba2a');
		$this->set_color($i, 2, '#1e73be');
		
		$i = 'heading_color';
		
		$this->add_color($i, $section_id, __('H1-H6 heading', 'sg-window'), $p++, false);
		$this->set_color($i, 0, '#3f3f3f');
		$this->set_color($i, 1, '#141414');
		$this->set_color($i, 2, '#3f3f3f');
		
		$i = 'heading_link';
		
		$this->add_color($i, $section_id, __('H1-H6 Link', 'sg-window'), $p++, false);
		$this->set_color($i, 0, '#1e73be');	
		$this->set_color($i, 1, '#b7ba2a');	
		$this->set_color($i, 2, '#1e73be');
		
		$i = 'description_color';
		
		$this->add_color($i, $section_id, __('Description', 'sg-window'), $p++, false);
		$this->set_color($i, 0, '#ffffff');	
		$this->set_color($i, 1, '#fff');
		$this->set_color($i, 2, '#ffffff');			
		
		$i = 'hover_color';
		
		$this->add_color($i, $section_id, __('Link Hover', 'sg-window'), $p++, false, 'refresh');
		$this->set_color($i, 0, '#45d61d');
		$this->set_color($i, 1, '#dd3333');
		$this->set_color($i, 2, '#45d61d');
	
		add_action( 'customize_register', array( $this, 'sgwindow_create_colors_controls' ), 21 );
		add_action( 'sgwindow_option_defaults', array( $this, 'sgwindow_add_defaults' ) );
		add_action( 'customize_controls_print_scripts', array( $this, 'sgwindow_print_customizer_js_colors') );

	}
	
	/* Print js for color scheme switching */
	public function sgwindow_print_customizer_js_colors() {

	?>
	<script type="text/javascript">
		jQuery( document ).ready(function( $ ) {
			var api = wp.customize;
			function SetControlVal(name, newVal) {
				var control = api.control(name); 
				if( control ){
					control.setting.set( newVal );
				}
				return;
			}	
			function SetColor(cname, newColor) {
				//update colors in picker
				var control = api.control(cname); 
				if(control){
					control.setting.set(newColor);	
					picker = control.container.find('.color-picker-hex');
					if(picker)
						if(newColor == '')
							picker.val( control.setting() ).wpColorPicker().trigger( 'clear' );
						else
							picker.val( control.setting() ).wpColorPicker().trigger( 'change' );
				}
				return;
			}	
			wp.customize( 'color_scheme', function( value ) {
				value.bind( function( to ) {
				
					sgwindow_refresh_colors(to);

				});
			});
			
			function sgwindow_refresh_colors( color_scheme ) { 
			
			<?php 
				foreach( $this->color_schemes as $scheme_id => $value ) {
					?>
				
				if ( '<?php echo esc_js($scheme_id); ?>' == color_scheme) {
					<?php
						foreach($this->colors as $id => $scheme) {
							$index = ( array_key_exists($scheme_id, $this->colors[$id] ) ? $scheme_id : 0 );
						?>
						SetColor('<?php echo esc_js($id); ?>', '<?php echo esc_js($scheme[$index]['def_val']); ?>');
						<?php 
							if( '1' == $scheme['is_has_opacity'] ) {
						?>
						SetControlVal('<?php echo esc_js($id.'_opacity'); ?>', '<?php echo esc_js($scheme[$index]['def_op']); ?>');
						<?php
							}	
						?>
					<?php
						}
						?>
					}
			<?php
				}?>
			}
		});
	</script>
	<?php
	}
	
	public function get_color_scheme() {
	
		return $this->color_scheme; 
		
	}
	
	public function add_section($name, $title, $description, $priority, $panel = 'custom_colors') {
	
		$this->sections[$name]['title'] = $title;
		$this->sections[$name]['description'] = $description;
		$this->sections[$name]['priority'] = $priority;
		$this->sections[$name]['panel'] = $panel;
		
	}

	// Set color properties
	public function add_color($name, $section, $title, $priority, $is_has_opacity = false, $transport = 'postMessage') {
	
		$this->colors[$name]['section'] = $section;
		$this->colors[$name]['val'] = '';
		$this->colors[$name]['text'] = $title;
		$this->colors[$name]['priority'] = $priority;
		$this->colors[$name]['is_has_opacity'] = $is_has_opacity;
		$this->colors[$name]['transport'] = $transport;
		
	}
	
	// Set color value and opacity for the color scheme
	public function set_color($name, $color_scheme, $color, $opacity = 1) {

		$this->colors[$name][$color_scheme]['def_val'] = $color;
		$this->colors[$name][$color_scheme]['def_op'] = $opacity;
		
	}	
	// Set color value and opacity for the color scheme
	public function use_default( $id ) {

		$this->is_use_default_colors = true;
		$this->color_scheme = $id;
		
	}
	
	// Return hex color value
	public function get_color( $name ) {
	
		if ( ! isset( $this->colors[ $name ] ) )
			return 'transparent';

		if ( true == $this->is_use_default_colors ) {
			$color = $this->colors[ $name ][ $this->color_scheme ]['def_val'];
			
			if( $this->colors[$name]['is_has_opacity'] ) {
				$opacity = $this->colors[ $name ][ $this->color_scheme ]['def_op'];
				$color = $this->hex_to_rgba( $color, $opacity );
			}
		} else {
			$color = get_theme_mod($name, $this->colors[ $name ][ $this->color_scheme ]['def_val']);
			
			if( $this->colors[$name]['is_has_opacity'] ) {
				$opacity = get_theme_mod($name.'_opacity', $this->colors[ $name ][ $this->color_scheme ]['def_op']);
				$color = $this->hex_to_rgba( $color, $opacity );
			}
		}
		
		return $color;
	}
	
// Return hex color value
	public function get_color_val( $name ) {

		if ( true == $this->is_use_default_colors ) {
			$color = $this->colors[ $name ][ $this->color_scheme ]['def_val'];
		} else {
			$color = get_theme_mod($name, $this->colors[ $name ][ $this->color_scheme ]['def_val']);
		}
		
		return $color;
	}
	
	// Add new color scheme
	public function add_scheme( $id, $text) {
		$this->color_schemes[ $id ] = $text;
	}
	
	// Set color scheme
	public function set_scheme( $id ) {
		$this->color_scheme = $id;
	}
	
	// Return color schemes
	public function get_schemes() {
		return $this->color_schemes;
	}
	
	// Add sections and controls to the Customizer
	public function sgwindow_create_colors_controls( $wp_customize ) {

		$wp_customize->add_panel( 'custom_colors', array(
			'priority'       => 103,
			'title'          => __( 'Customize Colors', 'sg-window' ),
			'description'    => __( 'In this section you can change colors for different elements.', 'sg-window' ),
		) );
		
		$wp_customize->add_section( 'color_scheme', array(
			'title'          => __( 'Color Scheme', 'sg-window' ),
			'description'    => __( 'This option refresh theme colors.', 'sg-window' ),
			'priority'       => 1,
			'panel'  => 'custom_colors',
		) );

		$wp_customize->add_setting( 'color_scheme', array(
			'default'        => $this->color_scheme,
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sgwindow_sanitize_color_scheme'
		) );

		$wp_customize->add_control( 'color_scheme', array(
			'label'      => __( 'Color Scheme', 'sg-window' ),
			'section'    => 'color_scheme',
			'settings'   => 'color_scheme',
			'type'       => 'select',
			'priority'   => 1,
			'choices'	 => $this->get_schemes(),
		) );
	
		// Register Customizer sections
		foreach( $this->sections as $id => $section ) {
		
			$wp_customize->add_section( $id, array(
				'priority'       => $section['priority'],
				'title'          => $section['title'],
				'description'    => $section['description'],
				'panel'  => $section['panel'],
			) );
			
		}	
		// Register Customizer settings and controls
		foreach( $this->colors as $id => $colors ) {
			$p = $colors['priority'];
				
			$wp_customize->add_setting( $id, array(
				'default'        => $colors[ $this->color_scheme ]['def_val'],
				'transport'		 => $colors['transport'],
				'capability'     => 'edit_theme_options',
				'sanitize_callback' => 'sgwindow_sanitize_hex_color'
			) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
				'label'   => $colors['text'],
				'section' => $colors['section'],
				'settings'   => $id,
				'priority' =>  $colors['priority'],
			) ) );
			
			if( $colors['is_has_opacity'] ) {
				$wp_customize->add_setting( $id.'_opacity', array(
					'default'        => $colors[ $this->color_scheme ]['def_op'],
					'transport'		 => 'postMessage',
					'capability'     => 'edit_theme_options',
					'sanitize_callback' => 'sgwindow_sanitize_opacity'
				) );
				
				$wp_customize->add_control( $id.'_opacity', array(
					'label'      => __('Opacity for the ', 'sg-window').$colors['text'],
					'section'    => $colors['section'],
					'settings'   => $id.'_opacity',
					'type'       => 'select',
					'priority'   => $colors['priority'],
					'choices'	 => array (
										   '0' => '0',
										   '0.1' => '0.1', 
										   '0.2' => '0.2', 
										   '0.3' => '0.3', 
										   '0.4' => '0.4', 
										   '0.5' => '0.5',
										   '0.6' => '0.6', 
										   '0.7' => '0.7',
										   '0.8' => '0.8',
										   '0.9' =>  '0.9',
										   '1' => '1')
				) );
				$wp_customize->add_setting( $id.'_opacity_range', array(
					'type'			 => 'empty',
					'default'        => 10*get_theme_mod($id.'_opacity', $colors[ $this->color_scheme ]['def_op']),
					'capability'     => 'edit_theme_options',
					'transport'		 => 'postMessage',
					'sanitize_callback' => 'absint'
				) );

				$wp_customize->add_control( $id.'_opacity_range', array(
					'label'      => '',
					'section'    => $colors['section'],
					'settings'   => $id.'_opacity_range',
					'type'       => 'range',
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 10,
						'step'  => 1,),
						'priority' =>  $colors['priority'],
				));
			}
		}
	}
	
	/**
	 * Transform hex color to rgba
	 *
	 * @param string $color hex color. 
	 * @param int $opacity opacity. 
	 * @return string rgba color.
	 * @since SG Window 1.0.0
	 */
	function hex_to_rgba( $color, $opacity ) {

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
	/* Add values to defaults array */

	function sgwindow_add_defaults( $defaults ) {

		foreach( $this->colors as $id => $values ) {

			$defaults[ $id ] = $values[0]['def_val'];
			
		}

		return $defaults;
	}
}
/**
 * Return string Sanitized color scheme
 *
 * @since SG Window 1.0.0
 */
function sgwindow_sanitize_color_scheme( $value ) {
	global $sgwindow_colors_class;
	$defaults = sgwindow_get_defaults();
	$possible_values = $sgwindow_colors_class->get_schemes();
	return ( array_key_exists( $value, $possible_values ) ? $value : $defaults['color_scheme'] );
}

 /**
 * Add custom styles to the header.
 *
 * @since SG Window 1.0.0
*/
function sgwindow_hook_css_colors() {

	global $sgwindow_colors_class;
	$colors = $sgwindow_colors_class;
?>
	<style type="text/css">	
		
		.widget.sgwindow_recent_posts .content article footer a,
		.content-container article .entry-content a,
		.comments-link a,
		.category-list a,
		.featured-post,
		.logged-in-as a,
		.site .edit-link,
		.jetpack-widget-tag-nav,
		.jetpack-widget-nav,
		.content footer a {
			color: <?php echo esc_attr($colors->get_color('link_color')); ?>;
		}		
		
		.entry-header .entry-title a {
			color: <?php echo esc_attr($colors->get_color('heading_link')); ?>;
		}
		
		a:hover,
		.widget.sgwindow_recent_posts .content article footer a:hover,
		.content-container .entry-content a:hover,
		.comments-link a:hover,
		.comment-author.vcard a:hover,
		.comment-metadata a:hover,
		.entry-meta a:hover,
		.site-title a:hover,
		.site .author.vcard a:hover,
		.entry-header .entry-title a:hover,
		.site .widget .entry-meta a:hover,
		.category-list a:hover {
			color: <?php echo esc_attr($colors->get_color('hover_color')); ?>;
		}

		.site-description h2 {
			color: <?php echo esc_attr($colors->get_color('description_color')); ?>;
		}
		
		entry-header .entry-title a,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			color: <?php echo esc_attr($colors->get_color('heading_color')); ?>;
		}
		
		.site-title h1 a {
			color: #<?php echo esc_attr( get_header_textcolor() ); ?>;

		}
	</style>
	<?php
}
add_action('wp_head', 'sgwindow_hook_css_colors');