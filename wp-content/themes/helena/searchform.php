<?php
/**
 * The template for displaying search form
 *
 * @package Catch Themes
 * @subpackage Helena
 * @since Helena 0.1
 */
?>

<?php $search_text 	= apply_filters( 'helena_get_option', 'search_text' ); // Get options ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'helena' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( $search_text ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo esc_attr_x( 'Search', 'submit button', 'helena' ); ?></span></button>
</form>