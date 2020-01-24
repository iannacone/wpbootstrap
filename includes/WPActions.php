<?php
/**
 * WPActions class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;

use WPBootstrap\WPActions\RegisterNavMenus;
use WPBootstrap\WPActions\ThemeSupports;
use WPBootstrap\WPActions\AdminBarCache;
use WPBootstrap\WPActions\HtmlMarginTop;



class WPActions {
	
	
	
	/**
	* WPAction
	*/
	public $scripts = [];
	
	
	
	/**
	* WPAction
	*/
	public $styles = [];
	
	
	
	/**
	* WPAction
	*/
	public $sidebars = [];
	
	
	
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
		
		$this->menus = new RegisterNavMenus();
		$this->theme_supports = new ThemeSupports();
		$this->admin_bar_cache = new AdminBarCache();
		
	}
	
	
	
	/*
	 * admin login header
	 */
	public function htmlMarginTop($active) {
		
		new HtmlMarginTop($active);
		
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