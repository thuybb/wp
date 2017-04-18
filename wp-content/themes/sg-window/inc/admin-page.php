<?php
/**
 * Add menu to Appearance screen
 *
 * @since SG Window 1.0.1
 */
function sgwindow_admin_page() {
	add_theme_page( __( 'About theme', 'sg-window' ), __( 'About SG Window', 'sg-window' ), 'edit_theme_options', 'sgwindow-page', 'sgwindow_about_page');
}
add_action('admin_menu', 'sgwindow_admin_page');

/**
 * Add admin styles
 *
 * @since SG Window 1.0.0
 */
function sgwindow_custom_admin_style() {

	wp_enqueue_style( 'sgwindow-admin', esc_url_raw( get_template_directory_uri() . '/inc/css/admin.css' ) );
		
}
add_action( 'admin_enqueue_scripts', 'sgwindow_custom_admin_style' );
 
 /**
 * Add css styles for admin page
 *
 * @since SG Window 1.0.1
 */
function sgwindow_admim_style( $hook ) {
	if ( 'appearance_page_sgwindow-page' != $hook ) {
		return;
	}
	wp_enqueue_style( 'sgwindow-admin-page-style', get_template_directory_uri() . '/inc/css/admin-page.css', array(), null );
	wp_enqueue_style( 'sgwindow-admin-fonts', '//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038', array(), null );

	__( 'SG Window is a highly customizable WordPress theme with responsive design. Front page can include custom blocks and pages with different layouts. Theme includes one page navigation menu and CSS3&JQuery effects. It has many options in the theme customizer (per page sidebars, layouts: right column, left column, two columns, full width; blog: from 1 to 4 columns; favicon; logo; all google fonts; 2 color schemes, 3 nav menus and other options). SG Window has 4 footers, 4 per page sidebars and 10 custom widgets (Social Media Icons, Buttons, Images, Posts, Pages, Navigation). It can be used for portfolio, blog, e-commerce, business, landing page websites. Supports popular plugins: WooCommerce and portfolio from Jetpack. Translation ready. You can find the demo at http://wpblogs.info/demo/sg-window/', 'sg-window' );
	
}
add_action( 'admin_enqueue_scripts', 'sgwindow_admim_style' );

/**
 * About theme page
 *
 * @since SG Window 1.0.1
 */
function sgwindow_about_page() {
?>
	<div class="main-wrapper">
		<img class="main-image" src="<?php echo get_template_directory_uri() . esc_url( '/img/header.jpg' ); ?>"/>
		<p class="sg-header"><?php esc_html_e( 'Main Info', 'sg-window' ); ?></p>
		<ul class="sg-buttons">
			<li><a href="<?php echo home_url() . esc_url( '/wp-admin/customize.php' ); ?>"><?php esc_html_e( 'Theme Options', 'sg-window' ); ?></a></li>
			<li><a href="<?php echo home_url() . esc_html( '/wp-admin/customize.php?autofocus[panel]=widgets' ); ?>"><?php esc_html_e( 'Widgets', 'sg-window' ); ?></a></li>
			<li><a href="<?php echo __( 'http://wpblogs.ru/themes/how-to-video-sg-window-theme/', 'sg-window' ); ?>"><?php esc_html_e( 'How to use a theme (Video)', 'sg-window' ); ?></a></li>
			<li><a href="<?php echo esc_url( 'https://wordpress.org/support/theme/sg-window' ); ?>"><?php esc_html_e( 'Support forum', 'sg-window' ); ?></a></li>
			<li><a href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/sg-window#postform' ); ?>"><?php esc_html_e( 'Rate on WordPress.org', 'sg-window' ); ?></a></li>
			<?php if ( ! defined ( 'SGWINDOW' ) ) : ?>
			<li class="pro"><a href="<?php echo esc_url( 'http://wpblogs.ru/themes/sg-window-pro/' ); ?>"><?php esc_html_e( 'Update to Pro', 'sg-window' ); ?></a></li>
			<?php endif; ?>
			</li>
		</ul>
		<div class="info-wrapper">
			<div class="icon-image">
				<img src="<?php echo get_template_directory_uri() . '/screenshot.png'; ?>"/>
			</div><!-- .icon-image -->
			<div class="info">
			<?php if ( ! defined ( 'SGWINDOW' ) ) : ?>
				<p><?php esc_html_e( 'You are using light version of SG Window. Update to SG Window Pro to have even more features. For Example:', 'sg-window' ); ?></p>
				<ul>
					<li><?php esc_html_e( 'Custom colors;', 'sg-window' ); ?></li>
					<li><?php esc_html_e( 'Site/content width;', 'sg-window' ); ?></li>
					<li><?php esc_html_e( 'Boxed/Full width layout;', 'sg-window' ); ?></li>
					<li><?php esc_html_e( 'WooCommerce layouts;', 'sg-window' ); ?></li>
					<li><?php esc_html_e( 'Footer text options.', 'sg-window' ); ?></li>
				</ul>
			<?php else: ?>
				<p><?php esc_html_e( 'You are using full version of SG Window: SG Window Pro. If you find this theme useful please consider supporting it by donation.', 'sg-window' ); ?></p>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
				">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1" scale="0">
				</form>		
			<?php endif; ?>

			</div><!-- .info -->
			
		</div><!-- .info-wrapper -->
		<div class="more-info">
			<a href="<?php echo esc_url( 'http://wpblogs.ru/themes/sg-window-pro/' ); ?>"><?php esc_html_e( 'More Info', 'sg-window' ); ?></a>
		</div><!-- .more-info -->
	</div><!-- .main-wrapper -->
<?php
}