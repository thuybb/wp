<?php
/**
 * The sidebar containing the before footer widget area.
 *
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */

$sgwindow_curr_slug = sgwindow_get_sidebar_slug();
$hook_name = 'sgwindow_empty_sidebar_before_footer-'.$sgwindow_curr_slug;

$defaults = sgwindow_get_defaults();
if( '1' != get_theme_mod( 'sidebar-before-footer' . '_' . $sgwindow_curr_slug, ( isset( $defaults['defined_sidebars'][ $sgwindow_curr_slug ]['sidebar-before-footer'] ) ? $defaults['defined_sidebars'][ $sgwindow_curr_slug ]['sidebar-before-footer'] : '' ) ) )
	return;

global $wp_filter;
if( ! isset( $wp_filter[ $hook_name ] ) && ! is_active_sidebar( 'sidebar-before-footer'.'-'.$sgwindow_curr_slug ) )
	return;

?>

<div class="sidebar-wrap">
	<div class="sidebar-before-footer wide">
		<div class="widget-area">
			<?php if ( is_active_sidebar( 'sidebar-before-footer'.'-'.$sgwindow_curr_slug ) ) : ?>
			
					<?php dynamic_sidebar( 'sidebar-before-footer'.'-'.$sgwindow_curr_slug ); ?>

			<?php else : ?>

					<?php do_action( $hook_name ) ?>
			
			<?php endif; ?>
		</div><!-- .widget-area -->
	</div><!-- .sidebar-before-footer .wide -->
</div><!-- .sidebar-wrap -->