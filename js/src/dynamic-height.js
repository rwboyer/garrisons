jQuery(window).on('resize', function(){
  var cw = jQuery('.big-block').outerWidth();
  jQuery('.big-block').css({'height':cw+'px'});
  cw = jQuery('.post-block').outerWidth();
  jQuery('.post-block').css({'height':cw+'px'});
});

jQuery(window).on('resize', function(){
  jQuery('.post-block article p').each(function(){
    $clamp(this, {clamp: 'auto'});
  });
});

jQuery(document).ready(function(){
  jQuery(window).trigger('resize');
});

