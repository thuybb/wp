<?php
/**
 * Implement Default Theme/Customizer Options
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */


/**
 * Returns the default options for helena.
 *
 * @since Helena 0.1
 */
function helena_get_default_theme_options( $parameter = null ) {
	$default_theme_options = array(
		//Site Info
		'disable_tagline_header'               => 0,
		'disable_tagline_footer'               => 0,
		'move_title_tagline'                   => 0,

		//Header Image
		'enable_header_image'                  => 'exclude-home-page-post',
		'featured_image_size'                  => 'helena-slider',
		'featured_header_title'                => esc_html( get_bloginfo( 'name') ),
		'featured_header_content'              => esc_html( get_bloginfo( 'description' ) ),
		'featured_header_button_text'          => esc_html__( 'View More', 'helena' ),
		'featured_header_button_link'          => '#',
		'featured_header_button_target'        => 0,

		//Breadcrumb Options
		'breadcrumb_option'                    => 0,
		'breadcrumb_on_homepage'               => 0,
		'breadcrumb_seperator'                 => '&raquo;',

		//Custom CSS
		'custom_css'                           => '',

		//Excerpt Options
		'excerpt_length'                       => '40',
		'excerpt_more_text'                    => esc_html__( 'Continue reading', 'helena' ),

		//Homepage / Frontpage Settings
		'front_page_category'                  => '0',

		//Layout Options
		'theme_layout'                         => 'no-sidebar-full-width',
		'single_page_post_layout'              => 'no-sidebar-full-width',
		'content_layout'                       => 'excerpt-image-top',
		'single_post_image_layout'             => 'disabled',

		//Promotion Headline Options
		'promotion_headline_option'            => 'homepage',
		'promotion_headline_type'              => 'demo',
		'promotion_headline_show'              => 'excerpt',
		'promotion_headline_title'             => '',
		'promotion_headline_content'           => '',
		'promotion_headline_button_1'          => esc_html__( 'Buy Now', 'helena' ),
		'promotion_headline_url_1'             => '#',
		'promotion_headline_target_1'          => 1,
		'promotion_headline_button_2'          => esc_html__( 'Buy Now', 'helena' ),
		'promotion_headline_url_2'             => '#',
		'promotion_headline_target_2'          => 1,

		//Pagination Options
		'pagination_type'                      => 'default',

		//Search Options
		'search_text'                          => esc_html__( 'Search...', 'helena' ),

		//Scrollup Options
		'disable_scrollup'                     => 0,

		//Basic Color Options
		'color_scheme'                         => 'light',
		'background_color'                     => '#f3f3f3',
		'header_textcolor'                     => '#ffffff',

		//Header Highlight Content Options
		'header_highlight_content_option'      => 'disabled',
		'header_highlight_content_type'        => 'demo-header-highlight-content',
		'header_highlight_content_headline'    => '',
		'header_highlight_content_subheadline' => '',
		'header_highlight_content_number'      => '3',
		'header_highlight_content_show'        => 'hide-content',

		//Featured Slider Options
		'featured_slider_option'               => 'disabled',
		'featured_slider_image_loader'         => 'true',
		'featured_slider_transition_effect'    => 'fadeout',
		'featured_slider_transition_delay'     => '4',
		'featured_slider_transition_length'    => '1',
		'featured_slider_type'                 => 'demo-featured-slider',
		'featured_slider_number'               => '4',

		//Hero Content Options
		'hero_content_option'                  => 'disabled',
		'hero_content_type'                    => 'demo-hero-content',
		'hero_content_number'                  => '1',
		'hero_content_enable_title'            => 1,
		'hero_content_show'                    => 'excerpt',
		'disable_read_more'                    => 0,

		//Featured Content Options
		'featured_content_option'              => 'disabled',
		'featured_content_layout'              => 'three-columns',
		'featured_content_position'            => 0,
		'featured_content_slider'              => 1,
		'featured_content_headline'            => '',
		'featured_content_subheadline'         => '',
		'featured_content_type'                => 'demo-featured-content',
		'featured_content_number'              => '3',
		'featured_content_enable_title'        => 1,
		'featured_content_show'                => 'hide-content',
		'featured_content_select_category'     => '0',

		//Portfolio
		'portfolio_option'                     => 'disabled',
		'portfolio_layout'                     => 'four-columns',
		'portfolio_position'                   => 0,
		'portfolio_slider'                     => 1,
		'portfolio_headline'                   => '',
		'portfolio_subheadline'                => '',
		'portfolio_type'                       => 'demo-portfolio',
		'portfolio_number'                     => '4',
		'portfolio_enable_title'               => 1,
		'portfolio_select_category'            => '0',
		'portfolio_hide_category'              => 0,
		'portfolio_hide_tags'                  => 1,
		'portfolio_hide_author'                => 1,
		'portfolio_hide_date'                  => 0,

		//Logo Slider
		'logo_slider_option'                   => 'disabled',
		'logo_slider_type'                     => 'demo',
		'logo_slider_visible_items'            => '4',
		'logo_slider_transition_delay'         => '4',
		'logo_slider_transition_length'        => '1',
		'logo_slider_title'                    => '',
		'logo_slider_number'                   => '5',

		//Reset all settings
		'reset_all_settings'                   => 0,
	);

	if ( null == $parameter ) {
		return apply_filters( 'helena_default_theme_options', $default_theme_options );
	} else {
		return isset( $default_theme_options[ $parameter ] ) ? $default_theme_options[ $parameter ] : false;
	}
}

