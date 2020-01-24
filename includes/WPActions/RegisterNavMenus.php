<?php
/**
 * RegisterNavMenus class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;



class RegisterNavMenus extends WPAction {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('after_setup_theme');
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback($menus = null) {
		
		register_nav_menus($menus);
		
	}
	
	
	
}
