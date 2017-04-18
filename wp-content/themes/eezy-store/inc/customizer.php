<?php
/**
 * eezy-store Theme Customizer.
 *
 * @package eezy-store
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
 
 
function eezy_store_customize_register( $wp_customize ) {
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	// Banner image
	$wp_customize->add_section("banner", array(
		"title" => __("Banner Options", "eezy-store"),
		"priority" => 31,
	));
		
		// for banner on off option
		$wp_customize->add_setting("bnr_on_off", array(
			"default" => 'off',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_radio_sanitize_row',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"bnr_on_off",
			array(
			'type' => 'radio',
			'label' => __("Banner On/Off", "eezy-store"),
			'section' => 'banner',
			'choices' => array(
				'on' => 'On',
				'off' => 'Off',
			),
		)
		));
		
		
		
		// for banner image 1
		$wp_customize->add_setting("bnr_img1", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"bnr_img1",
			array(
				"label" => __("Banner Image 1", "eezy-store"),
				"section" => "banner",
				"settings" => "bnr_img1",
				
			)
		));
		
		// for banner image 1 Heading Text
		$wp_customize->add_setting("bnr_img1_heading", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"bnr_img1_heading",
			array(
				"label" => __("Banner Image 1 Heading Text", "eezy-store"),
				"section" => "banner",
				"settings" => "bnr_img1_heading",
				"type" => "text",
			)
		));
		
		// for banner image 1 Description Text
		$wp_customize->add_setting("bnr_img1_descrp", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"bnr_img1_descrp",
			array(
				"label" => __("Banner Image 1 Description Text", "eezy-store"),
				"section" => "banner",
				"settings" => "bnr_img1_descrp",
				"type" => "text",
			)
		));
		
		// for banner image 2
		$wp_customize->add_setting("bnr_img2", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"bnr_img2",
			array(
				"label" => __("Banner Image 2", "eezy-store"),
				"section" => "banner",
				"settings" => "bnr_img2",
				
			)
		));
		
		// for banner image 2 Heading Text
		$wp_customize->add_setting("bnr_img2_heading", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"bnr_img2_heading",
			array(
				"label" => __("Banner Image 2 Heading Text", "eezy-store"),
				"section" => "banner",
				"settings" => "bnr_img2_heading",
				"type" => "text",
			)
		));
		
		// for banner image 2 Description Text
		$wp_customize->add_setting("bnr_img2_descrp", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"bnr_img2_descrp",
			array(
				"label" => __("Banner Image 2 Description Text", "eezy-store"),
				"section" => "banner",
				"settings" => "bnr_img2_descrp",
				"type" => "text",
			)
		));
		
		// for banner image shop now btn
		$wp_customize->add_setting("bnr_img_shop_btn", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"bnr_img_shop_btn",
			array(
				"label" => __("Banner Image Shop Now Button Text", "eezy-store"),
				"section" => "banner",
				"settings" => "bnr_img_shop_btn",
				"type" => "text",
			)
		));
		
		// for banner 1 shop now btn link address
		$wp_customize->add_setting("banner1_shop_btn_link", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"banner1_shop_btn_link",
			array(
				"label" => __("Banner 1 Shop Now Button Link", "eezy-store"),
				"section" => "banner",
				"settings" => "banner1_shop_btn_link",
				"type" => "url",
			)
		));
		
		// for banner 2 shop now btn link address
		$wp_customize->add_setting("banner2_shop_btn_link", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"banner2_shop_btn_link",
			array(
				"label" => __("Banner 2 Shop Now Button Link", "eezy-store"),
				"section" => "banner",
				"settings" => "banner2_shop_btn_link",
				"type" => "url",
			)
		));
		
	// Home large and small product options
	$wp_customize->add_section("home_product_opt", array(
		"title" => __("Home Products Options", "eezy-store"),
		"priority" => 32,
	));
	
		// for home product on off option
		$wp_customize->add_setting("home_prdct_on_off", array(
			"default" => 'off',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_radio_sanitize_row',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"home_prdct_on_off",
			array(
			'type' => 'radio',
			'label' => __("Home Product On/Off", "eezy-store"),
			'section' => 'home_product_opt',
			'choices' => array(
				'on' => 'On',
				'off' => 'Off',
			),
		)
		));
		
		
		// for large product 1 image
		$wp_customize->add_setting("large_prdct1_img", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"large_prdct1_img",
			array(
				"label" => __("Large Product 1 Image", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct1_img",
				
			)
		));
		
		// for large product 2 image
		$wp_customize->add_setting("large_prdct2_img", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"large_prdct2_img",
			array(
				"label" => __("Large Product 2 Image", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct2_img",
				
			)
		));
		
		// for large product 1 first heading
		$wp_customize->add_setting("large_prdct1_first_head", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"large_prdct1_first_head",
			array(
				"label" => __("Large Product 1 First Heading", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct1_first_head",
				"type" => "text",
			)
		));
		
		// for large product 1 second heading
		$wp_customize->add_setting("large_prdct1_scnd_head", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"large_prdct1_scnd_head",
			array(
				"label" => __("Large Product 1 Second Heading", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct1_scnd_head",
				"type" => "text",
			)
		));
		
		// for large product 1 description
		$wp_customize->add_setting("large_prdct1_descr", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"large_prdct1_descr",
			array(
				"label" => __("Large Product 1 Description", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct1_descr",
				"type" => "text",
			)
		));
		
		// for large product 2 description
		$wp_customize->add_setting("large_prdct2_descr", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"large_prdct2_descr",
			array(
				"label" => __("Large Product 2 Description", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct2_descr",
				"type" => "text",
			)
		));
		
		// for large product 2 first heading
		$wp_customize->add_setting("large_prdct2_first_head", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"large_prdct2_first_head",
			array(
				"label" => __("Large Product 2 First Heading", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct2_first_head",
				"type" => "text",
			)
		));
		
		// for large product 2 second heading
		$wp_customize->add_setting("large_prdct2_scnd_head", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"large_prdct2_scnd_head",
			array(
				"label" => __("Large Product 2 Second Heading", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct2_scnd_head",
				"type" => "text",
			)
		));
		
		// for large product shop now btn text
		$wp_customize->add_setting("large_prdct_shop_btn", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"large_prdct_shop_btn",
			array(
				"label" => __("Large Product Shop Now Button Text", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct_shop_btn",
				"type" => "text",
			)
		));
		
		
		// for small product shop button
		$wp_customize->add_setting("small_prdct_shop_btn", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"small_prdct_shop_btn",
			array(
				"label" => __("Large Product Shop Now Button Text", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "small_prdct_shop_btn",
				"type" => "text",
			)
		));
		
		// for small product 1 name
		$wp_customize->add_setting("small_prdct1_name", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"small_prdct1_name",
			array(
				"label" => __("Small Product 1 Name", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "small_prdct1_name",
				"type" => "text",
			)
		));
		
		// for small product 2 name
		$wp_customize->add_setting("small_prdct2_name", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"small_prdct2_name",
			array(
				"label" => __("Small Product 2 Name", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "small_prdct2_name",
				"type" => "text",
			)
		)); 
		// for small product 1 image
		$wp_customize->add_setting("small_prdct1_img", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"small_prdct1_img",
			array(
				"label" => __("Small Product 1 Image", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "small_prdct1_img",
				
			)
		));
		
		// for small product 2 image
		$wp_customize->add_setting("small_prdct2_img", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"small_prdct2_img",
			array(
				"label" => __("Small Product 2 Image", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "small_prdct2_img",
				
			)
		));
		
		
		// for large product 1 link address
		$wp_customize->add_setting("large_prdct1_link", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"large_prdct1_link",
			array(
				"label" => __("Large Product 1 Link", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct1_link",
				"type" => "url",
			)
		));
		
		// for large product 2 link address
		$wp_customize->add_setting("large_prdct2_link", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"large_prdct2_link",
			array(
				"label" => __("Large Product 2 Link", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "large_prdct2_link",
				"type" => "url",
			)
		));
		
		// for small product 1 link address
		$wp_customize->add_setting("small_prdct1_link", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"small_prdct1_link",
			array(
				"label" => __("Small Product 1 Link", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "small_prdct1_link",
				"type" => "url",
			)
		));
		
		// for small product 2 link address
		$wp_customize->add_setting("small_prdct2_link", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"small_prdct2_link",
			array(
				"label" => __("Small Product 2 Link", "eezy-store"),
				"section" => "home_product_opt",
				"settings" => "small_prdct2_link",
				"type" => "url",
			)
		));

	
// Home products heading section
	$wp_customize->add_section("home_product_heading", array(
		"title" => __("Home Products Heading", "eezy-store"),
		"priority" => 32,
	));	
	
		// for top Featured product
		$wp_customize->add_setting("top_feature_prdct", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"top_feature_prdct",
			array(
				"label" => __("Top Featured Text", "eezy-store"),
				"section" => "home_product_heading",
				"settings" => "top_feature_prdct",
				"type" => "text",
			)
		));
		
		// for top Featured product
		$wp_customize->add_setting("new_arvls_prdct", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"new_arvls_prdct",
			array(
				"label" => __("New Arrivals Text", "eezy-store"),
				"section" => "home_product_heading",
				"settings" => "new_arvls_prdct",
				"type" => "text",
			)
		));
		
		// for top rated product
		$wp_customize->add_setting("top_rated_prdct", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"top_rated_prdct",
			array(
				"label" => __("Top Rated Text", "eezy-store"),
				"section" => "home_product_heading",
				"settings" => "top_rated_prdct",
				"type" => "text",
			)
		));
		
		// for top seller product
		$wp_customize->add_setting("top_seller_prdct", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"top_seller_prdct",
			array(
				"label" => __("Top Seller Text", "eezy-store"),
				"section" => "home_product_heading",
				"settings" => "top_seller_prdct",
				"type" => "text",
			)
		));
	
	
	// Footer Text options 
	$wp_customize->add_section("footer_opt", array(
		"title" => __("Footer Options", "eezy-store"),
		"priority" => 33,
	));
	
		// for copyright text
		$wp_customize->add_setting("footer_copyrght_txt", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'eezy_store_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"footer_copyrght_txt",
			array(
				"label" => __("Copyright Text", "eezy-store"),
				"section" => "footer_opt",
				"settings" => "footer_copyrght_txt",
				"type" => "text",
			)
		));
}
add_action( 'customize_register', 'eezy_store_customize_register' );

function eezy_store_text_sanitize( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function eezy_store_radio_sanitize_row($input) {
  $valid_keys = array(
		'on' => 'On',
		'off' => 'Off',
  );
  if ( array_key_exists( $input, $valid_keys ) ) {
	 return $input;
  } else {
	 return '';
  }
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function eezy_store_customize_preview_js() {
	wp_enqueue_script( 'eezy-store-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'eezy_store_customize_preview_js' );