<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Helena
 */

/**
 * Get Values from theme options, append default values if not present
 *
 * @param  [text] $value [option name].
 * @return [type]        [value of option].
 */
function helena_get_option( $value ) {
	return get_theme_mod( $value, helena_get_default_theme_options( $value ) );
}
add_filter( 'helena_get_option', 'helena_get_option' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function helena_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Archive Content Image Layout.
	$content_layout = apply_filters( 'helena_get_option', 'content_layout' );

	$classes[] = $content_layout;

	// Adds a class of helena-masonry to the body if Masonry is used.
	if ( 'excerpt-image-top' == $content_layout && ( is_archive() || is_home() ) ) {
		$classes[] = 'helena-masonry';
	}

	$layout = helena_get_theme_layout();

	switch ( $layout ) {
		case 'right-sidebar':
			$classes[] = 'layout-two-columns content-left';
		break;

		case 'no-sidebar-full-width':
			$classes[] = 'layout-one-column no-sidebar full-width';
		break;
	}

	// Social Icon's Brand Color Options.
	$social_icon_brand_color = apply_filters( 'helena_get_option', 'social_icon_brand_color' );

	if ( 'hover' == $social_icon_brand_color ) {
		$classes[] = 'social-brand-hover';
	} elseif ( 'hover-static' == $social_icon_brand_color ) {
		$classes[] = 'social-brand-static';
	}

	$classes[] = 'primary-menu-search';

	return $classes;
}
add_filter( 'body_class', 'helena_body_classes' );


if ( ! function_exists( 'helena_post_classes' ) ) :
	/**
	 * Adds Helena post classes to the array of post classes.
	 * used for supporting different content layouts
	 *
	 * @param  [array] $classes [body classes].
	 * @return [array] $classes [returned new body classes array]
	 *
	 * @since Helena 0.1
	 */
	function helena_post_classes( $classes ) {
		// Getting Ready to load data from Theme Options Panel.
		$content_layout = apply_filters( 'helena_get_option', 'content_layout' );

		if ( is_archive() || is_home() ) {
			$classes[] = $content_layout;
		}

		return $classes;
	}
endif; // helena_post_classes.
add_filter( 'post_class', 'helena_post_classes' );


/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since Helena 0.1
 */
function helena_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'footer-1' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'footer-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'footer-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'footer-4' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class ) {
		echo 'class="' . esc_attr( $class ) . '"';
	}
}


if ( ! function_exists( 'helena_get_theme_layout' ) ) :
	/**
	 * Returns Theme Layout prioritizing the meta box layouts
	 *
	 * @uses  get_theme_mod
	 *
	 * @action wp_head
	 *
	 * @since Helena 0.1
	 */
	function helena_get_theme_layout() {
		$id = '';

		global $post, $wp_query;

	    // Front page displays in Reading Settings.
		$page_on_front  = get_option( 'page_on_front' );
		$page_for_posts = get_option( 'page_for_posts' );

		// Get Page ID outside Loop.
		$page_id = $wp_query->get_queried_object_id();

		// Blog Page or Front Page setting in Reading Settings.
		if ( $page_id == $page_for_posts || $page_id == $page_on_front ) {
	        $id = $page_id;
	    } elseif ( is_singular() ) {
	 		if ( is_attachment() ) {
				$id = $post->post_parent;
			} else {
				$id = $post->ID;
			}
		}

		// Get appropriate metabox value of layout.
		if ( '' != $id ) {
			$layout = get_post_meta( $id, 'helena-layout-option', true );
		} else {
			$layout = 'default';
		}

		// Check empty and load default.
		if ( empty( $layout ) || 'default' == $layout ) {
			if ( ! is_front_page() && ( is_single() || is_page() ) ) {
				$layout = apply_filters( 'helena_get_option', 'single_page_post_layout' );
			} else {
				$layout = apply_filters( 'helena_get_option', 'theme_layout' );
			}
		}

		return $layout;
	}
endif; //helena_get_theme_layout


if ( ! function_exists( 'helena_excerpt_length' ) ) :
    /**
     * Sets the post excerpt length to n words.
     *
     * function tied to the excerpt_length filter hook.
     * @uses filter excerpt_length
     *
     * @since Helena 1.3.1
     */
    function helena_excerpt_length( $length ) {
        $length  = apply_filters( 'helena_get_option', 'excerpt_length' );
        
        return $length;
    }
