(function(){
	
	if(typeof deferred_styles !== 'undefined') {
		
		var loadDeferredStyles = function(){
				deferred_styles.forEach(function(id){
					var addStylesNode = document.getElementById(id);
					var replacement = document.createElement('div');
					replacement.innerHTML = addStylesNode.textContent;
					document.body.appendChild(replacement);
					addStylesNode.parentElement.removeChild(addStylesNode);
				});
			},
			raf = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
			
		if(raf)
			raf(function(){
				window.setTimeout(loadDeferredStyles, 0);
			});
		else
			window.addEventListener('load', loadDeferredStyles);
		
	}
	
})();