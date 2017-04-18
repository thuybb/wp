<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */
?>
<div class="content-container">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="element effect-1">
					<div class="entry-thumbnail">
						<?php the_post_thumbnail(); ?>
					</div><!-- .entry-thumbnail -->
																		
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="link-hover" rel="bookmark">
						<span class="link-button">
							<?php esc_html_e('Read more..', 'sg-window'); ?>
						</span>
					</a>
						
				</div><!-- .element -->
			<?php endif; ?>
			
		<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
										
		</header><!-- .entry-header -->

		<?php if( 'excerpt' == sgwindow_get_theme_mod('page_style') ) : ?>
			
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
				
		<?php elseif( 'content' == sgwindow_get_theme_mod('page_style') ) : ?>
			
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
			
		<?php endif; ?>
		
		<footer class="entry-footer">
			<div class="entry-meta">
				<?php edit_post_link( __( 'Edit', 'sg-window' ), '<span class="edit-link">', '</span>' ); ?>
			</div> <!-- .entry-meta -->
		</footer><!-- .entry-footer -->
	</article><!-- #post-## -->
</div><!-- .content-container -->