endif; //helena_excerpt_length
add_filter( 'excerpt_length', 'helena_excerpt_length' );


if ( ! function_exists( 'helena_continue_reading' ) ) :
    /**
     * Returns a "Custom Continue Reading" link for excerpts
     *
     * @since Helena 1.3.1
     */
    function helena_continue_reading() {
        $more_tag_text = apply_filters( 'helena_get_option', 'excerpt_more_text' );

        return ' <div class="more-button"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $more_tag_text . '</a></div>';
    }
endif; //helena_continue_reading
add_filter( 'excerpt_more', 'helena_continue_reading' );

if ( ! function_exists( 'helena_custom_excerpt' ) ) :
    /**
     * Adds Continue Reading link to more tag excerpts.
     *
     * function tied to the get_the_excerpt filter hook.
     *
     * @since Helena 1.3.1
     */
    function helena_custom_excerpt( $output ) {
        if ( has_excerpt() && ! is_attachment() ) {
            $output .= helena_continue_reading();
        }
        return $output;
    }
endif; //helena_custom_excerpt
add_filter( 'get_the_excerpt', 'helena_custom_excerpt' );


if ( ! function_exists( 'helena_more_link' ) ) :
    /**
     * Replacing Continue Reading link to the_content more.
     *
     * function tied to the the_content_more_link filter hook.
     *
     * @since Helena 1.3.1
     */
    function helena_more_link( $more_link, $more_link_text ) {
        $more_tag_text = apply_filters( 'helena_get_option', 'excerpt_more_text' );

        return str_replace( $more_link_text, $more_tag_text, $more_link );
    }
endif; //helena_more_link
add_filter( 'the_content_more_link', 'helena_more_link', 10, 2 );

if ( ! function_exists( 'helena_custom_css' ) ) :
/**
 * Enqueue Custom CSS
 *
 * @uses  get_theme_mod
 *
 * @action wp_head
 *
 * @since Helena 0.1
 */
function helena_custom_css() {
	if ( ( !$output = get_transient( 'helena_custom_css' ) ) ) {
			echo '<!-- refreshing cache -->' . "\n";

			$text_color = get_header_textcolor();

			if (  get_theme_support( 'custom-header', 'default-text-color' ) !== '#' . $text_color ) {
				$output .= " .site-title a { color: #" .  esc_attr( $text_color ) . "; }" . "\n";
			}

			/* Custom CSS Option */
			$custom_css = apply_filters( 'helena_get_option', 'custom_css' );

			if ( $custom_css ) {
				$output	.= $custom_css . "\n";
			}

			if ( '' != $output ){
				$output = '<!-- '.get_bloginfo('name').' inline CSS Styles -->' . "\n" . '<style type="text/css" media="screen">' . "\n" . $output;

				$output .= '</style>' . "\n";
			}

			set_transient( 'helena_custom_css', $output, 86940 );
		}
	echo $output;
}
endif; //helena_custom_css
add_action( 'wp_head', 'helena_custom_css', 101 );

/**
 * Alter the query for the main loop in homepage
 *
 * @action pre_get_posts
 *
 * @since Helena 0.1
 */
function helena_alter_home( $query ){
	if ( $query->is_main_query() && $query->is_home() ) {
		$cats                = (array) apply_filters( 'helena_get_option', 'front_page_category' );

		if ( !in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}
	}
}
add_action( 'pre_get_posts','helena_alter_home' );

/**
 * Return footer content
 *
 * @since Helena 0.1
 *
 */
function helena_footer_content() {
	if ( ! $output = get_transient( 'helena_footer_content' ) ) {
		$output = helena_get_content();

		set_transient( 'helena_footer_content', $output, 86940 );
	}

    echo $output;
}
add_action( 'helena_footer', 'helena_footer_content', 60 );

if ( ! function_exists( 'helena_scrollup' ) ) {
	/**
	 * This function loads Scroll Up Navigation
	 */
	function helena_scrollup() {
		$disable_scrollup = apply_filters( 'helena_get_option', 'disable_scrollup' );

		if ( $disable_scrollup ) {
			//Bail if scroll up is disabled
			return;
		}

		echo '<a href="#masthead" id="scrollup"><span class="screen-reader-text">' . esc_html__( 'Scroll Up', 'helena' ) . '</span></a>' ;
	}
}
add_action( 'wp_footer', 'helena_scrollup', 10 );

