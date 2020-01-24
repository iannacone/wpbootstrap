<?php
/**
 * AdminBarCache class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;



class AdminBarCache extends WPAction {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('wp_before_admin_bar_render');
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback($arg = null) {
		
		global $wp_admin_bar;
		
		$wp_admin_bar->add_menu([
			'id' => 'clear_cache',
			'title' => __('Clear the cache'),
			'parent' => false,
			'href' => '?' . WPBS_CLEARCACHE . '=1',
			'meta' => [
				'class' => 'clear-cache',
				'onclick' => 'if(!confirm("' . __('Are you sure?') . '")) return false;',
			],
		]);
		
	}
	
	
	
}
