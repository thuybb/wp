<?php
/**
 * The template part for displaying the first post in index view.
 *
 * @package Helena
 */

?>

<?php $current_content_layout = apply_filters( 'helena_get_option', 'content_layout' ); ?>
<div class="stamp">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( has_post_thumbnail() && ! post_password_required() && "full-content" != $current_content_layout ) : ?>
			<a class="post-thumbnail" aria-hidden="true" href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) ); ?>
			</a>
		<?php endif; ?>
		<div class="entry-container">
	        <header class="entry-header">
                <div class="entry-meta">
			        <?php helena_posted_on(); ?>
		        </div><!-- .entry-meta -->
		        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	        </header><!-- .entry-header -->

	        <?php if ( "full-content" == $current_content_layout ) { ?>
	        	<div class="entry-content">
			        <?php
			        the_content();
			        wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'helena' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'helena' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						) );
			        ?>
		        </div><!-- .entry-content -->
	        <?php
	    	}
	    	else { ?>
				<div class="entry-summary">
				    <?php
				        if ( strpos( $post->post_content, '<!--more' ) ) {
				            the_content( sprintf(
				                /* translators: %s: Name of current post. */
				                wp_kses( esc_html__( 'Continue reading %s', 'helena' ), array( 'span' => array( 'class' => array() ) ) ),
				                the_title( '<span class="screen-reader-text">"', '"</span>', false )
				            ) );
				        } else {
				            the_excerpt();
				        }
				    ?>
				</div><!-- .entry-summary -->
		    <?php
	    	} ?>
        </div><!-- .entry-container -->
	</article><!-- #post-## -->
</div><!-- .stamp -->