<?php

/**
 * ScssVariables class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPFilters;

use WPBootstrap\WPFilter;



class ScssVariables extends WPFilter
{



	/**
	 * initialize
	 */
	public function __construct()
	{
		parent::__construct('wp_scss_variables', 10, 1);
	}



	/**
	 * callback
	 */
	public function callback($value, $args = null)
	{
		$variables = $value;

		$this->appendCollection($variables);
		$variables = $this->collection;

		return $variables;
	}
}
