<?php
/**
 * The sidebar containing the footer widget area
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */

$hook_name = 'sgwindow_empty_sidebar_footer';
global $wp_filter;
if( ! isset( $wp_filter[$hook_name . '-1'] ) && ! isset( $wp_filter[$hook_name . '-2'] ) && ! isset( $wp_filter[$hook_name . '-3'] ) && ! is_active_sidebar( 'sidebar-footer-1') 
									  && ! is_active_sidebar( 'sidebar-footer-2') 
									  && ! is_active_sidebar( 'sidebar-footer-3')  )
	return;
?>

<div class="sidebar-footer-wrap">
	<div class="sidebar-footer-content">

		<div class="sidebar-footer small footer-1">
			<div class="widget-area">
				<?php if ( is_active_sidebar( 'sidebar-footer-1' ) ) : ?>
				
						<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>

				<?php else : ?>

						<?php do_action( $hook_name . '-1' ); ?>
				
				<?php endif; ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-footer -->

		<div class="sidebar-footer small footer-2">
			<div class="widget-area">
				<?php if ( is_active_sidebar( 'sidebar-footer-2' ) ) : ?>
				
						<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>

				<?php else : ?>

						<?php do_action( $hook_name . '-2' ); ?>
				
				<?php endif; ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-footer -->

		<div class="sidebar-footer small footer-3">
			<div class="widget-area">
				<?php if ( is_active_sidebar( 'sidebar-footer-3' ) ) : ?>
				
						<?php dynamic_sidebar( 'sidebar-footer-3' ); ?>

				<?php else : ?>

						<?php do_action( $hook_name . '-3' ); ?>
				
				<?php endif; ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-footer -->
	</div><!-- .sidebar-footer-content -->

</div><!-- .sidebar-footer-wrap -->