<?php
/**
 * The template for displaying the Slider
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */



if ( !function_exists( 'helena_featured_slider' ) ) :
	/**
	 * Add slider.
	 *
	 * @uses action hook helena_before_content.
	 *
	 * @since Helena 0.1
	 */
	function helena_featured_slider() {
		//helena_flush_transients();
		global $wp_query;

		$enable_slider = apply_filters( 'helena_get_option', 'featured_slider_option' );

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		// Front page displays in Reading Settings
		$page_on_front = get_option('page_on_front') ;
		$page_for_posts = get_option('page_for_posts');

		if ( 'entire-site' == $enable_slider  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_slider  ) ) {
			if ( ( !$output = get_transient( 'helena_featured_slider' ) ) ) {
				echo '<!-- refreshing cache -->';

				$output = '
					<section id="feature-slider">
						<div class="wrapper">
							<div class="cycle-slideshow"
							    data-cycle-log="false"
							    data-cycle-pause-on-hover="true"
							    data-cycle-swipe="true"
							    data-cycle-fx="'. esc_attr( apply_filters( 'helena_get_option', 'featured_slider_transition_effect' ) ) .'"
								data-cycle-speed="'. esc_attr( apply_filters( 'helena_get_option', 'featured_slider_transition_length' ) ) * 1000 .'"
								data-cycle-timeout="'. esc_attr( apply_filters( 'helena_get_option', 'featured_slider_transition_delay' ) ) * 1000 .'"
								data-cycle-loader="'. esc_attr( apply_filters( 'helena_get_option', 'featured_slider_image_loader' ) ) .'"
								data-cycle-slides="> article"
								>

							    <!-- prev/next links -->
							    <div class="cycle-prev"></div>
							    <div class="cycle-next"></div>

							    <!-- empty element for pager links -->
		    					<div class="cycle-pager"></div>';

		    					$select_slider 	= apply_filters( 'helena_get_option', 'featured_slider_type' );

								// Select Slider
								if ( 'demo-featured-slider' == $select_slider ) {
									$output .= helena_demo_slider();
								}
								else {
									$output .= helena_post_page_category_slider();
								}

				$output .= '
							</div><!-- .cycle-slideshow -->
						</div><!-- .wrapper -->
					</section><!-- #feature-slider -->';

				set_transient( 'helena_featured_slider', $output, 86940 );
			}
			echo $output;
		}
	}
endif;
add_action( 'helena_after_header', 'helena_featured_slider', 20 );


