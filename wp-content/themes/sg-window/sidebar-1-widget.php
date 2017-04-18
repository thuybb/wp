<?php
/**
 * The sidebar containing the main widget area for the widget page
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */

global $sgwindow_curr_page_id;
$sgwindow_curr_slug = sgwindow_get_page_sidebar_slug( $sgwindow_curr_page_id );
$hook_name = 'sgwindow_empty_column_1-'.$sgwindow_curr_slug;

?>
<div class="sidebar-1">
	<div class="column small">		
		<div class="widget-area recurs">
		<?php if ( is_active_sidebar( 'column-1'.'-'.$sgwindow_curr_slug ) ) : ?>
		
				<?php dynamic_sidebar( 'column-1'.'-'.$sgwindow_curr_slug ); ?>

		<?php else : ?>

				<?php do_action( $hook_name ); ?>
		
		<?php endif; ?>
		</div><!-- .widget-area -->
	</div><!-- .column -->
</div><!-- .sidebar-1 -->