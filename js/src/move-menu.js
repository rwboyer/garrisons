jQuery(document).ready(function(){
  jQuery('header.navigation').css({ top: jQuery('p.demo_store').outerHeight() });
  jQuery('#content').css({ top: jQuery('p.demo_store').outerHeight() });
});