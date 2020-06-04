<?php

/**
 * functions and defines
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wpbootstrap
 */



namespace WPBootstrap;



define('I18N_TEXTDOMAIN', 'wp-bootstrap');
define('WPBOOTSTRAP_FOOTER_COLUMNS', 4);
define('WPBOOTSTRAP_VERSION', '4.5');
define('WPBS_CLEARCACHE', 'clearCache');
define('WPBS_CSSCACHE', 'style.css');
define('FONT_SIZE_BASE', 16);
define('WP_SCSS_ALWAYS_RECOMPILE', \WP_DEBUG);



require_once('Autoload.php');



$WPBootstrap = new WPBootstrap();
