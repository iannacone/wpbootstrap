<?php

/**
 * LogoClasses class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPFilters;

use WPBootstrap\WPFilter;



class LogoClasses extends WPFilter
{



	/**
	 * initialize
	 */
	public function __construct()
	{
		parent::__construct('get_custom_logo', 10, 2);
	}



	/**
	 * callback
	 */
	public function callback($value, $args = null)
	{
		$html = $value;
		list($blog_id) = $args;

		$wp = 'custom-logo-link';

		$this->append($wp);
		$logo_classes = $this->collection;

		$html = str_replace($wp, implode(' ', $logo_classes), $html);

		return $html;
	}
}
