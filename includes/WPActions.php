<?php
/**
 * WPActions class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;

use WPBootstrap\WPActions\Menus;
use WPBootstrap\WPActions\ThemeSupports;
use WPBootstrap\WPActions\AdminBarButtons;
use WPBootstrap\WPActions\HtmlMarginTop;
use WPBootstrap\WPActions\Styles;
use WPBootstrap\WPActions\Scripts;
use WPBootstrap\WPActions\Sidebars;
use WPBootstrap\WPActions\CustomPostType;



class WPActions {
	
	
	
	/**
	* Scripts
	*/
	public $scripts = [];
	
	
	
	/**
	* Styles
	*/
	public $styles = [];
	
	
	
	/**
	* Sidebars
	*/
	public $sidebars = [];
	
	
	
	/**
	* Menus
	*/
	public $menus;
	
	
	
	/**
	* ThemeSupports
	*/
	public $theme_supports;
	
	
	
	/**
	* AdminBarButtons
	*/
	public $admin_bar_btns;
	
	
	
	/**
	* HtmlMarginTop
	*/
	public $html_margin_top;
	
	
	
	/**
	* CustomPostType
	*/
	public $custom_post_types;
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		$this->menus = new Menus();
		$this->theme_supports = new ThemeSupports();
		$this->admin_bar_btns = new AdminBarButtons();
		$this->html_margin_top = new HtmlMarginTop();
		$this->styles = new Styles();
		$this->scripts = new Scripts();
		$this->sidebars = new Sidebars();
		$this->custom_post_types = new CustomPostType();
		
	}
	
	
	
}