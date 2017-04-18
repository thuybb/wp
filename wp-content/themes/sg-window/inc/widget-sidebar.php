<?php
/**
 * Add a widget for displaying custom sidebars
 *
 * @since SG Window 1.1.0
 */
 
class sgwindow_side_bar extends WP_Widget {

	/**
	 * Widget constructor
	 *
	 * @since SG Window 1.1.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'sgwindow_side_bar',
		'description' => __( 'Allows to build a page layout by adding new sidebars with custom number of columns and column width.', 'sg-window' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 200,
		'id_base' => 'sgwindow_side_bar');

		/* Create the widget. */		
		
		parent::__construct( 'sgwindow_side_bar', __( 'SG Layout Builder', 'sg-window' ), $widget_ops, $control_ops );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}
	
	/**
	 * Widget styles
	 *
	 * @since SG Window 1.1.0
	 *
	*/
	public function enqueue_styles() {

		wp_enqueue_style( 'sgwindow-sidebar-widget', get_template_directory_uri() . '/inc/css/sidebar-widget.css');

	}

	/**
	 * Widget admin scripts
	 *
	 * @since SG Window 110.0
	 *
	*/
	public function enqueue_scripts( $hook_suffix ) {

		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}
		wp_enqueue_script( 'sgwindow-sidebar-register', get_template_directory_uri() . '/inc/js/sidebar.js', array( 'jquery' ) );
		wp_enqueue_style( 'sgwindow-sidebar-css', get_template_directory_uri() . '/inc/css/sidebar.css' );

	}
	
	/**
	 * Widget output
	 *
	 * @since SG Window 1.1.0
	 *
	*/
	function widget( $args, $instance ) {
		// Widget output
		extract($args);
		$sidebar_id = ( isset($args['id']) ? $args['id'] : '' );
				
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) ); 
		$width = $this->get_width( $sidebar_id );
		
		for( $i = 0; $i < 4; $i++ ) {
		
			if ( ! isset( $instance[ 'sidebar_name_' . $i ] ) ) {
				$instance[ 'sidebar_name_' . $i ] = __( 'Sidebar', 'sg-window' ) . ' ' . ( $i + 1 );
			}
			if ( ! isset( $instance[ 'width_' . $i ] ) ) {
				$instance[ 'width_' . $i ] = 100 / 4;
			}
			if ( ! isset( $instance[ 'sidebar_id_' . $i ] ) ) {
				$instance[ 'sidebar_id_' . $i ] = $i;
			}
			
		}

		$tmp_content_width = $GLOBALS['content_width'];
		
		//print the widget for the sidebar
		echo $args['before_widget'];

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if( '' !== trim($instance['title'])) echo $before_title . esc_html( $instance['title'] ) . $after_title; 

		?>
		<div class="widget-sidebar-wrapper">
			<?php
			for ( $i = 0; $i < $instance['count']; $i++ ) : 
			
				$GLOBALS['content_width'] = ( $width - $instance['count'] * 42 )/ 100 * $instance[ 'width_' . $i ];
				
			?>		
			
				<div class="my-sidebar-layout widget-sidebar column small flex-column-<?php echo esc_attr( $instance['count'] ); ?>">		
					<div class="widget-area">
					<?php

					if ( is_active_sidebar( 's_' . $instance[ 'sidebar_id_' . $i ] ) ) : ?>
					
						<?php dynamic_sidebar( 's_' . $instance[ 'sidebar_id_' . $i ] ); ?>

					<?php else : ?>
					
						<div style="text-align: center;padding: 30% 20%;">
							<a style="color: #000;" href="<?php echo esc_html( home_url() .  '/wp-admin/customize.php?autofocus[panel]=widgets' ); ?>">
								<?php echo __( 'Place for your Content, Sidebar', 'sg-window' ) . ' ' . esc_attr( $instance[ 'sidebar_id_' . $i ] ); ?> 
							</a>
						</div>
						
					<?php endif; ?>
					
					</div><!-- .widget-area -->
				</div><!-- .column -->

			<?php
			endfor;
			?>
		</div> <!-- .sidebar-wrapper -->
		<?php

		echo $args['after_widget'];
		$GLOBALS['content_width'] = $tmp_content_width;
	
	}

	/**
	 * Data validation
	 *
	 * @since SG Window 1.1.0
	 *
	 * @param array $new_instance Array of widget options.
	 * @param array $old_instance Array of old widget options.
	*/
	function update( $new_instance, $old_instance ) {
		// Save widget options
		
		$instance['title'] = esc_html($new_instance['title']); 
		$instance['count'] = absint($new_instance['count']); 
		$instance['count'] = ( $instance['count'] > 4 ? 4 : $instance['count'] );
		$instance['count'] = ( $instance['count'] <= 0 ? 4 : $instance['count'] );
		
		if( isset( $new_instance['is_transparent'] ) )
			$instance['is_transparent'] = '1';	
			
		$width = 0;

		for( $i = 0; $i < 4; $i++ ) {
		
			$instance[ 'sidebar_name_' . $i ] = esc_html( $new_instance[ 'sidebar_name_' . $i ]); 
			$instance[ 'width_' . $i ] = floatval( $new_instance[ 'width_' . $i ]); 
			$instance[ 'width_' . $i ] = ( $instance[ 'width_' . $i ] > 100 ? 100 : $instance[ 'width_' . $i ] );

			if ( $i < $instance['count'] )
				$width += $instance[ 'width_' . $i ]; 
			
			$instance[ 'sidebar_id_' . $i ] = absint( $new_instance[ 'sidebar_id_' . $i ] );
			
		}

		return $instance;
	}

	/**
	 * Widget form
	 *
	 * @since SG Window 1.1.0
	 *
	 * @param array $instance Array of widget options.
	*/
	function form( $instance ) {
		// Output admin widget options form
		// Set up some default widget settings. 				
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) ); 
		
		sgwindow_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'sg-window' ), 0);
	
		$widget_id = str_replace( '-' . 'count', '', $this->get_field_id( 'count' ) );
		$widget_id = substr( $widget_id, 7 );
		$id = sgwindow_get_last_id();
				
		$defaults = $this->defaults( $instance );

		?>
			
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) );?>"><?php echo esc_html( __( 'Number of sidebars (number in range [1:4]) (Press Apply): ', 'sg-window' ) ); ?></label>
			<br>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" class="change-count <?php echo esc_attr( $instance['count'] . ' ' . $widget_id ); ?>" value="<?php echo esc_attr( $instance['count'] ); ?>" />		
		</p>
		<hr>
		
		<span id="<?php echo $this->get_field_id( 'sidebar_id_0' ); ?>_b" class="add-sidebar-button <?php echo esc_attr( $instance['count'] ). ' ' . $widget_id; ?> <?php echo ( ! isset( $instance[ 'sidebar_id_0' ] ) ? 'active-class' : '' ); ?>">
			<?php _e( 'Register New Sidebars', 'sg-window' ); ?>
		</span>	<!-- .add-sidebar-button -->

		<div id="<?php echo $this->get_field_id( 'sidebar_id_0' ); ?>_wrap" class="sidebar-options <?php echo ( isset( $instance[ 'sidebar_id_0' ] ) ? 'active-class' : '' ); ?>">
		<?php

			for( $i = 0; $i < 4; $i++ ) {
					
				if ( ! isset( $instance[ 'sidebar_name_' . $i ] ) || empty ( $instance[ 'sidebar_name_' . $i ] ) ) {
					$instance[ 'sidebar_name_' . $i ] = __( 'Sidebar', 'sg-window' ) . ' ' . ( $id );
				}
				if ( ! isset( $instance[ 'width_' . $i ] ) || empty ( $instance[ 'width_' . $i ] ) || 0 == $instance[ 'width_' . $i ] ) {
					$instance[ 'width_' . $i ] = 100 / $instance['count'];
				}
				if ( ! isset( $instance[ 'sidebar_id_' . $i ] ) ) {
					$instance[ 'sidebar_id_' . $i ] = $id++;
				}			

				?>
				<p style="display: none;">
					<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'sidebar_id_' . $i ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sidebar_id_' . $i ) ); ?>" value="<?php echo esc_attr( $instance['sidebar_id_' . $i] ); ?>" />		
				</p>

				<div id="<?php echo esc_attr( $this->get_field_id( 'sidebar_id_' . $i ) ); ?>_hide" class="sidebar-button" <?php echo ( $i >= $instance['count'] ? 'style="display:none"' : '' ); ?>>
					<?php
					sgwindow_echo_section_main_start( __( 'Edit Sidebar ', 'sg-window' ) . ( $i + 1 ), $this->get_field_id( 'width_' . $i ) . $i );

						sgwindow_echo_input_text( $this, 'sidebar_name_' . $i, $instance, __( 'Name of sidebar (You will see this name after refreshing Customizer): ', 'sg-window' ) );
						sgwindow_echo_input_text( $this, 'width_' . $i, $instance, __( 'Width of sidebar (%): ', 'sg-window' ) );
				
					sgwindow_echo_section_main_end();
					?>

				</div>
				<?php

			}					

		?>
		</div><!-- .sidebar-options -->
		<?php

	}
	
	/**
	 * Return array Defaults
	 *
	 * @since SG Window 1.1.0
	 */
	function defaults( $instance ){
	
		$defaults = array('title' => '',
						  'count'   => '4',				  							  						  
						);
		
		return $defaults;
	}	
	
	/**
	 * Print css styles
	 *
	 * @since SG Window 1.1.0
	 */
	function echo_css( $instance, $widget_id, $sidebar  ) {
	
	?>
		<style type="text/css"> 
	<?php		
	
		for ( $i = 0; $i < $instance['count']; $i++ ) : ?>	

			@media screen and (min-width: <?php echo esc_attr( sgwindow_get_theme_mod('width_mobile_switch') ); ?>px) {
			
				#<?php echo esc_attr( $widget_id ); ?> .my-sidebar-layout:nth-child(<?php echo $i + 1; ?>) {
				
					width: <?php echo esc_attr( $instance['width_' . $i ] ); ?>%;	
					
				}						  						  
				
			}
	<?php
		endfor;
	?>
		</style>
	<?php

	}

	/* Sanitize hex color.
	 * @param string color.
	 * @return string color.
	 */
	function sanitize_hex_color( $color ) {
		if ( '' === $color )
			return '';

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
			return $color;

		return null;
	}
	
	/**
	 * Register widget-sidebars
	 *
	 * @since SG Window 1.10.0
	 */
	function register_widget_sidebars( $instance, $widget_id, $sidebar_id ){
	
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) ); 
		for( $i = 0; $i < 4; $i++ ) {
		
			if ( ! isset( $instance[ 'sidebar_id_' . $i ] ) ) {
				$instance[ 'sidebar_id_' . $i ] = $i;
			}

		}
		
		for( $i = 0; $i < $instance['count']; $i++ ) {
			
			register_sidebar( array(
				'name' => esc_attr( $instance[ 'sidebar_name_' . $i ] ),
				'id' => 's_' . esc_attr( $instance['sidebar_id_' . $i ] ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => "</aside>",
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );

		}
	}
	
	/* widget column width
	 * @param int $sidebar_id sidebar id.
	 * @param int $columns number of $columns.
	 * @param int $i1 widget left margin.
	 * @param int $i2 widget right margin.
	 * @return int width.
	 * @since SG Window 1.1.0
	 */
	function get_width( $sidebar_id ) {	
	
		$width = sgwindow_get_theme_mod( 'width_top_widget_area' ) - 4;
		return $width;
	}
}

