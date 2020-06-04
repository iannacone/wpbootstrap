<?php

/**
 * WPFilters class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;

use WPBootstrap\WPFilters\LogoClasses;
// use WPBootstrap\WPFilters\ScssVariables; deprecated
use WPBootstrap\WPFilters\InlineStyles;
use WPBootstrap\WPFilters\DeferredStyles;
use WPBootstrap\WPFilters\AsyncDeferScripts;
use WPBootstrap\WPFilters\ExcerptMoreLink;
use WPBootstrap\WPFilters\ExcerptMore;

class WPFilters
{



	/**
	 * InlineStyles
	 */
	public $inline_styles;



	/**
	 * DeferredStyles
	 */
	public $deferred_styles;



	/**
	 * AsyncDeferScripts
	 */
	public $scripts_async_deferred;



	/**
	 * ScssVariables
	 */
	// public $scss_variables; deprecated



	/**
	 * LogoClasses
	 */
	public $logo_classes;



	/**
	 * ExcerptMoreLink
	 */
	public $excerpt_more_link;



	/**
	 * ExcerptMore
	 */
	public $excerpt_more;



	/**
	 * initialize
	 */
	public function __construct()
	{
		$this->logo_classes = new LogoClasses();
		// $this->scss_variables = new ScssVariables(); deprecated
		$this->inline_styles = new InlineStyles();
		$this->deferred_styles = new DeferredStyles();
		$this->scripts_async_deferred = new AsyncDeferScripts();
		$this->excerpt_more_link = new ExcerptMoreLink();
		$this->excerpt_more = new ExcerptMore();
	}
}
