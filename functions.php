<?php
/**
 * functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wpbootstrap
 */



namespace WPBootstrap;



define('WPBOOTSTRAP_FOOTER_COLUMNS', 3);
define('WPBOOTSTRAP_VERSION', '4.3.1');
define('WPBS_CLEARCACHE', 'clearCache');
define('FONT_SIZE_BASE', 14); // for a mixin
define('WP_SCSS_ALWAYS_RECOMPILE', WP_DEBUG);



require_once('Autoload.php');


class WPBootstrap {
	
	
	
	/**
	 * WPBootstrap\WPFilters
	 */
	protected $WPFilters;
	
	/**
	 * WPBootstrap\WPActions
	 */
	protected $WPActions;
	
	/**
	 * WPBootstrap\Handlebars
	 */
	protected $Handlebars;
	
	/**
	 * WPBootstrap\YouTube
	 */
	protected $YouTube;
	
	/**
	 * array of names of style handles (for deferring the styles with a script)
	 */
	protected $styles_deferred;
	
	
	
	/**
	 * init
	 */
	public function __construct() {
		
		$this->WPFilters = new WPFilters();
		$this->WPActions = new WPActions();
		$this->Handlebars = new Handlebars();
		$this->YouTube = new YouTube();
		$this->styles_deferred = [];
		
		/*
		all the styles are managed and compressed with wpscss
		https://wordpress.org/plugins/wp-scss/
		$this->styles();
		*/
		$this->removeHtmlMarginTop();
		$this->handlebars();
		$this->logoClasses();
		$this->scssVariables();
		$this->scripts();
		$this->sidebars();
		// $this->inlineCSS();
		// $this->deferCss();
		/*
		replaced by hyperdriver plugin
		$this->asyncDeferScripts();
		*/
		// $this->removeAdminLoginHeader();
		
	}
	
	
	
	/**
	* remove the margin top on the html tag made for the admin menu in forntend
	*/
	public function removeHtmlMarginTop() {
		
		$this->WPActions->removeHtmlMarginTop();
		
	}
	
	
	
	/**
	* styles manager
	*/
	public function styles() {
		
		$this->WPActions->styles([
			[
				'handle' => 'bootstrap',
				'src' => WPBOOTSTRAP_BS . '/css/bootstrap.min.css',
			],
			[
				'handle' => 'bootstrap-theme',
				'src' => WPBOOTSTRAP_BS . '/css/bootstrap-theme.min.css',
				'deps' => ['bootstrap'],
			],
			[
				'handle' => 'custom',
				'src' => WPBOOTSTRAP_CSS . '/custom.css',
				'deps' => ['bootstrap-theme'],
			],
		]);
		
	}
	
	
	
	/**
	* register the lazy block plugin handlebars
	*/
	public function handlebars() {
		
		$this->Handlebars->lzb_handlebars_object();
		
	}
	
	
	
	/**
	* set the variables to pass to the scss compiler
	*/
	public function logoClasses() {
		
		$this->WPFilters->logoClasses([
			'navbar-brand',
		]);
		
	}
	
	
	
	/**
	* set the variables to pass to the scss compiler
	*/
	public function scssVariables() {
		
		$this->WPFilters->scssVariables([
			'bs_version' => '\'' . WPBOOTSTRAP_VERSION . '\'',
			'font-size-base' => FONT_SIZE_BASE . 'px', // for a mixin
		]);
		
		
		if (isset($_GET[WPBS_CLEARCACHE]) && current_user_can('administrator')) {
			
			WPHelper::emptyDirectory(WPBOOTSTRAP_CACHE);
			
			if (function_exists('wp_scss_compile')) {
				wp_scss_compile();
			}
			
			$clear_url = WPHelper::stripOffUrl(WPHelper::getCurrentUrl(), [WPBS_CLEARCACHE]);
			header('Location: ' . $clear_url);
			die();
		}
		
		
	}
	
	
	
