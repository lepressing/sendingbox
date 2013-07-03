
$(document).ready(function () {
    $(function(){
      var $container = $('#containeriso');

      $container.isotope({
        itemSelector : '.box',
/*         layoutMode: 'cellsByRow',cellsByRow: {columnWidth: 0,rowHeight: 300} */
      });
// filter items when filter link is clicked
	$('#filters a').click(function(){
	
	  var selector = $(this).attr('data-filter');
	  $container.isotope({
	  //options
	  	filter: selector,
	  	animationOptions: {duration: 750,easing: 'linear',queue: false}        
      });
 // light link is clicked
      var $optionSets = $('#options .option-set'),
          $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
	        if ( $this.hasClass('selected') ) {
	          return false;
	         }
	       });
       });		
	});	
});