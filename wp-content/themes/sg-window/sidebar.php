<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */
 
$sgwindow_curr_slug = sgwindow_get_sidebar_slug();
$hook_name_1 = 'sgwindow_empty_column_1-'.$sgwindow_curr_slug;
$hook_name_2 = 'sgwindow_empty_column_2-'.$sgwindow_curr_slug;
?>

<div class="sidebar-1">
	<div class="column small">		
		<div class="widget-area">
			<?php 
			if ( is_active_sidebar( 'column-1'.'-'.$sgwindow_curr_slug  ) ) :
			
				dynamic_sidebar( 'column-1'.'-'.$sgwindow_curr_slug  );
				
			else :
				
				do_action( $hook_name_1 );

			endif;
			?>
		</div><!-- .widget-area -->
	</div><!-- .column -->
</div><!-- .sidebar-1 -->
	
<div class="sidebar-2">
	<div class="column small">
		<div class="widget-area">
			<?php if ( is_active_sidebar( 'column-2'.'-'.$sgwindow_curr_slug  ) ) :

				dynamic_sidebar( 'column-2'.'-'.$sgwindow_curr_slug  );
				
			else :
				
				do_action( $hook_name_2 );

			endif;
			?>	
		</div><!-- .widget-area -->
	</div><!-- .column -->
</div><!-- .sidebar-2 -->