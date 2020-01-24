<?php
/**
 * HtmlMarginTop class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;



class HtmlMarginTop extends WPAction {
	
	
	
	private $active;
	
	
	
	/**
	* initialize
	*/
	public function __construct($active) {
		
		$this->active = $active;
		parent::__construct('get_header');
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback($arg = null) {
		
		// remove admin login header
		if (!$this->active) {
			remove_action('wp_head', '_admin_bar_bump_cb');
		}
		
	}
	
	
	
}
