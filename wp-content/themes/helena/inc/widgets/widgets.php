<?php
/**
 * Add Custom Sidebars and Widgets
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

/**
 * Register widgetized area
 *
 * @since Helena 0.1
 */
function helena_widgets_init() {
	//Primary Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'helena' ),
		'id'            => 'primary-sidebar',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget'  => '</div><!-- .widget-wrap --></section><!-- #widget-default-search -->',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		'description'	=> esc_html__( 'This is the primary sidebar if you are using a two column site layout option.', 'helena' ),
	) );

	$footer_no = 3; //Number of footer sidebars

	for( $i=1; $i <= $footer_no; $i++ ) {
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer Area %d', 'helena' ), $i ),
			'id'            => sprintf( 'footer-%d', $i ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget'  => '</div><!-- .widget-wrap --></section><!-- #widget-default-search -->',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			'description'	=> sprintf( esc_html__( 'Footer %d widget area.', 'helena' ), $i ),
		) );
	}
}
add_action( 'widgets_init', 'helena_widgets_init' );

/**
 * Loads up Necessary JS Scripts for widgets
 *
 * @since Helena 0.1
 */
function helena_widgets_scripts( $hook) {
	if ( 'widgets.php' == $hook ) {
		wp_enqueue_style( 'helena-widgets-styles', get_template_directory_uri() . '/css/widgets.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'helena_widgets_scripts' );

// Load Featured Post Widget
include trailingslashit( get_template_directory() ) . 'inc/widgets/featured-posts.php';

// Load Social Icon Widget
include trailingslashit( get_template_directory() ) . 'inc/widgets/social-icons.php';

// Load Newsletter Widget
include trailingslashit( get_template_directory() ) . 'inc/widgets/tag-cloud.php';
