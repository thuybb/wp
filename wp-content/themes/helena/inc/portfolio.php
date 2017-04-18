<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

if ( !function_exists( 'helena_portfolio_display' ) ) :
	/**
	* Add Featured content.
	*
	* @uses action hook helena_before_content.
	*
	* @since Helena 0.1
	*/
	function helena_portfolio_display() {
		//helena_flush_transients();
		global $post, $wp_query;

		// get data value from options
		$enable_content = apply_filters( 'helena_get_option', 'portfolio_option' );
		$content_select = apply_filters( 'helena_get_option', 'portfolio_type' );

		// Front page displays in Reading Settings
		$page_on_front 	= get_option('page_on_front') ;
		$page_for_posts = get_option('page_for_posts');


		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
			if ( ( !$output = get_transient( 'helena_portfolio' ) ) ) {
				$layouts 	 = apply_filters( 'helena_get_option', 'portfolio_layout' );
				$headline 	 = apply_filters( 'helena_get_option', 'portfolio_headline' );
				$subheadline = apply_filters( 'helena_get_option', 'portfolio_subheadline' );

				echo '<!-- refreshing cache -->';

				if ( !empty( $layouts ) ) {
					$classes = $layouts ;
				}

				$classes .= ' ' . $content_select;

				if ( 'demo-portfolio' == $content_select  ) {
					$headline 		= esc_html__( 'Portfolio', 'helena' );
					$subheadline 	= esc_html__( 'Here you can showcase the x number of Portfolios.', 'helena' );
				}

				$output ='
				<section class="' . $classes . '" id="portfolio">
					<div class="wrapper">';
					if ( $headline || $subheadline ) {
						$output .='
						<div class="portfolio-heading-wrap">';
									if ( $headline ) {
										$output .='<h2 class="section-title">'.  $headline .'</h2>';
									}
									if ( $subheadline ) {
										$output .='<p>'. $subheadline .'</p>';
									}
								$output .='
						</div><!-- .portfolio-heading-wrap -->';
						}

						$output .='<div class="portfolio-content-wrap clear">';
							// Select portfolio
							if ( 'demo-portfolio' == $content_select ) {
								$output .= helena_demo_portfolio();
							}
							else {
								$output .= helena_post_page_category_portfolio();
							}

				$output .='
						</div><!-- .portfolio-content-wrap -->
					</div><!-- .wrapper -->
				</section><!-- .demo-portfolio -->';

				set_transient( 'helena_portfolio', $output, 86940 );
			}

			echo $output;
		}
	} //helena_portfolio_display
	endif;
add_action( 'helena_before_content', 'helena_portfolio_display', 40 );

