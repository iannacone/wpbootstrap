<?php

/**
 * defines
 *
 * @package wpbootstrap
 */



namespace WPBootstrap;



define('WPBOOTSTRAP_FOOTER_COLUMNS', 4);
define('WPBS_CLEARCACHE', 'clearCache');
define('WPBS_CSSCACHE', 'style.css');
define('WP_SCSS_ALWAYS_RECOMPILE', \WP_DEBUG);
define('I18N_TEXTDOMAIN', 'wp-bootstrap');


// paths

define('WPBOOTSTRAP', get_template_directory_uri());
define('WPBOOTSTRAP_JS', WPBOOTSTRAP . '/assets/js');
define('WPBOOTSTRAP_NODE', WPBOOTSTRAP . '/node_modules');
define('WPBOOTSTRAP_BS', WPBOOTSTRAP_NODE . '/bootstrap');
define('WPBOOTSTRAP_CACHE', WPBOOTSTRAP . '/cache');

define('WPBOOTSTRAP_ABS', __DIR__);
define('WPBOOTSTRAP_VENDOR_ABS', WPBOOTSTRAP_ABS . '/vendor');
define('WPBOOTSTRAP_INC', WPBOOTSTRAP_ABS . '/includes');
define('WPBOOTSTRAP_NODE_ABS', WPBOOTSTRAP_ABS . '/node_modules');
define('WPBOOTSTRAP_CACHE_ABS', WPBOOTSTRAP_ABS . '/cache');
