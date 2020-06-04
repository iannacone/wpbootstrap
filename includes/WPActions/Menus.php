<?php

/**
 * Menus class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;



class Menus extends WPAction
{



	/**
	 * initialize
	 */
	public function __construct()
	{
		parent::__construct('after_setup_theme');
	}



	/**
	 * callback
	 */
	public function callback()
	{
		$menus = $this->collection;

		register_nav_menus($menus);
	}
}
