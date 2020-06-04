<?php

/**
 * DeferredStyles class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPFilters;

use WPBootstrap\WPFilter;



class DeferredStyles extends WPFilter
{



	/**
	 * initialize
	 */
	public function __construct()
	{
		parent::__construct('style_loader_tag', 10, 4);
	}



	/**
	 * callback
	 */
	public function callback($value, $args = null)
	{
		$html = $value;
		list($handle, $href, $media) = $args;

		if (in_array($handle, $this->collection)) {
			// $html = "<noscript id='$handle'><link rel='stylesheet' href='$href' type='text/css' media='$media' /></noscript>"; that sucks
			$html = '<noscript id="' . $handle . '"><link rel="stylesheet" href="' . $href . '" type="text/css" media="' . $media . '" /></noscript>';
		}

		return $html;
	}
}
