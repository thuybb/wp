<?php
/**
 * The template for Managing Theme Structure
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

if ( ! function_exists( 'helena_doctype' ) ) :
	/**
	 * Doctype Declaration
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_doctype() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<?php
	}
endif;
add_action( 'helena_doctype', 'helena_doctype', 10 );


if ( ! function_exists( 'helena_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}
endif;
add_action( 'helena_before_wp_head', 'helena_head', 10 );


if ( ! function_exists( 'helena_page_start' ) ) :
	/**
	 * Start div id #page
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_page_start() {
		?>
		<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'helena' ); ?></a>
		<?php
	}
endif;
add_action( 'helena_before_header', 'helena_page_start', 10 );


if ( ! function_exists( 'helena_header_start' ) ) :
	/**
	 * Start Header id #masthead
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_header_start() {
		?>
		<header id="masthead" role="banner">
			<div class="wrapper site-header-main">
		<?php
	}
endif;
add_action( 'helena_header', 'helena_header_start', 10 );


if ( ! function_exists( 'helena_site_branding_wrap' ) ) :
	/**
	 * Add Site Title and Tagline
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_site_branding_wrap() {
		//Main class wrap
		$class[] = "site-branding-wrap";

		//Checking Logo
		$site_logo = '';
		$move_title_tagline = apply_filters( 'helena_get_option', 'move_title_tagline' );
		if ( has_custom_logo() ) {
			$site_logo = '<div id="site-logo">'. get_custom_logo() . '</div><!-- #site-logo -->';

			if ( $move_title_tagline ) {
				$class[] = "logo-right";
			}
			else {
				$class[] = "logo-left";
			}
		}

		//Header Text, add screen-reader-text class if header text is not displayed
		$header_class = '';
		if ( !display_header_text() ) {
			$header_class = ' class="screen-reader-text"';
		}

		//Site title
		$title = '
			<p class="site-title">
				<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">
					 '. get_bloginfo( 'name' ) .'
				</a>
			</p>
		';

		if ( is_front_page() && is_home() ) {
			$title = '
				<h1 class="site-title">
					<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">
						 '. get_bloginfo( 'name' ) .'
					</a>
				</h1>
			';
		}

		//Site Description
		$description_check = apply_filters( 'helena_get_option', 'disable_tagline_header' );
		$description       = '';
		if ( !$description_check ) {
			$class[]     = 'enable-description';
			$description = '<p class="site-description">' . get_bloginfo( 'description' ) . '</p>';
		}

		$site_header = '
		<div id="site-header" ' . $header_class . '>
			' . $title . $description . '
		</div><!-- #site-header -->';

		$site_branding = '<div id="site-branding" class="' . implode( ' ' , $class ) . '">' . $site_logo . $site_header . '</div><!-- .site-branding -->';

		if ( has_custom_logo() && $move_title_tagline ) {
			$site_branding = '<div id="site-branding" class="' . implode( ' ' , $class ) . '">' . $site_header . $site_logo . '</div><!-- .site-branding -->';
		}

		echo $site_branding;
	}
endif;
add_action( 'helena_header', 'helena_site_branding_wrap', 20 );


if ( ! function_exists( 'helena_primary_menu' ) ) :
	/**
	 * Add Primary Menu #primary-menu
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_primary_menu() {
		?>
		<button id="menu-toggle" class="menu-toggle"><?php _e( 'Menu', 'helena' ); ?></button>

		<div id="site-header-menu" class="site-header-menu">
			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Menu', 'helena' ); ?>">
				<div class="main-menu-container">
                    <?php
                        if ( has_nav_menu( 'primary' ) ) {
                            $helena_primary_menu_args = array(
                                'theme_location'    => 'primary',
                                'menu_class'        => 'menu',
                                'container' 		=> 'div',
                                'container_class' 	=> 'primary-menu'
                            );
                            wp_nav_menu( $helena_primary_menu_args );
                        }
                        else {
                            wp_page_menu( array( 'menu_class'  => 'menu primary-menu' ) );
                        }
                    ?>
                </div><!--end menu-main-menu-container-->

                <div id="search-toggle">
                    <a class="screen-reader-text" href="#search-container"><?php _e( 'Search', 'helena' ); ?></a>
                </div>

                <div id="search-container" class="displaynone">
                    <?php get_search_form(); ?>
                </div>
            </nav><!--end main-navigation-->
        </div><!-- .site-header-menu -->
		<?php
	}
endif;
add_action( 'helena_header', 'helena_primary_menu', 30 );


if ( ! function_exists( 'helena_header_end' ) ) :
	/**
	 * End in header class .site-banner and class .wrapper
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_header_end() {
		?>
			</div><!-- .wrapper.site-header-main -->
		</header><!-- #masthead -->
		<?php
	}
endif;
add_action( 'helena_header', 'helena_header_end', 40 );


if ( ! function_exists( 'helena_content_start' ) ) :
	/**
	 * Start div id #content
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_content_start() {
		?>
		<div id="content" class="site-content">
			<div class="wrapper">
	<?php
	}
endif;
add_action('helena_content', 'helena_content_start', 10 );


if ( ! function_exists( 'helena_content_end' ) ) :
	/**
	 * End div id #content
	 *
	 * @since Helena 0.1
	 */
	function helena_content_end() {
		?>
	    	</div><!-- .wrapper -->
	    </div><!-- #content -->
		<?php
	}
