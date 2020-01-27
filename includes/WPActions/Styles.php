<?php
/**
 * Styles class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;
use WPBootstrap\WPHelper;



class Styles extends WPAction {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('wp_enqueue_scripts');
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback($styles = null) {
		
		/**
		* extension of wp_enqueue_style and wp_register_style
		*/

		foreach ($styles as $args) {
			
			$default = [
				'handle' => '',
				'src' => '',
				'deps' => [],
				'ver' => false,
				'media' => 'all',
			];
			
			$args = array_merge($default, $args);
			
			extract($args);
			
			if (WP_DEBUG && strlen($src) > 0 && !WPHelper::fileExists($src)) {
				wp_die(sprintf(__('%s style not found.'), $src));
			}
			
			wp_enqueue_style($handle, $src, $deps, $ver, $media);
			
		}
	}
	
	
	
}
