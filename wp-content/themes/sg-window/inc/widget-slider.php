<?php
/**
 * Add a widget for displaying custom slides
 *
 * @since SG Window 1.1.0
 */
 
class sgwindow_slider extends WP_Widget {

	/**
	 * Widget constructor
	 *
	 * @since SG Window 1.1.0
	 *
	*/
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'sgwindow_slider',
		'description' => __( 'Responsive slider for displaying images, posts from category, popular posts, portfolio.', 'sg-window' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 200,
		'id_base' => 'sgwindow_slider');

		/* Create the widget. */		
		
		parent::__construct( 'sgwindow_slider', __( 'SG Slider', 'sg-window' ), $widget_ops, $control_ops );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}
	
	/**
	 * Fix for the color-picker
	 *
	 * @since SG Window 1.1.0
	 *
	*/
	public function print_scripts() {
	?>
		<script>
			( function( $ ){
					function initColorPicker( widget ) {
							widget.find( '.color-picker' ).wpColorPicker( {
									change: _.throttle( function() { // For Customizer
											$(this).trigger( 'change' );
									}, 3000 )
							});
					}
						function onFormUpdate( event, widget ) {
							initColorPicker( widget );
					}
					$( document ).on( 'widget-added widget-updated', onFormUpdate );

					$( document ).ready( function() {
							$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
									initColorPicker( $( this ) );
							} );
					} );
			}( jQuery ) );
		</script>
	<?php
	}
	
	/**
	 * Widget styles
	 *
	 * @since SG Window 1.1.0
	 *
	*/
	public function enqueue_styles() {

		wp_enqueue_style( 'sgwindow-slider-css', get_template_directory_uri() . '/inc/css/slider.css');
		wp_enqueue_script( 'sgwindow-slider', get_template_directory_uri() . '/inc/js/slider.js', array( 'jquery' ) );

	}
	
	/**
	 * Admin Scripts
	 *
	 * @since SG Window 1.1.7
	 *
	*/
	public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix || class_exists( 'WP_Customize_Control' ) ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_media();

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
				
		// Set up some default widget settings. 
						
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) ); 
	
		$curr_query = null;
		$popular_posts = null;
				
		if ( 1 == $instance['content_type'] ) {
			global $post;
			$not_in = array();
			if( is_singular() ) {
				$not_in []= $post->ID;
			}
			$not_in = array_merge ( $not_in, get_option( 'sticky_posts' ) );
			$args = array();
			$tax = 'category';
			if( '0' != $instance['category'] ) {
				$args =  array(
					array(
						'taxonomy' => $tax,
						'terms'    => array( $instance['category'] ),
						'field'    => 'term_id',
						'operator' => 'IN',
					),
				);
			}
			
			$query = new WP_Query( array(
				'order'          => 'DESC',
				'orderby'        => $instance['order'],
				'posts_per_page' => $instance['count'],
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'has_password' => false,
				'post__not_in'   => $not_in,
				'post_type'		 => array('post'),
				'tax_query'      => $args,
			) );
			
			$curr_query = $query;
			
		} elseif ( 3 == $instance['content_type'] ) { //from current query
		
			global $wp_query;
			$curr_query = $wp_query;
			
		} elseif ( 4 == $instance['content_type'] ) { //featured posts
		
			global $post;
			$not_in = array();
			if( is_singular() ) {
				$not_in []= $post->ID;
			}
			
			$sticky = get_option( 'sticky_posts' );
			$args = array();
			$tax = 'category';
			if( '0' != $instance['category'] ) {
				$args =  array(
					array(
						'taxonomy' => $tax,
						'terms'    => array( $instance['category'] ),
						'field'    => 'term_id',
						'operator' => 'IN',
					),
				);
			}
			
			$query = new WP_Query( array(
				'order'          => 'DESC',
				'orderby'        => $instance['order'],
				'posts_per_page' => $instance['count'],
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'has_password' => false,
				'post__in'   	 => $sticky,
				'post__not_in'   => $not_in,
				'post_type'		 => array('post'),
				'tax_query'      => $args,
			) );
			
			$curr_query = $query;
			
		} elseif ( 2 == $instance['content_type'] ) { //portfolio
		
			global $post;
			
			$not_in = array();
			if( is_singular() ) {
				$not_in []= $post->ID;
			}
			$not_in = array_merge ( $not_in, get_option( 'sticky_posts' ) );
			$args = array();
			$tax = 'jetpack-portfolio-type';
			if( '0' != $instance['jetpack-portfolio-type'] ) {
				$args =  array(
					array(
						'taxonomy' => $tax,
						'terms'    => array( $instance['jetpack-portfolio-type'] ),
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
				'has_password' => false,
				'post__not_in'   => $not_in,
				'post_type'		 => 'jetpack-portfolio',
				'tax_query'      => $args,
			) );
			
			$curr_query = $query;
			
		} elseif ( 6 == $instance['content_type'] ) { //popular posts
		
			if( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'stats' ) && function_exists ( 'stats_get_csv' ) ) {
				$popular_posts = stats_get_csv( 'postviews', 'days=-1&limit=-1' );
			}
				
		} elseif ( 5 == $instance['content_type'] ) { //related posts

			global $post;
			$not_in = array();
			if( is_singular() ) {
				$not_in []= $post->ID;
			}
			$not_in = array_merge ( $not_in, get_option( 'sticky_posts' ) );
			$args = array();
				
			$args =  array (
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'terms'    => wp_get_post_categories( $post->ID ) ,
					'field'    => 'term_id',
					'operator' => 'IN',
				),
				array(
					'taxonomy' => 'post_tag',
					'terms'    => wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) ) ,
					'field'    => 'term_id',
					'operator' => 'IN',
				),
			);

			$query = new WP_Query( array(
				'order'          => 'DESC',
				'orderby'        => $instance['order'],
				'posts_per_page' => $instance['count'],
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'has_password' => false,
				'post__not_in'   => $not_in,
				'post_type'		 => array('post'),
				'tax_query'      => $args,
			) );
			
			$curr_query = $query;

		}
		
		//print the widget for the sidebar
		
		if ( 0 == $instance['content_type']	|| ( isset( $curr_query ) && $curr_query->have_posts() ) || isset( $popular_posts ) ) {
		
			echo $before_widget;
			
			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
			if( '' !== trim($instance['title'])) echo $before_title . esc_html( $instance['title'] ) . $after_title; 
			
			if ( 0 == $instance['content_type'] ) {

				for ( $i = 0; $i < $instance['count']; $i++ ) {
					if ( ! isset ( $instance['is_link_' . $i ] ) || empty ( $instance['is_link_' . $i ] ) )
						$instance[ 'is_link_' . $i ] = $instance[ 'is_link' ];
					if ( ! isset ( $instance['link_' . $i ] ) || empty ( $instance['link_' . $i ] ) )
						$instance[ 'link_' . $i ] = '#';
					if ( ! isset ( $instance['img_' . $i ] ) || empty ( $instance['img_' . $i ] ) || '' == $instance['img_' . $i ] )
						$instance[ 'img_' . $i ] = $instance['empty' ];		
					if ( ! isset ( $instance['title_' . $i ] ) || empty ( $instance['title_' . $i ] ) )
						$instance[ 'title_' . $i ] = __( 'Slide Title', 'sg-window' ) . ' ' . ( $i + 1 );
					if ( ! isset ( $instance['descr_' . $i ] ) || empty ( $instance['descr_' . $i ] ) )
						$instance[ 'descr_' . $i ] = __( 'description', 'sg-window' );
				}
				
			} elseif ( 6 == $instance['content_type'] ) { //popular posts
				
				$i = 0;
								
				if( isset( $popular_posts ) ) {
					
					foreach ( $popular_posts as $post ) {
										
						if ( $i >= $instance[ 'count' ] )
							break;
					
						if ( ( '1' == $instance['is_popular_pages'] || 'post' == get_post_type( $post['post_id'] ) ) 
							&& 'publish' == get_post_status ( $post['post_id'] ) 
							&& false == post_password_required ( $post['post_id'] ) 
							&& 0 != $post['post_id'] ) {

							$instance['img_' . $i ] = $instance[ 'empty' ];	
							
							if ( has_post_thumbnail( $post['post_id'] ) ) {			
								$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post['post_id'] ), $instance['image_size'] );
								if ( $img )
									$instance['img_' . $i ] = $img[0];
							}
					
							$instance[ 'title_' . $i ] = $post['post_title']; 
							$instance[ 'descr_' . $i ] = '';
							$instance[ 'link_' . $i ]  = $post['post_permalink'];
							$instance[ 'is_link_' . $i ]  = '1';
							$instance[ 'cat_' . $i ]  = '';
							
							if ( '1' == $instance[ 'is_cat' ] ) {
								$categories = get_the_category( $post['post_id'] );
								if ( ! empty( $categories ) ) {
									$instance[ 'cat_' . $i ] =  $categories[0]->name;
								}
							}
							
							$i++;
						}
					}

				}
				$instance['count'] = $i;
				
			} else {
				$i = 0;
			
				while ( $curr_query->have_posts() ) {
					 $curr_query->the_post();
					 
					$instance['img_' . $i ] = $instance[ 'empty' ];	
					
					if ( has_post_thumbnail() && ! post_password_required() ) {			
						$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $instance['image_size'] );
						if ( $img )
							$instance['img_' . $i ] = $img[0];
					}
					
					$instance[ 'title_' . $i ] = get_the_title();		 
					$instance[ 'descr_' . $i ] = get_the_excerpt();
					$instance[ 'link_' . $i ]  = get_permalink();
					$instance[ 'is_link_' . $i ]  = '1';
					$instance[ 'cat_' . $i ]  = '';
					
					if ( '1' == $instance[ 'is_cat' ] ) {
						$categories = get_the_category( get_the_ID() );
						if ( ! empty( $categories ) ) {
							$instance[ 'cat_' . $i ] = $categories[0]->name;
						}
					}
					
					$i++;
					
					if ( 3 == $instance['content_type'] && $instance['count'] == $i )
						break;
				}
				
				$instance['count'] = $i;
					
			}
	
			?>
			<div class="sgwindow-slider-wrapper">
			
			<div class="sgwindow-slider" style="margin: 0 <?php echo esc_attr( $instance['margin'] ); ?>%;">
				<div class="<?php echo esc_attr( $instance['is_play'] ) . ' ' . absint( $instance['speed'] ) . ' ' . absint( $instance['delay'] ); ?> sgwindow-slider-content" style="padding-bottom:<?php echo esc_attr( $instance['height'] ); ?>%;">
				
					<?php for ( $i = 0; $i < $instance['count']; $i++ ) : ?>
						<article class="sgwindow-slide">
						
							<?php if ( '1' == $instance[ 'is_link_' . $i ] ) : ?>
								<a class="slide-link" href="<?php echo esc_url( $instance['link_' . $i ] ); ?>">
							<?php endif; ?>
									<div class="sgwindow-slide-content" <?php if ( '1' == $instance['is_background'] ) : ?>style="background-image: url(<?php echo esc_url( $instance['img_' . $i ] ); ?>);" <?php endif; ?>>
									
										<?php if ( '1' != $instance['is_background'] ) : ?>
										
											<img class="slider-image" src="<?php echo esc_url( $instance['img_' . $i ] ); ?>" alt="" />
									
										<?php endif; ?>
										
										<div class="slider-text-wrap">
											<header>
												<h1 class="slider-title" style="color:<?php echo esc_attr( $instance['text_color'] ); ?>;"><?php echo esc_attr( $instance['title_' . $i] ); ?></h1>
											</header>
											<p class="slider-descr" style="color:<?php echo esc_attr( $instance['text_color'] ); ?>;"><?php echo esc_attr( $instance['descr_' . $i] ); ?></p>
											
											<?php if ( '1' == $instance['is_cat'] && isset( $instance['cat_' . $i] ) ) : ?>
												<p class="slider-cat"><?php echo esc_attr( $instance['cat_' . $i] ); ?></p>
											<?php endif; ?>

										</div><!-- .slider-text-wrap -->
									</div><!-- .sgwindow-slide-content -->
									
							<?php if ( '1' == $instance[ 'is_link_' . $i ] ) : ?>
								</a><!-- .slide-link -->
							<?php endif; ?>

						</article><!-- .sgwindow-slide -->
					<?php endfor; ?>
				
				</div><!-- .sgwindow-slider-content -->
				<span class="sgwindow-next-button"><span class="genericon genericon-pocket"></span></span>
				<span class="sgwindow-prev-button"><span class="genericon genericon-pocket"></span></span>
				<ul class="sgwindow-slider-buttons">
					<li class="current"></li>
					<?php for ( $i = 1; $i < $instance['count']; $i++ ) : ?>
						<li></li>
					<?php endfor; ?>
				</ul><!-- .sgwindow-slider-buttons -->
			</div><!-- .sgwindow-slider -->

			</div><!-- .sgwindow-slider-wrapper -->
			<?php

			echo $after_widget;
			
			if ( 0 != $instance['content_type'] && 3 != $instance['content_type'] )
				wp_reset_postdata();
			
		}
	
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
		$instance['count'] = absint( $new_instance['count'] ); 
		$instance['count'] = $instance['count'] < 1 ? 1 : $instance['count']; 
		$instance['speed'] = absint( $new_instance['speed'] ); 
		$instance['speed'] = $instance['speed'] > 100 ? $instance['speed'] : 1000; 
		$instance['delay'] = absint( $new_instance['delay'] ); 
		$instance['delay'] = $instance['delay'] > 10 ? $instance['delay'] : 4000; 
		$instance['height'] = absint( $new_instance['height'] ); 
		$instance['height'] = $instance['height'] > 100 ? 40 : $instance['height']; 
		$instance['height'] = $instance['height'] < 10 ? 10 : $instance['height']; 
		
		$instance['text_color'] = $this->sanitize_hex_color( $new_instance['text_color'] ); 
		
		$instance['margin'] = absint( $new_instance['margin'] ); 
		$instance['margin'] = $instance['margin'] > 34 ? 20 : $instance['margin']; 
		
		$possible_values = array('post-thumbnail', 'thumbnail', 'large', 'full');	
		$instance['image_size'] = ( in_array( $new_instance['image_size'], $possible_values ) ? $new_instance['image_size'] : 'large');

		if( isset( $new_instance['is_play'] ) )
			$instance['is_play'] = '1';			
			
		if( isset( $new_instance['is_background'] ) )
			$instance['is_background'] = '1';	

		if( isset( $new_instance['is_cat'] ) )
			$instance['is_cat'] = '1';			
		if( isset( $new_instance['is_popular_pages'] ) )
			$instance['is_popular_pages'] = '1';	

		$instance['content_type'] = absint( $new_instance['content_type'] );
		$instance['category'] = absint( $new_instance['category'] );
		$instance['jetpack-portfolio-type'] = absint( $new_instance['jetpack-portfolio-type'] );
		
		$possible_values = array('date', 
									'rand', 
									'comment_count', 
									'popular',
								);
								
		$instance['order'] = ( in_array( $new_instance['order'], $possible_values ) ? $new_instance[order] : 'date' );
	
		for( $i = 0; $i < $instance['count']; $i++ ) {
		
			$instance[ 'title_' . $i ] = esc_html( $new_instance[ 'title_' . $i ]  );
			$instance[ 'descr_' . $i ] = esc_html( $new_instance[ 'descr_' . $i ]  );
			$instance[ 'link_' . $i ] = esc_url_raw( $new_instance[ 'link_' . $i ]  );
			
			$img = wp_get_attachment_image_src( $new_instance[ 'img_' . $i ], $instance['image_size'] );
			if ( $img )
				$instance['img_' . $i] = esc_url_raw( $img[0] );
			else
				$instance[ 'img_' . $i ] = esc_url_raw( $new_instance[ 'img_' . $i ]  );
			
			if( isset( $new_instance[ 'is_link_' . $i ] ) )
				$instance[ 'is_link_' . $i ] = '1';			  						  
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
		
		sgwindow_echo_input_text( $this, 'count', $instance, __( 'Number of Slides', 'sg-window' ) );
		
		/* What to display */
		_e( 'What you wish to display? (<span style="color:red;">Press "Apply" button to see new fields</span>):', 'sg-window' ); ?>
		<select id="<?php echo $this->get_field_id('content_type'); ?>" name="<?php echo $this->get_field_name('content_type'); ?>" style="width:100%;">
			<option value="0" <?php selected( $instance['content_type'], '0' ); ?>><?php esc_html_e('Custom Slides', 'sg-window'); ?></option>
			<option value="1" <?php selected( $instance['content_type'], '1' ); ?>><?php esc_html_e('Posts from the Category', 'sg-window'); ?></option>
			
			<?php if( class_exists( 'Jetpack' ) ) : ?>
			<option value="2" <?php selected( $instance['content_type'], '2' ); ?>><?php esc_html_e('Portfolio Projects', 'sg-window'); ?></option>
			<?php endif; ?>
			
			<option value="3" <?php selected( $instance['content_type'], '3' ); ?>><?php esc_html_e('Posts from the Current Query ( from Blog )', 'sg-window'); ?></option>
			<option value="4" <?php selected( $instance['content_type'], '4' ); ?>><?php esc_html_e('Sticky Posts', 'sg-window'); ?></option>
			<option value="5" <?php selected( $instance['content_type'], '5' ); ?>><?php esc_html_e('Related Posts', 'sg-window'); ?></option>
			<option value="6" <?php selected( $instance['content_type'], '6' ); ?>><?php esc_html_e('Popular Posts (Jetpack)', 'sg-window'); ?></option>
		</select>
		
		<?php
		
		if ( '1' == $instance[ 'content_type'] || '2' == $instance[ 'content_type'] || '4' == $instance[ 'content_type'] || '5' == $instance[ 'content_type'] ) :

			esc_html_e( 'Sort Order:', 'sg-window' ); ?>
			<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" style="width:100%;">
				<option value="date" <?php selected( $instance['order'], 'date' ); ?>><?php esc_html_e('Date', 'sg-window'); ?></option>
				<option value="rand" <?php selected( $instance['order'], 'rand' ); ?>><?php esc_html_e('Random', 'sg-window'); ?></option>
				<option value="comment_count" <?php selected( $instance['order'], 'comment_count' ); ?>><?php esc_html_e('Number of Comments', 'sg-window'); ?></option>
			</select>
		
		<?php 
		endif;


		/* Category */
		if (  '1' == $instance[ 'content_type'] || '3' == $instance[ 'content_type'] || '4' == $instance[ 'content_type'] || '5' == $instance[ 'content_type'] || '6' == $instance[ 'content_type'] ) {
			sgwindow_echo_input_checkbox( $this, 'is_cat', $instance, __( 'Display Category', 'sg-window' ) );
		}		
		
		/* Is Pages  */
		if (  '6' == $instance[ 'content_type'] ) {
			sgwindow_echo_input_checkbox( $this, 'is_popular_pages', $instance, __( 'Display Popular Pages', 'sg-window' ) );
		}
		
		if ( '1' == $instance[ 'content_type'] || '4' == $instance[ 'content_type']  ) :

			$tax = 'category';
				
			$terms = get_terms( $tax );
								
			if ( $terms && ! is_wp_error( $terms ) ) : 

				esc_html_e('Category:', 'sg-window'); ?>
				<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" style="width:100%;">
					<option value="0"><?php esc_html_e('Any', 'sg-window'); ?></option>
				<?php 

					foreach ( $terms as $term ) :
						echo '<option value="' . esc_attr($term->term_id) . '" ';
						selected( $instance['category'], $term->term_id  );
						echo '>' . esc_html( $term->name ) . '</option>';
					endforeach;
				?>
				</select>
							
			<?php 
			endif;

		endif;		
		
		/* Project */
		if ( '2' == $instance[ 'content_type'] ) :

			$tax = 'jetpack-portfolio-type';
				
			$terms = get_terms( $tax );
								
			if ( $terms && ! is_wp_error( $terms ) ) : 

				esc_html_e('Project:', 'sg-window'); ?>
				<select id="<?php echo $this->get_field_id( $tax ); ?>" name="<?php echo $this->get_field_name( $tax ); ?>" style="width:100%;">
					<option value="0"><?php esc_html_e( 'Any', 'sg-window' ); ?></option>
				<?php 

					foreach ( $terms as $term ) :
						echo '<option value="' . esc_attr( $term->term_id ) . '" ';
						selected( $instance[ $tax ], $term->term_id  );
						echo '>' . esc_html( $term->name ) . '</option>';
					endforeach;
				?>
				</select>
							
			<?php 
			endif;

		endif;
		
		if ( '0' == $instance[ 'content_type' ] ) {
			for( $i = 0; $i < $instance[ 'count' ]; $i++ ) {
			
				if ( ! isset ( $instance['link_' . $i ] ) || empty ( $instance['link_' . $i ] ) )
					$instance['link_' . $i ] = '#';
				if ( ! isset ( $instance['img_' . $i ] ) || empty ( $instance['img_' . $i ] ) || '' == $instance['img_' . $i ] )
					$instance['img_' . $i ] = $instance['img_0' ];		
				if ( ! isset ( $instance['title_' . $i ] ) || empty ( $instance['title_' . $i ] ) )
					$instance['title_' . $i ] = __( 'Slide Title', 'sg-window' ) . ' ' . ( $i + 1 );
				if ( ! isset ( $instance['descr_' . $i ] ) || empty ( $instance['descr_' . $i ] ) )
					$instance['descr_' . $i ] = __( 'description', 'sg-window' );
				if ( ! isset ( $instance['is_link_' . $i ] ) || empty ( $instance['is_link_' . $i ] ) )
					$instance['is_link_' . $i ] = $instance['is_link'];
							
				sgwindow_echo_section_main_start( __( 'Edit Image ', 'sg-window' ) . ( $i + 1 ), $this->get_field_id( 'title_' . $i ) . $i );

					sgwindow_echo_input_upload_id( $this, 'img_' . $i, $instance, __( 'Image: ', 'sg-window' ));
					sgwindow_echo_input_text( $this, 'title_' . $i, $instance, __( 'Title: ', 'sg-window' ) );
					sgwindow_echo_input_text( $this, 'descr_' . $i, $instance, __( 'Description: ', 'sg-window' ) );
					sgwindow_echo_input_checkbox( $this, 'is_link_' . $i, $instance, __( 'Display Link? ', 'sg-window' ) );
					sgwindow_echo_input_text( $this, 'link_' . $i, $instance, __( 'Link: ', 'sg-window' ) );
			
				sgwindow_echo_section_main_end();

			}

		}
		
		sgwindow_echo_section_start( __( 'Slider options', 'sg-window' ), $this->get_field_id( 'speed' ) );
			
			sgwindow_echo_input_text( $this, 'speed', $instance, __( 'Movement Speed (ms): ', 'sg-window' ) );
			sgwindow_echo_input_text( $this, 'delay', $instance, __( 'Delay (ms): ', 'sg-window' ) );
			sgwindow_echo_input_checkbox( $this, 'is_play', $instance, __( 'Auto play slides', 'sg-window' ) );
			sgwindow_echo_input_text( $this, 'height', $instance, __( 'Height of slides (number between 10-100, % of width): ', 'sg-window' ) );
			sgwindow_echo_input_text( $this, 'margin', $instance, __( 'Visible part of the next and previous slide ( number between 0-34, %): ', 'sg-window' ) );
			sgwindow_echo_input_color( $this, 'text_color', $instance, __( 'Text color: ', 'sg-window'), '#ffffff' );
			sgwindow_echo_input_checkbox( $this, 'is_background', $instance, __( 'Display Image as background ', 'sg-window' ) );
		
		sgwindow_echo_section_end();

	}
	
	/**
	 * Return array Defaults
	 *
	 * @since SG Window 1.1.0
	 */
	function defaults( $instance ){
	
		$defaults = array('title' => '',
						  'count'   => '4',				  							  						  
						  'speed'   => sgwindow_get_theme_mod( 'slider_speed' ),				  							  						  
						  'delay'   => sgwindow_get_theme_mod( 'slider_delay' ),			  							  						  
						  'is_play'   => ( $instance == null ? sgwindow_get_theme_mod( 'slider_play' ) : '' ),				  							  						  
						  'empty'   => get_template_directory_uri() . '/img/0.jpg',				  							  						  
						  'img_0'   => get_template_directory_uri() . '/img/1.jpg',				  							  						  
						  'img_1'   => get_template_directory_uri() . '/img/2.jpg',				  							  						  
						  'img_2'   => get_template_directory_uri() . '/img/3.jpg',	
						  'img_3'   => get_template_directory_uri() . '/img/4.jpg',				  							  						  						  
						  'descr'   => __( 'Description', 'sg-window' ),				  							  						  
						  'link'   => '#',				  							  						  
						  'is_link'   => ($instance == null ? '1' : ''),				  							  						  
						  'height'   => sgwindow_get_theme_mod( 'slider_height' ),			  							  						  
						  'margin'   => sgwindow_get_theme_mod( 'slider_margin' ),  							  						  
						  'text_color'   => '#ffffff',  							  						  
						  'content_type'   => sgwindow_get_theme_mod( 'slider_content_type' ),  							  						  
						  'category'   => '0',  							  						  
						  'jetpack-portfolio-type'   => '0',  							  						  
						  'order'   => 'date',  							  						  
						  'image_size'   => 'large',  							  						  
						  'is_background'   => ( $instance == null ? '1' : ''),	
						  'is_cat'  => '',						  
						  'is_popular_pages'  => '',						  
						);
		
		return $defaults;
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
}

/* Register widget
 *
 * @since SG Window 1.1.0
 *
 */
function sgwindow_register_slider_widget() {

	register_widget( 'sgwindow_slider' );

}
add_action( 'widgets_init', 'sgwindow_register_slider_widget' );