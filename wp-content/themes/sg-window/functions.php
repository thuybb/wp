<?php
/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
*/

/**
 * Set up the content width value.
 *
 * @since SG Window 1.0.0
 */
      
if ( ! isset( $content_width ) ) {
	$content_width = 1280;
}

if ( ! isset( $sgwindow_sidebars ) ) {
	$sgwindow_sidebars = array();
}

if ( ! function_exists( 'sgwindow_setup' ) ) :

/**
 * sgwindow setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * @since SG Window 1.0.0
 */

function sgwindow_setup() {

	load_theme_textdomain( 'sg-window', get_template_directory() . '/languages' );
	
	$defaults = sgwindow_get_defaults();
	
	global $sgwindow_sidebar_slug;
	$sgwindow_sidebar_slug = null;
	
	/* new */
	global $sgwindow_widget_sidebars;
	$sgwindow_widget_sidebars = array();

	/* default values */
	global $sgwindow_defaults;
	$sgwindow_defaults = null;

	/* custom layouts */
	global $sgwindow_layout_class;
	$sgwindow_layout_class = new sgwindow_Layout_Class();	
	
	/* custom colors */
	global $sgwindow_colors_class;
	$sgwindow_colors_class = new sgwindow_Colors_Class();	
		
	if ( get_theme_mod( 'is_show_top_menu', $defaults ['is_show_top_menu']) == '1' )
		register_nav_menu( 'top1', __( 'First Top Menu', 'sg-window' ));
	if ( get_theme_mod( 'is_show_secont_top_menu', $defaults ['is_show_secont_top_menu']) == '1' )
		register_nav_menu( 'top2', __( 'Second Top Menu', 'sg-window' ));
	if ( get_theme_mod( 'is_show_footer_menu', $defaults ['is_show_footer_menu']) == '1' )
		register_nav_menu( 'footer', __( 'Footer Menu', 'sg-window' ));
	
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'custom-background', array(
		'default-color' => 'cccccc',
	) );

	add_theme_support( 'post-thumbnails' );
	
	set_post_thumbnail_size( sgwindow_get_theme_mod( 'post_thumbnail_size' ) , 9999 ); 
	
	$args = array(
		'default-image'          => '',
		'header-text'            => true,
		'default-text-color'     => sgwindow_text_color(get_theme_mod('color_scheme'), $defaults ['color_scheme']),
		'width'                  => absint( sgwindow_get_theme_mod('size_image') ),
		'height'                 => absint( sgwindow_get_theme_mod('size_image_height') ),
		'flex-height'            => true,
		'flex-width'             => true,
	);
	add_theme_support( 'custom-header', $args );
	
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'caption'
	) );
	
	add_theme_support( 'title-tag' );
	
	/*
	 * Enable support for WooCommerce plugin.
	 */
	 
	add_theme_support( 'woocommerce' );
	
	/*
	 * Enable support for Jetpack Portfolio custom post type.
	 */
	 
	add_theme_support( 'jetpack-portfolio' );

}
add_action( 'after_setup_theme', 'sgwindow_setup' );
endif;

if ( ! function_exists( '_wp_render_title_tag' ) ) :
/**
 *  Backwards compatibility for older versions (4.1)
 * 
 * @since SG Window 1.0.0
 */
	function sgwindow_render_title() {
	?>
		 <title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
	}
	add_action( 'wp_head', 'sgwindow_render_title' );
	
/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since SG Window 1.0.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function sgwindow_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'sg-window' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'sgwindow_wp_title', 10, 2 );
	
endif;

/**
 * Return the Google font stylesheet URL if available.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_get_font_url() {
	$font_url = '';
	$font = str_replace( ' ', '+', sgwindow_get_theme_mod( 'body_font' ) );
	$heading_font = str_replace( ' ', '+', sgwindow_get_theme_mod( 'heading_font' ) );
	$header_font = str_replace( ' ', '+', sgwindow_get_theme_mod( 'header_font' ) );
	if ( '0' == $font && '0' == $heading_font && '0' == $header_font ) 
		return $font_url;
		
	if ( '0' != $font && '0' != $heading_font )
		$font .= '%7C';
		
	$font .= $heading_font;	
	
	if ( '0' != $font && '0' != $header_font )
		$font .= '%7C';

	$font .= $header_font;
	
	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, Alegreya Sans, Allerta Stencil fonts, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans, Allerta Stencil, Alegreya Sans fonts: on or off', 'sg-window' ) ) {
		$subsets = 'latin,latin-ext';
		$family = $font . ':300,400';

		/* translators: To add an additional Open Sans character subset specific to your language,	
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Font: add new subset (greek, cyrillic, vietnamese)', 'sg-window' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		}
		if ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		}
		elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		$query_args = array(
			'family' => $family,
			'subset' => $subsets,
		);
		$font_url = "//fonts.googleapis.com/css?family=" . $family . '&' . $subsets;
		
	}

	return $font_url;
}
/**
 * Enqueue scripts and styles for front-end.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_scripts_styles() {

	$defaults = sgwindow_get_defaults();
	
	// Add Genericons font.
	wp_enqueue_style( 'sgwindow-genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '05.08.2015' );
	
	$font_url = sgwindow_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'sgwindow-fonts', esc_url_raw( $font_url ), array(), null );
		
	// Loads our main stylesheet.
	wp_enqueue_style( 'sgwindow-style', get_stylesheet_uri(), array(), '05.08.2015' );

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		
	// Adds JavaScript for handing the navigation menu and top sidebars hide-and-show behavior.
	wp_enqueue_script( 'sgwindow-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '2015321', true );
	
	global $sgwindow_colors_class;
	
	wp_enqueue_style( 'sgwindow-colors', get_template_directory_uri() . '/css/scheme-' . esc_attr( sgwindow_get_theme_mod( 'color_scheme', $defaults['color_scheme'] ) ) . '.css', array(), '05.08.2015' );
	
	wp_enqueue_script( 'sgwindow-parallax', get_template_directory_uri() . '/js/parallax.js', array( 'jquery'), '05.08.2015', true );

}
add_action( 'wp_enqueue_scripts', 'sgwindow_scripts_styles' );
 
/**
 * Add Editor styles and fonts to Tiny MCE
 *
 * @since SG Window 1.0.0
 */
