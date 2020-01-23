<?php
/**
 * RegisterNavMenu class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction as WPAction;



class RegisterNavMenu extends WPAction {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('after_setup_theme', [$this, 'registerNavMenu']);
		
	}
	
	
	
	/**
	* callback
	*/
	public function registerNavMenu($menus) {
		
		foreach ($menus as $menu) {
			register_nav_menu($menu[0], $menu[1]);
		}
		
	}
	
	
	
}
