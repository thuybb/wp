<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */



if ( !function_exists( 'helena_promotion_headline_display' ) ) :
	/**
	* Add Featured content.
	*
	* @uses action hook helena_before_content
	*
	* @since Helena 0.1
	*/
	function helena_promotion_headline_display() {
		//helena_flush_transients();
		global $wp_query;

		$enable_content = apply_filters( 'helena_get_option', 'promotion_headline_option' );
		$content_select = apply_filters( 'helena_get_option', 'promotion_headline_type' );

		// Front page displays in Reading Settings
		$page_on_front 	= get_option('page_on_front') ;
		$page_for_posts = get_option('page_for_posts');


		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
			if ( ( !$output = get_transient( 'helena_promotion_headline' ) ) ) {
				echo '<!-- refreshing cache -->';

				$classes[] = $content_select ;

				$output ='
					<section id="promotion-message" class="' . implode( ' ', $classes ) . '">
						<div class="wrapper">';
							// Select content
							if ( 'demo' == $content_select ) {
								$output .= helena_demo_promotion_headline();
							}
							else {
								$output .= helena_post_page_category_promotion_headline();
							}

					$output .='
						</div><!-- .wrapper -->
					</section><!-- #promotion-message -->';

				set_transient( 'helena_promotion_headline', $output, 86940 );
			}
		echo $output;
		}
	}
endif;
add_action( 'helena_before_content', 'helena_promotion_headline_display', 60 );


if ( ! function_exists( 'helena_demo_promotion_headline' ) ) :
	/**
	 * This function to display hero posts content
	 *
	 * @get the data value from customizer options
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_demo_promotion_headline() {
		return '
		<div class="section left">
			<h2 class="section-title">'
			. esc_html__( 'Helena WordPress Theme', 'helena' ) .
			'</h2>

			<p>' . esc_html__( 'This is promotion headline', 'helena' ) . '</p>
		</div><!-- .section.left -->

		<div class="section right">
			<span class="more-button button-one"><a class="more-link" href="#" target="_blank">' . esc_html__( 'Buy Now', 'helena' ) . '</a></span>
		</div><!-- .section.right -->';
	}
endif; // helena_demo_promotion_headline


if ( ! function_exists( 'helena_post_page_category_promotion_headline' ) ) :
	/**
	 * This function to display hero posts content
	 *
	 * @since Helena 0.1
	 */
	function helena_post_page_category_promotion_headline() {
		$type      = apply_filters( 'helena_get_option', 'promotion_headline_type' );
		$more_text = apply_filters( 'helena_get_option', 'excerpt_more_text' );
		$output    = '';

		$args = array(
			'post_type'           => 'any',
			'posts_per_page'      => 1,
			'ignore_sticky_posts' => 1
		);

		if ( 'post' == $type ) {
			$args['p'] = absint( apply_filters( 'helena_get_option', 'promotion_headline_post' ) );
		}
		elseif ( 'page' == $type ) {
			$args['p'] = absint( apply_filters( 'helena_get_option', 'promotion_headline_page' ) );
		}
		elseif ( 'category' == $type ) {
			$args['cat'] = absint( apply_filters( 'helena_get_option', 'promotion_headline_category' ) );
		}

		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) {
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$content_show = apply_filters( 'helena_get_option', 'promotion_headline_show' );
			$content      ='';
			if ( 'excerpt' == $content_show ) {
				$content = get_the_excerpt();
			}
			elseif ( 'full-content' == $content_show ) {
				$content = apply_filters( 'the_content', get_the_content() );
				$content = str_replace( ']]>', ']]&gt;', $content );
			}

			if ( '' != $content ) {
				$content = '<p>' . $content . '</p>';
			}

			$output .= '
				<div class="section left" class="' . esc_attr( get_the_ID() ) . '">'
					. the_title( '<h2 class="section-title">','</h2>', false ) . $content . '
				</div><!-- .section.left -->

				<div class="section right">
					<span class="more-button"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . esc_html( $more_text ) . '</a></span>
				</div><!-- .section.right -->';
		} //endwhile

		wp_reset_postdata();

		return $output;
	}
endif; // helena_post_page_category_promotion_headline