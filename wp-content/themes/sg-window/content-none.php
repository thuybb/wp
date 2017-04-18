<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */
?>
<div id="primary" class="content-area">
	<div class="nothing-found">
		<article <?php post_class(); ?>>

			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Nothing Found', 'sg-window' ); ?></h1>
			</header>


			<div class="entry-content">

			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'sg-window' ), admin_url( 'post-new.php' ) ); ?></p>

			<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'sg-window' ); ?></p>
			<?php get_search_form(); ?>

			<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'sg-window' ); ?></p>
			<?php get_search_form(); ?>

			<?php endif; ?>
			
			<footer class="entry-footer">
				<?php do_action( 'sgwindow_after_content' ); ?>	
			</footer><!-- .entry-footer -->	
			
		</article>
		
	</div><!-- .nothing-found -->
</div><!-- #content-area-->