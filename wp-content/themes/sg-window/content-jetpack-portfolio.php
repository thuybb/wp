<?php
/**
 * The default template for displaying content for the jetpack portfolio
 *
 * Used for both single and index/archive/search
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */
?>
<div class="content-container">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php
			if (  is_single() ) :
				if ( '1' == sgwindow_get_theme_mod('is_display_portfolio_title') ) :

					the_title( '<h1 class="entry-title">', '</h1>' );		
				
				endif;
				
			else : 
			
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
	
			endif;
			
			if ( is_single() ) :
			?>
			
			<?php if ( '1' == sgwindow_get_theme_mod('is_display_portfolio_project') ) : ?>

				<div class="project-list">
					<?php echo get_the_term_list( get_the_ID(), 'jetpack-portfolio-type'); ?>
				</div><!-- .project-list -->
			
			<?php endif; ?>
			
			<?php 
			endif;
			
			if ( has_post_thumbnail() && ! post_password_required() && '1' == sgwindow_get_theme_mod('is_display_portfolio_image') ) : ?>
			<div class="entry-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .entry-thumbnail -->

			<?php endif; ?>
			
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __('<div class="meta-nav">Continue Reading... &rarr;</div>', 'sg-window' )); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Portfolio:', 'sg-window'), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<div class="clear"></div>
		
		<footer class="entry-footer">
		
			<div class="entry-meta">
			
				<?php if ( '1' == sgwindow_get_theme_mod('is_display_portfolio_tags') ) : ?>
					
				<div class="tags">
				<?php echo get_the_term_list( $post->ID, 'jetpack-portfolio-tag', '', ' ') ?>
				</div> <!-- .tags -->
				
				<?php endif; ?>

				<?php edit_post_link( __( 'Edit', 'sg-window' ), '<span class="edit-link">', '</span>' ); ?>
			</div> <!-- .entry-meta -->
					
			<?php 
			if ( is_single() ) :
				do_action( 'sgwindow_after_content' );
			endif; 
			?>	
			
		</footer><!-- .entry-footer -->	
		
	</article><!-- #post -->
</div><!-- .content-container -->