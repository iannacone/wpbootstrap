<?php
/**
 * AdminBarButtons class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;



class AdminBarButtons extends WPAction {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('wp_before_admin_bar_render');
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback($btns = null) {
		
		global $wp_admin_bar;
		
		foreach ($btns as $btn) {
			$wp_admin_bar->add_menu($btn);
		}
		
	}
	
	
	
}
