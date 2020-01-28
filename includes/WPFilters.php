<?php
/**
 * WPFilters class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;

use WPBootstrap\WPFilters\LogoClasses;
// use WPBootstrap\WPFilters\ScssVariables; deprecated
use WPBootstrap\WPFilters\InlineStyles;
use WPBootstrap\WPFilters\DeferredStyles;
use WPBootstrap\WPFilters\AsyncDeferScripts;

class WPFilters {
	
	
	
	/**
	* InlineStyles
	*/
	public $inline_styles;
	
	
	
	/**
	* DeferredStyles
	*/
	public $deferred_styles;
	
	
	
	/**
	* AsyncDeferScripts
	*/
	public $scripts_async_deferred;
	
	
	
	/**
	* ScssVariables
	*/
	public $scss_variables;
	
	
	
	/**
	* LogoClasses
	*/
	public $logo_classes;
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		$this->logo_classes = new LogoClasses();
		// $this->scss_variables = new ScssVariables(); deprecated
		$this->inline_styles = new InlineStyles();
		$this->deferred_styles = new DeferredStyles();
		$this->scripts_async_deferred = new AsyncDeferScripts();
		
	}
	
	
	
}