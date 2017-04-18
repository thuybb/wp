<?php

/* Template Name: Homepage */ 

get_header('inner');

?>

	</div><!-- #content -->
</div><!-- .container-->
<?php if(get_theme_mod("bnr_on_off") != '' && get_theme_mod("bnr_on_off") == 'on'): ?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<!-- Carousel indicators -->
	
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
	</ol> 
	
	<!-- Wrapper for carousel items -->
	<div class="carousel-inner">
	
		<div class="item active">
		<?php if(get_theme_mod("bnr_img1") != ''): ?>
			<img src="<?php echo esc_url(get_theme_mod("bnr_img1")); ?>" />
			<?php endif;?>	
			<div class="carousel-caption">
				<h2><?php echo esc_html( get_theme_mod("bnr_img1_heading"))?></h2>
				<h3><?php echo esc_html(get_theme_mod("bnr_img1_descrp")); ?></h3>
				<a href="<?php echo esc_url(get_theme_mod("banner1_shop_btn_link"));?>"><?php echo esc_html(get_theme_mod("bnr_img_shop_btn")); ?> &#8594 </a>
			</div>
		</div>
		
		
		<div class="item">
			<?php if(get_theme_mod("bnr_img2") != ''): ?>
			<img src="<?php echo esc_url(get_theme_mod("bnr_img2")); ?>" />
			<?php endif;?>
			<div class="carousel-caption">
				<h2><?php echo esc_html(get_theme_mod("bnr_img2_heading")); ?></h2>
				<h3><?php echo esc_html(get_theme_mod("bnr_img2_descrp")); ?></h3>
				<a href="<?php echo esc_url(get_theme_mod("banner2_shop_btn_link"));?>"><?php echo esc_html(get_theme_mod("bnr_img_shop_btn")); ?> &#8594 </a>
			</div>
		</div>
		
	</div>

</div>
<?php endif; ?>
	
<div class="container eezy-store-home-template">
	<?php if(get_theme_mod("home_prdct_on_off") != '' && get_theme_mod("home_prdct_on_off") == 'on'): ?>
	<div class="home-product-wrapper"> 
		<div class="home-product-large">
			<div id="myCarousel-2" class="carousel slide" data-ride="carousel"> 
			<!-- Wrapper for carousel items -->
			<div class="carousel-inner">
				<div class="item active">
				
					<?php if(get_theme_mod("large_prdct1_img") != ''): ?>
			
							<img src="<?php echo esc_url(get_theme_mod("large_prdct1_img")); ?>" />
						
					<?php endif;?>
					
						<div class="carousel-caption">
							<h2><?php echo esc_html(get_theme_mod("large_prdct1_first_head")); ?></h2>
							<h3><?php echo esc_html(get_theme_mod("large_prdct1_scnd_head")); ?></h3>
							<p><?php echo esc_html(get_theme_mod("large_prdct1_descr")); ?></p>
							<a href="<?php echo esc_url(get_theme_mod("large_prdct1_link"));?>"><?php echo esc_html(get_theme_mod("large_prdct_shop_btn")); ?> &#8594 </a>
						</div>
				</div>
			</div>

			</div> <!-- end myCarousel-2 -->
		</div> 
	
	
		<div class="home-product-small">
			<div class="small-product-wrapper">
			
				<?php if(get_theme_mod("small_prdct1_img") != ''): ?>
			
						<img src="<?php echo esc_url(get_theme_mod("small_prdct1_img")); ?>" />
					
				<?php endif;?>
				
				<a href="<?php echo esc_url(get_theme_mod("small_prdct1_link"));?>"><?php echo esc_html(get_theme_mod("small_prdct1_name")); ?></a>
				<a class="shop-btn" href="<?php echo esc_url(get_theme_mod("small_prdct1_link"));?>"><?php echo esc_html(get_theme_mod("small_prdct_shop_btn")); ?> &#8594 </a>
			</div>
		</div>

	</div> <!-- end home-product-wrapper -->
	
	<div class="home-product-wrapper"> 
	
		<div class="home-product-small second">
			<div class="small-product-wrapper">
			
				<?php if(get_theme_mod("small_prdct2_img") != ''): ?>
			
						<img src="<?php echo esc_url(get_theme_mod("small_prdct2_img")); ?>" />
					
				<?php endif;?>
				
				<a href="<?php echo esc_url(get_theme_mod("small_prdct2_link"));?>"><?php echo esc_html(get_theme_mod("small_prdct2_name")); ?></a>
				<a class="shop-btn" href="<?php echo esc_url(get_theme_mod("small_prdct2_link"));?>"><?php echo esc_html(get_theme_mod("small_prdct_shop_btn")); ?> &#8594 </a>
			</div>
		</div>
		
		<div class="home-product-large second">
			<div id="myCarousel-3" class="carousel slide" data-ride="carousel"> 
			<!-- Wrapper for carousel items -->
			<div class="carousel-inner">
				<div class="item active">
				
					<?php if(get_theme_mod("large_prdct2_img") != ''): ?>
			
							<img src="<?php echo esc_url(get_theme_mod("large_prdct2_img")); ?>" />
						
					<?php endif;?>
					
						<div class="carousel-caption">
							<h2><?php echo esc_html(get_theme_mod("large_prdct2_first_head")); ?></h2>
							<h3><?php echo esc_html(get_theme_mod("large_prdct2_scnd_head")); ?></h3>
							<p><?php echo esc_html(get_theme_mod("large_prdct2_descr")); ?></p>
							<a href="<?php echo esc_url(get_theme_mod("large_prdct2_link"));?>"><?php echo esc_html(get_theme_mod("large_prdct_shop_btn")); ?> &#8594 </a>
						</div>
				</div>
			</div>

			</div> <!-- end myCarousel-3 -->
		</div> 
			
	</div> <!-- end home-product-wrapper -->
<?php endif;?>
	
<?php if ( class_exists( 'WooCommerce' ) ) :?> 
	<div class="col-sm-12 home-featured-product-wrapper">
		
		<div class="col-md-3 col-sm-6 col-xs-6 col-product no-left-padding">
			<div class="home-featured-product">
				<h2><?php echo esc_html(get_theme_mod("top_feature_prdct")); ?></h2>
				<?php echo do_shortcode('[featured_products per_page="3" columns="4"]'); ?>
			</div>
		</div>
		
		<div class="col-md-3 col-sm-6 col-xs-6 col-product">
			<div class="home-featured-product">
				<h2><?php echo esc_html(get_theme_mod("new_arvls_prdct")); ?></h2>
				<?php echo do_shortcode('[recent_products per_page="4" columns="4"]'); ?>
			</div>
		</div>
		
		<div class="col-md-3 col-sm-6 col-xs-6 col-product">
			<div class="home-featured-product">
				<h2><?php echo esc_html(get_theme_mod("top_rated_prdct")); ?></h2>
				<?php echo do_shortcode('[top_rated_products per_page="3"]'); ?>
			</div>
		</div>
		
		<div class="col-md-3 col-sm-6 col-xs-6 col-product no-right-padding">
			<div class="home-featured-product">
				<h2><?php echo esc_html(get_theme_mod("top_seller_prdct")); ?></h2>
				<?php echo do_shortcode('[best_selling_products per_page="3"]'); ?>
			</div>
		</div>
		
	</div>
<?php endif; ?>
		
</div> <!-- end container -->
<?php get_footer(); ?>