/* Register widget
 *
 * @since SG Window 1.1.0
 *
 */
function sgwindow_register_sidebar_widget() {

	register_widget( 'sgwindow_side_bar' );
	
}
add_action( 'widgets_init', 'sgwindow_register_sidebar_widget' );
/**
 * Register sidebars for the customizer
 *
 * @since SG Window 1.1.0
 */
function sgwindow_side_bar_reg( $count ){

	if ( class_exists ( 'WP_Customize_Manager' ) ) {
		
		$sgwindow_widget_sidebars = sgwindow_get_theme_mod( 'max_id' );
	
		for( $i = $sgwindow_widget_sidebars; $i < $sgwindow_widget_sidebars + $count; $i++ ) {
			register_sidebar( array(
				'name' => __( 'Sidebar', 'sg-window' ) . ' ' . $i,
				'id' => 's_' . $i,
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => "</aside>",
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		}
	}
}
/**
 * Register Widget-Sidebar
 *
 * @since SG Window 1.1.0
 */
function sgwindow_register_sidebars() {

	$myWidget = new sgwindow_side_bar();
	$widgets = $myWidget->get_settings();
				
	foreach ( $widgets as $key => $instance ) {
		$widget_id = 'sgwindow_side_bar-' . $key;
		$sidebar = is_active_widget( '', $widget_id, 'sgwindow_side_bar' );
		if ( $sidebar ) {
			if( $widgets[ $key ] != null ) {
				$myWidget->register_widget_sidebars( $widgets[ $key ], $widget_id, $sidebar );
			}
		}
	}
	
	sgwindow_side_bar_reg( sgwindow_get_theme_mod( 'sidebar_widgets_count' ) );

}
add_action( 'widgets_init', 'sgwindow_register_sidebars', 200 );

/**
 * Add styles to the head
 *
 * @since SG Window 1.1.0
 */
function sgwindow_echo_css_sidebar() {

	$myWidget = new sgwindow_side_bar();
	$widgets = $myWidget->get_settings();
				
	foreach ( $widgets as $key => $instance ) {
		$widget_id = 'sgwindow_side_bar-' . $key;
		$sidebar = is_active_widget( '', $widget_id, 'sgwindow_side_bar' );
		if ( $sidebar ) {
			if( $widgets[ $key ] != null ) {
				$myWidget->echo_css( $widgets[ $key ], $widget_id, $sidebar );
			}
		}
	}

}
add_action( 'wp_head', 'sgwindow_echo_css_sidebar' );
/*
 * Return sidebar id 
 *
 * @since SG Window 1.1.0
 */
function sgwindow_get_last_id() {

	return sgwindow_get_theme_mod( 'max_id' );
	
}
/*
 * Print sidebar id
 *
 * @since SG Window 1.1.0
 */
function sgwindow_get_id() {

	echo sgwindow_get_theme_mod( 'max_id' );
    die();
	
}
add_action( 'wp_ajax_sgwindow_get_id', 'sgwindow_get_id' );
add_action( 'wp_ajax_nopriv_sgwindow_get_id', 'sgwindow_get_id' );