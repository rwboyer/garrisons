<?php
/**
 * Column short-code.
 */


// Add Shortcode
function column_shortcode( $atts , $content = null ) {

	// Attributes
	extract( $atts );
	
  
  $output = '<div class="inner-column">';
  
  $output = $output . do_shortcode($content) ;
  $output = $output . '</div>';
  
	return $output;
}
add_shortcode( 'column', 'column_shortcode' );

/**
 * Shortcode empty paragraph fix
 *
 *
 * @package WordPress
 */
  
add_filter( 'the_content', 'tgm_io_shortcode_empty_paragraph_fix' );
/**
 * Filters the content to remove any extra paragraph or break tags
 * caused by shortcodes.
 *
 * @since 1.0.0
 *
 * @param string $content  String of HTML content.
 * @return string $content Amended string of HTML content.
 */
function tgm_io_shortcode_empty_paragraph_fix( $content ) {
 
    $array = array(
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']'
    );
    return strtr( $content, $array );
 
}

?>