function sgwindow_add_editor_styles() {
	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css' ) );
	
	$font_url = sgwindow_get_font_url();
	if ( ! empty( $font_url ) )
		 add_editor_style( $font_url );
}
add_action( 'after_setup_theme', 'sgwindow_add_editor_styles' );

/**
 * Extend the default WordPress body classes.
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 *
 * @since SG Window 1.0.0
 */

function sgwindow_body_class( $classes ) {

	$background_color = get_background_color();
	$background_image = get_background_image();
	
	$defaults = sgwindow_get_defaults();
	
	if(sgwindow_get_theme_mod('image_style') == 'boxed'){
		$classes[] = 'boxed-image';
	}	
	if(sgwindow_get_theme_mod('content_style') == 'boxed'){
		$classes[] = 'boxed-content';
		$classes[] = 'boxed-header';
	}	
	/* new */
	if(sgwindow_get_theme_mod('site_style') == 'boxed'){
		$classes[] = 'boxed-site';
	}
	
	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) )
			$classes[] = 'custom-background';
		elseif ( in_array( $background_color, array( 'ccc', 'cccccc' ) ) )
			$classes[] = 'custom-background';
	}
	
	// Enable custom class only if the header text enabled.
	if ( display_header_text() ) {
		$classes[] = 'header-text-is-on';
	}	
	
	if( is_front_page() && '' == sgwindow_get_theme_mod('front_page_style') && ! is_home() ) {
		$classes[] = 'no-content';
	}
	
	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'sgwindow-fonts', 'queue' ) )
		$classes[] = 'google-fonts-on';

	// Enable custom class only if the logotype is active.
	if ( get_theme_mod( 'logotype_url', $defaults['logotype_url'] ) != '' ) 
		$classes[] = 'logo-is-on';	

	return $classes;
}
add_filter( 'body_class', 'sgwindow_body_class' );

/**
 * Create not empty title
 *
 * @since SG Window 1.0.0
 *
 * @param string $title Default title text.
 * @param int $id.
 * @return string The filtered title.
 */
function sgwindow_title( $title, $id = null ) {

    if ( trim($title) == '' && (is_archive() || is_home() || is_search() ) ) {
        return ( esc_html( get_the_date() ) );
    }
	
    return $title;
}
add_filter( 'the_title', 'sgwindow_title', 10, 2 );

if ( ! function_exists( 'sgwindow_get_header' ) ) :

/**
 * Return default header image url
 *
 * @since SG Window 1.0.0
 *
 * @param string color_scheme color scheme.
 * @return string header url.
 */
function sgwindow_get_header( $color_scheme ) {

    return '';

}

endif;

if ( ! function_exists( 'sgwindow_text_color' ) ) :

/**
 * Return default header text color
 *
 * @since SG Window 1.0.0
 *
 * @param string color_scheme color scheme.
 * @return string header url.
 */
function sgwindow_text_color( $color_scheme ) {

	switch ($color_scheme) {
		case '0':
			$text_color = 'd0dff4';
		break;		
		case '1':
			$text_color = 'b7ba2a';
		break;
		default:
			$text_color = 'ffffff';
		break;
	}

    return $text_color;
}

endif;

