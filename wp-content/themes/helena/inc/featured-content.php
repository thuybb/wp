<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */



if ( !function_exists( 'helena_featured_content_display' ) ) :
	/**
	* Add Featured content.
	*
	* @uses action hook helena_before_content.
	*
	* @since Helena 0.1
	*/
	function helena_featured_content_display() {
		//helena_flush_transients();
		global $wp_query;

		// get data value from options
		$enable_content = apply_filters( 'helena_get_option', 'featured_content_option' );
		$content_select = apply_filters( 'helena_get_option', 'featured_content_type' );
		$slider_select  = apply_filters( 'helena_get_option', 'featured_content_slider' );

		// Front page displays in Reading Settings
		$page_for_posts = get_option('page_for_posts');


		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
			if ( !$output = get_transient( 'helena_featured_content' ) ) {
				$layouts 	 = apply_filters( 'helena_get_option', 'featured_content_layout' );
				$headline 	 = apply_filters( 'helena_get_option', 'featured_content_headline' );
				$subheadline = apply_filters( 'helena_get_option', 'featured_content_subheadline' );

				echo '<!-- refreshing cache -->';

				if ( !empty( $layouts ) ) {
					$classes = $layouts ;
				}

				$classes .= ' ' . $content_select ;

				if ( 'demo-featured-content' == $content_select ) {
					$headline    = esc_html__( 'Featured Content', 'helena' );
					$subheadline = esc_html__( 'Here you can showcase the x number of Featured Content. You can edit this Headline, Subheadline and Feaured Content from "Appearance -> Customize -> Featured Content Options".', 'helena' );
				}

				$position = apply_filters( 'helena_get_option', 'featured_content_position' );
				if ( $position ) {
					$classes .= ' border-top' ;
				}

				$output ='
					<section id="featured-content" class="' . $classes . '">
						<div class="wrapper">';
							if ( !empty( $headline ) || !empty( $subheadline ) ) {
								$output .='<div class="featured-heading-wrap">';
									if ( !empty( $headline ) ) {
										$output .='<h2 id="featured-heading" class="section-title">'.  $headline .'</h2>';
									}
									if ( !empty( $subheadline ) ) {
										$output .='<p>'. $subheadline .'</p>';
									}
								$output .='</div><!-- .featured-heading-wrap -->';
							}

							if ( $slider_select ) {
								$output .='
								<!-- prev/next links -->
								<div id="content-controls">
									<div id="content-prev"></div>
									<div id="content-next"></div>
								</div>
								<div class="cycle-slideshow"
								    data-cycle-log="false"
								    data-cycle-pause-on-hover="true"
								    data-cycle-swipe="true"
								    data-cycle-auto-height=container
									data-cycle-slides=".featured_content_slider_wrap"
									data-cycle-fx="scrollHorz"
									data-cycle-prev="#content-prev"
	    							data-cycle-next="#content-next"
									>';
							 }

							$output .='
							<div class="featured-content-wrap">';

								// Select content
								if ( 'demo-featured-content' == $content_select ) {
									$output .= helena_demo_content();
								}
								else {
									$output .= helena_post_page_category_content();
								}

								if ( $slider_select ) {
									$output .='
									</div><!-- .cycle-slideshow -->';
								}

				$output .='
							</div><!-- .featured-content-wrap -->
						</div><!-- .wrapper -->
					</section><!-- #featured-content -->';
			set_transient( 'helena_featured_content', $output, 86940 );
			}
		echo $output;
		}
	}
endif;


if ( ! function_exists( 'helena_featured_content_display_position' ) ) :
	/**
	 * Homepage Featured Content Position
	 *
	 * @action helena_content, helena_after_secondary
	 *
	 * @since Helena 0.1
	 */
	function helena_featured_content_display_position() {
		// Getting data from Theme Options
		$position = apply_filters( 'helena_get_option', 'featured_content_position' );
		if ( $position ) {
			add_action( 'helena_after_content', 'helena_featured_content_display', 30 );
		}
		else {
			add_action( 'helena_before_content', 'helena_featured_content_display', 40 );
		}
	}
	endif; // helena_featured_content_display_position
add_action( 'helena_before_header', 'helena_featured_content_display_position' );