/**
 * Returns an array of feature header enable options
 *
 * @since Helena 0.1
 */
function helena_enable_header_image_options() {
	$options = array(
		'homepage'               => esc_html__( 'Homepage / Frontpage', 'helena' ),
		'exclude-home'           => esc_html__( 'Excluding Homepage', 'helena' ),
		'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'helena' ),
		'entire-site'            => esc_html__( 'Entire Site', 'helena' ),
		'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'helena' ),
		'pages-posts'            => esc_html__( 'Pages and Posts', 'helena' ),
		'disabled'               => esc_html__( 'Disabled', 'helena' ),
	);

	return apply_filters( 'helena_enable_header_image_options', $options );
}

/**
 * Returns an array of feature image size
 *
 * @since Helena 0.1
 */
function helena_featured_image_size_options() {
	$options['helena-slider'] = esc_html__( 'Slider size (1170x658)', 'helena' );
	$options['full'] = esc_html__( 'Full size', 'helena' );

	return apply_filters( 'helena_featured_image_size_options', $options );
}

/**
 * Returns an array of color schemes registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_color_schemes() {
	$options = array(
		'light' => esc_html__( 'Light', 'helena' ),
		'dark'  => esc_html__( 'Dark', 'helena' ),
	);

	return apply_filters( 'helena_color_schemes', $options );
}

/**
 * Returns an array of layout options registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_layouts() {
	$options = array(
		'right-sidebar'         => esc_html__( 'Content, Primary Sidebar', 'helena' ),
		'no-sidebar-full-width' => esc_html__( 'No Sidebar ( Full Width )', 'helena' ),
	);
	return apply_filters( 'helena_layouts', $options );
}

/**
 * Returns an array of pagination schemes registered for helena.
 *
 * @since Helena 0.1
 */
function helena_get_pagination_types() {
	$options = array(
		'default'                => esc_html__( 'Default(Older Posts/Newer Posts)', 'helena' ),
		'numeric'                => esc_html__( 'Numeric', 'helena' ),
		'infinite-scroll-click'  => esc_html__( 'Infinite Scroll (Click)', 'helena' ),
		'infinite-scroll-scroll' => esc_html__( 'Infinite Scroll (Scroll)', 'helena' ),
	);

	return apply_filters( 'helena_get_pagination_types', $options );
}

/**
 * Returns an array of content layout options registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_get_archive_content_layout() {
	$options = array(
		'excerpt-image-top'   => esc_html__( 'Show Excerpt (Image Top)', 'helena' ),
		'full-content'        => esc_html__( 'Show Full Content (No Featured Image)', 'helena' )
	);
	return apply_filters( 'helena_get_archive_content_layout', $options );
}

/**
 * Returns an array of content featured image size.
 *
 * @since Helena 0.1
 */
function helena_single_post_image_layout_options() {
	$options['disabled'] 	= esc_html__( 'Disabled', 'helena' );
	$options['full']     	= esc_html__( 'Full size', 'helena' );
	$options['helena-slider']	= esc_html__( 'Slider size (1170x658)', 'helena' );

	return apply_filters( 'helena_single_post_image_layout_options', $options );
}

