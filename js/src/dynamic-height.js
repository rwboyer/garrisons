jQuery(window).on('resize', function(){
  var cw = jQuery('.big-block').outerWidth();
  jQuery('.big-block').css({'height':cw+'px'});
});

jQuery(document).ready(function(){
  jQuery(window).trigger('resize');
});