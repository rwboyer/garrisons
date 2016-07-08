<?php
/**
 * Template Name: Closeouts
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
  <div class="content-home">
    <article>
      <h1>Bikes</h1>
    </article>
  </div>
</div>

<div class="wrap">
  <div class="content-home">
  
<?php  
// WP_Query arguments
$args = array (
	'post_type'              => array( 'post_type_closeout' ),
	'post_status'            => array( 'publish' ),
  'category_name'          => 'bikes',	
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
		$size = (get_field('size')) ? get_field('size') :'' ;
		$orig_price = (get_field('original_price')) ? get_field('original_price') :'' ;
		$close_price = (get_field('closeout_price')) ? get_field('closeout_price') :'' ; 
		$quantity = (get_field('quantity')) ? get_field('quantity') :'1' ; ?>
		  <div class="inner-column">
  		  <ul class="resource-blocks">
  		    <li class="resource-info">
    		    <h1><?php the_title('', '', true) ;?></h1>
    		    <ul>
      		    <li><?php the_time( get_option( 'date_format' ) ); ?></li>
      		    <li>Size: <?php echo($size) ; ?></li>
      		    <li>Quantity Available: <?php echo($quantity) ; ?></li>
      		    <li><?php echo '<strike>' . $orig_price . '</strike>' . ' / '. $close_price ;?></li>
    		    </ul>
            <a href="<?php echo the_permalink(); ?>"><button>More Info</button></a>
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

<div class="wrap">
  <div class="content-home">
    <article>
      <h1 class="components">Components</h1>
    </article>
  </div>
</div>

<div class="wrap">
  <div class="content-home">
  
<?php  
// WP_Query arguments
$args = array (
	'post_type'              => array( 'post_type_closeout' ),
	'post_status'            => array( 'publish' ),
  'category_name'          => 'components',	
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
		$size = (get_field('size')) ? get_field('size') :'' ;
		$orig_price = (get_field('original_price')) ? get_field('original_price') :'' ;
		$close_price = (get_field('closeout_price')) ? get_field('closeout_price') :'' ; 
		$quantity = (get_field('quantity')) ? get_field('quantity') :'1' ; ?>
		  <div class="inner-column">
  		  <ul class="resource-blocks">
  		    <li class="resource-info">
    		    <h1><?php the_title('', '', true) ;?></h1>
    		    <ul>
      		    <li><?php the_time( get_option( 'date_format' ) ); ?></li>
      		    <li>Size: <?php echo($size) ; ?></li>
      		    <li>Quantity Available: <?php echo($quantity) ; ?></li>
      		    <li><?php echo '<strike>' . $orig_price . '</strike>' . ' / '. $close_price ;?></li>
    		    </ul>
            <a href="<?php echo the_permalink(); ?>"><button>More Info</button></a>
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