	/**
	* scripts manager
	*/
	public function scripts() {
		
		$scripts = [
			[
				'handle' => 'html5shiv',
				'src' => WPBOOTSTRAP_VENDOR . '/html5shiv/dist/html5shiv.min.js',
				'data' => [
					'key' => 'conditional',
					'value' => 'lt IE 9',
				]
			],
			[
				'handle' => 'respond',
				'src' => WPBOOTSTRAP_VENDOR . '/respond/respond.matchmedia.addListener.min.js',
				'data' => [
					'key' => 'conditional',
					'value' => 'lt IE 9',
				]
			],
			[
				'handle' => 'skip-link-focus',
				'src' => WPBOOTSTRAP_VENDOR . '/skip-link-focus/skip-link-focus.min.js',
			],
			// [
				// 'handle' => 'polyfill',
				// 'src' => WPBOOTSTRAP_VENDOR . '/bootstrap.native/dist/polyfill.min.js',
			// ],
			[
				'handle' => 'bootstrap',
				'src' => WPBOOTSTRAP_VENDOR . '/bootstrap.native/dist/bootstrap-native' . (intval(WPBOOTSTRAP_VERSION) > 3 ? '-v4' : '') . '.min.js',
				// 'deps' => ['polyfill'],
			],
			// [
				// 'handle' => 'touch-punch',
				// 'src' => WPBOOTSTRAP_VENDOR . '/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js',
				// 'deps' => ['jquery'],
			// ],
			// [
				// 'handle' => 'graphic-code-start',
				// 'src' => WPBOOTSTRAP_JS . '/graphic-code-start.js',
				// 'deps' => ['touch-punch'],
			// ],
			// [
				// 'handle' => 'bootstrap',
				// 'src' => WPBOOTSTRAP_BS . '/js/bootstrap.min.js',
				// 'deps' => ['graphic-code-start'],
			// ],
			// [
				// 'handle' => 'graphic-code-end',
				// 'src' => WPBOOTSTRAP_JS . '/graphic-code-end.js',
				// 'deps' => ['bootstrap'],
			// ],
		];
		
		if ($this->styles_deferred) {
			// script for deferring styles
			$scripts[] = [
				'handle' => 'deferred-styles',
				'src' => WPBOOTSTRAP_JS . '/deferred-styles.min.js',
				'localize' => [
					'object_name' => 'deferred_styles',
					'l10n' => $this->styles_deferred,
				],
			];
		}
		
		$this->WPActions->scripts($scripts);
		
	}
	
	
	
	/**
	* create the sidebars
	*/
	public function sidebars() {
		
		$sidebars = [
			[
				'id' => 'bs-side',
				'name' => 'Side Widget',
				'description' => 'Side Sidebar',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			],
		];
		
		
		for ($c = 1; $c <= WPBOOTSTRAP_FOOTER_COLUMNS; $c++) {
			$sidebars[] = [
				'id' => 'bs-footer-' . $c,
				'name' => 'Footer column ' . $c,
				'description' => __('Add widgets here to appear in your footer.'),
				'before_widget' => '<section id="%1$s" class="widget %2$s bs-footer-' . $c . '"><div class="widget-wrapper">',
				'after_widget' => '</div></section>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			];
		}

		$this->WPActions->sidebars($sidebars);
		
	}
	
	
	
	/**
	* print inline the styles
	*/
	public function inlineCSS() {
		
		// array of handles names
		$this->WPFilters->inlineCss([]);
		
	}
	
	
	
	/**
	* defer the styles with a script
	*/
	public function deferCss() {
		
		// array of handles names
		$this->WPFilters->deferCss($this->styles_deferred);
		
	}
	
	
	
	/**
	* defer the scripts with a async and defer attributes
	* http://scottnelle.com/756/async-defer-enqueued-wordpress-scripts/
	*/
	public function asyncDeferScripts() {
		
		// array of handles names
		$this->WPFilters->asyncDeferScripts([]);
		
	}
	
	
	
	/**
	* remove the admin bar in the frontend when logged in
	*/
	public function removeAdminLoginHeader() {
		
		$this->WPActions->removeAdminLoginHeader();
		
	}
	
	
	
}

$WPBootstrap = new WPBootstrap();
