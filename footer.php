<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hooch
 */

?>

	</div><!-- #content -->

	<footer class="footer" role="contentinfo">
	  <div class="footer-logo">

			<?php if(get_theme_mod('site_logo')) {
				echo '<img src="'. get_theme_mod('site_logo') . '" alt="'.get_bloginfo( 'name' ).'">';
			} else { ?>
			<img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
			<?php } ?>
		
	  </div>
	  <div class="footer-links">
	    <?php dynamic_sidebar( 'footer-1' ); ?>
	  	<?php dynamic_sidebar( 'footer-2' ); ?>
	  	<?php dynamic_sidebar( 'footer-3' ); ?>	 
	  	<?php dynamic_sidebar( 'footer-4' ); ?>	 	
	  </div>

	  <hr>

	  <p class="footer-hours">
	  	Mon: CLOSED  /  Tue: 9-6  /  Wed: 9-8  /  Thu: 9-6  /  Fri: 9-8  /  Sat: 9-5  /  Sun: 11-4	
		</p><!-- .site-info -->
	  <p class="site-info">
	  	(302) 384-6827  /  info@garrisonscyclery.com  /  5801 Kennett Pike, Centreville, DE 19807	
		</p><!-- .site-info -->
		<div class="copyright">
  		<a href="http://2fish.com" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/2fish-logo.png' ;?>"></a>
  		<p>Copyright <?php echo date("Y"); ?> Garrison's Cyclery</p>
	</footer>


</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
