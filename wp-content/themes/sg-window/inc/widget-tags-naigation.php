<?php
/**
 * Add a widget for displaying portfolio navigation-filter
 *
 * @since SG Window 1.0.0
 */
 
class sgwindow_portfolio_tag_nav extends WP_Widget {
	/**
	 * Widget constructor
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'sgwindow_portfolio_tag_nav',
		'description' => __('Display portfolio tags navigation on both jetpack portfolio index and archive pages', 'sg-window' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 200,
		'id_base' => 'sgwindow_portfolio_tag_nav');

		/* Create the widget. */		
		parent::__construct( 'sgwindow_portfolio_tag_nav', __('SG Portfolio Tags Nav (SG Window)', 'sg-window' ), $widget_ops, $control_ops );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

	}
	
	public function enqueue_styles() {
		wp_enqueue_script( 'sgwindow-portfolio-nav', get_template_directory_uri() . '/inc/js/portfolio-nav.js', array('jquery') );
	}
	/**
	 * Widget output
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	function widget( $args, $instance ) {
	
		/* display widget on portfolio index and archive pages only */
		if( ! ('jetpack-portfolio' == get_post_type()) || is_singular('jetpack-portfolio'))
			return;
	
		$instance = wp_parse_args( (array) $instance, $this->defaults() );	
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$tax = 'jetpack-portfolio-tag';
		
		//print the widget for the sidebar
		if ( have_posts() ) : 
		
		echo $args['before_widget'];

		?>
		<section>
			<header>
		<?php
		
			$tax_names = array();
		
			if(trim( '' !== $title)) echo $args['before_title'] . esc_html($title) . $args['after_title'];
			
			if ( '1' == $instance['is_one_page'] ) :
				$tax_names = sgwindow_get_tax_ids( $tax ); 
				
				?><ul class="jetpack-widget-tag-nav">
					<li class="all current"><?php _e( 'All Tags', 'sg-window' ) ?></li>
					<?php
					foreach( $tax_names as $id => $value ) : ?>
					<li class="<?php echo esc_attr( $id ); ?>"><?php echo $value; ?></li>
					<?php
					endforeach;
				?></ul>
				
				<?php
			else :
				$terms = get_terms( $tax );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
					?>
					<ul class="jetpack-widget-tag-nav-2">
						<li <?php echo ( 'jetpack-portfolio' == get_post_type() && ! is_singular( 'jetpack-portfolio' ) && ! is_search() && ! is_tax('jetpack-portfolio-type' && ! is_tax('jetpack-portfolio-tag' )) ? 'class="current"' : '' ); ?>>
							<a href="<?php echo get_post_type_archive_link( 'jetpack-portfolio' ); ?>"><?php _e( 'Portfolio', 'sg-window' ); ?></a>
						</li>					
					<?php
					foreach ( $terms as $term ) :
					?>
						<li <?php echo ( is_tax( $tax, $term ) ? 'class="current"' : '' ); ?>>
							<a href="<?php echo esc_url( get_term_link( $term ) ) . '">' . esc_attr( trim ( $term->name ) ); ?></a>
						</li>
					<?php	
					endforeach;
					?>
					</ul>			
					<?php
				endif;
			endif;
									
		?>
			</header>
		</section>
		<?php echo $args['after_widget']; ?>
		<?php
		endif; // End check for posts.

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
		$instance['title'] = esc_html($new_instance['title']);
		if( isset($new_instance['is_one_page']) )
			$instance['is_one_page'] = '1';
			
		return $instance;
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

		sgwindow_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'sg-window' ));
		sgwindow_echo_input_checkbox( $this, 'is_one_page', $instance, __( 'SG One page navigation (portfolio index)', 'sg-window') );
	}

	/**
	 * Return array Defaults
	 *
	 * @since SG Window 1.0.0
	 */
	function defaults(){
	
		// Set up some default widget settings. 
		$defaults = array(
							'title' => __( 'Tags', 'sg-window' ), 
							'is_one_page' => '1',
						);
		
		return $defaults;
	}		
}
/**
 * Register widget
 *
 * @since SG Window 1.0.0
 */
function sgwindow_register_tag_nav_widget() {
	register_widget( 'sgwindow_portfolio_tag_nav' );
}
add_action( 'widgets_init', 'sgwindow_register_tag_nav_widget' );