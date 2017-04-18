<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Helena
 */
/**
 * helena_doctype hook
 *
 * @hooked helena_doctype -  10
 *
 */
do_action( 'helena_doctype' );
?>

<head>
	<?php
	/**
	 * helena_before_wp_head hook
	 *
	 * @hooked helena_head -  10
	 *
	 */
	do_action( 'helena_before_wp_head' );

	wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	/**
	 * helena_before_header hook
	 *
	 * @hooked helena_page_start -  10
	 *
	 */
	do_action( 'helena_before_header' );


	/**
	 * helena_header hook
	 *
	 * @hooked helena_header_start -  10
	 * @hooked helena_site_branding_start -  20
	 * @hooked helena_header_nav_start -  40
	 * @hooked helena_site_branding_wrap -  50
	 * @hooked helena_primary_menu -  60
	 * @hooked helena_header_nav_end -  70
	 * @hooked helena_site_branding_end -  80
	 * @hooked helena_header_end -  200
	 *
	 */
	do_action( 'helena_header' );


	/**
	 * helena_after_header hook
	 *
	 * @hooked helena_header_featured_image - 10
	 * @hooked helena_featured_slider - 20
	 * @hooked helena_add_breadcrumb - 30
	 *
	 */
	do_action( 'helena_after_header' );

	/**
	 * helena_before_content hook
	 *
	 * @hooked
	 *
	 */
	do_action( 'helena_before_content' );

	/**
	 * helena_content hook
	 *
	 * @hooked helena_content_start - 10
	 *
	 */
	do_action( 'helena_content' );
