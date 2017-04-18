<?php
/**
 * Add a widget for displaying one page navigation in the top sidebar
 *
 * @since SG Window 1.0.0
 */
 
class sgwindow_sidebar_nav extends WP_Widget {
	/**
	 * Widget constructor
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'sgwindow_sidebar_nav',
		'description' => __('Display one page sidebar navigation', 'sg-window' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 200,
		'id_base' => 'sgwindow_sidebar_nav');

		/* Create the widget. */		
		parent::__construct( 'sgwindow_sidebar_nav', __('SG One Page Nav (SG Window)', 'sg-window' ), $widget_ops, $control_ops );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

	}
	
	public function enqueue_styles() {
		wp_enqueue_style( 'sgwindow-one-page-nav', get_template_directory_uri() . '/inc/css/one-page.css');
		wp_enqueue_script( 'sgwindow-sidebar-nav', get_template_directory_uri() . '/inc/js/one-page-nav.js', array('jquery') );
	}
	/**
	 * Widget output
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	function widget( $args, $instance ) {
	
		$instance = wp_parse_args( (array) $instance, $this->defaults() );	
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		
		$sidebars_widgets = get_option( 'sidebars_widgets', array() );
		$sidebar_name = 'sidebar-top' . '-' . sgwindow_get_sidebar_slug();

		//print the widget for the sidebar
		
		if ( '' != $instance['demo'] ) {
			echo $args['before_widget'];

			if( trim( '' !== $title) ) echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			
			?>
			<div class="nav-one-page">
				<ul class="one-page-nav">
					<li class="invisible">0</li>

				<?php
				for ( $j = 1; $j < $instance['demo']; $j++ ) {				
				?>
					<li class="<?php echo $j; ?>"><?php echo $j; ?></li>
				<?php
				}
				?>
				</ul> <!-- .one-page-nav -->
			</div> <!-- .nav-one-page -->

				<?php
			echo $args['after_widget'];
			return;
		}
		
		if ( ! isset( $sidebars_widgets[ $sidebar_name ] ) ) {
			return;
		}

		$widgets = (array) $sidebars_widgets[ $sidebar_name ];

		echo $args['before_widget'];
			
		if( trim( '' !== $title) ) echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		
		?>
		<div class="nav-one-page">
			<ul class="one-page-nav">
			<?php

			foreach ( $widgets as $id => $widget ) {

				$class = '';
				if ( false !== strpos( $widget, 'sgwindow_sidebar_nav' ) ) {
					$class = ' invisible';
				}
				
			?>
				<li class="<?php echo esc_attr( $id ) . $class; ?>"><?php echo esc_html( $id ); ?></li>
			<?php
			}
			?>
			</ul> <!-- .one-page-nav -->
		</div> <!-- .nav-one-page -->

			<?php
		echo $args['after_widget'];

	}
	/**
	 * Data validation
	 *
	 * @since SG Window 1.0.0
	 *
	 * @param array $new_instance Array of widget options.
	 * @param array $old_instance Array of old widget options.
	*/
	function update( $new_instance, $old_instance ) {
		// Save widget options
		$new_instance['title'] = esc_html($new_instance['title']);
	
		return $new_instance;
	}
	/**
	 * Widget form
	 *
	 * @since SG Window 1.0.0
	 *
	 * @param array $instance Array of widget options.
	*/
	function form( $instance ) {
		// Set up some default widget settings. 
		$instance = wp_parse_args( (array) $instance, $this->defaults() );
	
	   sgwindow_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'sg-window' )); ?>
<?php
}

	/**
	 * Return array Defaults
	 *
	 * @since SG Window 1.0.0
	 */
	function defaults(){
	
		// Set up some default widget settings. 
		$defaults = array('title' => '',
						  'demo' => '',
						);
		
		return $defaults;
	}		
}
/**
 * Register widget
 *
 * @since SG Window 1.0.0
 */
function sgwindow_register_one_widget() {
	register_widget( 'sgwindow_sidebar_nav' );
}
add_action( 'widgets_init', 'sgwindow_register_one_widget' );