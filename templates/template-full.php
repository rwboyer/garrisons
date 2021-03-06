<?php
/**
 * Template Name: Full
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Hooch
 */

get_header(); ?>

<div class="page-header">
  <div class="wrap">
    <div class="content-home">
      <h1><span class="header"><?php single_post_title('', true) ;?></span></h1>
    </div>
  </div>
</div>

<div class="wrap">
	<div id="primary" class="content-home">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page-full' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

</div> <!-- .wrap -->

<?php get_footer(); ?>
