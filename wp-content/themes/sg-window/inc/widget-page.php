<?php
/**
 * Add a widget for displaying page
 *
 * @since SG Window 1.0.0
 */
 
class sgwindow_page extends WP_Widget {

	/**
	 * Widget constructor
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'sgwindow_page',
		'description' => __('Display one page with sidebars', 'sg-window' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 200,
		'id_base' => 'sgwindow_page');

		/* Create the widget. */		
		
		parent::__construct( 'sgwindow_page', __('SG Page (SG Window)', 'sg-window' ), $widget_ops, $control_ops );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	
	/**
	 * Widget styles
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	public function enqueue_styles() {
		wp_enqueue_style( 'sgwindow-page', get_template_directory_uri() . '/inc/css/page.css');
	}

	/**
	 * Widget scripts
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}
	}

	/**
	 * Widget output
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	function widget( $args, $instance ) {
		// Widget output
		extract($args);
		$sidebar_id = ( isset($args['id']) ? $args['id'] : '' );
		
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) );
		$width = $this->get_width($sidebar_id, 2);
		
		/* save current page id in global variable, use it in sidebar-X-widget.php */
		
		global $sgwindow_curr_page_id;

		$sgwindow_curr_page_id = $instance['page_id'];
		
		$query = new WP_Query( array(
			'order'          => 'DESC',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'post__in' => array( $sgwindow_curr_page_id ),
			'post_type'		 => 'page',
		) );

		if ( $query->have_posts() ) :
			$tmp_content_width = $GLOBALS['content_width'];
			$GLOBALS['content_width'] = $width;
			
			//print the widget for the sidebar
			//print the widget for the sidebar
			echo $args['before_widget'];

			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
			if( '' !== trim($instance['title'])) echo $before_title . esc_html( $instance['title'] ) . $after_title; 

			?>

			<div class="widget-page-wrap <?php echo ( '1' == $instance['is_centered'] ? 'centered' : '' ); ?> <?php echo ( '1' == $instance['is_transparent'] ? 'transparent' : '' ); ?>">
				<div class="main-wrapper <?php echo esc_attr( $instance['layout'] ); ?>">

					<?php
					sgwindow_get_sidebar_widget( $instance['layout'] );
					$query->the_post();
					?>
					<div class="site-content"> 
						<div class="content"> 
							<div class="content-container">

								<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

									<header class="entry-header">

										<?php if ( '1' != $instance['is_no_title'] ) : 

											the_title( '<h1 class="entry-title">', '</h1>' );		
										
										 endif; ?>	
										
										<?php if ( has_post_thumbnail() && '1' == sgwindow_get_theme_mod('is_display_page_image') ) : ?>
											<div class="entry-thumbnail">
												<?php the_post_thumbnail(); ?>
											</div>
										<?php endif; ?>
																	
									</header><!-- .entry-header -->

									<div class="entry-content">
										<?php
											the_content();
										?>
									</div><!-- .entry-content -->
									<?php edit_post_link( __( 'Edit', 'sg-window' ), '<span title="'.__( 'Edit', 'sg-window' ).'" class="edit-link">', '</span>' ); ?>
								</div><!-- #post-## -->
							</div><!-- .content-container -->								
						</div><!-- .content -->	
						<div class="clear"></div>
					</div><!-- .site-content -->
				</div> <!-- .main-wrapper -->
			</div> <!-- .widget-page-wrap -->
			
		<?php
			echo $args['after_widget'];
			wp_reset_postdata();
			$GLOBALS['content_width'] = $tmp_content_width;
	
		endif; 
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
		$instance['page_id'] = absint($new_instance['page_id']); 
		
		if( isset($new_instance['is_no_title']) )
			$instance['is_no_title'] = '1';
		
		if( isset($new_instance['is_centered']) )
			$instance['is_centered'] = '1';

		if( isset($new_instance['is_transparent']) )
			$instance['is_transparent'] = '1';
			
		$possible_values = array( 'right-sidebar', 
								  'left-sidebar', 
								  'two-sidebars', 
								  'no-sidebar', 
						);
						
		$instance['layout'] =  in_array( $new_instance['layout'], $possible_values ) ? $new_instance['layout'] : 'no-sidebar'; 
		
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
		// Output admin widget options form
		// Set up some default widget settings. 				
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) ); 
		
		sgwindow_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'sg-window' ), 0);
		sgwindow_echo_input_checkbox( $this, 'is_no_title', $instance, __( 'No Title', 'sg-window'));
		sgwindow_echo_input_checkbox( $this, 'is_centered', $instance, __( 'Text align center', 'sg-window'));
		sgwindow_echo_input_checkbox( $this, 'is_transparent', $instance, __( 'Set Background Opacity to 0', 'sg-window'));
		
		$pages = get_pages(); 
		
		esc_html_e('Page:', 'sg-window'); ?>
		<select id="<?php echo esc_attr( $this->get_field_id('page_id') ); ?>" name="<?php echo esc_attr( $this->get_field_name('page_id') ); ?>" style="width:100%;">
		<?php 

			foreach ( $pages as $page ) :
				echo '<option value="'. esc_attr( $page->ID ).'" ';
				selected( $instance['page_id'], $page->ID  );
				echo '>'.esc_html( $page->post_title ).'</option>';
			endforeach;
		?>
		</select>
		
		<?php
		esc_html_e('Layout:', 'sg-window'); ?>
		<select id="<?php echo esc_attr( $this->get_field_id('layout') ); ?>" name="<?php echo esc_attr( $this->get_field_name('layout') ); ?>" style="width:100%;">
		<?php 
			$styles = array( 'right-sidebar' => __('Right Sidebar', 'sg-window'), 
							'left-sidebar' => __('Left Sidebar', 'sg-window'), 
							'two-sidebars' => __('Two Sidebars', 'sg-window'), 
							'no-sidebar' => __('No Sidebars', 'sg-window'), 
							);
							
			foreach ( $styles as $id => $style ) :
				echo '<option value="'. esc_attr( $id ).'" ';
				selected( $instance['layout'], $id  );
				echo '>'.esc_html( $style ).'</option>';
			endforeach;
		?>
		</select>
	<?php	
	}

	
	/**
	 * Return array Defaults
	 *
	 * @since SG Window 1.0.0
	 */
	function defaults( $instance ){
	
		$defaults = array('title' => '',
						  'page_id'   => '',	
						  'is_no_title'   => '',	
						  'is_centered'   => '',	
						  'is_transparent'   => '',	
						  'layout'   => 'no-sidebar',							  
						);
		
		return $defaults;
	}
	
	/* widget column width
	 * @param int $sidebar_id sidebar id.
	 * @param int $columns number of $columns.
	 * @param int $i1 widget left margin.
	 * @param int $i2 widget right margin.
	 * @return int width.
	 * @since SG Window 1.0.0
	 */
	function get_width( $sidebar_id, $columns, $i1 = 0, $i2 = 0 ) {	
		if($columns <= 0) $columns = 1;
		$width = sgwindow_get_sidebar_width($sidebar_id);
		$width = ($width - $width*$i1/100 - $width*$i2/100)/$columns;
		return $width;
	}
}

/* Register widget
 *
 * @since SG Window 1.0.0
 *
 */
function sgwindow_register_page_widget() {
	register_widget( 'sgwindow_page' );
}
add_action( 'widgets_init', 'sgwindow_register_page_widget' );