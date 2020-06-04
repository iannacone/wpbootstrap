<?php

/**
 * CustomPostType class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;



class CustomPostType extends WPAction
{



	/**
	 * initialize
	 */
	public function __construct()
	{
		parent::__construct('init');
	}



	/**
	 * callback
	 */
	public function callback()
	{
		$cpt = $this->collection;

		foreach ($cpt as $id => $options) {
			register_post_type($id, $options);
		}
	}
}