/**
 * Return registered image sizes.
 *
 * Return a two-dimensional array of just the additionally registered image sizes, with width, height and crop sub-keys.
 *
 * @since Helena 0.1
 *
 * @global array $_wp_additional_image_sizes Additionally registered image sizes.
 *
 * @return array Two-dimensional, with width, height and crop sub-keys.
 */
function helena_get_additional_image_sizes() {
	global $_wp_additional_image_sizes;

	if ( $_wp_additional_image_sizes ) {
		return $_wp_additional_image_sizes;
	}

	return array();
}

if ( ! function_exists( 'helena_get_meta' ) ) :
	/**
	 * Returns HTML with meta information for the categories, tags, date and author.
	 *
	 * @param [boolean] $hide_category Adds screen-reader-text class to category meta if true
	 * @param [boolean] $hide_tags Adds screen-reader-text class to tag meta if true
	 * @param [boolean] $hide_posted_by Adds screen-reader-text class to date meta if true
	 * @param [boolean] $hide_author Adds screen-reader-text class to author meta if true
	 *
	 * @since Helena 0.1
	 */
	function helena_get_meta( $hide_category = false, $hide_tags = false, $hide_posted_by = false, $hide_author = false ) {
		$output = '<p class="entry-meta">';

		if ( 'post' == get_post_type() ) {

			$class = $hide_category ? 'screen-reader-text' : '';

			$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'helena' ) );
			if ( $categories_list && helena_categorized_blog() ) {
				$output .= sprintf( '<span class="cat-links ' . $class . '">%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Categories</span>', 'Used before category names.', 'helena' ) ),
					$categories_list
				);
			}

			$class = $hide_tags ? 'screen-reader-text' : '';

			$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'helena' ) );
			if ( $tags_list ) {
				$output .= sprintf( '<span class="tags-links ' . $class . '">%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Tags</span>', 'Used before tag names.', 'helena' ) ),
					$tags_list
				);
			}

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

			$class = $hide_posted_by ? 'screen-reader-text' : '';

			$output .= sprintf( '<span class="posted-on ' . $class . '">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
				sprintf( _x( '<span class="screen-reader-text">Posted on</span>', 'Used before publish date.', 'helena' ) ),
				esc_url( get_permalink() ),
				$time_string
			);

			if ( is_singular() || is_multi_author() ) {
				$class = $hide_author ? 'screen-reader-text' : '';

				$output .= sprintf( '<span class="bypostauthor byline ' . $class . '"><span class="author vcard">%1$s<a class="url fn n" href="%2$s">%3$s</a></span></span>',
					sprintf( _x( '<span class="screen-reader-text">Author</span>', 'Used before post author name.', 'helena' ) ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_html( get_the_author() )
				);
			}
		}

		$output .= '</p><!-- .entry-meta -->';

		return $output;
	}
endif; //helena_get_meta

/**
 * Display Multiple Select type for and array of categories
 *
 * @param  [string] $name  [field name]
 * @param  [string] $id    [field_id]
 * @param  [array] $selected    [selected values]
 * @param  string $label [label of the field]
 */
function helena_dropdown_categories( $name, $id, $selected, $label = '' ) {
	$dropdown = wp_dropdown_categories(
		array(
			'name'             => $name,
			'echo'             => 0,
			'hide_empty'       => false,
			'show_option_none' => false,
			'hierarchical'       => 1,
		)
	);

	if ( '' != $label ) {
		echo '<label for="' . $id . '">
			'. $label .'
			</label>';
	}

	$dropdown = str_replace('<select', '<select multiple = "multiple" style = "height:120px; width: 100%" ', $dropdown );

	foreach( $selected as $selected ) {
		$dropdown = str_replace( 'value="'. $selected .'"', 'value="'. $selected .'" selected="selected"', $dropdown );
	}

	echo $dropdown;

	echo '<span class="description">'. esc_html__( 'Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.', 'helena' ) . '</span>';
}

