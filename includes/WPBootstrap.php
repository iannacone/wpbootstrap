<?php
/**
 * WPBootstrap class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



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
		$this->menus();
		// $this->cpt();
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
	* create the menus
	*/
	public function menus() {
		
		// array of handles names
		$this->WPActions->menus->appendCollection([
			'primary-menu' => __('Main Header Menu'),
		]);
		
	}
	
	
	
	/**
	* create the custom post types
	*/
	public function cpt() {
		
		$this->WPActions->custom_post_types->appendCollection([
			'id' => [
				'supports' => [
					'title',          // post title
					'editor',         // post content
					'author',         // post author
					'thumbnail',      // featured images
					'excerpt',        // post excerpt
					'custom-fields',  // custom fields
					'comments',       // post comments
					'revisions',      // post revisions
					'post-formats',   // post formats
				],
				'labels' => [
					'name'                   => _x( 'Post Types', 'Post Type General Name', 'text_domain' ),
					'singular_name'          => _x( 'Post Type', 'Post Type Singular Name', 'text_domain' ),
					'menu_name'              => __( 'Post Types', 'text_domain' ),
					'name_admin_bar'         => __( 'Post Type', 'text_domain' ),
					'archives'               => __( 'Item Archives', 'text_domain' ),
					'attributes'             => __( 'Item Attributes', 'text_domain' ),
					'parent_item_colon'      => __( 'Parent Item:', 'text_domain' ),
					'all_items'              => __( 'All Items', 'text_domain' ),
					'add_new_item'           => __( 'Add New Item', 'text_domain' ),
					'add_new'                => __( 'Add New', 'text_domain' ),
					'new_item'               => __( 'New Item', 'text_domain' ),
					'edit_item'              => __( 'Edit Item', 'text_domain' ),
					'update_item'            => __( 'Update Item', 'text_domain' ),
					'view_item'              => __( 'View Item', 'text_domain' ),
					'view_items'             => __( 'View Items', 'text_domain' ),
					'search_items'           => __( 'Search Item', 'text_domain' ),
					'not_found'              => __( 'Not found', 'text_domain' ),
					'not_found_in_trash'     => __( 'Not found in Trash', 'text_domain' ),
					'featured_image'         => __( 'Featured Image', 'text_domain' ),
					'set_featured_image'     => __( 'Set featured image', 'text_domain' ),
					'remove_featured_image'  => __( 'Remove featured image', 'text_domain' ),
					'use_featured_image'     => __( 'Use as featured image', 'text_domain' ),
					'insert_into_item'       => __( 'Insert into item', 'text_domain' ),
					'uploaded_to_this_item'  => __( 'Uploaded to this item', 'text_domain' ),
					'items_list'             => __( 'Items list', 'text_domain' ),
					'items_list_navigation'  => __( 'Items list navigation', 'text_domain' ),
					'filter_items_list'      => __( 'Filter items list', 'text_domain' ),
				],
				'label'                => __( 'Post Type', 'text_domain' ),
				'description'          => __( 'Post Type Description', 'text_domain' ),
				'supports'             => false,
				'taxonomies'           => ['category', 'post_tag'],
				'hierarchical'         => false,
				'public'               => true,
				'show_ui'              => true,
				'show_in_menu'         => true,
				'menu_position'        => 5,
				'show_in_admin_bar'    => true,
				'show_in_nav_menus'    => true,
				'can_export'           => true,
				'has_archive'          => true,
				'exclude_from_search'  => false,
				'publicly_queryable'   => true,
				'capability_type'      => 'page',
				'menu_icon'            => get_stylesheet_directory_uri() . '/assets/imgs/cpt.png',
				'rewrite'              => ['slug' => 'slug-to-rewrite-here', 'with_front' => false],
			],
		]);
		
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
	* add buttons to the admin bar in the frontend when logged in
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