endif;
add_action( 'helena_after_content', 'helena_content_end', 10 );

if ( ! function_exists( 'helena_footer_sidebar' ) ) :
	/**
	 * Footer Sidebar
	 *
	 * @since Helena 0.1
	 */
	function helena_footer_sidebar() {
		get_sidebar( 'footer' );
	}
	endif;
add_action( 'helena_footer', 'helena_footer_sidebar', 20 );


if ( ! function_exists( 'helena_footer_content_start' ) ) :
	/**
	 * Start footer id #colophon
	 *
	 * @since Helena 0.1
	 */
	function helena_footer_content_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
	    <?php
	}
endif;
add_action( 'helena_footer', 'helena_footer_content_start', 10 );

if ( ! function_exists( 'helena_site_info_start' ) ) :
	/**
	 * Site Info start
	 *
	 * @since Helena 0.1
	 */
	function helena_site_info_start() { ?>
		<div class="site-info">
			<div class="wrapper">
	<?php
	}
endif;
add_action( 'helena_footer', 'helena_site_info_start', 30 );

if ( ! function_exists( 'helena_footer_site_description' ) ) :
	/**
	 * Footer Site Description
	 *
	 * @since Helena 0.1
	 */
	function helena_footer_site_description() {
		if ( apply_filters( 'helena_get_option', 'disable_tagline_footer' ) ) {
			return;
		}
		?>
        	<p class="site-description"><?php bloginfo( 'description' ); ?></p>
		<?php
		?>
	<?php
	}
endif;
add_action( 'helena_footer', 'helena_footer_site_description', 40 );

if ( ! function_exists( 'helena_social_menu' ) ) :
	/**
	 * Social Menu
	 *
	 * @since Helena 0.1
	 */
	function helena_social_menu() {
		if ( has_nav_menu( 'social' ) ) {
		?>
			<div class="social-menu">
				<?php wp_nav_menu( array(
						'theme_location' => 'social',
						'depth'          => '1',
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>' )
					);
				?>
			</div><!-- .social-menu -->
		<?php
        }
	}
endif;
add_action( 'helena_footer', 'helena_social_menu', 60 );

if ( ! function_exists( 'helena_site_info_end' ) ) :
	/**
	 * Site Info end
	 *
	 * @since Helena 0.1
	 */
	function helena_site_info_end() { ?>
			<div><!-- .wrapper -->
		</div><!-- .site-info -->
	<?php
	}
endif;
add_action( 'helena_footer', 'helena_site_info_end', 70 );

if ( ! function_exists( 'helena_footer_content_end' ) ) :
	/**
	 * End footer id #colophon
	 *
	 * @since Helena 0.1
	 */
	function helena_footer_content_end() {
		?>
		</footer><!-- #colophon -->
		<?php
	}
	endif;
add_action( 'helena_footer', 'helena_footer_content_end', 190 );

if ( ! function_exists( 'helena_page_end' ) ) :
	/**
	 * End div id #page
	 *
	 * @since Helena 0.1
	 *
	 */
	function helena_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'helena_footer', 'helena_page_end', 200 );
