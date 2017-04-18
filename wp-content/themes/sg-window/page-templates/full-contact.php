<?php
/**
 * Template Name: Contact Template
 *
 * @package WordPress
 * @subpackage sgwindow
 * @since SG Window 1.0.0
 */
 __( 'Contact Template', 'sg-window' );

get_header(); 

?>
<div class="main-wrapper contacts">

	<div class="site-content"> 
			<?php
				if ( have_posts() ) : ?>
				
					<div class="content"> 

				<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'content', 'page' );
						
					endwhile; ?>
					
					</div><!-- .content -->
					<div class="clear"></div>
				
				<?php

					sgwindow_paging_nav();
					
				else :  
				?>
					<div class="content"> 
					<?php 
						get_template_part( 'content', 'none' );
					?>
					
					</div><!-- .content -->
				<?php 
				endif;
?>
	</div><!-- .site-content -->
</div> <!-- .main-wrapper -->

<?php
get_footer();
