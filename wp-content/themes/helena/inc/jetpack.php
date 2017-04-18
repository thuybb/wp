<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Helena
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function helena_jetpack_setup() {
    // Add theme support for Responsive Videos.
    add_theme_support( 'jetpack-responsive-videos' );

    /**
     * Setup Infinite Scroll using JetPack if navigation type is set
     */
    $pagination_type    = apply_filters( 'helena_get_option', 'pagination_type' );

    if ( 'infinite-scroll-click' == $pagination_type ) {
        add_theme_support( 'infinite-scroll', array(
            'type'      => 'click',
            'container' => 'main',
            'render'    => 'helena_infinite_scroll_render',
            'footer'    => 'page'
        ) );
    }
    else if ( 'infinite-scroll-scroll' == $pagination_type ) {
        //Override infinite scroll disable scroll option
        update_option('infinite_scroll', true);

        add_theme_support( 'infinite-scroll', array(
            'type'      => 'scroll',
            'container' => 'main',
            'render'    => 'helena_infinite_scroll_render',
            'footer'    => 'page'
        ) );
    }
} // end function helena_jetpack_setup
add_action( 'after_setup_theme', 'helena_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function helena_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
		    get_template_part( 'template-parts/content', 'search' );
		else :
		    get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
} // end function helena_infinite_scroll_render