if ( ! function_exists( 'helena_demo_slider' ) ) :
	/**
	 * This function to display featured posts slider
	 *
	 * @get the data value from customizer options
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_demo_slider() {
		return '
		<article class="post demo-image-1 hentry slides displayblock">
			<figure class="slider-image">
				<a title="Slider Image 1" href="'. esc_url( home_url( '/' ) ) .'">
					<img src="'.get_template_directory_uri().'/images/slider1-1170x658.jpg" class="wp-post-image" alt="Slider Image 1" title="Slider Image 1">
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a title="Top 8 mountain getaways" href="#"><span>Top 8 mountain getaways</span></a>
					</h2>
					<div class="screen-reader-text"><span class="post-time">Posted on <time pubdate="" datetime="2014-08-16T10:56:23+00:00" class="entry-date updated">16 August, 2014</time></span><span class="post-author">By <span class="author vcard"><a rel="author" title="View all posts by Catch Themes" href="https://catchthemes.com/blog/" class="url fn n">Catch Themes</a></span></span></div>
				</header>
				<div class="entry-content">
					<p>Nepal contains part of the Himalayas, the highest mountain range in the world. Eight of the fourteen eight-thousanders are located in the country, either in whole or shared across a border with China or India.<span class="more-button"><a href="#" class="more-link">Continue reading</a></span></p>
				</div>
			</div>
		</article><!-- .slides -->

		<article class="post demo-image-2 hentry slides displaynone">
			<figure class="Slider Image 2">
				<a title="Slider Image 2" href="'. esc_url( home_url( '/' ) ) .'">
					<img src="'. get_template_directory_uri() . '/images/slider2-1170x658.jpg" class="wp-post-image" alt="Slider Image 2" title="Slider Image 2">
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a title="Mountain Bar No-Bake Cookies" href="#"><span>Mountain Bar No-Bake Cookies</span></a>
					</h2>
					<div class="screen-reader-text"><span class="post-time">Posted on <time pubdate="" datetime="2014-08-16T10:56:23+00:00" class="entry-date updated">16 August, 2014</time></span><span class="post-author">By <span class="author vcard"><a rel="author" title="View all posts by Catch Themes" href="https://catchthemes.com/blog/" class="url fn n">Catch Themes</a></span></span></div>
				</header>
				<div class="entry-content">
					<p>You cannot go wrong with the primary ingredients of chocolate and peanut butter. These cookies are easy-to-make and require no baking and are gluten-free. Children seem to love these cookies and can never seem to get enough.<span class="more-button"><a href="#" class="more-link">Continue reading</a></span></p>
				</div>
			</div>
		</article><!-- .slides --> ';
	}
endif; // helena_demo_slider


if ( ! function_exists( 'helena_post_page_category_slider' ) ) :
	/**
	 * This function to display featured post, page or category slider
	 *
	 * @since Helena 0.1
	 */
	function helena_post_page_category_slider() {
		$no_of_post = 0; // for number of posts
		$post_list  = array();// list of valid post/page ids
		$type       = apply_filters( 'helena_get_option', 'featured_slider_type' );
		$quantity   = apply_filters( 'helena_get_option', 'featured_slider_number' );
		$more_text  = apply_filters( 'helena_get_option', 'excerpt_more_text' );
		$output     = '';

		$args = array(
			'post_type'           => 'any',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
		if ( 'featured-post-slider' == $type || 'featured-page-slider' == $type  ) {
			for( $i = 1; $i <= $quantity; $i++ ){
				$post_id = '';

				if ( 'featured-post-slider' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'featured_slider_post_' . $i );
				}
				elseif ( 'featured-page-slider' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'featured_slider_page_' . $i );
				}

				if ( $post_id && '' != $post_id ) {
					$post_list = array_merge( $post_list, array( $post_id ) );

					$no_of_post++;
				}
			}

			$args['post__in'] = $post_list;
		}
		elseif ( 'featured-category-slider' == $type ) {
			$no_of_post = $quantity;

			$args['category__in'] = apply_filters( 'helena_get_option', 'featured_slider_select_category' );
		}

		if ( 0 == $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$loop = new WP_Query( $args );

		while ( $loop->have_posts()) { 
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );
			$excerpt = get_the_excerpt();
			$classes[] = 'post post-' . esc_attr( get_the_ID() ).' hentry slides';

			if (0 == $loop->current_post ) {
				$classes[] =  'displayblock';
			}
			else {
				$classes[] = 'displaynone';
			}

			$output .= '
			<article class="' . esc_attr( implode( ' ', $classes ) ) . '">
				<figure class="slider-image">';
				if ( has_post_thumbnail() ) {
					$output .= '<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">
						'. get_the_post_thumbnail( get_the_ID(), 'helena-slider', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class'	=> 'attached-post-image' ) ).'
					</a>';
				}
				else {
					//Default value if there is no first image
					$image = '<img class="wp-post-image" src="'.get_template_directory_uri().'/images/no-featured-image-1170x658.jpg" >';

					//Get the first image in page, returns false if there is no image
					$first_image = helena_get_first_image( get_the_ID(), 'helena-slider', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class' => 'attached-post-image' ) );

					//Set value of image as first image if there is an image present in the page
					if ( '' != $first_image ) {
						$image =	$first_image;
					}

					$output .= '<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">
						'. $image .'
					</a>';
				}

				$output .= '
				</figure><!-- .slider-image -->
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">'.the_title( '<span>','</span>', false ).'</a>
						</h2>
						<div class="screen-reader-text">'. helena_page_post_meta().'</div>
					</header>';
					if ( $excerpt !='') {
						$output .= '<div class="entry-content"><p>'. $excerpt.'</p></div>';
					}
					$output .= '
				</div><!-- .entry-container -->
			</article><!-- .slides -->';
		} //endwhile;

		wp_reset_postdata();

		return $output;
	}
endif; // helena_post_page_category_slider