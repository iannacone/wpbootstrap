<?php
/**
 * HtmlMarginTop class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;



class HtmlMarginTop extends WPAction {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('get_header');
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback() {
		
		$args = $this->collection;

		// remove admin login header
		if (isset($arg[0]) && $arg[0] == false) {
			remove_action('wp_head', '_admin_bar_bump_cb');
		}
		
	}
	
	
	
}
