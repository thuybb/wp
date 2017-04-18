<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */


if ( !function_exists( 'helena_header_highlight_content_display' ) ) :
	/**
	* Add Featured content.
	*
	* @uses action hook helena_before_content.
	*
	* @since Helena 0.1
	*/
	function helena_header_highlight_content_display() {
		//helena_flush_transients();
		global $post, $wp_query;

		// get data value from options
		$enable_content = apply_filters( 'helena_get_option', 'header_highlight_content_option' );
		$content_select = apply_filters( 'helena_get_option', 'header_highlight_content_type' );

		// Front page displays in Reading Settings
		$page_on_front 	= get_option('page_on_front') ;
		$page_for_posts = get_option('page_for_posts');


		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
			if ( !$output = get_transient( 'helena_header_highlight_content' ) ) {

				echo '<!-- refreshing cache -->';
				$classes[]      = $content_select;

				$content_number = apply_filters( 'helena_get_option', 'header_highlight_content_number' );
				$headline       = apply_filters( 'helena_get_option', 'header_highlight_content_headline' );
				$subheadline    = apply_filters( 'helena_get_option', 'header_highlight_content_subheadline' );

				$classes[]      = ' content-number-' . $content_number;

				$output ='
					<section id="header-highlights-content" class="' . esc_attr( implode( ' ', $classes ) ) . '">
						<div class="wrapper">';
							if ( $headline || $subheadline ) {
								$output .='
								<div class="header-highlight-heading-wrap">';
									if ( $headline ) {
										$output .='
										<h2 id="header-highlight-heading" class="section-title">'. $headline .'</h2>';
									}
									if ( $subheadline ) {
										$output .='
										<p>'. $subheadline .'</p>';
									}
								$output .='
								</div><!-- .header-highlight-heading-wrap -->';
							}

							$output .='
							<div class="header-highlight-content-wrap">';
								// Select content
								if ( 'demo-header-highlight-content' == $content_select ) {
									$output .= helena_demo_header_highlight_content();
								}
								else {
									$output .= helena_header_highlight_post_page_category_content();
								}

				$output .='
							</div><!-- .header-highlight-content-wrap -->
						</div><!-- .wrapper -->
					</section><!-- #header-highlight-content -->';
				set_transient( 'helena_header_highlight_content', $output, 86940 );

			}
			echo $output;
		}
	}
	endif;
add_action( 'helena_before_content', 'helena_header_highlight_content_display', 30 );


