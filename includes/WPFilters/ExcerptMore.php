<?php

/**
 * ExcerptMore class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPFilters;

use WPBootstrap\WPFilter;



class ExcerptMore extends WPFilter
{



	/**
	 * initialize
	 */
	public function __construct()
	{
		parent::__construct('excerpt_more', 10, 1);
	}



	/**
	 * callback
	 */
	public function callback($value, $args = null)
	{
		$more = $value;
		$collection = $this->collection;

		if (isset($collection[0]) && $collection[0] !== null && $collection[0] !== false) {
			$more = $collection[0];
		}

		return $more;
	}
}
