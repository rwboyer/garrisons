<?php
/**
 * Template Name: Homepage
 *
 *
 * @package Hooch
 */

get_header('home'); ?>

<?php 
	 // Gets the uploaded featured image
  	$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
  	// Checks and returns the featured image
  	$bg = (!empty( $featured_img ) ? "background-image: url('". $featured_img[0] ."');" : '');
?>

<div class="hero" style="<?php echo $bg; ?>">
	<div class="hero-inner">
    <div class="hero-logo">
    	<?php if(get_field('hero_image')) {
			echo '<img src="' . get_field('hero_image') . '" alt="">';
		} else { ?>
			<img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
		<?php } ?>
    	
	</div>
		<div class="hero-copy">
			<?php the_field('hero_content') ?>	
		</div>
	</div>
</div>

<div class="hours">
  <div class="wrap">
    <div class="content-home">
      <p>Mon: CLOSED  /  Tue: 9-6  /  Wed: 9-8  /  Thu: 9-6  /  Fri: 9-8  /  Sat: 9-5  /  Sun: 11-4</p>
    </div>
  </div>
</div>

<div class="wrap">
	<div id="primary" class="content-page">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'home' ); ?>
				
				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<div class="savings">
  	<h1> Shop Tax-Free &<br><span>Save 6-10%!</span></h1>
	</div>

</div> <!-- .wrap -->

<div class="callout">
  <p>To schedule an appointment for bicycle repair or an experienced bike fitting</p>
  <h1>CALL THE PROS AT (302) 384-6827</h1>
</div>

<?php echo do_shortcode('[instagram-feed showheader=false num=9 cols=3 showbutton=false showfollow=false]') ; ?>

<div id="news" class="wrap">
  <div class="content-home">
    <h2>News & Events</h2>
    
    <?php
    // WP_Query arguments
    $args = array (
    	'post_type'              => array( 'post' ),
    	'post_status'            => array( 'publish' ),
    	'nopaging'               => true,
    );
    
    // The Query
    $query = new WP_Query( $args );
    
    // The Loop
    
    $count = 0;
    if ( $query->have_posts() ) {
    	while ( $query->have_posts() && $count++ < 5) {
    		$query->the_post();
    ?>
      	<header class="entry-header">
      		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
      		<a class="button" href="<?php echo esc_url( get_permalink() );?>">Read More</a>
      	</header><!-- .entry-header -->
    <?php
      }
    } 
        
    // Restore original Post Data
    wp_reset_postdata();
    ?>
    
  </div>
</div>
    
<div class="wrap brand-section">
  <div class="brand-statement">
    <div class="red-header"><h1>Our Brands</h1></div>
    <p>The brands of bikes and components we carry are on the shelf for a reason. Purchases are made and products are endorsed because of experience, not profit margin. In other words, we only sell products we believe in. That’s the bottom line.</p>
  </div>
  
  <div class="brand-slider">
    <div id="lean-slider">
        
<?php  
// WP_Query arguments
$args = array (
	'post_type'              => array( 'post_type_brand' ),
	'post_status'            => array( 'publish' ),
);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		$brand_link = (get_field('brand_link')) ? get_field('brand_link') :'#' ;
		?>
		<div><a href="<?php echo $brand_link; ?>"><?php echo get_the_post_thumbnail($post_id, 'full'); ?></a></div>
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
    
</div>

<div class="closeouts">
  <div class="wrap no-margin">
    <div class="closeout-list">
      <h1>Inventory Closeouts</h1>
<?php  
// WP_Query arguments
$args = array (
	'post_type'              => array( 'post_type_closeout' ),
	'post_status'            => array( 'publish' ),
);

// The Query
$query = new WP_Query( $args );

// The Loop

$count = 0;

if ( $query->have_posts() ) {
	while ( $query->have_posts() && $count++ < 5 ) {
		$query->the_post();
		$make = (get_field('make') ? get_field('make') : 'Make');
		$model = (get_field('model') ? get_field('model') : 'Model');
		$color = (get_field('color') ? get_field('color') : 'Color');
		$size = (get_field('size') ? get_field('size') : 'Size');
		$price = (get_field('closeout_price') ? get_field('closeout_price') : '0.00');
		//the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); 
		?>
		<p class="top-line">
    		<span class="description">
    		  <a href="<?php the_permalink() ;?>">
            <?php echo $make. '/' . $model ;?>
    		  </a>
        </span>
  		<span class="price"><?php echo $price ;?></span>
		</p>
		<p><?php echo $color . '/' . $size ;?></p>
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
</div>

<div class="wrap service-section">
  <div class="service-section-inner">
    <h1>An authorized service center for Chris King, Rock Shox, Fox & Shimano</h1>
    <ul class="service-brands">
      <li class="service-brand"><img src="<?php bloginfo('template_url'); ?>/images/chris-king-logo.png"></li>
      <li class="service-brand"><img src="<?php bloginfo('template_url'); ?>/images/rockshox-logo.gif"></li>
      <li class="service-brand"><img src="<?php bloginfo('template_url'); ?>/images/fox-logo.jpg"></li>
      <li class="service-brand"><img src="<?php bloginfo('template_url'); ?>/images/shimano-logo.png"></li>
    </ul>
  </div>
</div>

<div class="testimonial-section">
  <ul class="testimonials">
<?php  
// WP_Query arguments
$args = array (
	'post_type'              => array( 'testimonial_post_typ' ),
	'post_status'            => array( 'publish' ),
  'orderby'                => 'rand',
);

// The Query
$query = new WP_Query( $args );

// The Loop

$count = 0;

if ( $query->have_posts() ) {
	while ( $query->have_posts() && $count++ < 3 ) {
		$query->the_post();
		$testimonial = (get_field('testimonial') ? get_field('testimonial') : 'Testimonial goes here');
		$cite = the_title('', '', false);
		?>
    <li class="testimonial"><blockquote><?php echo $testimonial ;?><cite><?php echo $cite ;?></cite></blockquote></li>
		<?php
	}
} else {
	// no posts found
}

// Restore original Post Data
wp_reset_postdata();
?>
  </ul>
</div>

<div class="map-section">
  <?php echo do_shortcode('[mappress mapid="1" width="100%" height="400" adaptive="true"]'); ?>
</div>

<script>
  jQuery(document).ready(function() {
      jQuery('#lean-slider').leanSlider({pauseTime: 1000});
  });
</script>

<!--
<script>
	jQuery(document).ready(function($) {
		$('.brands-slider').unslider();
	});
</script>
-->

<?php get_footer(); ?>
