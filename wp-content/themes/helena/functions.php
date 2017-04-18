<?php
/**
 * Helena functions and definitions.
 *
 * @package Helena
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

/**
 * Define default constants
 */
if ( ! defined( 'HELENA_THEME_VERSION' ) ) {
	$theme_data = wp_get_theme();

	define( 'HELENA_THEME_VERSION', $theme_data->get( 'Version' ) );
}

if ( ! function_exists( 'helena_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function helena_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Helena, use a find and replace
		 * to change 'helena' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'helena', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Add tyles the visual editor to resemble the theme style.
		add_editor_style( array( 'css/editor-style.css', helena_fonts_url() ) );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Hero content, Header Highlight.
		set_post_thumbnail_size( 585, 439, true ); // Ratio 4:3.

		add_image_size( 'helena-slider', 1170, 658, true ); // Ratio: 16:9.

		add_image_size( 'helena-small', 90, 68, true ); // used in Widgets

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'helena' ),
			'social'  => esc_html__( 'Social Menu', 'helena' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'helena_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'custom-logo' );
	}
	endif; // helena_setup.
add_action( 'after_setup_theme', 'helena_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function helena_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'helena_content_width', 1090 );
}
add_action( 'after_setup_theme', 'helena_content_width', 0 );

if ( ! function_exists( 'helena_template_redirect' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet for different value other than the default one
	 *
	 * @global int $content_width
	 */
	function helena_template_redirect() {
	    $layout = helena_get_theme_layout();

	    if ( 'right-sidebar' == $layout ) {
			$GLOBALS['content_width'] = 800;
		}
	}
endif;
add_action( 'template_redirect', 'helena_template_redirect' );

/**
 * Enqueue scripts and styles.
 */
function helena_scripts() {
	wp_enqueue_style( 'helena-style', get_stylesheet_uri(), array(), HELENA_THEME_VERSION );

	wp_enqueue_style( 'helena-fonts', helena_fonts_url(), array(), HELENA_THEME_VERSION );

	// To avoid double loading, we don't prefix custom styles or scripts.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/css/genericons/genericons.css', false, '3.4.1' );

	$color_scheme = apply_filters( 'helena_get_option', 'color_scheme' );

	if ( 'light' != $color_scheme ) {
		wp_enqueue_style( 'helena-' . $color_scheme, get_template_directory_uri() . '/css/colors/' . $color_scheme . '.css', array(), null );
	}

	wp_enqueue_script( 'helena-navigation', get_template_directory_uri() . '/js/navigation.js', array(), HELENA_THEME_VERSION, true );

	wp_enqueue_script( 'helena-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), HELENA_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Loads up Cycle JS
	 */
	$slider_option  = apply_filters( 'helena_get_option', 'featured_slider_option' );
	$content_slider = apply_filters( 'helena_get_option', 'featured_content_slider' );
	$logo_slider_option      = apply_filters( 'helena_get_option', 'logo_slider_option' );
	$transition_effect       = apply_filters( 'helena_get_option', 'featured_slider_transition_effect' );

	/**
	 * Loads up Cycle JS
	 */
	if ( 'disabled' != $slider_option || $content_slider || 'disabled' != $logo_slider_option  ) {
		wp_register_script( 'jquery.cycle2', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.min.js', array( 'jquery' ), '2.1.5', true );

		/**
		 * Condition checks for additional slider transition plugins
		 */
		// Scroll Vertical transition plugin addition.
		if ( 'scrollVert' == $transition_effect ) {
			wp_enqueue_script( 'jquery.cycle2.scrollVert', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.scrollVert.min.js', array( 'jquery.cycle2' ), '20140128', true );
		} elseif ( 'flipHorz' == $transition_effect || 'flipVert' == $transition_effect ) {
			// Flip transition plugin addition.
			wp_enqueue_script( 'jquery.cycle2.flip', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.flip.min.js', array( 'jquery.cycle2' ), '20140128', true );
		} elseif ( 'tileSlide' == $transition_effect || 'tileBlind' == $transition_effect ) {
			// Shuffle transition plugin addition.
			wp_enqueue_script( 'jquery.cycle2.tile', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.tile.min.js', array( 'jquery.cycle2' ), '20140128', true );
		} elseif ( 'shuffle' == $transition_effect ) {
			// Shuffle transition plugin addition.
			wp_enqueue_script( 'jquery.cycle2.shuffle', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.shuffle.min.js', array( 'jquery.cycle2' ), '20140128 ', true );
		} else {
			if ( 'disabled' != $logo_slider_option ) {
				wp_enqueue_script( 'jquery.cycle2.carousel', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.carousel.min.js', array( 'jquery.cycle2' ), '20160603', true );
			} else {
				wp_enqueue_script( 'jquery.cycle2' );
			}
		}
	}

	wp_enqueue_script( 'helena-scripts', get_template_directory_uri() . '/js/custom-scripts.min.js', array( 'jquery' ), HELENA_THEME_VERSION, true );

	// Archive Content Image Layout.
	$content_layout = apply_filters( 'helena_get_option', 'content_layout' );

	if ( 'excerpt-image-top' == $content_layout && ( is_archive() || is_home() ) ) {
		wp_enqueue_script( 'helena-masonry', get_template_directory_uri() . '/js/custom-masonry.min.js', array( 'jquery', 'jquery-masonry' ), HELENA_THEME_VERSION, true );
	}

	// We localize only few lines in custom-scripts.js.
	$localize_data = array(
		'screenReaderText' => array(
			'expand'   => esc_html__( 'expand child menu', 'helena' ),
			'collapse' => esc_html__( 'collapse child menu', 'helena' ),
		),
		'placeholder'      => array(
			'author'  => esc_html__( 'Name', 'helena' ),
			'email'   => esc_html__( 'Email', 'helena' ),
			'url'     => esc_html__( 'URL', 'helena' ),
			'comment' => esc_html__( 'Comment', 'helena' ),
		),
	);

	wp_localize_script( 'helena-scripts', 'localizeData', $localize_data );
}
add_action( 'wp_enqueue_scripts', 'helena_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 */
function helena_admin_fonts() {
	wp_enqueue_style( 'helena-fonts', helena_fonts_url(), array(), HELENA_THEME_VERSION );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'helena_admin_fonts' );

/**
 * Register Google fonts.
 */
function helena_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Rubik, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$rubik = _x( 'on', 'Rubik: on or off', 'helena' );

	/* Translators: If there are characters in your language that are not
	* supported by Playfair Display, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$playfair_display = _x( 'on', 'Playfair Display font: on or off', 'helena' );

	if ( 'off' !== $rubik || 'off' !== $playfair_display ) {
		$font_families = array();

		if ( 'off' !== $rubik ) {
		$font_families[] = 'Rubik';
		}

		if ( 'off' !== $playfair_display ) {
		$font_families[] = 'Playfair+Display';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Load Custom Widgets
 */
require trailingslashit( get_template_directory() ) . 'inc/widgets/widgets.php';

/**
 * Include Breadcrumb
 */
require trailingslashit( get_template_directory() ) . 'inc/breadcrumb.php';

/**
 * Custom functions that act independently of the theme templates
 */
require trailingslashit( get_template_directory() ) . 'inc/extras.php';

/**
 * Include Custom Header
 */
require trailingslashit( get_template_directory() ) . 'inc/custom-header.php';

/**
 * Customizer additions
 */
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer.php';

/**
 * Include Default Options
 */
require trailingslashit( get_template_directory() ) . 'inc/default-options.php';

/**
 * Include Featured Content
 */
require trailingslashit( get_template_directory() ) . 'inc/featured-content.php';

/**
 * Include Featured Slider
 */
require trailingslashit( get_template_directory() ) . 'inc/featured-slider.php';

/**
 * Include Header Highlight Content
 */
require trailingslashit( get_template_directory() ) . 'inc/header-highlight-content.php';

/**
 * Include Hero Content
 */
require trailingslashit( get_template_directory() ) . 'inc/hero-content.php';

/**
 * Load Jetpack compatibility file
 */
require trailingslashit( get_template_directory() ) . 'inc/jetpack.php';

/**
 * Include logo slider
 */
require trailingslashit( get_template_directory() ) . 'inc/logo-slider.php';

/**
 * Include metabox options
 */
require trailingslashit( get_template_directory() ) . 'inc/metabox.php';

/**
 * Include portfolio
 */
require trailingslashit( get_template_directory() ) . 'inc/portfolio.php';

/**
 * Include promotion headline
 */
require trailingslashit( get_template_directory() ) . 'inc/promotion-headline.php';

/**
 * Include Main Structure file
 */
require trailingslashit( get_template_directory() ) . 'inc/structure.php';

/**
 * Custom template tags for this theme
 */
require trailingslashit( get_template_directory() ) . 'inc/template-tags.php';