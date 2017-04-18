<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Helena
 */

?>

<?php
$current_content_layout = apply_filters( 'helena_get_option', 'content_layout' );
if ( "excerpt-image-top" == $current_content_layout ) {
	echo '<div class="grid-item">';
} ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
				/**
				 * helena_before_entry_container hook
				 *
				 * @hooked helena_archive_content_image - 10
				 */
				do_action( 'helena_before_entry_container' );
			?>
			<div class="entry-container">
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-subtitle"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				</header><!-- .entry-header -->

				<?php if ( "full-content" == $current_content_layout ) {
					echo '<div class="entry-content">';
						the_content();

						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'helena' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'helena' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						) );
					echo '</div><!-- .entry-content -->';
				}
				else { ?>
					<div class="entry-summary">
					    <?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				<?php
				} ?>
			</div><!-- .entry-container -->
		</article><!-- #post-## -->
<?php
if ( "excerpt-image-top" == $current_content_layout ) {
	echo '</div><!-- .grid-item -->';
} ?>