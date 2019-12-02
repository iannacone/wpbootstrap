<?php
/**
 * Autoload class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



define('WPBOOTSTRAP', get_template_directory_uri());
define('WPBOOTSTRAP_ABS', __DIR__);
define('WPBOOTSTRAP_INC', WPBOOTSTRAP_ABS . '/includes');
define('WPBOOTSTRAP_JS', WPBOOTSTRAP . '/assets/js');
define('WPBOOTSTRAP_VENDOR', WPBOOTSTRAP . '/vendor');
define('WPBOOTSTRAP_VENDOR_ABS', WPBOOTSTRAP_ABS . '/vendor');
define('WPBOOTSTRAP_BS', WPBOOTSTRAP_VENDOR . '/bootstrap/' . WPBOOTSTRAP_VERSION);
define('WPBOOTSTRAP_CACHE', WPBOOTSTRAP_ABS . '/cache');
// define('WPBOOTSTRAP_CSS', WPBOOTSTRAP . '/assets/css'); // wp-scss



/*
 * requires because no class
 */
require_once(WPBOOTSTRAP_VENDOR_ABS . '/scssphp/scss.inc.php');



class Autoload {
	
	
	
	private static $classes = [
		'ScssPhp\ScssPhp\Server' => WPBOOTSTRAP_VENDOR_ABS . '/scssphp/example/Server.php',
		'WPBootstrap\WPHelper' => WPBOOTSTRAP_INC . '/WPHelper.php',
		'WPBootstrap\WPFilters' => WPBOOTSTRAP_INC . '/WPFilters.php',
		'WPBootstrap\WPActions' => WPBOOTSTRAP_INC . '/WPActions.php',
		'WPBootstrap\Handlebars' => WPBOOTSTRAP_INC . '/Handlebars.php',
		'WPBootstrap\YouTube' => WPBOOTSTRAP_INC . '/YouTube.php',
		'WP_Bootstrap_Navwalker' => WPBOOTSTRAP_ABS . '/vendor/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php',
		// 'WPFlyPage' => WPBOOTSTRAP_INC . '/WPFlyPage.php',
	];
	
	
	
	public function __construct() {
		
		spl_autoload_register(__CLASS__ . '::classResolver');
		
	}
	
	
	
	public static function classResolver($className) {
		
		self::register(self::$classes, $className);
		
	}
	
	
	
	private static function register($classes, $className) {
		
		if (isset($classes[$className])) {
			require_once($classes[$className]);
		}
		
	}
	
	
	
}

new Autoload();