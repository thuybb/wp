<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package eezy-store
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>> 
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'eezy-store' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="custom-header">
		
	<div class="container">
		<div class="site-branding">
			<div class="col-sm-7 col-xs-6 brand-logo">
				<?php
				
				eezy_store_custom_logo();
				
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>	
			</div>
			
			<div class="col-sm-5 col-xs-6 login-sec">
			
				<?php 
					
				if ( class_exists( 'WooCommerce' ) ) :?> 
					
					<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id')));?>"><span class="mobile_hide"><?php esc_html_e('My Account', 'eezy-store'); ?></span> <span class="fa fa-user"></span></a>
						
				<?php endif; ?>
			
				
				<div class="basket-cart">
				
				<?php 
					
					if ( class_exists( 'WooCommerce' ) ) :?>
					<?php global $woocommerce; ?><a class="cart-contents" href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'eezy-store'); ?>"><?php echo sprintf(_n('<span class="item-count">%d</span> <span class="mobile_item_hide">'.__("item","eezy-store").'</span>', '<span class="item-count">%d</span> <span class="mobile_item_hide">'.__("items","eezy-store").'</span>', $woocommerce->cart->cart_contents_count, 'eezy-store'), $woocommerce->cart->cart_contents_count);?> <span class="mobile_item_hide"> - </span><?php echo wp_kses_post($woocommerce->cart->get_cart_total()); ?></a>
					
					
				<?php endif; ?>	
				</div>
			</div>
			
		</div><!-- .site-branding -->
		
		
		<div class="navbar-container">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' , 'container_class'=> 'eezy-store-nav') ); ?>
			</nav><!-- #site-navigation --> 
			
			<span class="eezy-search-icon"><a href="javascript:void(0);"><i class="fa fa-search"></i></a></span>
			
			<div class="eezy-search-form">
				<?php get_search_form(); ?>
			</div>
			
		</div><!--end container-->
	</div>
	
	<div class="custom-header-media">
		<?php the_custom_header_markup(); ?>
	</div>
	
	</div>	
	</header><!-- #masthead -->
	
	<div class="container">

	<div id="content" class="site-content">