<?php
/**
 * Implement Custom Header functionality
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */


if ( ! function_exists( 'helena_custom_header' ) ) :
/**
 * Implementation of the Custom Header feature
 * Setup the WordPress core custom header feature and default custom headers packaged with the theme.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
	function helena_custom_header() {
		$color_scheme = apply_filters( 'helena_get_option', 'color_scheme' );

		if ( 'light' == $color_scheme ) {
			$default_header_color = helena_get_default_theme_options();
			$default_header_color = $default_header_color['header_textcolor'];
		}
		elseif ( 'dark' == $color_scheme ) {
			$default_header_color = helena_default_dark_color_options();
			$default_header_color = $default_header_color['header_textcolor'];
		}

		$args = array(
		// Text color and image (empty to use none).
		'default-text-color'     => $default_header_color,

		// Header image default
		'default-image'			=> get_template_directory_uri() . '/images/header-bg.jpg',

		// Set height and width, with a maximum value for the width.
		'height'                 => 658,
		'width'                  => 1170,

		// Support flexible height and width.
		'flex-height'            => true,
		'flex-width'             => true,

		// Random image rotation off by default.
		'random-default'         => false,
	);

	$args = apply_filters( 'custom-header', $args );

	// Add support for custom header
	add_theme_support( 'custom-header', $args );

	}
endif; // helena_custom_header
add_action( 'after_setup_theme', 'helena_custom_header' );


if ( ! function_exists( 'helena_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own helena_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since Helena 0.1
	 */
	function helena_featured_page_post_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		$page_for_posts = get_option('page_for_posts');

		$header_page_id = '';

		$image = get_header_image();

		if ( get_post() ) {
			if ( is_home() && $page_for_posts == $page_id ) {
				$header_page_id = $page_id;
			}
			else {
				$header_page_id = $post->ID;
			}
		}

		if ( has_post_thumbnail( $header_page_id ) ) {
			$featured_image_size = apply_filters( 'helena_get_option', 'featured_image_size' );
			$feat_image          = wp_get_attachment_image_src( get_post_thumbnail_id( $header_page_id ), $featured_image_size );

			$image = $feat_image[0];
		}

		return $image;
	} // helena_featured_page_post_image
endif;


if ( ! function_exists( 'helena_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own helena_featured_image(), and that function will be used instead.
	 *
	 * @since Helena 0.1
	 */
	function helena_featured_image() {
		global $post, $wp_query;
		$defaults            = helena_get_default_theme_options();
		$enable_header_image = apply_filters( 'helena_get_option', 'enable_header_image' );
		$header_image        = get_header_image();
		$singlular_image     = helena_featured_page_post_image();
		$image               = false;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		$page_for_posts = get_option('page_for_posts');

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'helena_-header-image', true );

			if ( 'disable' == $individual_featured_image || ( 'default' == $individual_featured_image && 'disable' == $enable_header_image ) ) {
				echo '<!-- Page/Post Disable Header Image -->';
				return false;
			}
			elseif ( 'enable' == $individual_featured_image ) {
				$image = helena_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' == $enable_header_image  ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				$image = $header_image;
			}
		}
		// Check Excluding Homepage
		elseif ( 'exclude-home' == $enable_header_image  ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			else {
				$image = $header_image;
			}
		}
		elseif ( 'exclude-home-page-post' == $enable_header_image  ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			elseif ( is_page() || is_single() ) {
				$image = helena_featured_page_post_image();
			}
			else {
				$image = $header_image;
			}
		}
		// Check Entire Site
		elseif ( 'entire-site' == $enable_header_image  ) {
			$image = $header_image;
		}
		// Check Entire Site (Post/Page)
		elseif ( 'entire-site-page-post' == $enable_header_image  ) {
			if ( is_page() || is_single() ) {
				$image = helena_featured_page_post_image();
			}
			else {
				$image = $header_image;
			}
		}
		// Check Page/Post
		elseif ( 'pages-posts' == $enable_header_image  ) {
			if ( is_page() || is_single() ) {
				$image = helena_featured_page_post_image();
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}

		return $image;
	} // helena_featured_image
endif;

if ( ! function_exists( 'helena_header_featured_image' ) ) :
	/**
	 * Display Header Featured Image
	 *
	 * @since Helena 0.1
	 */
	function helena_header_featured_image() {
		//Check if header image is active or not
		$header_image = helena_featured_image();

		if ( $header_image ) {
			global $post;
			$title               = apply_filters( 'helena_get_option', 'featured_header_title' );
			$content             = apply_filters( 'helena_get_option', 'featured_header_content' );
			$button_text         = apply_filters( 'helena_get_option', 'featured_header_button_text' );
			$button_link         = apply_filters( 'helena_get_option', 'featured_header_button_link' );
			$button_target       = apply_filters( 'helena_get_option', 'featured_header_button_target' );
			$enable_header_image = apply_filters( 'helena_get_option', 'enable_header_image' );

			if ( is_page() || is_single() ) {
				//Individual Page/Post Image Setting
				$individual_featured_image = get_post_meta( $post->ID, 'helena-header-image', true );

				if ( 'disable' == $individual_featured_image || ( 'default' == $individual_featured_image && 'disable' == $enable_header_image ) ) {
					echo '<!-- Page/Post Disable Header Image -->';
					return false;
				}
			}

			$button_target_value = '_self';

			if ( $button_target ) {
				$button_target_value = '_blank';
			}

			if ( get_template_directory_uri() . '/images/header-bg.jpg' == $header_image ) {
				$classes[] = 'default';
			}

			$header = '<img src="' . esc_url( $header_image ) . '" class="wp-post-image" alt="' . esc_attr( $title ) . '">';
			if ( '' != $button_link ) {
				$header = '<a href="' . esc_url( $button_link ) . '" target="' . esc_attr( $button_target_value ) . '">' . $header . '</a>';
			}

			echo '
			<section id="header-featured-image">
				<div class="wrapper">
					<article class="hentry header-image">
						<figure class="featured-image">
							' . $header . '
						</figure>';
						if ( '' != $title || '' != $content || '' != $button_text ) {
							echo '
							<div class="entry-container">';
								if ( '' != $title ) {
									if ( '' != $button_link ) {
										$title = '<a href="' . esc_url( $button_link ) . '" target="' . esc_attr( $button_target_value ) . '">' . $title . '</a>';
									}
									echo '
									<header class="entry-header">
										<h1 class="entry-title">
											' . esc_attr( $title ) . '
										</h1>
									</header>';
								}

								if ( '' != $content || '' != $button_text ) {
									echo '
									<div class="entry-content"><p>
										' . $content;

									if ( '' != $button_text ) {
										echo '
										<span class="more-button"><a class="more-link" href="' . esc_url( $button_link ) . '" target="' . esc_attr( $button_target_value ) . '">'. esc_html( $button_text ) .'</a></span>';
									}
									echo '</p></div>';
								}
							echo '</div><!-- .entry-container -->';
						}
						echo '
					</article><!-- .hentry.header-image -->
				</div><!-- .wrapper -->
			</section><!-- #header-featured-image -->';
		}
	} // helena_header_featured_image
endif;
add_action( 'helena_after_header', 'helena_header_featured_image', 10 );