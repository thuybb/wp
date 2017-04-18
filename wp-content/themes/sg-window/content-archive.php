<?php
/**
 * The default template for displaying content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */
 
global $sgwindow_layout_content;
?>
<div class="content-container">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">

			<?php if ( ( has_post_thumbnail() && ! post_password_required() ) ) : ?>
				<div class="element effect-1">
					
					<?php if ( '1' == sgwindow_get_theme_mod( 'is_defaults_post_thumbnail_background' ) && 'default' != $sgwindow_layout_content && 'flex-layout-1' != $sgwindow_layout_content ) : ?>

						<div class="entry-thumbnail coverback" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>); ">
						</div><!-- .entry-thumbnail -->
						
					<?php else : ?>
					
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div><!-- .entry-thumbnail -->
															
					<?php endif; ?>
																		
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="link-hover" rel="bookmark">
						<span class="link-button">
							<?php esc_html_e('Read more..', 'sg-window'); ?>
						</span>
					</a>
						
				</div><!-- .element -->
			<?php elseif ( sgwindow_get_theme_mod( 'is_thumbnail_empty_icon' ) ) : ?>
				<div class="element effect-1">

					<div class="entry-thumbnail coverback" style="background-image: url(<?php echo esc_url( get_template_directory_uri() . '/img/empty.png');  ?>); ">
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
		
		<?php if( 'excerpt' == sgwindow_get_theme_mod('single_style') || ( 'content' == sgwindow_get_theme_mod('single_style') && is_search() )  ) : ?>
			
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
				
		<?php elseif( 'content' == sgwindow_get_theme_mod('single_style') ) : ?>
			
			<div class="entry-content">
				<?php the_content( __('<div class="meta-nav">Continue reading... &rarr;</div>', 'sg-window' )); ?>
			</div><!-- .entry-content -->
			
		<?php endif; ?>
		
		<footer class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : ?>

				<span class="post-date">
					<?php sgwindow_posted_on(); ?>
				</span>
				
			<?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'sg-window' ), '<span title="'.__( 'Edit', 'sg-window' ).'" class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
		
	</article><!-- #post -->
	
</div><!-- .content-container -->