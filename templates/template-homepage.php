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
	<div id="primary" class="content-home">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'home' ); ?>
				
				<?php 
                    // Checks to see if the bullet color values are set
					$color1 = (get_field('bullet_1_color') ? 'background:' . get_field('bullet_1_color') . ';' : '');
					$color2 = (get_field('bullet_2_color') ? 'background:' . get_field('bullet_2_color') . ';' : '');
					$color3 = (get_field('bullet_3_color') ? 'background:' . get_field('bullet_3_color') . ';' : ''); 
				?>

				<ul class="bullets">
				  <li class="bullet">
				    <div class="bullet-icon bullet-icon-1" style="<?php echo $color1; ?>">
				    	<?php if(get_field('bullet_1_image')) {
							echo '<img src="' . get_field('bullet_1_image') . '" alt="">';
						} else { ?>
							<img src="<?php bloginfo('template_url'); ?>/images/bullet-1.png" alt="">
						<?php } ?>
				    </div>
				    <div class="bullet-content">
				      <?php the_field('bullet_1_content') ?>
				  </div>
				  </li>  
				  <li class="bullet">
				    <div class="bullet-icon bullet-icon-2" style="<?php echo $color2; ?>">
				      <?php if(get_field('bullet_2_image')) {
							echo '<img src="' . get_field('bullet_2_image') . '" alt="">';
						} else { ?>
							<img src="<?php bloginfo('template_url'); ?>/images/bullet-2.png" alt="">
						<?php } ?>
				    </div>
				    <div class="bullet-content">
				      <?php the_field('bullet_2_content') ?>
				  </div>
				  </li>
				  <li class="bullet">
				    <div class="bullet-icon bullet-icon-3" style="<?php echo $color3; ?>">
				      <?php if(get_field('bullet_3_image')) {
							echo '<img src="' . get_field('bullet_3_image') . '" alt="">';
						} else { ?>
							<img src="<?php bloginfo('template_url'); ?>/images/bullet-3.png" alt="">
						<?php } ?>
				    </div>
				    <div class="bullet-content">
				      <?php the_field('bullet_3_content') ?>
				  </div>
				  </li> 
				</ul>

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
    if ( $query->have_posts() ) {
    	while ( $query->have_posts() ) {
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

<?php get_footer(); ?>
