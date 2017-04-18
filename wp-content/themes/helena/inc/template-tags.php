<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Helena
 */

if ( ! function_exists( 'helena_the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function helena_the_posts_navigation() {
	global $wp_query, $post;

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
		return;
	}

	$pagination_type    = apply_filters( 'helena_get_option', 'pagination_type' );

	/**
	 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled, else goto default pagination
	 * if it's active then disable pagination
	 */
	if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		return false;
	}
	?>

	<?php
		/**
		 * Check if navigation type is numeric and if Wp-PageNavi Plugin is enabled
		 */
		if ( 'numeric' == $pagination_type ) {
			if ( function_exists( 'wp_pagenavi' ) ) {
				echo '<nav class="navigation wp_pagenavi" role="navigation">';
				wp_pagenavi();
				echo '</nav><!-- .wp_pagenavi -->';
			}
			else {
				the_posts_pagination( array(
					'prev_text'          => esc_html__( 'Previous page', 'helena' ),
					'next_text'          => esc_html__( 'Next page', 'helena' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'helena' ) . ' </span>',
				) );
			}
        }
        else {
        	the_posts_navigation();
        } ?>
	<?php
}
endif;

if ( ! function_exists( 'helena_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function helena_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = sprintf(
		esc_html_x( '&mdash;%s', 'post author', 'helena' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="bypostauthor byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'helena' ), esc_html__( '1 Comment', 'helena' ), esc_html__( '% Comments', 'helena' ) );
		echo '</span>';
	}

}
endif;

if ( ! function_exists( 'helena_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function helena_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'helena' ) );
		if ( $categories_list && helena_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'helena' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'helena' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'helena' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'helena' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function helena_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'helena_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'helena_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so helena_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so helena_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in helena_categorized_blog.
 */
function helena_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'helena_categories' );
}
add_action( 'edit_category', 'helena_category_transient_flusher' );
add_action( 'save_post',     'helena_category_transient_flusher' );
