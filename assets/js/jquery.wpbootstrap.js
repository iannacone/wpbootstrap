/**
 * Javascript for adjust bootstrap after init
 */

(function($){
	
	$(document).ready(function(){
		
		
		
		$('[data-toggle="modal"]').click(function(e){
			
			e.preventDefault();
			var $this = $(this),
				src = $this.find('img').attr('src'),
				$target = $($this.data('target'));
				
			$target.find('img').attr('src', src);
			
		});
		
		
		
	});
	
})(jQuery);