/**
 * Returns an array of content and slider layout options registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_featured_section_enable_options() {
	$options = array(
		'homepage'    => esc_html__( 'Homepage / Frontpage', 'helena' ),
		'entire-site' => esc_html__( 'Entire Site', 'helena' ),
		'disabled'    => esc_html__( 'Disabled', 'helena' ),
	);

	return apply_filters( 'helena_featured_section_enable_options', $options );
}

/**
 * Returns an array of header highlight content types registered for Helena.
 *
 * @since Helena 0.1
 */
function helena_header_highlight_content_types() {
	$options = array(
		'demo-header-highlight-content'     => esc_html__( 'Demo Content', 'helena' ),
		'header-highlight-page-content'     => esc_html__( 'Page Content', 'helena' ),
	);

	return apply_filters( 'helena_header_highlight_content_types', $options );
}

/**
 * Returns an array of featured content show registered for parallaxframe.
 *
 * @since parallaxframe 1.6
 */
function helena_featured_content_show() {
	$options = array(
		'excerpt'      => esc_html__( 'Show Excerpt', 'helena' ),
		'full-content' => esc_html__( 'Show Full Content', 'helena' ),
		'hide-content' => esc_html__( 'Hide Content', 'helena' )
	);

	return apply_filters( 'helena_featured_content_show', $options );
}

/**
 * Returns an array of feature slider transition effects
 *
 * @since Helena 0.1
 */
function helena_featured_slider_transition_effects() {
	$options = array(
		'fade' 		=> esc_html__( 'Fade', 'helena' ),
		'fadeout' 	=> esc_html__( 'Fade Out', 'helena' ),
		'none' 		=> esc_html__( 'None', 'helena' ),
		'scrollHorz'=> esc_html__( 'Scroll Horizontal', 'helena' ),
		'scrollVert'=> esc_html__( 'Scroll Vertical', 'helena' ),
		'flipHorz'	=> esc_html__( 'Flip Horizontal', 'helena' ),
		'flipVert'	=> esc_html__( 'Flip Vertical', 'helena' ),
		'tileSlide'	=> esc_html__( 'Tile Slide', 'helena' ),
		'tileBlind'	=> esc_html__( 'Tile Blind', 'helena' ),
		'shuffle'	=> esc_html__( 'Shuffle', 'helena' )
	);

	return apply_filters( 'helena_featured_slider_transition_effects', $options );
}

/**
 * Returns an array of feature slider types registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_featured_slider_types() {
	$options = array(
		'demo-featured-slider'     => esc_html__( 'Demo Featured Slider', 'helena' ),
		'featured-page-slider'     => esc_html__( 'Featured Page Slider', 'helena' ),
	);

	return apply_filters( 'helena_featured_slider_types', $options );
}

/**
 * Returns an array of featured slider image loader options
 *
 * @since Helena 0.1
 */
function helena_featured_slider_image_loader() {
	$options = array(
		'true'  => esc_html__( 'True', 'helena' ),
		'wait'  => esc_html__( 'Wait', 'helena' ),
		'false' => esc_html__( 'False', 'helena' )
	);

	return apply_filters( 'helena_featured_slider_image_loader', $options );
}

