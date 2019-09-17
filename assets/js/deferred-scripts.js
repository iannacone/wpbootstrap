(function(){
	
	if(typeof deferred_scripts !== 'undefined') {
		
		var loadDeferredScripts = function(){
				deferred_scripts.forEach(function(url){
					var replacement = document.createElement('script');
					replacement.setAttribute('type', 'text/javascript');
					replacement.src = url;
					document.head.appendChild(replacement);
				});
			},
			raf = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
			
		if(raf)
			raf(function(){
				window.setTimeout(loadDeferredScripts, 0);
			});
		else
			window.addEventListener('load', loadDeferredScripts);
		
	}
	
})();