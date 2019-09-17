(function(){
	
	if(typeof deferred_fonts !== 'undefined') {
		
		/*
		EXAMPLE
		var font = new FontFace("Awesome Font", "url(/fonts/awesome.woff2)", {
			style: 'normal', unicodeRange: 'U+000-5FF', weight: '400'
		});
		*/
		
		deferred_fonts.forEach(function(args, index){
			var font = new FontFace(args);
			font.load().then(function(){
				document.fonts.add(font);
			});
		});
		
	}
	
})();