if ( ! function_exists( 'helena_demo_content' ) ) :
	/**
	 * This function to display featured posts content
	 *
	 * @get the data value from customizer options
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_demo_content() {
		$output = '
		<div class="featured_content_slider_wrap">
			<article id="featured-post-1" class="post hentry post-demo">
				<figure class="featured-content-image">
					<a href="#" rel="bookmark">
						<img class="wp-post-image" src="'.get_template_directory_uri() . '/images/featured1-585x439.jpg" />
					</a>
				</figure>
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#" rel="bookmark">Photo Shoot</a>
						</h2>
					</header>
					<div class="entry-content">
						A photo shoot is generally used in the fashion or glamour industry, whereby a model poses for a photographer at a studio or an outdoor location where multiple photos are taken.
					</div>
				</div><!-- .entry-container -->
			</article>

			<article id="featured-post-2" class="post hentry post-demo">
				<figure class="featured-content-image">
					<a href="#" rel="bookmark">
						<img class="wp-post-image" src="'.get_template_directory_uri() . '/images/featured2-585x439.jpg" />
					</a>
				</figure>
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#" rel="bookmark">iPhoneography</a>
						</h2>
					</header>
					<div class="entry-content">
						iPhoneography is the art of creating photos with an iPhone. This is a style differs from all other forms of digital photography in that images are both shot and processed on the iOS device.
					</div>
				</div><!-- .entry-container -->
			</article>

			<article id="featured-post-3" class="post hentry post-demo">
				<figure class="featured-content-image">
					<a href="#" rel="bookmark">
						<img class="wp-post-image" src="'.get_template_directory_uri() . '/images/featured3-585x439.jpg" />
					</a>
				</figure>
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#" rel="bookmark">Wildlife Photography</a>
						</h2>
					</header>
					<div class="entry-content">
						Wildlife photography is a genre of photography concerned with documenting various forms of wildlife in their natural habitat. It is one of the more challenging forms of photography.
					</div>
				</div><!-- .entry-container -->
			</article>';

		$layout = apply_filters( 'helena_get_option', 'featured_content_layout' );
		if ( 'four-columns' == $layout ) {
			$output .= '
			<article id="featured-post-4" class="post hentry post-demo">
				<figure class="featured-content-image">
					<a href="#" rel="bookmark">
						<img class="wp-post-image" src="'.get_template_directory_uri() . '/images/featured4-585x439.jpg" />
					</a>
				</figure>
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#" rel="bookmark">Sports photography</a>
						</h2>
					</header>
					<div class="entry-content">
						Sports photography refers to the genre of photography that covers all types of sports. In the majority of cases, professional sports photography is a branch of photojournalism.
					</div>
				</div><!-- .entry-container -->
			</article>';
		}
		$output .= '</div><!-- .featured_content_slider_wrap -->';

		$slider = apply_filters( 'helena_get_option', 'featured_content_slider' );
		if ( $slider ) {
			$output .= '
			<div class="featured_content_slider_wrap">
				<article id="featured-post-5" class="post hentry post-demo">
					<figure class="featured-content-image">
						<a href="#" rel="bookmark">
							<img class="wp-post-image" src="'.get_template_directory_uri() . '/images/featured5-585x439.jpg" />
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="#" rel="bookmark">Photo Shoot</a>
							</h2>
						</header>
						<div class="entry-content">
							A photo shoot is generally used in the fashion or glamour industry, whereby a model poses for a photographer at a studio or an outdoor location where multiple photos are taken.
						</div>
					</div><!-- .entry-container -->
				</article>

				<article id="featured-post-6" class="post hentry post-demo">
					<figure class="featured-content-image">
						<a href="#" rel="bookmark">
							<img class="wp-post-image" src="'.get_template_directory_uri() . '/images/featured6-585x439.jpg" />
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="#" rel="bookmark">iPhoneography</a>
							</h2>
						</header>
						<div class="entry-content">
							iPhoneography is the art of creating photos with an iPhone. This is a style differs from all other forms of digital photography in that images are both shot and processed on the iOS device.
						</div>
					</div><!-- .entry-container -->
				</article>

				<article id="featured-post-7" class="post hentry post-demo">
					<figure class="featured-content-image">
						<a href="#" rel="bookmark">
							<img class="wp-post-image" src="'.get_template_directory_uri() . '/images/featured7-585x439.jpg" />
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="#" rel="bookmark">Wildlife Photography</a>
							</h2>
						</header>
						<div class="entry-content">
							Wildlife photography is a genre of photography concerned with documenting various forms of wildlife in their natural habitat. It is one of the more challenging forms of photography.
						</div>
					</div><!-- .entry-container -->
				</article>';

			if ( 'four-columns' == $layout ) {
				$output .= '
				<article id="featured-post-8" class="post hentry post-demo">
					<figure class="featured-content-image">
						<a href="#" rel="bookmark">
							<img class="wp-post-image" src="'.get_template_directory_uri() . '/images/featured8-585x439.jpg" />
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="#" rel="bookmark">Sports photography</a>
							</h2>
						</header>
						<div class="entry-content">
							Sports photography refers to the genre of photography that covers all types of sports. In the majority of cases, professional sports photography is a branch of photojournalism.
						</div>
					</div><!-- .entry-container -->
				</article>';
			}
			$output .= '</div><!-- .featured_content_slider_wrap -->';
		}

		return $output;
	}
endif; // helena_demo_content


if ( ! function_exists( 'helena_post_page_category_content' ) ) :
	/**
	 * This function to display featured posts content
	 *
	 * @since Helena 0.1
	 */
	function helena_post_page_category_content() {
		global $post;

		$no_of_post   = 0; // for number of posts
		$post_list    = array();// list of valid post/page ids

		$quantity     = apply_filters( 'helena_get_option', 'featured_content_number' );
		$layout_value = apply_filters( 'helena_get_option', 'featured_content_layout' );

		$output     = '<div class="featured_content_slider_wrap">';

		$layouts    = 3;

		if ( 'four-columns' == $layout_value ) {
			$layouts = 4;
		}

		$args = array(
			'post_type'           => 'any',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
		for( $i = 1; $i <= $quantity; $i++ ){
			$post_id = '';

			$post_id = apply_filters( 'helena_get_option', 'featured_content_page_' . $i );

			if ( $post_id && '' != $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}

			$args['post__in'] = $post_list;
		}

		if ( 0 == $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$get_posts = new WP_Query( $args );

		while ( $get_posts->have_posts() ) {

			$get_posts->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$current_post =  $get_posts->current_post + 1;

			$output .= '
				<article id="featured-post-' . esc_attr( $current_post ) . '" class="post hentry featured-page-content">';

				//Default value if there is no first image
				$image = '<img class="wp-post-image" src="'.get_template_directory_uri().'/images/no-featured-image-585x439.jpg" >';

				if ( has_post_thumbnail() ) {
					$image = get_the_post_thumbnail( $post->ID, 'post-thumbnail', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
				}
				else {
					//Get the first image in page, returns false if there is no image
					$first_image = helena_get_first_image( $post->ID, 'post-thumbnail', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

					//Set value of image as first image if there is an image present in the page
					if ( '' != $first_image ) {
						$image = $first_image;
					}
				}

				$output .= '
					<figure class="featured-homepage-image">
						<a href="' . esc_url( get_permalink() ) . '">
						'. $image .'
						</a>
					</figure>';

				$enable_title = apply_filters( 'helena_get_option', 'featured_content_enable_title' );
				$content_show = apply_filters( 'helena_get_option', 'featured_content_show' );

				if ( $enable_title || 'hide-content' != $content_show ) {
				$output .= '
					<div class="entry-container">';
					if ( $enable_title ) {
						$output .= '
							<header class="entry-header">
								<h2 class="entry-title">
									<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
								</h2>
							</header>';
					}

					if ( 'excerpt' == $content_show ) {
						//Show Excerpt
						$output .= '<div class="entry-excerpt"><p>' . get_the_excerpt() . '</p></div><!-- .entry-excerpt -->';
					}
					elseif ( 'full-content' == $content_show ) {
						//Show Content
						$content = apply_filters( 'the_content', get_the_content() );
						$content = str_replace( ']]>', ']]&gt;', $content );
						$output .= '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
					}
				}
				$output .= '
				</article><!-- .featured-post-'. esc_attr( $current_post ) .' -->';

				if ( 0 == ( $current_post  % $layouts ) && $current_post < $no_of_post ) {
					//end and start featured_content_slider_wrap div based on logic
					$output .= '
					</div><!-- .featured_content_slider_wrap -->

					<div class="featured_content_slider_wrap">';
				}
			} //endwhile

		wp_reset_postdata();

		$output .= '</div><!-- .featured_content_slider_wrap -->';

		return $output;
	}
endif; // helena_post_page_category_content