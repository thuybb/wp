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
 
$sgwindow_project = implode(sgwindow_get_curr_tax_ids('jetpack-portfolio-type'), ' ');
$sgwindow_tags = implode(sgwindow_get_curr_tax_ids('jetpack-portfolio-tag'), ' ');
?>
<div class="content-container jetpack-nav <?php echo esc_attr( $sgwindow_project.' '.$sgwindow_tags ); ?>">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
		
			<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
				<div class="element effect-1">
					<?php if ( '1' == sgwindow_get_theme_mod( 'is_defaults_post_thumbnail_background' ) ) : ?>

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
			<?php endif;
			
			the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			
			?>
			
		</header><!-- .entry-header -->

		<?php if( 'excerpt' == sgwindow_get_theme_mod('portfolio_style') ) : ?>
		
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			
		<?php elseif( 'content' == sgwindow_get_theme_mod('portfolio_style') ) : ?>
		
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		
		<?php endif; ?>
		
		<footer class="entry-meta">
			
			<span class="project" title="<?php echo esc_attr(implode(sgwindow_get_curr_tax_names('jetpack-portfolio-type'), ', ')); ?>">
				<?php echo get_the_term_list( get_the_ID(), 'jetpack-portfolio-type'); ?>
			</span><!-- .project -->
			
			<span class="tag" title="<?php echo esc_attr(implode(sgwindow_get_curr_tax_names('jetpack-portfolio-tag'), ', ')); ?>">
			
			</span> <!-- .tags -->
			
			
			<?php edit_post_link( __( 'Edit', 'sg-window' ), '<span title="'.__( 'Edit', 'sg-window' ).'" class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
		
	</article><!-- #post -->
</div><!-- .content-container -->