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
define('WPBOOTSTRAP_CACHE', WPBOOTSTRAP . '/cache');
define('WPBOOTSTRAP_CACHE_ABS', WPBOOTSTRAP_ABS . '/cache');



/*
 * requires because no class
 */
require_once(WPBOOTSTRAP_VENDOR_ABS . '/scssphp/scssphp/scss.inc.php');



class Autoload
{



	private static $classes = [
		'WPBootstrap\WPBootstrap' => WPBOOTSTRAP_INC . '/WPBootstrap.php',
		'WPBootstrap\SCSSPHP' => WPBOOTSTRAP_INC . '/SCSSPHP.php',
		'WPBootstrap\WPHelper' => WPBOOTSTRAP_INC . '/WPHelper.php',
		'WPBootstrap\WPCollection' => WPBOOTSTRAP_INC . '/WPCollection.php',
		'WPBootstrap\WPAction' => WPBOOTSTRAP_INC . '/WPAction.php',
		'WPBootstrap\WPActions\AdminBarButtons' => WPBOOTSTRAP_INC . '/WPActions/AdminBarButtons.php',
		'WPBootstrap\WPActions\HtmlMarginTop' => WPBOOTSTRAP_INC . '/WPActions/HtmlMarginTop.php',
		'WPBootstrap\WPActions\Menus' => WPBOOTSTRAP_INC . '/WPActions/Menus.php',
		'WPBootstrap\WPActions\Styles' => WPBOOTSTRAP_INC . '/WPActions/Styles.php',
		'WPBootstrap\WPActions\Scripts' => WPBOOTSTRAP_INC . '/WPActions/Scripts.php',
		'WPBootstrap\WPActions\Sidebars' => WPBOOTSTRAP_INC . '/WPActions/Sidebars.php',
		'WPBootstrap\WPActions\ThemeSupports' => WPBOOTSTRAP_INC . '/WPActions/ThemeSupports.php',
		'WPBootstrap\WPActions\CustomPostType' => WPBOOTSTRAP_INC . '/WPActions/CustomPostType.php',
		'WPBootstrap\WPActions' => WPBOOTSTRAP_INC . '/WPActions.php',
		'WPBootstrap\WPFilter' => WPBOOTSTRAP_INC . '/WPFilter.php',
		'WPBootstrap\WPFilters\LogoClasses' => WPBOOTSTRAP_INC . '/WPFilters/LogoClasses.php',
		'WPBootstrap\WPFilters\ScssVariables' => WPBOOTSTRAP_INC . '/WPFilters/ScssVariables.php',
		'WPBootstrap\WPFilters\InlineStyles' => WPBOOTSTRAP_INC . '/WPFilters/InlineStyles.php',
		'WPBootstrap\WPFilters\DeferredStyles' => WPBOOTSTRAP_INC . '/WPFilters/DeferredStyles.php',
		'WPBootstrap\WPFilters\AsyncDeferScripts' => WPBOOTSTRAP_INC . '/WPFilters/AsyncDeferScripts.php',
		'WPBootstrap\WPFilters\ExcerptMoreLink' => WPBOOTSTRAP_INC . '/WPFilters/ExcerptMoreLink.php',
		'WPBootstrap\WPFilters\ExcerptMore' => WPBOOTSTRAP_INC . '/WPFilters/ExcerptMore.php',
		'WPBootstrap\WPFilters' => WPBOOTSTRAP_INC . '/WPFilters.php',
		'WPBootstrap\Handlebars' => WPBOOTSTRAP_INC . '/Handlebars.php',
		'WPBootstrap\YouTube' => WPBOOTSTRAP_INC . '/YouTube.php',
		'WP_Bootstrap_Navwalker' => WPBOOTSTRAP_VENDOR_ABS . '/wp-bootstrap/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php',
		// 'WPFlyPage' => WPBOOTSTRAP_INC . '/WPFlyPage.php',
	];



	public function __construct()
	{

		spl_autoload_register(__CLASS__ . '::classResolver');
	}



	public static function classResolver($className)
	{

		self::register(self::$classes, $className);
	}



	private static function register($classes, $className)
	{

		if (isset($classes[$className])) {
			require_once($classes[$className]);
		}
	}
}

new Autoload();
