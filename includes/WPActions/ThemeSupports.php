<?php

/**
 * ThemeSupports class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;



class ThemeSupports extends WPAction
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
		$supports = $this->collection;

		foreach ($supports as $key => $value) {

			$has_args = is_string($key);
			$support = ($has_args ? $key : $value);
			$args = ($has_args ? $value : []);

			add_theme_support($support, $args);
		}
	}
}
