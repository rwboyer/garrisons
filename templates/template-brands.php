<?php
/**
 * Template Name: Brands
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

<?php 
	 // Gets the uploaded featured image
  	$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
  	// Checks and returns the featured image
  	$bg = (!empty( $featured_img ) ? "background-image: url('". $featured_img[0] ."');" : '');
?>

<ul class="big-blocks">
  <li class="big-block content-page" style="<?php echo $bg; ?>">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>
  </li>
  
<?php  
// WP_Query arguments
$args = array (
	'post_type'              => array( 'post_type_brand' ),
	'post_status'            => array( 'publish' ),
	'nopaging'               => true,
);

// The Query
$query = new WP_Query( $args );

// The Loop

$count = 0;

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		$brand_link = (get_field('brand_link')) ? get_field('brand_link') :'#' ;
		if ($count++ < 1) :?>
		  <li class="big-block">
		    <ul class="small-blocks">
		<?php
		endif  
		?>
		<li class="small-block">
      <a target="_blank" href="<?php echo $brand_link; ?>"><?php echo get_the_post_thumbnail($post_id, 'full'); ?></a>
		</li>
		<?php
    if($count == 9) :?>
		    </ul>
		  </li>
		<?php
  		$count = 0;
    endif;
	}
	if($count < 9 && $count > 0) :
	  for($i = 0; $i < 9 - $count; $i++){ ?>
  	  <li class="small-block"></li>
    <?php
	  }
	  ?>
      </ul>
    </li>
  <?php
  endif;
} else {
	// no posts found
}

// Restore original Post Data
wp_reset_postdata();
?>

</ul>
<div class="brand-footer">
  <p>We have many more brands in stock at the shop. Stop by to see hem all!</p>
</div>
<?php get_footer(); ?>
