<?php
/**
 * Template Name: About
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
  <li class="big-block page-content" style="<?php echo $bg; ?>">
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
	'post_type'              => array( 'post_type_about' ),
	'post_status'            => array( 'publish' ),
	'nopaging'               => true,
);

// The Query
$query = new WP_Query( $args );

// The Loop

$count = 0;
$bio = 0;

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		$staff_title = (get_field('title')) ? get_field('title') :'Title' ;
    $staff_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
    $bg = (!empty( $staff_img ) ? "background-image: url('". $staff_img[0] ."');" : '');
    if ($count++ < 1) :?>
		  <li class="big-block">
		    <ul class="small-blocks">
		<?php
		endif  
		?>
		<li class="small-block" style="<?php echo $bg ;?>">
      <div class="staff">
        <h1><?php the_title('', '', true) ;?></h1>
        <h2><?php echo $staff_title; ?></h2>
        <label for="modal-<?php echo ++$bio ;?>">
          <div class="modal-trigger"><button>Read Bio</button></div>
        </label>
      </div>
      <div class="modal">
        <input class="modal-state" id="modal-<?php echo $bio ;?>" type="checkbox" />
        <div class="modal-fade-screen">
          <div class="modal-inner">
            <div class="modal-close" for="modal-<?php echo $bio ;?>"></div>
            <h1><?php echo '<span>' . the_title('', '', false) . '</span>' . ', ' . $staff_title;;?></h1>
            <ul class="modal-items">
              <li class="modal-content">
                <?php the_content() ;?>
              </li>
              <li class="modal-img">
                <img src="<?php echo $staff_img[0] ; ?>">
              </li>
            </ul>
<!--
            <p class="modal-intro">Intro text lorem ipsum dolor sit ametm, quas, eaque facilis aliquid cupiditate tempora cumque ipsum accusantium illo modi commodi  minima.</p>
            <p class="modal-content">Body text lorem ipsum dolor ipsum dolor sit sit possimus amet, consectetur adipisicing elit. Itaque, placeat, explicabo, veniam quos aperiam molestias eriam molestias molestiae suscipit ipsum enim quasi sit possimus quod atque nobis voluptas earum odit accusamus quibusdam. Body text lorem ipsum dolor ipsum dolor sit sit possimus amet.</p>
-->
          </div>
        </div>
      </div>
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

<?php get_footer(); ?>
