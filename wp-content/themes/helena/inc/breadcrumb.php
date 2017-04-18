<?php
/**
 * The template for displaying the Breadcrumb
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */

if ( ! function_exists( 'helena_add_breadcrumb' ) ) :
	/**
	 * Add breadcrumb.
	 *
	 * @action helena_after_header
	 *
	 * @since Helena 0.1
	 */
	function helena_add_breadcrumb() {
		$enable      = apply_filters( 'helena_get_option', 'breadcrumb_option' );
		$on_homepage = apply_filters( 'helena_get_option', 'breadcrumb_on_homepage' );
		$seperator   = apply_filters( 'helena_get_option', 'breadcrumb_seperator' );

		if ( $enable ) {
			$delimiter = '<span class="sep">' . $seperator . '</span><!-- .sep -->'; // delimiter between crumbs.

			echo helena_custom_breadcrumbs( $on_homepage, $delimiter );
		} else {
			return false;
		}
	}
endif;
add_action( 'helena_after_header', 'helena_add_breadcrumb', 30 );


if ( ! function_exists( 'helena_custom_breadcrumbs' ) ) :
	/**
	 * Allows visitors to quickly navigate back to a previous section or the root page.
	 *
	 * @param  [boolean] $show_on_home [true if breadcrumb is to be shown on homepage].
	 * @param  [string]  $delimiter [breadcrumb separator].
	 * @since Helena 0.1
	 */
	function helena_custom_breadcrumbs( $show_on_home, $delimiter ) {
		/* === OPTIONS === */
		$text['home']     = esc_html__( 'Home', 'helena' ); // text for the 'Home' link
		$text['category'] = esc_html__( '%1$s Archive for %2$s', 'helena' ); // text for a category page
		$text['search']   = esc_html__( '%1$sSearch results for: %2$s', 'helena' ); // text for a search results page
		$text['tag']      = esc_html__( '%1$sPosts tagged %2$s', 'helena' ); // text for a tag page
		$text['author']   = esc_html__( '%1$sView all posts by %2$s', 'helena' ); // text for an author page
		$text['404']      = esc_html__( 'Error 404', 'helena' ); // text for the 404 page

		$show_current = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$before      = '<span class="breadcrumb-current">'; // tag before the current crumb
		$after       = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post, $paged, $page;
		$home_link   = home_url( '/' );
		$link_before = '<span class="breadcrumb" typeof="v:Breadcrumb">';
		$link_after  = '</span>';
		$link_attr   = ' rel="v:url" property="v:title"';
		$link       = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s ' . $delimiter . '</a>' . $link_after;

		if ( is_front_page() ) {

			if ( $show_on_home ) {
				echo '<div id="breadcrumb-list" class="clear">
					<div class="wrapper clear">';

					echo $link_before . '<a href="' . esc_url( $home_link ) . '">' . $text['home'] . '</a>' . $link_after;

					echo '</div><!-- .wrapper -->
				</div><!-- #breadcrumb-list -->';
			}
		} else {
			echo '<div id="breadcrumb-list" class="clear">
					<div class="wrapper clear">';

			echo sprintf( $link, esc_url( $home_link ), $text['home'] );

			if ( is_home() ) {
				if ( $show_current ) {
					echo $before . get_the_title( get_option( 'page_for_posts', true ) ) . $after;
				}
			} elseif ( is_category() ) {
				$this_cat = get_category( get_query_var( 'cat' ), false );

				if ( 0 != $this_cat->parent ) {
					$cats = get_category_parents( $this_cat->parent, true, false );
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', $delimiter . '</a>' . $link_after, $cats );
					echo $cats;
				}
				echo $before . sprintf( $text['category'], '<span class="archive-text">', '&nbsp</span>' . single_cat_title( '', false ) ) . $after;

			} elseif ( is_search() ) {
				echo $before . sprintf( $text['search'], '<span class="search-text">', '&nbsp</span>' . get_search_query() ) . $after;

			} elseif ( is_day() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) );
				echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) );
				echo $before . get_the_time( 'd' ) . $after;

			} elseif ( is_month() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) );
				echo $before . get_the_time( 'F' ) . $after;

			} elseif ( is_year() ) {
				echo $before . get_the_time( 'Y' ) . $after;
			} elseif ( is_single() && ! is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;
					printf( $link, esc_url( $home_link ) . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );

					if ( $show_current ) {
						echo $before . get_the_title() . $after;
					}
				} else {
					$cat  = get_the_category();
					$cat  = $cat[0];
					$cats = get_category_parents( $cat, true, '' );
					if ( ! $show_current ) {
						$cats = preg_replace( '#^(.+)$#', '$1', $cats );
					}
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', $delimiter . '</a>' . $link_after, $cats );
					echo $cats;
					if ( $show_current ) {
						echo $before . get_the_title() . $after;
					}
				}
			} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				echo $before . $post_type->labels->singular_name . $after;
			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat    = get_the_category( $parent->ID );

				if ( isset( $cat[0] ) ) {
					$cat = $cat[0];
				}

				if ( $cat ) {
					$cats = get_category_parents( $cat, true );
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', $delimiter . '</a>' . $link_after, $cats );
					echo $cats;
				}

				printf( $link, get_permalink( $parent ), $parent->post_title );

				if ( $show_current ) {
					echo $before . get_the_title() . $after;
				}
			} elseif ( is_page() && ! $post->post_parent ) {
				if ( $show_current ) {
					echo $before . get_the_title() . $after;
				}
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page_child    = get_post( $parent_id );
					$breadcrumbs[] = sprintf( $link, get_permalink( $page_child->ID ), get_the_title( $page_child->ID ) );
					$parent_id     = $page_child->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo $breadcrumbs[ $i ];
				}
				if ( $show_current ) {
					echo $before . get_the_title() . $after;
				}
			} elseif ( is_tag() ) {
				echo $before . sprintf( $text['tag'], '<span class="tag-text">', '&nbsp</span>' . single_tag_title( '', false ) ) . $after;
			} elseif ( is_author() ) {
				global $author;

				$userdata = get_userdata( $author );

				echo $before . sprintf( $text['author'], '<span class="author-text">', '&nbsp</span>' . $userdata->display_name ) . $after;
			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}
				echo sprintf( esc_html__( 'Page %s', 'helena' ), max( $paged, $page ) );
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ')';
				}
			}

			echo '</div><!-- .wrapper -->
			</div><!-- #breadcrumb-list -->';
		}
	} // end helena_breadcrumb_lists
endif;