if ( ! function_exists( 'sgwindow_post_nav' ) ) :
/**
 * Display navigation to next/previous post.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'sg-window' ); ?></h1>
		<div class="nav-link">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'sg-window' ) );
			else :
				$next = next_post_link( '%link ', __( '<span class="nav-next">%title &rarr;</span>', 'sg-window' ) );
				if ( $next ) :
					previous_post_link( '%link', __( '<span class="nav-previous">&larr; %title</span>', 'sg-window' ) );
					$next;
				else :
					previous_post_link( '%link', __( '<span class="nav-previous-one">&larr; %title</span>', 'sg-window' ) );
				endif;
				
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<div class="clear"></div>
	<?php
}
endif;

if ( ! function_exists( 'sgwindow_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_paging_nav() {

	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'sg-window' ),
		'next_text' => __( 'Next &rarr;', 'sg-window' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'sg-window' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
	
}
endif;

if ( ! function_exists( 'sgwindow_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_the_attached_image() {
	$post                = get_post();

	$attachment_size     = apply_filters( 'sgwindow_attachment_size', array( 987, 9999 ) );
	$next_attachment_url = wp_get_attachment_url();

	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'sgwindow_posted_on' ) ) :
/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_posted_on() {
	
	$is_author = ( is_singular() ? ( '1' == sgwindow_get_theme_mod( 'is_author' ) ? true : false ) : 
									( '1' == sgwindow_get_theme_mod( 'blog_is_author' ) ? true : false ) );
									
	$is_date = ( is_singular() ? ( '1' == sgwindow_get_theme_mod( 'is_date' ) ? true : false ) : 
									( '1' == sgwindow_get_theme_mod( 'blog_is_date' ) ? true : false ) );
									
	$is_comments = ( is_singular() ? ( '1' == sgwindow_get_theme_mod( 'is_comments' ) ? true : false ) : 
									( '1' == sgwindow_get_theme_mod( 'blog_is_comments' ) ? true : false ) );
									
	$is_views = ( is_singular() ? ( '1' == sgwindow_get_theme_mod( 'is_views' ) ? true : false ) : 
									( '1' == sgwindow_get_theme_mod( 'blog_is_views' ) ? true : false ) );
	$rez = '';
	// Set up and print post meta information.
	if ( $is_date ) {
	
		echo '<span class="entry-date">
					<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_date( '' ) ) . '" rel="bookmark">
						<span class="entry-date" datetime="' . esc_attr( get_the_date( '' ) ) . '">' . esc_html( get_the_date() ) .  '</span>
					</a>
			 </span>';
	}
	
	if ( $is_author ) {
	
		echo '<span class="byline">
				<span title="' . get_the_author() . '" class="author vcard">
					<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . get_the_author() . '</a>
				</span>
			</span>';
	}
	
	if ( $is_views ) {
	
		if( class_exists('Jetpack') && Jetpack::is_module_active('stats') && function_exists ( 'stats_get_csv' ) ) {
			$result = $result = stats_get_csv( 'postviews', 'post_id=' . get_the_ID() . '&days=-1&limit=-1&summarize');
			
			echo '<span class="post-views" title="' . number_format_i18n( $result[0]['views'] ) . '">' 
					. number_format_i18n( $result[0]['views'] ) .
			 '</span>';
			
		}
	}
	
	if ( $is_comments ) {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( __( 'Leave a comment', 'sg-window' ), __( '1 Comment', 'sg-window' ), __( '% Comments', 'sg-window' ) );
			echo '</span>';
		}

	}

}
endif;


if ( ! function_exists( 'sgwindow_content_width' ) ) :
/**
 * Adjust content width in certain contexts.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_content_width() {
	
	global $sgwindow_layout_class;
	global $content_width;
	
	$curr_layout = $sgwindow_layout_class->get_layout();
	$curr_content_layout = $sgwindow_layout_class->get_content_layout();
	$content_columns = preg_replace('/[^0-9]/','',$curr_content_layout);	
	$content_area_width = sgwindow_calc_content_width( $curr_layout );
	$content_width = sgwindow_calc_content_column_width ($content_area_width, $content_columns); 
}
add_action( 'template_redirect', 'sgwindow_content_width' );

endif;

if ( ! function_exists( 'sgwindow_calc_content_column_width' ) ) :
/**
 * Calculate width of the content area
 *
 * @param int width of content area.
 * @param int columns count.
 * @return int width of column.
 * @since SG Window 1.0.0
 */
function sgwindow_calc_content_column_width( $width, $columns ) {
	
	switch( $columns ) {
		case 1:
		break;	
		case 2:
			$width = $width/100*48;
		break;	
		case 3:
			$width = $width/100*30;
		break;	
		case 4:
			$width = $width/100*22;
		break;
	}
	$width = absint($width - 2); 
	
	return $width;
}
endif;

if ( ! function_exists( 'sgwindow_calc_content_width' ) ) :
/**
 * Calculate width of the content area
 *
 * @param string current layout.
 * @return int width of the content area.
 * @since SG Window 1.0.0
 */
function sgwindow_calc_content_width( $curr_layout ) {

	$content_width = (sgwindow_get_theme_mod( 'width_main_wrapper' ) > sgwindow_get_theme_mod( 'width_site' ) ? sgwindow_get_theme_mod( 'width_site' ) : sgwindow_get_theme_mod( 'width_main_wrapper' ) );
	$unit = sgwindow_get_theme_mod('unit');

	if( 'left-sidebar' == $curr_layout) {
		$content_width = $content_width - $content_width/100*sgwindow_get_theme_mod('width_column_1_left_rate') - 40;
	} 
	elseif( 'right-sidebar' == $curr_layout) {
		$content_width = $content_width - $content_width/100*sgwindow_get_theme_mod('width_column_1_right_rate') - 40;
	}
	elseif( 'two-sidebars' == $curr_layout) {
		$content_width = $content_width - $content_width/100*sgwindow_get_theme_mod('width_column_1_rate') - $content_width/100*sgwindow_get_theme_mod('width_column_2_rate') - 40;
	}
	else {
		$content_width -= 40;
	}

	$content_width = absint($content_width);
	return $content_width;
}
endif;
 /**
 * Return array default theme options
 *
 * @since SG Window 1.0.0
 */
 