if ( ! function_exists( 'helena_demo_portfolio' ) ) :
	/**
	 * This function to display featured posts content
	 *
	 * @get the data value from customizer options
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_demo_portfolio() {
		return '
		<article id="portfolio-post-1" class="post hentry post-demo">
			<figure class="portfolio-content-image featured-image">
				<a rel="bookmark" href="#">
					<img alt="White Velvet Concert" class="wp-post-image" src="'.get_template_directory_uri() . '/images/portfolio1-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<div class="vcenter">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#">White Velvet Concert</a>
						</h2>
					</header>
					<footer class="entry-footer">
						<p class="entry-meta">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Concert</a>
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
				</div><!-- .vcenter -->
			</div><!-- .entry-container -->
		</article>

		<article id="portfolio-post-2" class="post hentry post-demo">
			<figure class="portfolio-content-image featured-image">
				<a rel="bookmark" href="#">
					<img alt="Female Rockstar" class="wp-post-image" src="'.get_template_directory_uri() . '/images/portfolio2-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<div class="vcenter">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#">Female Rockstar</a>
						</h2>
					</header>
					<footer class="entry-footer">
						<p class="entry-meta">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Concert</a>
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
				</div><!-- .vcenter -->
			</div><!-- .entry-container -->
		</article>

		<article id="portfolio-post-3" class="post hentry post-demo">
			<figure class="portfolio-content-image featured-image">
				<a href="#">
					<img alt="Great Vocalist" class="wp-post-image" src="' . get_template_directory_uri() . '/images/portfolio3-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<div class="vcenter">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#">Great Vocalist</a>
						</h2>
					</header>
					<footer class="entry-footer">
						<p class="entry-meta">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Concert</a>
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
				</div><!-- .vcenter -->
			</div><!-- .entry-container -->
		</article>

		<article id="portfolio-post-4" class="post hentry post-demo">
			<figure class="portfolio-content-image featured-image">
				<a href="#">
					<img alt="Best Rock Band" class="wp-post-image" src="'.get_template_directory_uri() . '/images/portfolio4-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<div class="vcenter">
					<header class="entry-header">
						<h2 class="entry-title">
							<a title="Best Beaches" href="#">Best Rock Band</a>
						</h2>
					</header>
					<footer class="entry-footer">
						<p class="entry-meta">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Concert</a>
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
				</div><!-- .vcenter -->
			</div><!-- .entry-container -->
		</article>

		<article id="portfolio-post-5" class="post hentry post-demo">
			<figure class="portfolio-content-image featured-image">
				<a rel="bookmark" href="#">
					<img alt="White Velvet Concert" class="wp-post-image" src="'.get_template_directory_uri() . '/images/portfolio5-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<div class="vcenter">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#">White Velvet Concert</a>
						</h2>
					</header>
					<footer class="entry-footer">
						<p class="entry-meta">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Concert</a>
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
				</div><!-- .vcenter -->
			</div><!-- .entry-container -->
		</article>

		<article id="portfolio-post-6" class="post hentry post-demo">
			<figure class="portfolio-content-image featured-image">
				<a rel="bookmark" href="#">
					<img alt="Female Rockstar" class="wp-post-image" src="'.get_template_directory_uri() . '/images/portfolio6-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<div class="vcenter">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#">Female Rockstar</a>
						</h2>
					</header>
					<footer class="entry-footer">
						<p class="entry-meta">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Concert</a>
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
				</div><!-- .vcenter -->
			</div><!-- .entry-container -->
		</article>

		<article id="portfolio-post-7" class="post hentry post-demo">
			<figure class="portfolio-content-image featured-image">
				<a href="#">
					<img alt="Great Vocalist" class="wp-post-image" src="'.get_template_directory_uri() . '/images/portfolio7-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<div class="vcenter">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#">Great Vocalist</a>
						</h2>
					</header>
					<footer class="entry-footer">
						<p class="entry-meta">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Concert</a>
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
				</div><!-- .vcenter -->
			</div><!-- .entry-container -->
		</article>

		<article id="portfolio-post-8" class="post hentry post-demo">
			<figure class="portfolio-content-image featured-image">
				<a href="#">
					<img alt="Best Rock Band" class="wp-post-image" src="'.get_template_directory_uri() . '/images/portfolio8-585x439.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<div class="vcenter">
					<header class="entry-header">
						<h2 class="entry-title">
							<a title="Best Beaches" href="#">Best Rock Band</a>
						</h2>
					</header>
					<footer class="entry-footer">
						<p class="entry-meta">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Concert</a>
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
				</div><!-- .vcenter -->
			</div><!-- .entry-container -->
		</article>';
	}
endif; // helena_demo_portfolio

if ( ! function_exists( 'helena_post_page_category_portfolio' ) ) :
	/**
	 * This function to display featured posts content
	 *
	 * @param $options: helena_theme_options from customizer
	 *
	 * @since Helena 0.1
	 */
	function helena_post_page_category_portfolio() {
		$no_of_post = 0; // for number of posts
		$post_list  = array();// list of valid post/page ids
		$layouts    = 3;
		$quantity   = apply_filters( 'helena_get_option', 'portfolio_number' );
		$type       = apply_filters( 'helena_get_option', 'portfolio_type' );
		$more_text  = apply_filters( 'helena_get_option', 'excerpt_more_text' );

		$output     = '<div class="portfolio_slider_wrap">';
		$args = array(
			'post_type'           => 'any',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
		if ( 'post-portfolio' == $type || 'page-portfolio' == $type  ) {
			for( $i = 1; $i <= $quantity; $i++ ){
				if ( 'post-portfolio' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'portfolio_post_' . $i );
				}
				elseif ( 'page-portfolio' == $type ) {
					$post_id = apply_filters( 'helena_get_option', 'portfolio_page_' . $i );
				}

				if ( $post_id && '' != $post_id ) {
					$post_list = array_merge( $post_list, array( $post_id ) );

					$no_of_post++;
				}
			}

			$args['post__in'] = $post_list;
		}
		elseif ( 'category-portfolio' == $type ) {
			$no_of_post = $quantity;

			$args['category__in'] = apply_filters( 'helena_get_option', 'portfolio_select_category' );
		}

		$args['posts_per_page'] = $no_of_post;

		if ( 0 == $no_of_post ) {
			return;
		}

		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) {
			$loop->the_post();
			
			$title_attribute = the_title_attribute( 'echo=0' );

			$output .= '
				<article id="portfolio-post-' . esc_attr( get_the_ID() ) . '" class="post hentry">';

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
					<figure class="portfolio-content-image featured-image">
						<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
						'. $image .'
						</a>
					</figure>';

				$enable_title   = apply_filters( 'helena_get_option', 'portfolio_enable_title' );
				$portfolio_show = apply_filters( 'helena_get_option', 'portfolio_show' );

				if ( $enable_title || 'hide-content' != $portfolio_show ) {
				$output .= '
					<div class="entry-container">
						<div class="vcenter">';
							if ( $enable_title ) {
								$output .= '
									<header class="entry-header">
										<h2 class="entry-title">
											<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
										</h2>
									</header>';
							}

							$footer_class  = '';
							$hide_category = apply_filters( 'helena_get_option', 'portfolio_hide_category' );
							$hide_tags     = apply_filters( 'helena_get_option', 'portfolio_hide_tags' );
							$hide_date     = apply_filters( 'helena_get_option', 'portfolio_hide_date' );
							$hide_author   = apply_filters( 'helena_get_option', 'portfolio_hide_author' );

							if ( $hide_category && $hide_tags && $hide_date && $hide_author ) {
								$footer_class = 'screen-reader-text';
							}

							$output .= '
							<footer class="entry-footer ' . $footer_class . '">
								' . helena_get_meta( $hide_category, $hide_tags, $hide_date, $hide_author ) . '
							</footer><!-- .entry-footer -->
						</div><!-- .vcenter -->
					</div><!-- .entry-container -->';
				}
				$output .= '
				</article><!-- .post-' . esc_attr( get_the_ID() ) . ' -->';
			} //endwhile

		wp_reset_postdata();

		return $output;
	}
endif; // helena_post_page_category_portfolio