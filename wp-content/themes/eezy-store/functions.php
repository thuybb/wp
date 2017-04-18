<?php
/**
 * eezy_store functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package eezy-store
 */

if ( ! function_exists( 'eezy_store_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eezy_store_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org.
	 * If you're building a theme based on eezy-store, use a find and replace
	 * to change 'eezy-store' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'eezy-store');

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	// for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 248,
		'width'       => 248,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
	// Thumbnail sizes
	add_image_size( 'eezy-store-featured', 980, 600, true );
	
	add_image_size( 'eezy-store-featured-single', 980, 600, true );
	
	add_editor_style('editor-style.css');
	
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'eezy-store' ),
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
	
	// custom logo 
	if ( ! function_exists( 'eezy_store_custom_logo' ) ) :
	/**
 	* Displays the optional custom logo.
 	*
 	*	 Does nothing if the custom logo is not available.
 	*
 	* @since eezy-store
 	*/
	function eezy_store_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
	endif;

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'eezy_store_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'eezy_store_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eezy_store_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eezy_store_content_width', 640 );
}
add_action( 'after_setup_theme', 'eezy_store_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eezy_store_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'eezy-store' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'eezy-store' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar(array(
		'id' => 'eezy_store_footer1',
		'name' => esc_html__( 'Footer 1', 'eezy-store' ),
		'description'   => esc_html__( 'Add widgets here.', 'eezy-store' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-2 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	
	register_sidebar(array(
		'id' => 'eezy_store_footer2',
		'name' => esc_html__( 'Footer 2', 'eezy-store' ),
		'description'   => esc_html__( 'Add widgets here.', 'eezy-store' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-2 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	
	register_sidebar(array(
		'id' => 'eezy_store_footer3',
		'name' => esc_html__( 'Footer 3', 'eezy-store' ),
		'description'   => esc_html__( 'Add widgets here.', 'eezy-store' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-2 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	
	register_sidebar(array(
		'id' => 'eezy_store_footer4',
		'name' => esc_html__( 'Footer 4', 'eezy-store' ),
		'description'   => esc_html__( 'Add widgets here.', 'eezy-store' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-2 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	
	register_sidebar(array(
		'id' => 'eezy_store_footer5',
		'name' => esc_html__( 'Footer 5', 'eezy-store' ),
		'description'   => esc_html__( 'Add widgets here.', 'eezy-store' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-4 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	
	 register_sidebar(array(
		'id' => 'sidebar-shop',
		'name' => esc_html__( 'Sidebar-shop', 'eezy-store' ),
		'description' => esc_html__( 'Used on every page BUT the homepage page template.', 'eezy-store' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	  ));
	
}
add_action( 'widgets_init', 'eezy_store_widgets_init' );

/*Add theme menu page*/
 
add_action('admin_menu', 'eezy_store_menu');

function eezy_store_menu() {
	
	$eezy_store_page_title = __("Eezy Store Pro",'eezy-store');
	
	$eezy_store_menu_title = __("Eezy Store Pro",'eezy-store');
	
	add_theme_page($eezy_store_page_title, $eezy_store_menu_title, 'edit_theme_options', 'eezy_store_pro', 'eezy_store_pro_page');
	
}

/*
**
** Premium Theme Feature Page
**
*/

function eezy_store_pro_page(){
	
	if ( is_admin() ) {
		include_once( get_template_directory(). '/inc/admin/premium-screen/index.php');
	} 
	
} 

// eezy store remove sidebar from single product page

function eezy_store_remove_sidebar_product_page() {
    if ( is_singular('product') ) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
    }
}
add_action('template_redirect', 'eezy_store_remove_sidebar_product_page');

/**
 * Enqueue scripts and styles.
 */
function eezy_store_scripts() {
	
	wp_enqueue_script( 'eezy-store-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery' ), '1.0', true );
     
	wp_enqueue_script( 'eezy-store-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array('jquery' ), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_style( 'eezy-store-lato-font','https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900', array(), '1.0', 'all' );
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() .'/css/bootstrap.min.css',array(),'3.3.4' );
		
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome-4.7.0/css/font-awesome.min.css',array(),'4.7.0' );
	
	wp_enqueue_style( 'eezy-store-style', get_stylesheet_uri() );
	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery' ), '3.3.4', true ); 
	
	wp_enqueue_script( 'eezy-store-custom-js', get_template_directory_uri() . '/js/eezy_custom_js.js', array('jquery' ), '3.3.4', true );
	
}
add_action( 'wp_enqueue_scripts', 'eezy_store_scripts' );


function eezy_store_admin_script($eezy_store_hook){
	
	if($eezy_store_hook != 'appearance_page_eezy_store_pro') {
		return;
	} 
    
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome-4.7.0/css/font-awesome.min.css',array(),'4.7.0' );
	wp_enqueue_style( 'eezy-store-custom-css', get_template_directory_uri() .'/css/eeze-store-custom.css',array(),'1.0' );

}

add_action( 'admin_enqueue_scripts', 'eezy_store_admin_script' );


// Display an optional post thumbnail.
if ( ! function_exists( 'eezy_store_post_thumbnail')) :

	function eezy_store_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		if ( is_singular() ) :
		?>
		<div class="entry-summary">
			<?php the_post_thumbnail(); ?>
		</div><!-- .post-thumbnail -->
		<?php else : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php
					the_post_thumbnail('post-thumbnail', array( 'alt' => esc_attr(get_the_title())));
				?>
			</a>
		</div>
		<?php endif; // End is_singular()
	}
endif;

/* Include Premium Button Class File*/

require_once( trailingslashit( get_parent_theme_file_path() ) . 'trt-customize-pro/premium/class-customize.php' );

/**
 * Clean up the_excerpt()
 */
function eezy_store_excerpt_length($length) {
	
	if ( is_admin() ) {
        return $length;
    }else{
		return 50;
	}
	
}		

add_filter('excerpt_length', 'eezy_store_excerpt_length');

function eezy_store_excerpt_more($more) {
 
	return '<a class="eezy-store-excerpt-btn" href="'.esc_url(get_the_permalink()).'" rel="nofollow">'.__("Read More &hellip;",'eezy-store').'</a>';
}

add_filter('excerpt_more', 'eezy_store_excerpt_more');	

/**
 * Implement the Custom Header feature.
 */

require get_parent_theme_file_path() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_parent_theme_file_path() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_parent_theme_file_path() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_parent_theme_file_path() . '/inc/jetpack.php';