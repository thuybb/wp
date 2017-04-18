<?php
/**
 * The template for displaying archive by Author
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
						<h1 class="archive-title">
									<?php
										the_post();

										printf( __( 'All posts by %s', 'sg-window' ), get_the_author() );
									?>
								</h1>
								<?php if ( get_the_author_meta( 'description' ) ) : ?>
								<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
								<?php endif; ?>
					</header><!-- .archive-header -->
					
					<div class="content"> 

				<?php
				
					rewind_posts();

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
	<?php
	sgwindow_get_sidebar( sgwindow_get_theme_mod( 'layout_archive' ) );
	?>
</div> <!-- .main-wrapper -->

<?php
get_footer();