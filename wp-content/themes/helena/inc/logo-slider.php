<?php
/**
 * The template for displaying the Slider
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */



if ( !function_exists( 'helena_logo_slider' ) ) :
/**
 * Add slider.
 *
 * @uses action hook helena_before_content.
 *
 * @since Helena 0.1
 */
function helena_logo_slider() {
	//helena_flush_transients();
	global $wp_query;

	$enable_slider = apply_filters( 'helena_get_option', 'logo_slider_option' );
	$layout        = apply_filters( 'helena_get_option', 'logo_slider_visible_items' );
	$slider_type   = apply_filters( 'helena_get_option', 'logo_slider_type' );

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');

	if ( 'entire-site' == $enable_slider  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_slider  ) ) {
		if ( ( !$output = get_transient( 'helena_logo_slider' ) ) ) {
			echo '<!-- refreshing cache -->';
			$class[] = 'section-title';

			if ( 1 == $layout ) {
				$class[] = 'one-column';
			}
			elseif ( 2 == $layout ) {
				$class[] = 'two-columns';
			}
			elseif ( 3 == $layout ) {
				$class[] = 'three-columns';
			}
			elseif ( 4 == $layout ) {
				$class[] = 'four-columns';
			}
			elseif ( 5 == $layout ) {
				$class[] = 'five-columns';
			}


			$class[] = $slider_type;

			$output = '
				<section class="'. esc_attr( implode( ' ', $class ) ) .'" id="logo-slider">
					<div class="wrapper">';
					if ( 'demo' == $slider_type ) {
						$title = esc_html__( 'Our Associates', 'helena' );
					}
					else {
						$title = apply_filters( 'helena_get_option', 'logo_slider_title' );
					}

					if ( $title  ) {
						$output .= '<h2 id="logo-slider-title" class="section-title">' . esc_html( $title ) . '</h2>';
					}

					$output .= '
						<div class="logo_slider_content_slider_wrap cycle-slideshow"
						    data-cycle-log="false"
						    data-cycle-pause-on-hover="true"
						    data-cycle-swipe="true"
						    data-cycle-fx=carousel
						    data-cycle-carousel-fluid=true
						    data-cycle-carousel-visible="'. absint( apply_filters( 'helena_get_option', 'logo_slider_visible_items' ) ) .'"

							data-cycle-speed="'. esc_attr( apply_filters( 'helena_get_option', 'logo_slider_transition_length' ) ) * 1000 .'"
							data-cycle-timeout="'. esc_attr( apply_filters( 'helena_get_option', 'logo_slider_transition_delay' ) ) * 1000 .'"
							data-cycle-slides="> article"
							>';

	    					if ( 'demo' == $slider_type ) {
	    						$output .= helena_demo_logo_slider();
	    					}
	    					else {
	    						$output .= helena_post_page_category_logo_slider();
	    					}

			$output .= '
						</div><!-- .logo_slider_content_slider_wrap.cycle-slideshow -->
					</div><!-- .wrapper -->
				</section><!-- #feature-slider -->';

			set_transient( 'helena_logo_slider', $output, 86940 );
		}
		echo $output;
	}
}
endif;
add_action( 'helena_before_content', 'helena_logo_slider', 70 );


if ( ! function_exists( 'helena_demo_logo_slider' ) ) :
	/**
	 * This function to display featured posts content
	 *
	 * @get the data value from customizer options
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_demo_logo_slider() {
		return '
		<article id="featured-post-1" class="post hentry post-demo">
				<figure class="featured-content-image">
					<a href="#" rel="bookmark">
						<img alt="Demo Logo One" class="wp-post-image" src="'.get_template_directory_uri() . '/images/logo1.png" />
					</a>
				</figure>
		</article>

		<article id="featured-post-2" class="post hentry post-demo">
			<figure class="featured-content-image">
				<a href="#" rel="bookmark">
					<img alt="Demo Logo Two" class="wp-post-image" src="'.get_template_directory_uri() . '/images/logo2.png" />
				</a>
			</figure>
		</article>

		<article id="featured-post-3" class="post hentry post-demo">
			<figure class="featured-content-image">
				<a href="#" rel="bookmark">
					<img alt="Demo Logo Three" class="wp-post-image" src="'.get_template_directory_uri() . '/images/logo3.png" />
				</a>
			</figure>
		</article>

		<article id="featured-post-4" class="post hentry post-demo">
			<figure class="featured-content-image">
				<a href="#" rel="bookmark">
					<img alt="Demo Logo Four" class="wp-post-image" src="'.get_template_directory_uri() . '/images/logo4.png" />
				</a>
			</figure>
		</article>

		<article id="featured-post-5" class="post hentry post-demo">
			<figure class="featured-content-image">
				<a href="#" rel="bookmark">
					<img alt="Demo Logo Five" class="wp-post-image" src="'.get_template_directory_uri() . '/images/logo5.png" />
				</a>
			</figure>
		</article>';
	}
endif; // helena_demo_logo_slider


if ( ! function_exists( 'helena_post_page_category_logo_slider' ) ) :
	/**
	 * This function to display hero posts content
	 *
	 * @param $options: helena_theme_options from customizer
	 *
	 * @since Helena 0.1
	 */
	function helena_post_page_category_logo_slider() {
		$output     = '';
		$no_of_post = 0; // for number of posts
		$post_list  = array();// list of valid post/page ids
		$type       = apply_filters( 'helena_get_option', 'logo_slider_type' );
		$quantity   = apply_filters( 'helena_get_option', 'logo_slider_number' );

		$args = array(
			'post_type'           => 'any',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
		if ( 'post' == $type || 'page' == $type ) {
			for( $i = 1; $i <= $quantity; $i++ ){
				$post_id = '';

				if ( 'post' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'logo_slider_post_' . $i );
				}
				elseif ( 'page' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'logo_slider_page_' . $i );
				}

				if ( $post_id && '' != $post_id ) {
					$post_list = array_merge( $post_list, array( $post_id ) );

					$no_of_post++;
				}
			}

			$args['post__in'] = $post_list;
		}
		elseif ( 'category' == $type ) {
			$no_of_post           = $quantity;
			$args['category__in'] = apply_filters( 'helena_get_option', 'logo_slider_select_category' );
		}

		if ( 0 == $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;
		$get_hero_posts         = new WP_Query( $args );

		while ( $get_hero_posts->have_posts() ) {
			$get_hero_posts->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$output .= '
			<article id="post-' . esc_attr( get_the_ID() ) . '" class="post-' . esc_attr( get_the_ID() ) . ' hentry">';

			//Default value if there is no first image
			$image = '<img class="wp-post-image" src="'.get_template_directory_uri().'/images/no-featured-image-150x150.jpg" >';

			if ( has_post_thumbnail() ) {
				$image = get_the_post_thumbnail( get_the_ID(), 'full', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
			}
			else {
				//Get the first image in page, returns false if there is no image
				$first_image = helena_get_first_image( get_the_ID(), 'full', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

				//Set value of image as first image if there is an image present in the page
				if ( '' != $first_image ) {
					$image = $first_image;
				}
			}
			$output .= '
				<figure class="featured-content-image">
					<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
					'. $image .'
					</a>
				</figure>';

			$output .= '
			</article><!-- .post-' . esc_attr( get_the_ID() ) . ' -->';
		} //endwhile

		wp_reset_postdata();

		return $output;
	}
endif; // helena_post_page_category_logo_slider