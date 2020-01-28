<?php
/**
 * Sidebars class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;



class Sidebars extends WPAction {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('widgets_init');
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback() {
		
		$sidebars = $this->collection;

		foreach ($sidebars as $sidebar) {
			register_sidebar($sidebar);
		}
		
	}
	
	
	
}