if ( ! function_exists( 'helena_demo_header_highlight_content' ) ) :
	/**
	 * This function to display header highlight posts content
	 *
	 * @get the data value from customizer options
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_demo_header_highlight_content() {
		return '
		<article id="header-highlight-post-1" class="post hentry post-demo large-featured-image">
			<figure class="header-highlight-content-image">
				<a rel="bookmark" href="#">
					<img alt="Photography" class="wp-post-image" src="'.get_template_directory_uri() . '/images/highlight1-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#">Photography</a>
					</h2>
				</header>
				<footer class="entry-footer">
					<p class="entry-meta">
						<span class="cat-links">
							<span class="screen-reader-text">Categories</span>
							<a rel="category tag" href="#">Music</a>
						</span>
						<span class="posted-on">
							<span class="screen-reader-text">Posted on</span>

							<a rel="bookmark" href="#">
								<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>

								<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
							</a>
						</span>
					</p><!-- .entry-meta -->
				</footer>
			</div><!-- .entry-container -->
		</article>

		<article id="header-highlight-post-2" class="post hentry post-demo small-featured-image">
			<figure class="header-highlight-content-image">
				<a rel="bookmark" href="#">
					<img alt="Routes Built for Riders" class="wp-post-image" src="'.get_template_directory_uri() . '/images/highlight2-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#">Routes Built for Riders</a>
					</h2>
				</header>
				<footer class="entry-footer">
					<p class="entry-meta">
						<span class="cat-links">
							<span class="screen-reader-text">Categories</span>
							<a rel="category tag" href="#">Sports</a>
						</span>
						<span class="posted-on">
							<span class="screen-reader-text">Posted on</span>

							<a rel="bookmark" href="#">
								<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>

								<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
							</a>
						</span>
					</p><!-- .entry-meta -->
				</footer>
			</div><!-- .entry-container -->
		</article>

		<article id="header-highlight-post-3" class="post hentry post-demo small-featured-image">
			<figure class="header-highlight-content-image">
				<a rel="bookmark" href="#">
					<img alt="Cradle Mountain Canyons" class="wp-post-image" src="'.get_template_directory_uri() . '/images/highlight3-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#">Cradle Mountain Canyons</a>
					</h2>
				</header>
				<footer class="entry-footer">
					<p class="entry-meta">
						<span class="cat-links">
							<span class="screen-reader-text">Categories</span>
							<a rel="category tag" href="#">Sports</a>
						</span>
						<span class="posted-on">
							<span class="screen-reader-text">Posted on</span>
							<a rel="bookmark" href="#">
								<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>
								<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
							</a>
						</span>
					</p><!-- .entry-meta -->
				</footer>
			</div><!-- .entry-container -->
		</article>';
	}
endif; // helena_demo_content


if ( ! function_exists( 'helena_header_highlight_post_page_category_content' ) ) :
	/**
	 * This function to display header highlight posts content
	 *
	 * @since Helena 0.1
	 */
	function helena_header_highlight_post_page_category_content() {
		$quantity     = apply_filters( 'helena_get_option', 'header_highlight_content_number' );
		$no_of_post   = 0; // for number of posts
		$post_list    = array();// list of valid post/page ids
		$type         = apply_filters( 'helena_get_option', 'header_highlight_content_type' );
		$more_text    = apply_filters( 'helena_get_option', 'excerpt_more_text' );
		$show_content = apply_filters( 'helena_get_option', 'header_highlight_content_show' );
		$output       = '';

		$args = array(
			'post_type'           => 'any',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
		if ( 'header-highlight-post-content' == $type || 'header-highlight-page-content' == $type  ) {
			for( $i = 1; $i <= $quantity; $i++ ){
				$post_id = '';

				if ( 'header-highlight-post-content' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'header_highlight_content_post_' . $i );
				}
				elseif ( 'header-highlight-page-content' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'header_highlight_content_page_' . $i );
				}

				if ( $post_id && '' != $post_id ) {
					$post_list = array_merge( $post_list, array( $post_id ) );
					$no_of_post++;
				}
			}

			$args['post__in'] = $post_list;
		}
		elseif ( 'header-highlight-category-content' == $type ) {
			$no_of_post = $quantity;

			$args['category__in'] = apply_filters( 'helena_get_option', 'header_highlight_content_select_category' );
		}

		if ( 0 == $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) {
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$excerpt = get_the_excerpt();

			//Set image name to post-thumbnail 585x439
			$image_size 	= 'post-thumbnail';

			if ( 0 == $loop->current_post ) {
				$article_class	= 'large-featured-image';
			}
			else {
				$article_class	= 'small-featured-image';
			}

			$output .= '
			<article id="header-highlight-post-' . esc_attr( get_the_ID() ) . '" class="post hentry header-highlight-post-content ' . $article_class . '">';
			if ( has_post_thumbnail() ) {
				//Pull post thunbnail if it is present
				$thumbnail = get_the_post_thumbnail(
					get_the_ID(),
					$image_size,
					array(
						'title' => $title_attribute,
						'alt' => $title_attribute
					)
				);
			}
			else {
				$first_image = helena_get_first_image(
					get_the_ID(),
					$image_size,
					array(
						'title' => $title_attribute,
						'alt' => $title_attribute
						)
					);

				if ( '' != $first_image ) {
					$thumbnail = $first_image;
				}
				else {
					$thumbnail = '<img class="wp-post-image" src="'.get_template_directory_uri().'/images/no-featured-image-585x439.jpg" >';
				}
			}

			$output .= '
				<figure class="header-highlight-content-image">
					<a href="' . esc_url( get_permalink() ) . '">
					'. $thumbnail .'
					</a>
				</figure>';

			$output .= '
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
						</h2>
					</header>';

					if ( 'excerpt' == $show_content ) {
						$output .= '<div class="entry-summary"><p>' . $excerpt . '</p></div><!-- .entry-summary -->';
					}
					elseif ( 'full-content' == $show_content ) {
						$content = apply_filters( 'the_content', get_the_content() );
						$content = str_replace( ']]>', ']]&gt;', $content );
						$output .= '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
					}

					$footer_class  = '';
					$hide_category = apply_filters( 'helena_get_option', 'header_highlight_content_hide_category' );
					$hide_tags     = apply_filters( 'helena_get_option', 'header_highlight_content_hide_tags' );
					$hide_date     = apply_filters( 'helena_get_option', 'header_highlight_content_hide_date' );
					$hide_author   = apply_filters( 'helena_get_option', 'header_highlight_content_hide_author' );

					if ( $hide_category && $hide_tags && $hide_date && $hide_author ) {
						$footer_class = 'screen-reader-text';
					}

					$output .= '
					<footer class="entry-footer ' . $footer_class . '">
						' . helena_get_meta( $hide_category, $hide_tags, $hide_date, $hide_author ) . '
					</footer><!-- .entry-footer -->';

				$output .= '
				</div><!-- .entry-container -->
			</article><!-- .header-highlight-post-' . esc_attr( get_the_ID() ) . ' -->';
		}

		wp_reset_postdata();

		return $output;
	}
endif; // $output