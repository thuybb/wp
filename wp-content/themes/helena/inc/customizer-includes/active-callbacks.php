<?php
/**
 * Active callbacks for Theme/Customzer Options
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

/**
 * Active Callback function for site description
 */
function helena_blog_description_active_callback( $control ){
	return !( $control->manager->get_setting( 'disable_tagline_header' )->value() && $control->manager->get_setting( 'disable_tagline_footer' )->value() ) ;
}


if ( ! function_exists( 'helena_is_header_highlight_content_active' ) ) :
	/**
	* Return true if header highlight content is active
	*
	* @since Helena 0.1
	*/
	function helena_is_header_highlight_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'header_highlight_content_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) );
	}
endif;


if ( ! function_exists( 'helena_is_demo_header_highlight_content_inactive' ) ) :
	/**
	* Return true if demo header highlight content is inactive
	*
	* @since Helena 0.1
	*/
	function helena_is_demo_header_highlight_content_inactive( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'header_highlight_content_option' )->value();

		$type = $control->manager->get_setting( 'header_highlight_content_type' )->value();

		//return true only if previwed page on customizer matches the type of content option selected and is not demo content
		return ( ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) ) && !( 'demo-header-highlight-content' == $type ) );
	}
endif;

if ( ! function_exists( 'helena_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since Helena 0.1
	*/
	function helena_is_slider_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'featured_slider_option' )->value();

		//return true only if previwed page on customizer matches the type of slider option selected
		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) );
	}
endif;


if ( ! function_exists( 'helena_is_demo_slider_inactive' ) ) :
	/**
	* Return true if demo slider is inactive
	*
	* @since Helena 0.1
	*/
	function helena_is_demo_slider_inactive( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable	= $control->manager->get_setting( 'featured_slider_option' )->value();

		$type 	= $control->manager->get_setting( 'featured_slider_type' )->value();

		//return true only if previwed page on customizer matches the type of slider option selected and is not demo slider
		return ( ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) ) && !( 'demo-featured-slider' == $type ) );
	}
endif;

if ( ! function_exists( 'helena_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since Helena 0.1
	*/
	function helena_is_hero_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'hero_content_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) );
	}
endif;


if ( ! function_exists( 'helena_is_demo_hero_content_inactive' ) ) :
	/**
	* Return true if demo hero content is inactive
	*
	* @since Helena 0.1
	*/
	function helena_is_demo_hero_content_inactive( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'hero_content_option' )->value();

		$type 	= $control->manager->get_setting( 'hero_content_type' )->value();

		//return true only if previwed page on customizer matches the type of content option selected and is not demo content
		return ( ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) ) && !( 'demo-hero-content' == $type ) );
	}
endif;


if ( ! function_exists( 'helena_is_hero_post_content_active' ) ) :
	/**
	* Return true if post content is active
	*
	* @since Helena 0.1
	*/
	function helena_is_hero_post_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'hero_content_option' )->value();

		$type 	= $control->manager->get_setting( 'hero_content_type' )->value();

		//return true only if previwed page on customizer matches the type of content option selected and page content
		return ( ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) ) && ( 'hero-post-content' == $type ) );
	}
endif;


if ( ! function_exists( 'helena_is_hero_page_content_active' ) ) :
	/**
	* Return true if hero page content is active
	*
	* @since Helena 0.1
	*/
	function helena_is_hero_page_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'hero_content_option' )->value();

		$type 	= $control->manager->get_setting( 'hero_content_type' )->value();

		//return true only if previwed page on customizer matches the type of content option selected and page content
		return ( ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) ) && ( 'hero-page-content' == $type ) );
	}
endif;


if ( ! function_exists( 'helena_is_hero_category_content_active' ) ) :
	/**
	* Return true if hero category content is active
	*
	* @since Helena 0.1
	*/
	function helena_is_hero_category_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'hero_content_option' )->value();

		$type 	= $control->manager->get_setting( 'hero_content_type' )->value();

		//return true only if previwed page on customizer matches the type of content option selected and page content
		return ( ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) ) && ( 'hero-category-content' == $type ) );
	}
endif;

if ( ! function_exists( 'helena_is_featured_content_active' ) ) :
	/**
	* Return true if featured content is active
	*
	* @since Helena 0.1
	*/
	function helena_is_featured_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'featured_content_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) );
	}
endif;


if ( ! function_exists( 'helena_is_demo_featured_content_inactive' ) ) :
	/**
	* Return true if demo featured content is inactive
	*
	* @since Helena 0.1
	*/
	function helena_is_demo_featured_content_inactive( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'featured_content_option' )->value();

		$type 	= $control->manager->get_setting( 'featured_content_type' )->value();

		//return true only if previwed page on customizer matches the type of content option selected and is not demo content
		return ( ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) ) && !( 'demo-featured-content' == $type ) );
	}
endif;

if ( ! function_exists( 'helena_is_portfolio_active' ) ) :
	/**
	* Return true if portfolio is active
	*
	* @since Helena 0.1
	*/
	function helena_is_portfolio_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'portfolio_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) );
	}
endif;


if ( ! function_exists( 'helena_is_demo_portfolio_inactive' ) ) :
	/**
	* Return true if demo header highlight content is inactive
	*
	* @since Helena 0.1
	*/
	function helena_is_demo_portfolio_inactive( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable 	= $control->manager->get_setting( 'portfolio_option' )->value();

		$type 	= $control->manager->get_setting( 'portfolio_type' )->value();

		//return true only if previwed page on customizer matches the type of content option selected and is not demo content
		return ( ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) ) && !( 'demo-portfolio' == $type ) );
	}
endif;


if ( ! function_exists( 'helena_is_logo_slider_active' ) ) :
	/**
	* Return true if logo_slider is active
	*
	* @since Helena 0.1
	*/
	function helena_is_logo_slider_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'logo_slider_option' )->value();

		//return true only if previwed page on customizer matches the type of logo_slider option selected
		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) );
	}
endif;


if ( ! function_exists( 'helena_is_demo_logo_slider_inactive' ) ) :
	/**
	* Return true if demo logo_slider is inactive
	*
	* @since Helena 0.1
	*/
	function helena_is_demo_logo_slider_inactive( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable	= $control->manager->get_setting( 'logo_slider_option' )->value();

		$type 	= $control->manager->get_setting( 'logo_slider_type' )->value();

		//return true only if previwed page on customizer matches the type of logo_slider option selected and is not demo logo_slider
		return ( ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) ) && !( 'demo' == $type ) );
	}
endif;

if ( ! function_exists( 'helena_is_promotion_headline_active' ) ) :
	/**
	* Return true if featured content is active
	*
	* @since Helena 0.1
	*/
	function helena_is_promotion_headline_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'promotion_headline_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable  ) );
	}
endif;

if ( ! function_exists( 'helena_is_demo_promotion_headline_inactive' ) ) :
	/**
	* Return true if demo promotion headline is inactive
	*
	* @since Helena 0.1
	*/
	function helena_is_demo_promotion_headline_inactive( $control ) {
		$type 	= $control->manager->get_setting( 'promotion_headline_type' )->value();

		//return true only if previwed page on customizer matches the type of content option selected and page content
		return ( helena_is_promotion_headline_active( $control ) && 'demo' != $type );
	}
endif;