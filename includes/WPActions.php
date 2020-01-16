<?php
/**
 * WPActions class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



class WPActions {
	
	
	
	/**
	* WPAction
	*/
	public $scripts;
	
	
	
	/**
	* WPAction
	*/
	public $styles;
	
	
	
	/**
	* WPAction
	*/
	public $sidebars;
	
	
	
	/**
	* WPAction
	*/
	public $menus;
	
	
	
	/**
	* WPAction
	*/
	public $theme_supports;
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		$this->menus = new WPAction('after_setup_theme', function($menus) {
			foreach ($menus as $menu) {
				register_nav_menu($menu[0], $menu[1]);
			}
		});
		
		add_action('after_setup_theme', [$this, 'themeSupports']);
		add_action('wp_before_admin_bar_render', [$this, 'addFrontendAdminBarCacheSupport']);
		
	}
	
	
	
	/*
	 * add the theme supports
	 */
	public function themeSupports() {
		
		add_theme_support('custom-logo');
		add_theme_support('custom-background');
		add_theme_support('custom-header');
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		// set_post_thumbnail_size(250, 9999);
		add_theme_support('html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]);
		
		// gutenberg
		add_theme_support('align-wide');
		add_theme_support('wp-block-styles');
		// woocommerce
		// https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
		add_theme_support('woocommerce');
		
		register_nav_menu('primary-menu', __('Main Header Menu'));
		
	}
	
	
	
	/*
	 * add a link to the admin bar in the frontend to clear the cache
	 */
	public function addFrontendAdminBarCacheSupport() {
		
		global $wp_admin_bar;
		
		$wp_admin_bar->add_menu([
			'id' => 'clear_cache',
			'title' => __('Clear the cache'),
			'parent' => false,
			'href' => '?' . WPBS_CLEARCACHE . '=1',
			'meta' => [
				'class' => 'clear-cache',
				'onclick' => 'if(!confirm("' . __('Sure?') . '")) return false;',
			],
		]);
		
	}
	
	
	
	/*
	 * the action
	 */
	public function _removeHtmlMarginTop() {
		
		remove_action('wp_head', '_admin_bar_bump_cb');
		
	}
	
	
	
	/*
	 * remove admin login header
	 */
	public function removeHtmlMarginTop() {
		
		add_action('get_header', [$this, '_removeHtmlMarginTop']);
		
	}
	
	
	
	/*
	 * the action
	 */
	public function _assets() {
		
		WPHelper::styles($this->styles);
		WPHelper::scripts($this->scripts);
		
	}
	
	
	
	/**
	* add the scripts
	*/
	public function scripts($scripts = []) {
		
		$this->scripts = array_merge($this->scripts, $scripts);
		
		remove_action('wp_enqueue_scripts', [$this, '_assets']);
		add_action('wp_enqueue_scripts', [$this, '_assets']);
		
	}
	
	
	
	/**
	* add the script
	*/
	public function script($script = []) {
		
		$this->scripts([$script]);
		
	}
	
	
	
	/**
	* add the styles
	*/
	public function styles($styles = []) {
		
		$this->styles = array_merge($this->styles, $styles);
		
		remove_action('wp_enqueue_scripts', [$this, '_assets']);
		add_action('wp_enqueue_scripts', [$this, '_assets']);
		
	}
	
	
	
	/**
	* add the style
	*/
	public function style($style = []) {
		
		$this->styles([$style]);
		
	}
	
	
	
	/*
	 * the action
	 */
	public function _sidebars() {
		
		foreach ($this->sidebars as $sidebar) {
			register_sidebar($sidebar);
		}
		
	}
	
	
	
	/**
	* add the sidebars
	*/
	public function sidebars($sidebars = []) {
		
		$this->sidebars = array_merge($this->sidebars, $sidebars);
		
		remove_action('widgets_init', [$this, '_sidebars']);
		add_action('widgets_init', [$this, '_sidebars']);
		
	}
	
	
	
	/**
	* add the sidebar
	*/
	public function sidebar($sidebar = []) {
		
		$this->sidebars([$sidebar]);
		
	}
	
	
	
}