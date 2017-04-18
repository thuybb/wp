<?php
/**
 * The template for displaying woocommerce archive pages.
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */
get_header(); 

$sgwindow_layout_name = ( is_shop() || is_archive() ? 'layout_shop' : 'layout_shop-page' );
$sgwindow_layout = sgwindow_get_theme_mod( $sgwindow_layout_name );
global $woocommerce_loop;
$sgwindow_columns = 4;

if ( ! empty( $woocommerce_loop['columns'] ) )
	$sgwindow_columns = apply_filters( 'loop_shop_columns', 4 );
if ( is_singular() )
	$sgwindow_columns = 0;
?>

<div class="main-wrapper woo-shop <?php echo esc_attr($sgwindow_layout); ?> flex-layout-<?php echo esc_attr( $sgwindow_columns ); ?>">

	<div class="site-content"> 
		<div class="content"> 
			<?php if ( is_singular() ) : ?>
			<div class="content-container">
			<?php endif; ?>
	
					<?php woocommerce_breadcrumb(); ?>
					<?php woocommerce_content(); ?>
					<?php do_action( 'sgwindow_after_content' ); ?>	

			<?php if ( is_singular() ) : ?>
			</div><!-- .content-container -->
			<?php endif; ?>

		</div><!-- .content -->
		<div class="clear"></div>	
	</div><!-- .site-content -->
	<?php sgwindow_get_sidebar( $sgwindow_layout ); ?>

</div> <!-- .main-wrapper.woo-shop -->

<?php
get_footer();
