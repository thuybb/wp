<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */



if ( !function_exists( 'helena_hero_content_display' ) ) :
	/**
	* Add Featured content.
	*
	* @uses action hook helena_before_content.
	*
	* @since Helena 0.1
	*/
	function helena_hero_content_display() {
		//helena_flush_transients();
		global $wp_query;

		$enable_content = apply_filters( 'helena_get_option', 'hero_content_option' );
		$content_select = apply_filters( 'helena_get_option', 'hero_content_type' );

		// Front page displays in Reading Settings
		$page_for_posts = get_option('page_for_posts');


		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
			if ( ( !$output = get_transient( 'helena_hero_content' ) ) ) {
				echo '<!-- refreshing cache -->';

				$classes[] = $content_select ;

				$output ='
					<section id="hero-section" class="' . implode( ' ', $classes ) . '">
						<div class="wrapper">';
							// Select content
							if ( 'demo-hero-content' == $content_select ) {
								$output .= helena_demo_hero_content();
							}
							else {
								$output .= helena_post_page_category_hero_content();
							}


					$output .='
						</div><!-- .wrapper -->
					</section><!-- #hero-section -->';

				set_transient( 'helena_hero_content', $output, 86940 );
			}
		echo $output;
		}
	}
endif;
add_action( 'helena_before_content', 'helena_hero_content_display', 20 );


if ( ! function_exists( 'helena_demo_hero_content' ) ) :
	/**
	 * This function to display hero posts content
	 *
	 * @get the data value from customizer options
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_demo_hero_content() {
		return '
		<article class="post-11 page type-page status-publish has-post-thumbnail hentry" id="post-11">
			<figure class="featured-image">
		    	<a href="#" rel="bookmark">
		        	<img width="600" height="400" alt="" class="wp-post-image" src="'.get_template_directory_uri() . '/images/hero-585x439.jpg">
		        </a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title"><a href="#" rel="bookmark">Helena</a></h2>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p>Helena is a clean, responsive and incredibly resourceful Business WordPress theme that can adapt to any corporate and blog niche and provide users with an accessible interface. If your goal is to build a successful corporate/blog website that is natively responsive, then look no further than Helena.</p>
					<p>This clean and minimalistic business and blog WordPress theme is deeply customizable with options through theme customizer. Any user can tailor his/her experience, and create a website that stays true to his/her vision. The responsive and cross-browser compatibility design of Helena allows your website to adapt to any device and web browser.</p>
				</div><!-- .entry-content -->
			</div><!-- .entry-container -->
		</article>';
	}
endif; // helena_demo_hero_content


if ( ! function_exists( 'helena_post_page_category_hero_content' ) ) :
	/**
	 * This function to display hero posts content
	 *
	 * @since Helena 0.1
	 */
	function helena_post_page_category_hero_content() {
		$quantity   = apply_filters( 'helena_get_option', 'hero_content_number' );
		$no_of_post = 0; // for number of posts
		$post_list  = array();// list of valid post/page ids
		$type       = apply_filters( 'helena_get_option', 'hero_content_type' );
		$output     = '';

		$args = array(
			'post_type'           => 'any',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
		if ( 'hero-post-content' == $type || 'hero-page-content' == $type ) {
			for( $i = 1; $i <= $quantity; $i++ ){
				$post_id = '';

				if ( 'hero-post-content' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'hero_content_post_' . $i );
				}
				elseif ( 'hero-page-content' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'hero_content_page_' . $i );
				}

				if ( $post_id && '' != $post_id ) {
					$post_list = array_merge( $post_list, array( $post_id ) );

					$no_of_post++;
				}
			}

			$args['post__in'] = $post_list;
		}
		elseif ( 'hero-category-content' == $type ) {
			$no_of_post           = $quantity;
			$args['category__in'] = apply_filters( 'helena_get_option', 'hero_content_select_category' );
		}

		if ( 0 == $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$get_hero_posts         = new WP_Query( $args );

		$i=0;
		while ( $get_hero_posts->have_posts() ) {
			$get_hero_posts->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$output .= '
			<article id="post-' . esc_attr( get_the_ID() ) . '" class="post-' . esc_attr( get_the_ID() ) . ' hentry has-post-thumbnail">';

			//Default value if there is no first image
			$image = '<img class="wp-post-image" src="'.get_template_directory_uri().'/images/no-featured-image-585x439.jpg" >';

			if ( has_post_thumbnail() ) {
				$image = get_the_post_thumbnail( get_the_ID(), 'post-thumbnail', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
			}
			else {
				//Get the first image in page, returns false if there is no image
				$first_image = helena_get_first_image( get_the_ID(), 'post-thumbnail', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

				//Set value of image as first image if there is an image present in the page
				if ( '' != $first_image ) {
					$image = $first_image;
				}
			}

			$output .= '
				<figure class="featured-image">
					<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
					'. $image .'
					</a>
				</figure>';

			$enable_title = apply_filters( 'helena_get_option', 'hero_content_enable_title' );
			$content_show = apply_filters( 'helena_get_option', 'hero_content_show' );

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
					$output .= '
					<div class="entry-content">
						<p>' . get_the_excerpt() . '</p>
					</div><!-- .entry-content -->';
				}
				elseif ( 'full-content' == $content_show ) {
					//Show Content
					$content = apply_filters( 'the_content', get_the_content() );
					$content = str_replace( ']]>', ']]&gt;', $content );
					$output .= '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
				}
			}
			$output .= '
				</div><!-- .entry-container -->
			</article><!-- .post-' . esc_attr( get_the_ID() ) . ' -->';
		} //endwhile

		wp_reset_postdata();

		return $output;
	}
endif; // helena_post_page_category_hero_content