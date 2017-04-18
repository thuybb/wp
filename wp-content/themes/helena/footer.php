<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Helena
 */

/**
 * Set helena_after_content hook
 *
 * @hooked helena_content_end - 10
 */
do_action( 'helena_after_content' );

/**
 * Set helena_footer hook
 *
 * @hooked helena_footer_content_start - 10
 * @hooked helena_footer_sidebar - 20
 * @hooked helena_site_info_start - 30
 * @hooked helena_footer_site_description - 40
 * @hooked helena_social_menu - 50
 * @hooked helena_footer_content - 60
 * @hooked helena_site_info_end - 70
 * @hooked helena_footer_content_end - 190
 * @hooked helena_page_end - 200
 */
do_action( 'helena_footer' );

/**
 * Set helena_after hook
 */
do_action( 'helena_after' );

/**
 * Set helena_after hook
 *
 * @hooked helena_scrollup - 10
 */
wp_footer();
?>
</body>
</html>