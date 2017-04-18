<?php
/**
 * The template for displaying jetpack portfolio archive pages
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.9
 */

get_header(); 
$sgwindow_layout = sgwindow_get_theme_mod('layout_portfolio');
$sgwindow_layout_content = sgwindow_get_theme_mod('layout_portfolio_content');
?>
<div class="main-wrapper <?php echo esc_attr(sgwindow_content_class($sgwindow_layout_content)); ?> <?php echo esc_attr($sgwindow_layout); ?> ">

	<div class="site-content">
	<?php
		if ( have_posts() ) : ?>
		
			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Tag: %s', 'sg-window' ), single_tag_title( '', false ) ); ?></h1>
			</header><!-- .archive-header -->
		
			<div class="content"> 

		<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'jetpack-portfolio-archive' );
				
			endwhile; ?>
			</div><!-- .content -->
			<div class="clear"></div>
		
			<?php sgwindow_paging_nav();?>
			
			<div class="content-search">
				<?php do_action( 'sgwindow_after_content' ); ?>
			</div><!-- .content-search -->

			
		<?php else : ?>
			<div class="content"> 
			<?php 
				get_template_part( 'content', 'none' );
			?>
			
			</div><!-- .content -->
		<?php 
		endif;
?>
	</div><!-- .site-content -->
	<?php sgwindow_get_sidebar( sgwindow_get_theme_mod( 'layout_portfolio' ) ); ?>
</div> <!-- .main-wrapper -->

<?php
get_footer();