<?php
/**
 * Template File for normal post_type
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
      <h1><span class="header">Journal</span></h1>
    </div>
  </div>
</div>

<?php 
	 // Gets the uploaded featured image
  	$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
  	// Checks and returns the featured image
  	$bg = (!empty( $featured_img ) ? "background-image: url('". $featured_img[0] ."');" : '');
?>

<ul class="post-blocks">
	<?php while ( have_posts() ) : the_post(); ?>
    <li class="post-block">
      <article>
    		<h1><?php the_title() ?></h1>
        <?php the_excerpt() ;?>
        <a href="<?php the_permalink() ;?>">Read More&hellip;</a>
      </article>
    </li>
	<?php endwhile; // End of the loop. ?>
</ul>

<?php get_footer(); ?>
