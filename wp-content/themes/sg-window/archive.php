<?php
/**
 * The template for displaying Archive pages
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */

get_header();
$sgwindow_layout = sgwindow_get_theme_mod( 'layout_archive' );
$sgwindow_layout_content = sgwindow_get_theme_mod( 'layout_archive_content' );

?>
<div class="main-wrapper <?php echo esc_attr( sgwindow_content_class( $sgwindow_layout_content ) ); ?> <?php echo esc_attr( $sgwindow_layout ); ?> ">
	
	<div class="site-content">
			<?php
				if ( have_posts() ) : 
				?>
					<header class="archive-header">
					<?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'sg-window' ), get_the_date() );

						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'sg-window' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'sg-window' ) ) );

						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'sg-window' ), get_the_date( _x( 'Y', 'yearly archives date format', 'sg-window' ) ) );

						else :
							_e( 'Archives', 'sg-window' );

						endif; ?>
					
					</header><!-- .archive-header -->
					
					<div class="content"> 

				<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'content', sgwindow_get_content_prefix() );
						
					endwhile; ?>
						<div class="content-search">
						<?php do_action( 'sgwindow_after_content' ); ?>
						</div><!-- .content-search -->
					</div><!-- .content -->
					<div class="clear"></div>
				
				<?php

					sgwindow_paging_nav();
					
				else :  
				?>
					<div class="content"> 
					<?php 
						get_template_part( 'content', 'none' );
					?>
					
					</div><!-- .content -->
				<?php 
				endif;
?>
	</div><!-- .site-content -->
	<?php sgwindow_get_sidebar( sgwindow_get_theme_mod( 'layout_archive' ) ); ?>
</div> <!-- .main-wrapper -->

<?php
get_footer();