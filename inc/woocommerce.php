<?php
/**
 * WooCommerce Integration
 *
 *
 * @package WordPress
 */
  
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

add_action('woocommerce_before_main_content', 'garrisons_woo_start', 10);
add_action('woocommerce_after_main_content', 'garrisons_woo_end', 10);

function garrisons_woo_start() {
  echo '<div class="wrap">';
	echo '<div id="primary" class="content-area">';
	echo '<main id="main" class="site-main" role="main">';
}

function garrisons_woo_end() {
  echo '</main> <!-- #main -->';
	echo '</div> <!-- #primary -->';

  get_sidebar();

  echo '</div> <!-- .wrap -->';
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/**
  
function woocommerce_demo_store() {
 if ( get_option( 'woocommerce_demo_store' ) == 'no' )
 return;
 
  $notice = get_option( 'woocommerce_demo_store_notice' );
  if ( empty( $notice ) )
    $notice = __( 'This is a demo store for testing purposes &mdash; no orders shall be fulfilled.', 'woocommerce' );

  $current_user = wp_get_current_user();
  $role_name = $current_user->roles[0];
  if($role_name != 'wholesale_customer'){
    echo apply_filters( 'woocommerce_demo_store', '<p class="demo_store">' . $notice . '</p>'  );
  }
}


function sv_hide_quantity_input() {
    $post_id = get_queried_object_id();

    if ( is_product() && metadata_exists( 'post', $post_id, 'wccaf_disable_quantity' ) ) {
      $hide_quanity = get_post_meta( $post_id, "wccaf_disable_quantity", true );
      if($hide_quanity == 'hide') :
        ?>
          <crap><?php echo (($hide_quanity) ? 'checked-' : 'not checked-') . $hide_quanity ;?></crap>
            <style type="text/css">
                form.cart div.quantity {
                    display: none !important;
                }
            </style>
        <?php
      endif;
    }
}
add_action( 'wp_head', 'sv_hide_quantity_input' );
**/

?>