/**
 * Flush out all transients
 *
 * @uses delete_transient
 *
 * @action customize_save, helena_customize_preview (see helena_customizer function: helena_customize_preview)
 *
 * @since Helena 0.1
 */
function helena_flush_transients(){
	delete_transient( 'helena_header_highlight_content' );
	delete_transient( 'helena_featured_slider' );
	delete_transient( 'helena_hero_content' );
	delete_transient( 'helena_featured_content' );
	delete_transient( 'helena_portfolio' );
	delete_transient( 'helena_logo_slider' );
	delete_transient( 'helena_custom_css' );
	delete_transient( 'helena_footer_content' );
	delete_transient( 'helena_promotion_headline' );
	delete_transient( 'helena_social_icons' );
	delete_transient( 'helena_scrollup' );
	delete_transient( 'all_the_cool_cats' );
	delete_transient( 'helena_categories' );
}
add_action( 'customize_save', 'helena_flush_transients' );
add_action( 'customize_preview_init', 'helena_flush_transients' );

/**
 * Flush out all transients on post save
 *
 * @uses delete_transient
 *
 * @action save_post
 *
 * @since Helena Pro 1.0
 */
function helena_flush_post_transients(){
	delete_transient( 'helena_header_highlight_content' );
	delete_transient( 'helena_featured_slider' );
	delete_transient( 'helena_hero_content' );
	delete_transient( 'helena_featured_content' );
	delete_transient( 'helena_portfolio' );
	delete_transient( 'helena_logo_slider' );
	delete_transient( 'helena_promotion_headline' );
	delete_transient( 'all_the_cool_cats' );
	delete_transient( 'helena_categories' );
}
add_action( 'save_post', 'helena_flush_post_transients' );

if ( ! function_exists( 'helena_page_post_meta' ) ) :
	/**
	 * Post/Page Meta for Google Structure Data
	 */
	function helena_page_post_meta() {
		$helena_author_url = esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) );

		$helena_page_post_meta = '<span class="post-time">' . esc_html__( 'Posted on', 'helena' ) . ' <time class="entry-date updated" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" pubdate>' . esc_html( get_the_date() ) . '</time></span>';
	    $helena_page_post_meta .= '<span class="post-author">' . esc_html__( 'By', 'helena' ) . ' <span class="author vcard"><a class="url fn n" href="' . $helena_author_url . '" title="View all posts by ' . get_the_author() . '" rel="author">' .get_the_author() . '</a></span>';

		return $helena_page_post_meta;
	}
endif; //helena_page_post_meta

