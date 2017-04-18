<?php
/**
 * The template for displaying the header
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">

		<!-- Header -->
		<header id="masthead" class="site-header" role="banner">	
		
			<?php do_action( 'sgwindow_header_top' ); ?>
			
		</header><!-- #masthead -->

		<div class="sg-header-area">
			<div class="header-wrap">
	
			<?php
				do_action( 'sgwindow_header_image' );

				get_sidebar( 'top' ); 
			?>
			
			</div><!-- .header-wrap -->
		</div><!-- .sg-header-area -->

	<div class="main-area">