<?php
/**
 * The sidebar containing the top widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 */
 
$sgwindow_curr_slug = sgwindow_get_sidebar_slug();
$hook_name = 'sgwindow_empty_sidebar_top-'.$sgwindow_curr_slug;

$defaults = sgwindow_get_defaults();
if( '1' != get_theme_mod( 'sidebar-top' . '_' . $sgwindow_curr_slug, ( isset( $defaults['defined_sidebars'][ $sgwindow_curr_slug ]['sidebar-top'] ) ? $defaults['defined_sidebars'][ $sgwindow_curr_slug ]['sidebar-top'] : '' ) ) )
	return;
	
global $wp_filter;
if( ! isset( $wp_filter[ $hook_name ] ) && ! is_active_sidebar( 'sidebar-top'.'-'.$sgwindow_curr_slug ) )
	return;
?>

<div id="sidebar-1" class="sidebar-top-full wide">
	<div class="widget-area">
			<?php if ( is_active_sidebar( 'sidebar-top'.'-'.$sgwindow_curr_slug ) ) : ?>
			
					<?php dynamic_sidebar( 'sidebar-top'.'-'.$sgwindow_curr_slug ); ?>

			<?php else : ?>

					<?php do_action( $hook_name ); ?>
			
			<?php endif; ?>
	</div><!-- .widget-area -->
</div><!-- .sidebar-top-full -->