/**
 * Returns an array of portfolio types registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_portfolio_types() {
	$options = array(
		'demo-portfolio'     => esc_html__( 'Demo Portfolio', 'helena' ),
		'page-portfolio'     => esc_html__( 'Page Portfolio', 'helena' ),
	);

	return apply_filters( 'helena_portfolio_types', $options );
}


/**
 * Returns an array of feature content types registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_logo_slider_types() {
	$options = array(
		'demo' => esc_html__( 'Demo Logo Slider', 'helena' ),
		'page' => esc_html__( 'Page Logo Slider', 'helena' ),
	);

	return apply_filters( 'helena_logo_slider_types', $options );
}

/**
 * Returns an array of hero content types registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_hero_content_types() {
	$options = array(
		'demo-hero-content' => esc_html__( 'Demo Content', 'helena' ),
		'hero-page-content' => esc_html__( 'Page Content', 'helena' ),
	);

	return apply_filters( 'helena_hero_content_types', $options );
}

/**
 * Returns an array of featured content options registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_featured_content_layout_options() {
	$options = array(
		'three-columns' => esc_html__( '3 Columns', 'helena' ),
		'four-columns'  => esc_html__( '4 Columns', 'helena' )
	);

	return apply_filters( 'helena_featured_content_layout_options', $options );
}

/**
 * Returns an array of metabox layout options registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_metabox_layouts() {
	$options = array(
		'default' 	=> array(
			'id' 	=> 'helena-layout-option',
			'value' => 'default',
			'label' => esc_html__( 'Default', 'helena' ),
		),
		'right-sidebar' => array(
			'id' 	=> 'helena-layout-option',
			'value' => 'right-sidebar',
			'label' => esc_html__( 'Content, Primary Sidebar', 'helena' ),
		),
		'no-sidebar-full-width' => array(
			'id' 	=> 'helena-layout-option',
			'value' => 'no-sidebar-full-width',
			'label' => esc_html__( 'No Sidebar ( Full Width )', 'helena' ),
		),
	);
	return apply_filters( 'helena_layouts', $options );
}

/**
 * Returns an array of metabox header featured image options registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_metabox_header_featured_image_options() {
	$options = array(
		'default' => array(
			'id'		=> 'helena-header-image',
			'value' 	=> 'default',
			'label' 	=> esc_html__( 'Default', 'helena' ),
		),
		'enable' => array(
			'id'		=> 'helena-header-image',
			'value' 	=> 'enable',
			'label' 	=> esc_html__( 'Enable', 'helena' ),
		),
		'disable' => array(
			'id'		=> 'helena-header-image',
			'value' 	=> 'disable',
			'label' 	=> esc_html__( 'Disable', 'helena' )
		)
	);
	return apply_filters( 'header_featured_image_options', $options );
}


/**
 * Returns an array of metabox featured image options registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_metabox_featured_image_options() {
	$options['default'] = array(
		'id'	=> 'helena-featured-image',
		'value' => 'default',
		'label' => esc_html__( 'Default', 'helena' ),
	);

	$options['disabled'] = array(
		'id' 	=> 'helena-featured-image',
		'value' => 'disabled',
		'label' => esc_html__( 'Disabled', 'helena' )
	);

	$options['full'] = array(
		'id'	=> 'helena-featured-image',
		'value'	=> 'full',
		'label' => esc_html__( 'Full Image', 'helena' ),
	);

	$options['helena-slider'] = array(
		'id'	=> 'helena-featured-image',
		'value'	=> 'helena-slider',
		'label' => esc_html__( 'Slider size (1170x658)', 'helena' ),
	);

	return apply_filters( 'helena_metabox_featured_image_options', $options );
}

/**
 * Returns an array of feature content types registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_featured_content_types() {
	$options = array(
		'demo-featured-content'     => esc_html__( 'Demo Featured Content', 'helena' ),
		'featured-page-content'     => esc_html__( 'Featured Page Content', 'helena' ),
	);

	return apply_filters( 'helena_featured_content_types', $options );
}

/**
 * Returns an array of hero content types registered for parallaxframe.
 *
 * @since Helena 0.1
 */
function helena_promotion_headline_types() {
	$options = array(
		'demo'     => esc_html__( 'Demo Promotion Headline', 'helena' ),
		'page'     => esc_html__( 'Page Promotion Headline', 'helena' ),
	);

	return apply_filters( 'helena_promotion_headline_types', $options );
}

/**
 * Returns the default options for parallaxframe dark theme.
 *
 * @since parallaxframe 1.0
 */
function helena_default_dark_color_options() {
	$default_dark_color_options = array(
		//Basic Color Options
		'background_color' => '#262626',
		'header_textcolor' => '#ffffff',
	);

	return apply_filters( 'helena_default_dark_color_options', $default_dark_color_options );
}

/**
 * Returns footer content
 *
 * @since Helena 0.2
 */
function helena_get_content() {
	$theme_data = wp_get_theme();

	return sprintf( _x( 'Copyright &copy; %1$s %2$s.', '1: Year, 2: Site Title with home URL', 'helena' ), date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' ) . ' ' . esc_attr( $theme_data->get( 'Name') ) . '&nbsp;' . __( 'by', 'helena' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_attr( $theme_data->get( 'Author' ) ) .'</a>';
}