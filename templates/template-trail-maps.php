<?php
/**
 * Template Name: Trail Maps
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

<div class="wrap">
  <div class="content-home">
  
<?php  
// WP_Query arguments
$args = array (
	'post_type'              => array( 'post_type_trail' ),
	'post_status'            => array( 'publish' ),
	'nopaging'               => true,
);

// The Query
$query = new WP_Query( $args );

// The Loop

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
    $resource_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
    $bg = (!empty( $resource_img ) ? "background-image: url('". $resource_img[0] ."');" : '');
		$trail_link = (get_field('trail_link')) ? get_field('trail_link') :'#' ;
		$trail_map = (get_field('map')) ? get_field('map') :'#' ; ?>
		  <div class="inner-column">
  		  <ul class="resource-blocks">
  		    <li class="resource-info">
  		    <h1><?php the_title('', '', true) ;?></h1>
  		    <?php the_content('', false) ; ?>
          <a target="_blank" href="<?php echo $trail_map['url']; ?>"><button>Download</button></a>
  		    </li>
  		    <li class="resource-image" style="<?php echo $bg ;?>">
  		    </li>
  		  </ul>
		  </div>
  <?php
	}
} else {
	// no posts found
}

// Restore original Post Data
wp_reset_postdata();
?>
  
  </div>
</div>

<?php get_footer(); ?>
