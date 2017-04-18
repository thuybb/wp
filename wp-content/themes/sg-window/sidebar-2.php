<?php
/**
 * The sidebar containing the second widget area 
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */
 
$sgwindow_curr_slug = sgwindow_get_sidebar_slug();
$hook_name = 'sgwindow_empty_column_2-'.$sgwindow_curr_slug;
?>

<div class="sidebar-2">
	<div class="column small">		
		<div class="widget-area">
		<?php if ( is_active_sidebar( 'column-2'.'-'.$sgwindow_curr_slug ) ) : ?>
		
				<?php dynamic_sidebar( 'column-2'.'-'.$sgwindow_curr_slug ); ?>

		<?php else : ?>

				<?php do_action( $hook_name ); ?>
		
		<?php endif; ?>
		</div><!-- .widget-area -->
	</div><!-- .column -->
</div><!-- .sidebar-2 -->
