<?php
/**
 * functions and defines
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wpbootstrap
 */



namespace WPBootstrap;



define('WPBOOTSTRAP_FOOTER_COLUMNS', 4);
define('WPBOOTSTRAP_VERSION', '4.4.1');
define('WPBS_CLEARCACHE', 'clearCache');
define('WPBS_CSSCACHE', 'style.css');
define('FONT_SIZE_BASE', 16);
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
	 * WPBootstrap\SCSSPHP
	 */
	protected $SCSSPHP;
	
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
		
		$this->SCSSPHP = new SCSSPHP(WPBOOTSTRAP_ABS, WPBOOTSTRAP_CACHE_ABS, [
			'bs_version' => '\'' . WPBOOTSTRAP_VERSION . '\'',
			'font-size-base' => FONT_SIZE_BASE . 'px',
		]);
		
		$this->Handlebars = new Handlebars();
		$this->YouTube = new YouTube();
		
		$this->styles_deferred = [];
		
		$this->removeHtmlMarginTop();
		$this->logoClasses();
		$this->scss();
		$this->styles();
		$this->scripts();
		$this->sidebars();
		// $this->inlineCSS();
		// $this->deferCss();
		/*
		replaced by hyperdriver plugin
		$this->asyncDeferScripts();
		*/
		$this->adminBarBtns();
		
	}
	
	
	
	/**
	* remove the margin top on the html tag made for the admin menu in forntend
	*/
	public function removeHtmlMarginTop() {
		
		$this->WPActions->html_margin_top->append(false);
		
	}
	
	
	
	/**
	* styles manager
	*/
	public function styles() {
		
		$styles = [
			[
				'handle' => 'wpbs',
				'src' => WPBOOTSTRAP_CACHE . '/' . WPBS_CSSCACHE,
			],
			// [
				// 'handle' => 'custom',
				// 'src' => WPBOOTSTRAP_CSS . '/custom.css',
				// 'deps' => ['wpbs'],
			// ],
		];

		$this->WPActions->styles->appendCollection($styles);
		
	}
	
	
	
	/**
	* set the classes for the logo
	*/
	public function logoClasses() {
		
		$this->WPFilters->logo_classes->appendCollection([
			'navbar-brand',
		]);
		
	}
	
	
	
	/**
	* compile the scss
	*/
	public function scss() {
		
		$this->SCSSPHP->showErrorsAsCSS(WP_DEBUG);
		$recompile = isset($_GET[WPBS_CLEARCACHE]) && current_user_can('administrator');
		
		// if (WP_SCSS_ALWAYS_RECOMPILE || $recompile) {
			// WPHelper::emptyDirectory(WPBOOTSTRAP_CACHE_ABS);
		// }
		
		$this->SCSSPHP->checkedCachedCompile(WPBOOTSTRAP_ABS . '/style.scss', WPBOOTSTRAP_CACHE_ABS . '/' . WPBS_CSSCACHE, (WP_SCSS_ALWAYS_RECOMPILE || $recompile));
		
		if ($recompile) {
			$clear_url = WPHelper::stripOffUrl(WPHelper::getCurrentUrl(), [WPBS_CLEARCACHE]);
			header('Location: ' . $clear_url);
			wp_die();
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
				'src' => WPBOOTSTRAP_VENDOR . '/respond/dest/respond.matchmedia.addListener.min.js',
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
				'src' => WPBOOTSTRAP_VENDOR . '/bootstrap.native/dist/bootstrap-native-v4.min.js',
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
		
		$this->WPActions->scripts->appendCollection($scripts);
		
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
			[
				'id' => 'bs-fixed-bottom-right',
				'name' => 'Fixed space bottom right',
				'description' => 'A fixed space on the bottom right of the screen',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			],
			[
				'id' => 'bs-footer',
				'name' => 'Site info',
				'description' => 'Absolute site bottom',
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

		$this->WPActions->sidebars->appendCollection($sidebars);
		
	}
	
	
	
	/**
	* print inline the styles
	*/
	public function inlineCSS() {
		
		// array of handles names
		$this->WPFilters->inline_styles->appendCollection([]);
		
	}
	
	
	
	/**
	* defer the styles with a script
	*/
	public function deferCss() {
		
		// array of handles names
		$this->WPFilters->deferred_styles->appendCollection($this->styles_deferred);
		
	}
	
	
	
	/**
	* defer the scripts with a async and defer attributes
	* http://scottnelle.com/756/async-defer-enqueued-wordpress-scripts/
	*/
	public function asyncDeferScripts() {
		
		// array of handles names
		$this->WPFilters->scripts_async_deferred->appendCollection([]);
		
	}
	
	
	
	/**
	* remove the admin bar in the frontend when logged in
	*/
	public function adminBarBtns() {
		
		$btns = [
			[
				'id' => 'clear_cache',
				'title' => __('Clear the cache'),
				'parent' => false,
				'href' => '?' . WPBS_CLEARCACHE . '=1',
				'meta' => [
					'class' => 'clear-cache',
					'onclick' => 'if(!confirm("' . __('Are you sure?') . '")) return false;',
				],
			],
		];

		$this->WPActions->admin_bar_btns->appendCollection($btns);
		
	}
	
	
	
}

$WPBootstrap = new WPBootstrap();