if ( ! function_exists( 'helena_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since 2.4.1
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function helena_truncate_phrase( $text, $max_characters ) {
		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //helena_truncate_phrase


if ( ! function_exists( 'helena_get_the_content_limit' ) ) :
	/**
	 * Return content stripped down and limited content.
	 *
	 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
	 *
	 * @since 2.4.1
	 *
	 * @param integer $max_characters The maximum number of characters to return.
	 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)" .
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 *
	 * @return string Limited content.
	 */
	function helena_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {
		$content = get_the_content( '', $stripteaser );

		//* Strip tags and shortcodes so the content truncation count is done correctly
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		//* Remove inline styles / scripts
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		//* Truncate $content to $max_char
		$content = helena_truncate_phrase( $content, $max_characters );

		//* More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '<span class="more-button"><a href="%s">%s</a></span>', esc_url ( get_permalink() ), $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		return apply_filters( 'helena_get_the_content_limit', $output, $content, $link, $max_characters );

	}
endif; //helena_get_the_content_limit

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Helena 0.1
 */

function helena_get_first_image( $postID, $size, $attr ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if ( isset( $matches [1] [0] ) ) {
		//Get first image
		$first_img = $matches [1] [0];

		return '<img class="pngfix wp-post-image" src="'. $first_img .'">';
	}

	return false;
}

/**
 * Enqueue scripts and styles for Metaboxes
 * @uses wp_register_script, wp_enqueue_script, and  wp_enqueue_style
 *
 * @action admin_print_scripts-post-new, admin_print_scripts-post, admin_print_scripts-page-new, admin_print_scripts-page
 *
 * @since Helena 0.1
 */
function helena_enqueue_metabox_scripts() {
    //Scripts
	wp_enqueue_script( 'helena-metabox', get_template_directory_uri() . '/js/metabox.min.js', array( 'jquery' , 'jquery-ui-tabs' ), '2013-10-05' );

	//CSS Styles
	wp_enqueue_style( 'helena-metabox-tabs', get_template_directory_uri() . '/css/metabox-tabs.css' );
}
add_action( 'admin_print_scripts-post-new.php', 'helena_enqueue_metabox_scripts', 11 );
add_action( 'admin_print_scripts-post.php', 'helena_enqueue_metabox_scripts', 11 );
add_action( 'admin_print_scripts-page-new.php', 'helena_enqueue_metabox_scripts', 11 );
add_action( 'admin_print_scripts-page.php', 'helena_enqueue_metabox_scripts', 11 );

if ( ! function_exists( 'helena_archive_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply create your own helena_archive_content_image(), and that function will be used instead.
	 *
	 * @since Helena 0.1
	 */
	function helena_archive_content_image() {
		$featured_image = apply_filters( 'helena_get_option', 'content_layout' );

		if ( has_post_thumbnail() && 'full-content' != $featured_image ) { ?>
			<a class="post-thumbnail" aria-hidden="true" href="<?php echo esc_url( get_permalink() ); ?>">
				<?php
					the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
				?>
			</a>
	   	<?php
		}
	}
endif; //helena_archive_content_image
add_action( 'helena_before_entry_container', 'helena_archive_content_image', 10 );

if ( ! function_exists( 'helena_single_content_image' ) ) :
	/**
	 * Template for Featured Image in Single Post
	 *
	 * To override this in a child theme
	 * simply create your own helena_single_content_image(), and that function will be used instead.
	 *
	 * @since Helena 0.1
	 */
	function helena_single_content_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		if ( $post ) {
	 		if ( is_attachment() ) {
				$parent = $post->post_parent;
				$individual_featured_image = get_post_meta( $parent, 'helena-featured-image', true );
			} else {
				$individual_featured_image = get_post_meta( $page_id, 'helena-featured-image', true );
			}
		}

		if ( empty( $individual_featured_image ) || ( !is_page() && !is_single() ) ) {
			$individual_featured_image = 'default';
		}

		// Getting data from Theme Options
	   	$featured_image = apply_filters( 'helena_get_option', 'single_post_image_layout' );

		if ( ( 'disable' == $individual_featured_image  || '' == get_the_post_thumbnail() || ( 'default' == $individual_featured_image  && 'disabled' == $featured_image ) ) ) {
			//Bail if featured image is disabled
			return;
		}

		$class = array();

		if ( 'default' == $individual_featured_image ) {
			$class[] = $featured_image;
		}
		else {
			$class[] = 'from-metabox ';
			$class[] = $featured_image = $individual_featured_image;
		}

		?>
		<div class="entry-thumbnail <?php echo esc_attr( implode( ' ', $class ) ); ?>">
            <?php the_post_thumbnail( $featured_image ); ?>
        </div><!-- .entry-thunbnail -->
	   	<?php
	}
endif; //helena_single_content_image
add_action( 'helena_post_thumbnail', 'helena_single_content_image', 10 );

/**
 * Converts a HEX value to RGB.
 *
 * @since Helena 0.1
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function helena_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}


/**
 * Migrate Custom CSS to WordPress core Custom CSS
 *
 * Runs if version number saved in theme_mod "custom_css_version" doesn't match current theme version.
 */
function helena_custom_css_migrate(){
	$ver = get_theme_mod( 'custom_css_version', false );

	// Return if update has already been run
	if ( version_compare( $ver, '4.7' ) >= 0 ) {
		return;
	}

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
	    // Migrate any existing theme CSS to the core option added in WordPress 4.7.

	    /**
		 * Get Theme Options Values
		 */
	    $custom_css = apply_filters( 'helena_get_option', 'custom_css' );

	    if ( '' != $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return   = wp_update_custom_css_post( $core_css . $custom_css );
	        if ( ! is_wp_error( $return ) ) {
	            // Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
	            remove_theme_mod( 'custom_css' );

	            // Update to match custom_css_version so that script is not executed continously
				set_theme_mod( 'custom_css_version', '4.7' );
	        }
	    }
	}
}
add_action( 'after_setup_theme', 'helena_custom_css_migrate' );