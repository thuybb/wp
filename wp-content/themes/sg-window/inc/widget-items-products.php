<?php
 /**
 * Widget for displaying recent shop items
 *
 * @since SG Window 1.0.0
 */
class sgwindow_product extends WP_Widget {
	/**
	 * Widget constructor
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'sgwindow_product',
		'description' => __('Display Shop Items.', 'sg-window' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 250,
		'id_base' => 'sgwindow_product_widget');


		/* Create the widget. */		
		parent::__construct( 'sgwindow_product_widget', __('SG Shop Items (SG Window)', 'sg-window' ), $widget_ops, $control_ops );
		
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
		wp_enqueue_style( 'sgwindow-image', get_template_directory_uri() . '/inc/css/image.css');
		wp_enqueue_script( 'sgwindow-image-script', get_template_directory_uri() . '/inc/js/image-widget.js', array('jquery'), '20151012', true );
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

		wp_enqueue_media();

		wp_enqueue_script( 'sgwindow-upload-image', get_template_directory_uri() . '/inc/js/meta-box-image.js', array('jquery') );

	}
	/**
	 * Widget output
	 *
	 * @since SG Window 1.0.0
	 *
	*/
	function widget( $args, $instance ) {
	
		if ( ! class_exists( 'WooCommerce' ) )
			return;

		// Widget output
		extract($args);
		$sidebar_id = ( isset($args['id']) ? $args['id'] : '' );
				
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) );
		preg_match_all('!\d+!', $instance['columns'], $matches);
		$width = $this->get_width($sidebar_id, absint(implode(' ', $matches[0])), $instance['padding_right'], $instance['padding_left']);
			
		$args = array();
		$tax = 'product_cat';
		global $post;
		$not_in = array();
		if( is_singular() ) {
			$not_in []= $post->ID;
		}
		$not_in = array_merge ( $not_in, get_option( 'sticky_posts' ) );
		
		if( '0' != $instance['product_cat'] ) {
			$args =  array(
				array(
					'taxonomy' => $tax,
					'terms'    => array( $instance['product_cat'] ),
					'field'    => 'term_id',
					'operator' => 'IN',
				),
			);
		}
		
		$query = new WP_Query( array(
			'order'          => 'DESC',
			'posts_per_page' => $instance['count'],
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'post__not_in'   => $not_in,
			'post_type'		 => 'product',
			'tax_query'      => $args,
		) );
		
		if ( $query->have_posts() ) :
			$tmp_content_width = $GLOBALS['content_width'];
			$GLOBALS['content_width'] = $width;
					
			//print the widget for the sidebar
			echo $before_widget;
			if(trim($instance['title']) !== '') echo $before_title.esc_html($instance['title']).$after_title;
		
			$pos_class = '';
			if( 0 != $instance['is_has_description'] ) {
				$pos_class = ( 1 == ($instance['is_right']) ? ' right' : ' left' );
			}
		
			?>
			<div class="woocommerce">
				<div class="main-wrapper-image <?php echo $pos_class;?>" style="padding:<?php echo esc_attr($instance['padding_top']);?>px <?php echo esc_attr($instance['padding_right']);?>% <?php echo esc_attr($instance['padding_bottom'])?>px <?php echo esc_attr($instance['padding_left'])?>%">
					<?php if( 0 != $instance['is_has_description'] && '0' != $instance['product_cat']) : ?>
					
					<div class="description">
						<article>
							<header>
								<h3 class="main-title"><?php echo esc_html(get_term( $instance['product_cat'], $tax )->name);?></h3>
							</header><!-- header -->
							<p><?php echo term_description( $instance['product_cat'], $tax ) ?></p>
							<a href="<?php echo esc_url( get_term_link( $instance['product_cat'], $tax ) ); ?>" class="link" rel="bookmark"><?php _e('All Products', 'sg-window'); ?></a>
						</article> <!-- article -->
					</div> <!-- .description -->
					
					<?php endif; ?>
					
					<div class="wrapper-image <?php echo esc_attr($instance['columns']).( $instance['is_step'] ? ' step' : ' all' ).( $instance['is_hover_all'] ? ' hover-all' : '' ).( $instance['is_margin_0'] ? ' margin-0' : '' );?>">
						
						<?php
						while (  $query->have_posts() ) :
							 $query->the_post();
						?>
							
						<div class="element <?php echo esc_attr($instance['effect_id']).( $instance['is_animate_once'] ? ' once' : '' ).( $instance['is_animate'] ? ' animate' : '' );?>">
							<article>
						
								<?php 
									if( has_post_thumbnail() && ! post_password_required() ) {
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $instance['image_size'] );
									}
									else {
										$image = sgwindow_get_theme_mod('empty_image');;
									}
								 ?>

								<div class="entry-thumbnail" style="background-image:url('<?php echo $image[0]; ?>')">																
								</div>

								<div class="hover">
								
									<a href="<?php echo esc_url( get_permalink() ); ?>" class="hover-a">
								
									<header>
									
										<?php the_title( '<h2><a class="entry-title" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
										<?php woocommerce_get_template( 'loop/rating.php' ); ?>

										</header><!-- header -->
										
										<p><?php sgwindow_the_excerpt(); ?></p>
																											
									</a>
									
								</div><!-- .hover -->
								
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="link" rel="bookmark"><?php echo esc_html( $instance['link_caption']); ?></a>
								
								<div class="product-price">
									
									<?php woocommerce_get_template( 'loop/price.php' ); ?>
									
								</div><!-- .project-list -->
								
							</article><!-- article -->
						</div><!-- .element -->
									
						<?php
											
						endwhile; 
						
						$GLOBALS['content_width'] = $tmp_content_width;
						wp_reset_postdata();
						
					?>
					</div><!-- .wrapper -->
					<div class="hide-element"></div>
				</div><!-- .main-wrapper -->
			</div> <!-- .woocommerce -->
			<?php
			echo $after_widget;	
	
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
		
		$new_instance['count'] = absint($new_instance['count']);
		$new_instance['count'] = ($new_instance['count'] > 0 ? $new_instance['count'] : 1);
		
		$possible_values = array('post-thumbnail', 'thumbnail', 'large', 'full');	
		$new_instance['image_size'] = ( in_array( $new_instance['image_size'], $possible_values ) ? $new_instance['image_size'] : 'post-thumbnail');
		
		$new_instance['title'] = esc_html($new_instance['title']); 
		$new_instance['product_cat'] = absint($new_instance['product_cat']); 
		$possible_values = array('column-1', 'column-2', 'column-3', 'column-4');	
		$new_instance['columns'] = ( in_array( $new_instance['columns'], $possible_values ) ? $new_instance['columns'] : 'column-1');
		
		if( isset($new_instance['is_step']) )
			$new_instance['is_step'] = 1;
		if( isset($new_instance['is_hover_all']))
			$new_instance['is_hover_all'] = 1;		
		if( isset($new_instance['is_has_description']))
			$new_instance['is_has_description'] = 1;		
		if( isset($new_instance['is_right']))
			$new_instance['is_right'] = 1;			
		if( isset($new_instance['is_margin_0']))
			$new_instance['is_margin_0'] = 1;	
	
		$new_instance['padding_right'] = 0;
		$new_instance['padding_left'] = 0;

		$new_instance['padding_top'] = ( 1 == $new_instance['is_margin_0'] ? 0 : 20);
		$new_instance['padding_bottom'] = ( 1 == $new_instance['is_margin_0'] ? 0 : 20);
		
		$possible_values = array('effect-1', 'effect-2', 'effect-3', 'effect-4', 'effect-5', 'effect-6', 'effect-7', 'effect-8', 'effect-9', 'effect-10', 'effect-11', 'effect-12', 'effect-14', 'effect-15', 'effect-16');	
		$new_instance['effect_id'] = ( in_array( $new_instance['effect_id'], $possible_values ) ? $new_instance['effect_id'] : 'effect-1');

		if( isset($new_instance['is_animate']) )
			$new_instance['is_animate'] = 1;
		if( isset($new_instance['is_animate_once']) )
			$new_instance['is_animate_once'] = 1;

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
		// Output admin widget options form
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) ); 
		
		sgwindow_echo_input_text( $this, 'title', $instance, __( 'Title: ', 'sg-window' ), 0);
		
		
		$tax = 'product_cat';
			
		$terms = get_terms( $tax );
								
		if ( $terms && ! is_wp_error( $terms ) ) : 

			esc_html_e('Category:', 'sg-window'); ?>
			<select id="<?php echo esc_attr( $this->get_field_id('product_cat') ); ?>" name="<?php echo esc_attr( $this->get_field_name('product_cat') ); ?>" style="width:100%;">
				<option value="0"><?php esc_html_e('Any', 'sg-window'); ?></option>
			<?php 

				foreach ( $terms as $term ) :
					echo '<option value="'. esc_attr($term->term_id).'" ';
					selected( $instance['product_cat'], $term->term_id  );
					echo '>'.esc_html($term->name).'</option>';
				endforeach;
			?>
			</select>
			
		<?php endif; ?>
					
		<?php esc_html_e('Columns:', 'sg-window'); ?>
		<select id="<?php echo esc_attr( $this->get_field_id('columns') ); ?>" name="<?php echo esc_attr( $this->get_field_name('columns') ); ?>" style="width:100%;">
		<?php 
			$styles=array( __('1', 'sg-window'), __('2', 'sg-window'), __('3', 'sg-window'), __('4', 'sg-window'));
			$styles_ids=array('column-1', 'column-2', 'column-3', 'column-4');

			for ($i=0; $i<4; $i++) {
				echo '<option value="'. esc_attr($styles_ids[$i]).'" ';
				selected( $instance['columns'], $styles_ids[$i] );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		
		<?php 
		esc_html_e('Image Size:', 'sg-window'); ?>
		<select id="<?php echo esc_attr( $this->get_field_id('image_size') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image_size') ); ?>" style="width:100%;">
		<?php 
			$styles=array( __('Post Thumbnail', 'sg-window'), __('Thumbnail', 'sg-window'), __('Large', 'sg-window'), __('Full', 'sg-window'));
			$styles_ids=array('post-thumbnail', 'thumbnail', 'large', 'full');

			foreach($styles as $i => $type) {
				echo '<option value="'. esc_attr($styles_ids[$i]).'" ';
				selected( $instance['image_size'], $styles_ids[$i] );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		
		<?php 
		
		sgwindow_echo_input_hover_style( $this, 'effect_id', $instance);
		sgwindow_echo_input_text( $this, 'count', $instance, __( 'Count: ', 'sg-window' ), 0);
		
		?>
		
		<hr>
		
		<?php
		
		sgwindow_echo_section_start( __( 'More options', 'sg-window' ), $this->get_field_id( 'is_link' ));
		
		sgwindow_echo_input_checkbox( $this, 'is_margin_0', $instance, __( 'No Margins', 'sg-window'));
		sgwindow_echo_input_checkbox( $this, 'is_has_description', $instance, __( 'Display description block', 'sg-window'));
		
		if( $instance['is_has_description'] != 0 ) {
			sgwindow_echo_input_checkbox( $this, 'is_right', $instance, __( 'Right', 'sg-window'));
		}
		
		sgwindow_echo_section_end();
		
	}
	
	/**
	 * Return array Defaults
	 *
	 * @since SG Window 1.0.0
	 */
	function defaults( $instance ){
	
		$defaults = array('title' => __('Recent Products', 'sg-window'),
						  'product_cat'   => '0',	
						  'count'   => '4',	
						  'columns'   => 'column-4',
						  'image_size'   => 'post-thumbnail',							  
						  'is_step'   => '',
						  'is_hover_all'   => '',
						  'is_margin_0'   => '',
						  'effect_id'   => 'effect-1',
						  'is_animate'   => '',
						  'is_animate_once'   => ($instance == null ? 1 : ''),
						  'link_caption'   => __('More Info', 'sg-window'),
						  'padding_right'   => '0',
						  'padding_left'   => '0',
						  'padding_top'   => '0',
						  'padding_bottom'   => '0',
						  'is_has_description'   => 0,
						  'is_right'   => ($instance == null ? 1 : ''),
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
/**
 * Register widget
 *
 * @since SG Window 1.0.0
 */
function sgwindow_register_product_widgets() {
	register_widget( 'sgwindow_product' );
}
add_action( 'widgets_init', 'sgwindow_register_product_widgets' );
