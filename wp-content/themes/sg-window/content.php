<?php
/**
 * The default template for displaying content
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
			if ( is_single() ) :

				if ( '1' == sgwindow_get_theme_mod('is_display_post_title') ) :

					the_title( '<h1 class="entry-title">', '</h1>' );		
				
				endif;	
				
			else : 
			
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
	
			endif;
			?>
			
			<?php if ( '1' == sgwindow_get_theme_mod( 'is_display_post_cat' ) ) : ?>

			<div class="category-list">
				<?php echo get_the_category_list(''); ?>
			</div><!-- .category-list -->
			
			<?php endif; ?>
			
			<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() && '1' == sgwindow_get_theme_mod('is_display_post_image') ) : ?>
			<div class="entry-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div>
			<?php endif; ?>
			
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __('<div class="meta-nav">Read more... &rarr;</div>', 'sg-window' )); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'sg-window'), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<div class="clear"></div>
		<footer class="entry-footer">
			<div class="entry-meta">
			
				<?php if ( '1' == sgwindow_get_theme_mod('is_display_post_tags') ) : ?>

				<div class="tags">
					<?php echo get_the_tag_list('', ' ');?>
				</div>
				
				<?php endif; ?>
				
				<span class="post-date">
					<?php sgwindow_posted_on(); ?>
				</span>
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