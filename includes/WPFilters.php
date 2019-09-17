<?php
/**
 * WPFilters class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



class WPFilters {
	
	
	
	/**
	* array
	*/
	private $styles_inline = [];
	
	
	
	/**
	* array
	*/
	private $styles_deferred = [];
	
	
	
	/**
	* array
	*/
	private $scripts_async_deferred = [];
	
	
	
	/**
	* array
	*/
	private $scss_variables = [];
	
	
	
	/**
	* array
	*/
	private $logo_classes = [];
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		
		
	}
	
	
	
	/**
	* the filter
	*/
	public function _scssVariables($variables) {
		
		$variables = $this->scss_variables;
		
		return $variables;
		
	}
	
	
	
	/**
	* set the variables to pass to the scss compiler
	*/
	public function scssVariables($variables) {
		
		$this->scss_variables = array_merge($this->scss_variables, $variables);
		
		remove_filter('wp_scss_variables', [$this, '_scssVariables'], 10, 1);
		add_filter('wp_scss_variables', [$this, '_scssVariables'], 10, 1);
		
	}
	
	
	
	/**
	* set a variable to pass to the scss compiler
	*/
	public function scssVariable($name, $value) {
		
		$this->scssVariables([$name => $value]);
		
	}
	
	
	
	/**
	* the filter
	*/
	public function _logoClasses($html, $blog_id) {
		
		$wp = 'custom-logo-link';
		$this->logo_classes[] = $wp;
		
		$html = str_replace($wp , implode(' ', $this->logo_classes), $html);
		
		return $html;
		
	}
	
	
	
	/**
	* set the classes for the logo
	*/
	public function logoClasses($classes) {
		
		$this->logo_classes = array_merge($this->logo_classes, $classes);
		
		remove_filter('get_custom_logo', [$this, '_logoClasses'], 10, 2);
		add_filter('get_custom_logo', [$this, '_logoClasses'], 10, 2);
		
	}
	
	
	
	/**
	* set a class for the logo
	*/
	public function logoClass($class) {
		
		$this->logoClasses([$class]);
		
	}
	
	
	
	/**
	* the filter
	*/
	public function _asyncDeferScripts($tag, $handle, $src) {
		
		if (in_array($handle, $this->scripts_async_deferred)) {
			$tag = '<script type="text/javascript" src="' . $src . '" async="async" defer="defer"></script>' . "\n";
		}
		
		return $tag;
		
	}
	
	
	
	/**
	* set $scripts_async_deferred scripts to async and defer
	*/
	public function asyncDeferScripts($scripts_async_deferred = []) {
		
		$this->scripts_async_deferred = $scripts_async_deferred;
		
		add_filter('script_loader_tag', [$this, '_asyncDeferScripts'], 10, 3);
		
	}
	
	
	
	/**
	* the filter
	*/
	public function _inlineCss($html, $handle, $href, $media) {
		
		if (in_array($handle, $this->styles_inline)) {
			
			$css = WPHelper::getFile($href);
			$css = WPHelper::compressCss($css);
			$html = '<style type="text/css">' . $css . '</style>' . "\n";
			
		}
		
		return $html;
		
	}
	
	
	
	/**
	* print $styles_inline styles
	*/
	public function inlineCss($styles_inline = []) {
		
		$this->styles_inline = $styles_inline;
		
		add_filter('style_loader_tag', [$this, '_inlineCss'], 10, 4);
		
	}
	
	
	
	/**
	* the filter
	*/
	public function _deferCss($html, $handle, $href, $media) {
		
		if (in_array($handle, $this->styles_deferred)) {
			// $html = "<noscript id='$handle'><link rel='stylesheet' href='$href' type='text/css' media='$media' /></noscript>";
			$html = '<noscript id="' . $handle . '"><link rel="stylesheet" href="' . $href . '" type="text/css" media="' . $media . '" /></noscript>';
		}
		
		return $html;
		
	}
	
	
	
	/**
	* defer the $styles_deferred styles with a script
	*/
	public function deferCss($styles_deferred = []) {
		
		$this->styles_deferred = $styles_deferred;
		
		add_filter('style_loader_tag', [$this, '_deferCss'], 10, 4);
		
	}
	
	
	
}