function sgwindow_get_defaults() {

	global $sgwindow_defaults;
	
	if(isset($sgwindow_defaults)) {
		return $sgwindow_defaults;
	}
	
	$defaults = array();
	
	/* slider defaults */
	$defaults['slider_height'] = '80';
	$defaults['slider_margin'] = '33';
	$defaults['slider_play'] = '1';
	$defaults['slider_content_type'] = '0';
	$defaults['slider_speed'] = '500';
	$defaults['slider_delay'] = '4000';
	
	$defaults['is_thumbnail_empty_icon'] = '';
	
	$defaults['is_cat'] = '1';
	$defaults['is_author'] = '1';
	$defaults['is_date'] = '1';
	$defaults['is_views'] = '';
	$defaults['is_comments'] = '1';
	$defaults['blog_is_cat'] = '1';
	$defaults['blog_is_author'] = '1';
	$defaults['blog_is_date'] = '1';
	$defaults['blog_is_views'] = '';
	$defaults['blog_is_comments'] = '1';
	$defaults['blog_is_entry_meta'] = '';
	
	$defaults['is_sticky_first_menu'] = '';
	$defaults['is_sticky_second_menu'] = '';
	$defaults['site_style'] = 'full';
	$defaults['are_we_saved'] = '';
	$defaults['max_id'] = 0;
	
	$defaults['sidebar_widgets_count'] = '30';
	
	$defaults['is_defaults_post_thumbnail_background'] = '1';
	$defaults['is_parallax_header'] = '';
	$defaults['parallax_image_speed'] = 30;
	$defaults['parallax_image_height'] = 400;
	
	$defaults['logotype_url'] =  get_template_directory_uri() . '/img/logo.png';
	$defaults['is_show_top_menu'] = '1';
	$defaults['is_show_secont_top_menu'] = '1';
	$defaults['is_show_footer_menu'] = '';
	$defaults['column_background_url'] = get_template_directory_uri().'/img/back.jpg';	
	$defaults['post_thumbnail_size'] = '400';
	$defaults['scroll_button'] = 'none';
	$defaults['scroll_animate'] = 'none';
	$defaults['favicon'] = '';
	$defaults['is_header_on_front_page_only'] = '1';
	$defaults['body_font'] = 'Open Sans';
	$defaults['heading_font'] = 'Alegreya Sans';
	$defaults['header_font'] = 'Allerta Stencil';
	$defaults['body_font_size'] = '16';
	$defaults['heading_font_size'] = '36';
	$defaults['heading_weight'] = 'lighter';
	$defaults['color_scheme'] = 0;
	$defaults['is_second_menu_on_front_page_only'] = '';
	$defaults['is_text_on_front_page_only'] = '';
	$defaults['top'] = 'top';

	$defaults['front_page_style'] = '1';	
	$defaults['is_home_footer'] = '';
	$defaults['unit'] = 1;
	
	$defaults['width_site'] = '1680';
	$defaults['width_main_wrapper'] = '1200';
	$defaults['width_top_widget_area'] = '1680';
	$defaults['width_content_no_sidebar'] = '1680';	
	
	/* Header Image size */
	$defaults['size_image'] = '1680';
	$defaults['size_image_height'] = '400';
	/* Header Image and top sidebar wrapper */
	$defaults['width_image'] = '1680';
	$defaults['width_content'] = '1200';
	
	$defaults['header_style'] = 'full';
	$defaults['image_style'] = 'full';
	$defaults['content_style'] = 'full';
	
	$defaults['width_column_1_rate'] = '22';
	$defaults['width_column_1_left_rate'] = '34';
	$defaults['width_column_1_right_rate'] = '34';
	$defaults['width_column_2_rate'] = '22';
	
	/* post: excerpt/content */
	$defaults['single_style'] = '';
	$defaults['is_display_post_image'] = '1';
	$defaults['is_display_post_title'] = '1';
	$defaults['is_display_post_tags'] = '1';
	$defaults['is_display_post_cat'] = '1';

	/* page: excerpt/content */
	$defaults['page_style'] = '';
	$defaults['is_display_page_image'] = '1';
	$defaults['is_display_page_title'] = '1';
	
	/* portfolio: excerpt/content */
	$defaults['portfolio_style'] = 'excerpt';
	$defaults['is_display_portfolio_image'] = '1';
	$defaults['is_display_portfolio_title'] = '1';
	$defaults['is_display_portfolio_tags'] = '1';
	$defaults['is_display_portfolio_project'] = '1';
	
	$defaults['empty_image'] = get_template_directory_uri() . '/img/empty.png';;
	$defaults['footer_text'] = '<a href="' . __( 'http://wordpress.org/', 'sg-window' ) . '">' . __( 'Powered by WordPress', 'sg-window' ). '</a> | ' . __( 'theme ', 'sg-window' ) . '<a href="' .  __( 'http://wpblogs.ru/themes/blog/theme/sg-window/', 'sg-window') . '">SG Window</a>';
	
	$defaults['width_mobile_switch'] = '960';
	$defaults['columns_direction'] = 'c_1_2';
	$defaults['is_mobile_column_1'] = '1';
	$defaults['is_mobile_column_2'] = '1';

/* declare theme sidebars */

	$defaults['theme_sidebars']['column-1']  = array (
													'title' => __( 'First column', 'sg-window' ), 
													'is_checked' => '', 
													'is_constant' => '');
	$defaults['theme_sidebars']['column-2']  = array (
													'title' => __( 'Second column', 'sg-window' ), 
													'is_checked' => '', 
													'is_constant' => '');
	$defaults['theme_sidebars']['sidebar-top']  = array (
													'title' => __( 'First Top Sidebar', 'sg-window' ),
													'is_checked' => '',
													'is_constant' => '');	
	$defaults['theme_sidebars']['sidebar-before-footer']  = array (
													'title' => __( 'Before Footer Sidebar', 'sg-window' ), 
													'is_checked' => '', 
													'is_constant' => '');												
	$defaults['theme_sidebars']['sidebar-footer-1']  = array (
													'title' => __( 'Footer Sidebar 1', 'sg-window' ), 
													'is_checked' => '', 
													'is_constant' => '1');	
	$defaults['theme_sidebars']['sidebar-footer-2']  = array (
													'title' => __( 'Footer Sidebar 2', 'sg-window' ), 
													'is_checked' => '', 
													'is_constant' => '1');	
	$defaults['theme_sidebars']['sidebar-footer-3']  = array (
													'title' => __( 'Footer Sidebar 3', 'sg-window' ), 
													'is_checked' => '', 
													'is_constant' => '1');

	/* order is important */
	$defaults['defined_sidebars']['static'] = array(
											'use' => '1',
											'callback' => '',
											'param' => '', 
											'title' => __( 'Static', 'sg-window' ), 
											'sidebar-footer-1' => '1',
											);//Sidebars, visible on all posts and pages

	$defaults['defined_sidebars']['default'] = array(
											'use' => '1', 
											'callback' => '', 
											'param' => '', 
											'title' => __( 'Default', 'sg-window' ),
											'sidebar-top' => '1', 
											'column-1' => '1', 
											'column-2' => '1',
											'sidebar-before-footer' => '1',
											);
	
	$defaults['defined_sidebars']['page'] = array(
											'use' => '', 
											'callback' => 'is_page', 
											'param' => '', 
											'title' => __( 'Pages', 'sg-window' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '',
											'column-2' => '1', 
											);
	$defaults['defined_sidebars']['archive'] = array(
											'use' => '', 
											'callback' => 'is_archive', 
											'param' => '', 
											'title' => __( 'Archive', 'sg-window' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '1',
											'column-2' => '1', 
											);
	$defaults['defined_sidebars']['portfolio-page'] = array(
											'use' => '1', 
											'callback' => 'sgwindow_is_portfolio_page', 
											'param' => '', 
											'title' => __( 'Portfolio (Page)', 'sg-window' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '',
											'column-1' => '',
											'column-2' => '1', 
											);
	$defaults['defined_sidebars']['portfolio'] = array(
											'use' => '1', 
											'callback' => 'sgwindow_is_portfolio', 
											'param' => '', 
											'title' => __( 'Portfolio (Archive)', 'sg-window' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '1',
											'column-2' => '', 
											);
											
 	if ( defined ( 'SGWINDOW' ) ) :

	$defaults['defined_sidebars']['shop-page'] = array(
											'use' => '1', 
											'callback' => 'sgwindow_is_shop_page', 
											'param' => '', 
											'title' => __( 'Shop (Page)', 'sg-window' ),
											'sidebar-top' => '',
											'sidebar-before-footer' => '',
											'column-1' => '',
											'column-2' => '', 
											);	
	$defaults['defined_sidebars']['shop'] = array(
											'use' => '', 
											'callback' => 'sgwindow_is_shop', 
											'param' => '', 
											'title' => __( 'Shop (Archive)', 'sg-window' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '',
											'column-2' => '', 
											);
	endif;
	
	$defaults['defined_sidebars']['blog'] = array(
											'use' => '', 
											'callback' => 'is_home', 
											'param' => '', 
											'title' => __( 'Blog', 'sg-window' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '',
											'column-2' => '', 
											);
	$defaults['defined_sidebars']['search'] = array(
											'use' => '', 
											'callback' => 'is_search', 
											'param' => '',
											'title' => __( 'Search', 'sg-window' ),
											'sidebar-top' => '',
											'sidebar-before-footer' => '',
											'column-1' => '',
											'column-2' => '', 
											);
	$defaults['defined_sidebars']['home'] = array(
											'use' => '1', 
											'callback' => 'is_front_page', 
											'param' => '', 
											'title' => __( 'Home', 'sg-window' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '1',
											'column-1' => '1',
											'column-2' => '', 
											);
	$defaults['defined_sidebars']['page404'] = array(
											'use' => '1',
											'callback' => 'is_404',
											'param' => '',
											'title' => __( 'Page 404', 'sg-window' ),
											'sidebar-top' => '1',
											'sidebar-before-footer' => '',
											'column-1' => '1',
											'column-2' => '',
											);

	$defaults['per_page_sidebars'] = array();

	
	return apply_filters( 'sgwindow_option_defaults', $defaults );
}

 /**
 * Return theme mod
 *
 * @since SG Window 1.0.0
*/
function sgwindow_get_theme_mod( $name ) {
	$defaults = sgwindow_get_defaults();
	return apply_filters ( 'sgwindow_theme_mod', get_theme_mod( $name, $defaults[$name] ), $name );
}

/**
 * Convert given sidebar id to id from $defaults array
 *
 * @param string $sidebar_id sidebar id with page slug.
 * @return string slug of current sidebar.
 * @since SG Window 1.0.0
 */
function sgwindow_san_sidebar_id( $sidebar_id ) {
	$defaults = sgwindow_get_defaults();

	foreach( $defaults['theme_sidebars'] as $id => $value ) {

		if( '' != trim( $id ) && false !== strrpos($sidebar_id, $id)) {
			return $id;
		}

	}
	 return false;
}

/**
 * Return width of sidebar
 *
 * @param string $sidebar_id slug of current sidebar with page prefix.
 * @return int max width of sidebar.
 * @since SG Window 1.0.0
 */
function sgwindow_get_sidebar_width( $sidebar_id ) {
	$defaults = sgwindow_get_defaults();
	$width = 1366;
	$sidebar_id = sgwindow_san_sidebar_id( $sidebar_id );
	if( false == $sidebar_id)
		return $width;
				
	switch ( $sidebar_id ) {
		case 'sidebar-top':
			$width = sgwindow_get_theme_mod('width_site');
		break;
		case 'sidebar-before-footer':
			$width = sgwindow_get_theme_mod('width_site');
		break;
		case 'sidebar-footer':
			$width = sgwindow_get_theme_mod('width_main_wrapper')/3;
		break;
		case 'column-1':
			$width = 300;
		break;		
		case 'column-2':
			$width = 300;
		break;		
	}
		
	return $width;
}

/**
 * Return prefix for content-xxx.php file
 *
 * @since SG Window 1.0.0
 */
function sgwindow_get_content_prefix() {

	$post_type = get_post_type();
	$post_prefix = '';
	if( 'post' == $post_type) {
		$post_prefix = get_post_format();
	} else {
		$post_prefix = $post_type.'-'; 
	}
	if( is_search() || is_archive() || is_home() ) {
		$name = $post_prefix . ( '' == $post_prefix ? '' : '-') . 'archive';
		
		$located = locate_template( $name . '.php' );
		
		if ( ! empty( $located ) ) {
			return $name;
		} else {
			return 'archive';
		}
	}
	return get_post_format();

}

/**
 * Check for 'flex' prefix 
 *
 * @layout string content layout
 *
 * @since SG Window 1.0.0
 */
function sgwindow_content_class( $layout_content ) {
	$is_flex = strrpos($layout_content, 'flex');
	$layout_content = ( false === $is_flex ? $layout_content : 'flex '.$layout_content );
	return $layout_content;
}

 /**
 * Print credit links and scroll to top button
 *
 * @since SG Window 1.0.0
 */
function sgwindow_site_info() {
	$text = sgwindow_get_theme_mod( 'footer_text' );
	if ( '' != $text ) :
?>
		<div class="site-info">
			<?php echo wp_kses( $text, array(
									'a' => array(
										'href' => array(),
										'title' => array()
									),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
								)
								); ?>
		</div><!-- .site-info -->
	
	<?php endif; 
	
	if ( 'none' != sgwindow_get_theme_mod( 'scroll_button' ) ) : ?>
		<a href="#" class="scrollup <?php echo esc_attr( sgwindow_get_theme_mod( 'scroll_button' )).
			esc_attr( 'none' == sgwindow_get_theme_mod( 'scroll_animate' ) ? '' : ' ' . sgwindow_get_theme_mod( 'scroll_animate' ) ); ?>"></a>
	<?php endif;
}
add_action( 'sgwindow_site_info', 'sgwindow_site_info' );

/**
 * Print Favicon.
 *
 * @since SG Window 1.0.0
 */
function sgwindow_hook_favicon() {
	$defaults = sgwindow_get_defaults();
?>
	<?php if ( get_theme_mod( 'favicon', $defaults['favicon'] ) != '' ) : ?>
		<link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod( 'favicon', $defaults['favicon'] )); ?>" />
	<?php endif;
}
add_action('wp_head', 'sgwindow_hook_favicon');

 /**
 * Retrieve the array of ids of all terms for the current archive page 
 *
 * @param string $tax, taxonomy name
 * @since SG Window 1.0.0
 */
function sgwindow_get_tax_ids( $tax ) {
	$tax_names = array();
	
	while ( have_posts() ) : the_post(); 
			
		$terms = get_the_terms( get_the_ID(), $tax );
								
		if ( $terms && ! is_wp_error( $terms ) ) : 

			foreach ( $terms as $id => $term ) {
				$tax_names[ $term->term_id ] = $term->name;
			}

		endif;
		
	endwhile; 
	
	rewind_posts();

	return array_unique( $tax_names );
}

 /**
 * Retrieve the array of ids of terms from the current page
 *
 * @param string $tax, taxonomy name
 * @since SG Window 1.0.0
 */
function sgwindow_get_curr_tax_ids( $tax ) {
	$tax_names = array();
		
	$terms = get_the_terms( get_the_ID(), $tax );
							
	if ( $terms && ! is_wp_error( $terms ) ) : 

		foreach ( $terms as $term ) {
			$tax_names[] = $term->term_id;
		}

	endif;
			
	return array_unique( $tax_names );
}

 /**
 * Retrieve the array of names of terms from the current page
 *
 * @param string $tax, taxonomy name
 * @since SG Window 1.0.0
 */
function sgwindow_get_curr_tax_names( $tax ) {
	$tax_names = array();
		
	$terms = get_the_terms( get_the_ID(), $tax );
							
	if ( $terms && ! is_wp_error( $terms ) ) : 

		foreach ( $terms as $term ) {
			$tax_names[] = $term->name;
		}

	endif;
			
	return array_unique( $tax_names );
}

/**
 * Add new wrapper for woocommerce pages.
 *
 * @since SG Window 1.0.0
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'sgwindow_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'sgwindow_wrapper_end', 10);

function sgwindow_wrapper_start() {
  echo '<div id="woocommerce-wrapper">';
}

function sgwindow_wrapper_end() {
  echo '</div>';
}

/**
 * Change related products number
 *
 * @since SG Window 1.0.0
 */
add_filter( 'woocommerce_output_related_products_args', 'sgwindow_related_products_args' );
function sgwindow_related_products_args( $args ) {

	$args['posts_per_page'] = 3;
	$args['columns'] = 3;
	return $args;
}

/**
 * Echo column sidebars
 *
 * @param string $layout current layout
 *
 * @since SG Window 1.0.0
 */
function sgwindow_get_sidebar( $layout ) {

	if ( 'two-sidebars' == $layout ) {
		get_sidebar();
	} elseif ( 'right-sidebar' == $layout ) {
		get_sidebar( '2' );
	} elseif ( 'left-sidebar' == $layout ) {
		get_sidebar( '1' );
	}
}

/**
 * Echo column sidebars in widget
 *
 * @param string $layout current layout
 *
 * @since SG Window 1.0.0
 */
function sgwindow_get_sidebar_widget( $layout ) {

	if ( 'two-sidebars' == $layout ) {
		get_template_part('sidebar-widget');
	} elseif ( 'right-sidebar' == $layout ) {
		get_template_part( 'sidebar-2-widget' );
	} elseif ( 'left-sidebar' == $layout ) {
		get_template_part( 'sidebar-1-widget' );
	}

}

/**
 * Set excerpt length to 30 words
 *
 * @param string $length current length 
 *
 * @since SG Window 1.0.0
 */
function sgwindow_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'sgwindow_custom_excerpt_length', 99999 );

/**
 * Return Trimmed excerpts
 *
 * @param int $charlength length of output
 *
 * @since SG Window 1.0.0
 */
function sgwindow_the_excerpt( $charlength = 200 ) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '[...]';
	} else {
		echo $excerpt;
	}
}

/**
 * Add widgets to the top sidebar on the home page
 *
 * @since SG Window 1.0.0
 */
function sgwindow_the_top_sidebar_widgets() {

	the_widget( 'sgwindow_slider', 'title=&is_background=1&is_play=1' );
	
}
add_action('sgwindow_empty_sidebar_top-home', 'sgwindow_the_top_sidebar_widgets', 20);

/**
 * Add widgets to the before footer sidebar on the home page
 *
 * @since SG Window 1.0.0
 */
function sgwindow_the_footer_sidebar_widgets() {
			
	the_widget( 'WP_Widget_Search', 'title=' );
	
}
add_action('sgwindow_empty_sidebar_before_footer-home', 'sgwindow_the_footer_sidebar_widgets', 20);
/**
 * Add widgets to top sidebar on all pages
 *
 * @since SG Window 1.0.0
 */
function sgwindow_the_top_sidebar_default() {

	the_widget( 'WP_Widget_Search', 'title=' );

}
add_action('sgwindow_empty_sidebar_top-default', 'sgwindow_the_top_sidebar_default', 20);
add_action('sgwindow_empty_sidebar_top-portfolio-page', 'sgwindow_the_top_sidebar_default', 20);

/**
 * Add widgets to top sidebar on all pages
 *
 * @since SG Window 1.0.0
 */
function sgwindow_the_top_sidebar_portfolio() {

	the_widget( 'sgwindow_portfolio_nav', 'title='.__('Projects', 'sg-window') );

}
add_action('sgwindow_empty_sidebar_top-portfolio', 'sgwindow_the_top_sidebar_portfolio', 20);

/**
 * Top menu and site name
 *
 * @since SG Window 1.1.0
 */
function sgwindow_header() {

?>
	<div id="sg-site-header" class="sg-site-header">
		<?php if ( '' != sgwindow_get_theme_mod( 'logotype_url' ) ) : ?>
			<div class="logo-block">
				<a class="logo-section" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
					<img src='<?php echo esc_url( sgwindow_get_theme_mod( 'logotype_url' ) ); ?>' class="logo" alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
				</a><!-- .logo-section -->
			</div><!-- .logo-block -->
		<?php endif; ?>
		
	<div class="menu-top">
		<!-- First Top Menu -->		
		<div class="nav-container top-1-navigation">						
			<?php if ( sgwindow_get_theme_mod( 'is_show_top_menu' ) == '1' ) : ?>
				<nav class="horisontal-navigation menu-1" role="navigation">
					<?php if ( '' != sgwindow_get_theme_mod( 'logotype_url' ) ) : ?>
						<a class="small-logo" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
							<img src='<?php echo esc_url( sgwindow_get_theme_mod( 'logotype_url' ) ); ?>' class="menu-logo" alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
						</a><!-- .logo-section -->
					<?php endif; ?>
					<span class="toggle"><span class="menu-toggle"></span></span>
					<?php wp_nav_menu( array( 'theme_location' => 'top1', 'menu_class' => 'nav-horizontal' ) ); ?>
				</nav><!-- .menu-1 .horisontal-navigation -->
			<?php endif; ?>
			<div class="clear"></div>
		</div><!-- .top-1-navigation .nav-container -->

	<div class="sg-site-header-1">
		
		<div class="site-title">
			<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		</div><!-- .site-title -->
		<!-- Dscription -->
		<div class="site-description">
			<h2><?php echo bloginfo( 'description' ); ?></h2>
		</div><!-- .site-description -->
		
	</div><!-- .sg-site-header-1 -->
			
			<!-- Second Top Menu -->	
			<?php if ( '1' == sgwindow_get_theme_mod( 'is_show_secont_top_menu') ) : ?>

				<div class="nav-container top-navigation">
					<nav class="horisontal-navigation menu-2" role="navigation">
						<?php if ( '' != sgwindow_get_theme_mod( 'logotype_url' ) ) : ?>
							<a class="small-logo" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
								<img src='<?php echo esc_url( sgwindow_get_theme_mod( 'logotype_url' ) ); ?>' class="menu-logo" alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
							</a><!-- .logo-section -->
						<?php endif; ?>
						<span class="toggle"><span class="menu-toggle"></span></span>
						<?php wp_nav_menu( array( 'theme_location' => 'top2', 'menu_class' => 'nav-horizontal' ) ); ?>
					</nav><!-- .menu-2 .horisontal-navigation -->
					<div class="clear"></div>
				</div><!-- .top-navigation.nav-container -->
				
			<?php endif; ?>
		</div><!-- .menu-top  -->
	</div><!-- .sg-site-header -->
<?php
}
add_action( 'sgwindow_header_top', 'sgwindow_header', 20 );

/**
 * Header image
 *
 * @since SG Window 1.1.0
 */
function sgwindow_header_image() {

	if ( get_header_image() && ( sgwindow_get_theme_mod( 'is_header_on_front_page_only' ) != '1' || is_front_page() ) ) :	
				
		if ( '1' != sgwindow_get_theme_mod( 'is_parallax_header' ) ) : ?>
		
			<!-- Banner -->
			<div class="image-container">
				<div class="image-wrapper">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
					</a>
				</div>
			</div>
			
		<?php else : ?>

			<!-- Banner -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="my-image widget">
					<div class="parallax-image <?php echo esc_attr( sgwindow_get_theme_mod( 'parallax_image_speed' ) ); ?> 0 0" style="background-image: url(<?php header_image(); ?>);">
					</div><!-- .parallax-image -->
				</div><!-- .my-image -->
			</a>
			
		<?php endif; 
		
	endif;
}
add_action( 'sgwindow_header_image', 'sgwindow_header_image', 20 );

/**
 * Add widgets to the right sidebar on all pages
 *
 * @since SG Window 1.0.0
 */
function sgwindow_right_sidebar_default() {

	if ( is_single() ) {
	
		the_widget( 'sgwindow_slider', 'title=' . __( 'Related Posts', 'sg-window' ) . '&is_background=1&is_play=&content_type=5&margin=0' );

	} 	

	the_widget( 'sgwindow_items_category', 'title='.__('Recent Posts', 'sg-window').
								'&count=4'.
								'&category=0'.
								'&columns=column-1'.
								'&is_background=1'.
								'&is_margin_0='.
								'&is_link=1'.
								'&effect_id_0=effect-1');
}
add_action('sgwindow_empty_column_2-default', 'sgwindow_right_sidebar_default', 20);

/**
 * Add widgets to the right sidebar on portfolio pages
 *
 * @since SG Window 1.0.0
 */
function sgwindow_right_sidebar_portfolio() {

	the_widget( 'sgwindow_items_portfolio', 'title='.__('Recent Projects', 'sg-window').
								'&count=4'.
								'&jetpack-portfolio-type=0'.
								'&columns=column-1'.
								'&is_background=1'.
								'&is_margin_0='.
								'&is_link=1'.
								'&effect_id_0=effect-1');
}
add_action('sgwindow_empty_column_2-portfolio-page', 'sgwindow_right_sidebar_portfolio', 20);

/**
 * Add widgets to the search 404 page
 *
 * @since SG Window 1.0.0
 */
function sgwindow_404_sidebar() {

	the_widget( 'sgwindow_image', 'title=&is_background=1'.
								'&is_margin_0=1'.
								'&columns=column-1'.
								'&count=1'.
								'&effect_id_0=effect-17'.
								'&image_link_0=' . get_template_directory_uri() . '/img/' . '404.png' . ''.
								'&title_0=' . __( '404 Page', 'sg-window' ) .
								'&text_0=' . __( 'It looks like nothing was found at this location. Maybe try a search?', 'sg-window' )
	);
	the_widget( 'WP_Widget_Search', 'title=' );

}
add_action('sgwindow_empty_sidebar_top-page404', 'sgwindow_404_sidebar', 20);

/**
 * Add widgets to the left sidebar on portfolio archive/index
 *
 * @since SG Window 1.0.0
 */
function sgwindow_left_sidebar_portfolio() {

	the_widget( 'sgwindow_portfolio_tag_nav', 'title='.__('Tags', 'sg-window') );
}
add_action('sgwindow_empty_column_1-portfolio', 'sgwindow_left_sidebar_portfolio', 20);


// Add custom widgets and customizer files
/* Insert Page */
require get_template_directory() . '/inc/widget-page.php';

/* one page scroll */
require get_template_directory() . '/inc/widget-sidebar-navigation.php';
/* portfolio */
if( class_exists('Jetpack') ) {
	require get_template_directory() . '/inc/widget-items-portfolio.php';
	require get_template_directory() . '/inc/widget-tags-naigation.php';
	require get_template_directory() . '/inc/widget-project-naigation.php';
}
/* posts */
require get_template_directory() . '/inc/widget-items-category.php';

if ( class_exists( 'WooCommerce' ) ) {
	/* shop */
	require get_template_directory() . '/inc/widget-items-products.php';
}

/* images */
require get_template_directory() . '/inc/widget-image.php';

/* buttons */
require get_template_directory() . '/inc/widget-button.php';

require get_template_directory() . '/inc/widget-functions.php';

// Add custom social media icons widget.
require get_template_directory() . '/inc/social-media-widget.php';
// Add customize options.
require get_template_directory() . '/inc/customize.php';
// Add sidebar options.
require get_template_directory() . '/inc/customize-sidebars.php';

if ( ! class_exists ( 'sgwindow_Layout_Class' ) ) :
	require get_template_directory() . '/inc/customize-layout.php';
endif;

if ( ! class_exists ( 'sgwindow_Colors_Class' ) ) :
	require get_template_directory() . '/inc/customize-colors.php';
endif;

//widget-sidebar
if( ! class_exists( 'sgwindow_side_bar' ) ) {
	require_once get_template_directory() . '/inc/widget-sidebar.php';
}

//slider
if( ! class_exists( 'sgwindow_slider' ) ) {
	require get_template_directory() . '/inc/widget-slider.php';
}

require get_template_directory() . '/inc/customize-mobile.php';
require get_template_directory() . '/inc/customize-fonts.php';
require get_template_directory() . '/inc/customize-other.php';
require get_template_directory() . '/inc/customize-info.php';

//admin page
require get_template_directory() . '/inc/admin-page.php';