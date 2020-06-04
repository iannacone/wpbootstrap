<?php

/**
 * WPBootstrap class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



class WPBootstrap
{



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
	public function __construct()
	{

		$this->WPFilters = new WPFilters();
		$this->WPActions = new WPActions();

		$this->SCSSPHP = new SCSSPHP(WPBOOTSTRAP_ABS, WPBOOTSTRAP_CACHE_ABS, [
			// 'var-name' => '\'value\'',
		]);

		$this->Handlebars = new Handlebars();
		$this->YouTube = new YouTube();

		$this->styles_deferred = [];

		$this->themeSupports();
		$this->removeHtmlMarginTop();
		// $this->excerptMoreLink();
		// $this->excerptMore();
		$this->logoClasses();
		$this->scss();
		$this->styles();
		$this->scripts();
		$this->sidebars();
		$this->menus();
		// set_post_thumbnail_size(250, 9999);
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
	 * add the theme supports
	 */
	public function themeSupports()
	{
		$this->WPActions->theme_supports->appendCollection([
			'custom-logo' => [
				// 'height'      => 100,
				// 'width'       => 400,
				'flex-height' => true,
				'flex-width'  => true,
				// 'header-text' => [
				// 	'site-title',
				// 	'site-description',
				// ],
			],
			'custom-background' => [
				'default-image'          => '',
				'default-preset'         => 'default', // 'default', 'fill', 'fit', 'repeat', 'custom'
				'default-position-x'     => 'left',    // 'left', 'center', 'right'
				'default-position-y'     => 'top',     // 'top', 'center', 'bottom'
				'default-size'           => 'auto',    // 'auto', 'contain', 'cover'
				'default-repeat'         => 'repeat',  // 'repeat-x', 'repeat-y', 'repeat', 'no-repeat'
				'default-attachment'     => 'scroll',  // 'scroll', 'fixed'
				'default-color'          => '',
				'wp-head-callback'       => '_custom_background_cb',
				'admin-head-callback'    => '',
				'admin-preview-callback' => '',
			],
			'custom-header' => [
				'default-image'          => '',
				'random-default'         => false,
				'width'                  => 0,
				'height'                 => 0,
				'flex-height'            => false,
				'flex-width'             => false,
				'default-text-color'     => '',
				'header-text'            => true,
				'uploads'                => true,
				'wp-head-callback'       => '',
				'admin-head-callback'    => '',
				'admin-preview-callback' => '',
				'video'                  => false,
				'video-active-callback'  => 'is_front_page',
			],
			'automatic-feed-links',
			'title-tag',
			'post-thumbnails' => [
				'post',
				'page',
				'id',
			],
			'html5' => [
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			],
			// gutenberg
			'align-wide',
			'wp-block-styles',
			// woocommerce
			// https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
			'woocommerce',
		]);
	}



	/**
	 * remove the margin top on the html tag made for the admin menu in forntend
	 */
	public function removeHtmlMarginTop()
	{
		$this->WPActions->html_margin_top->append(false);
	}



	/**
	 * set the "Read more" text link of the posts excerpts
	 */
	public function excerptMoreLink()
	{
		$this->WPFilters->excerpt_more_link->append(__('', I18N_TEXTDOMAIN));
	}



	/**
	 * set the "…" text of the posts excerpts
	 */
	public function excerptMore()
	{
		$this->WPFilters->excerpt_more->append(false);
	}



	/**
	 * styles manager
	 */
	public function styles()
	{
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
	public function logoClasses()
	{
		$this->WPFilters->logo_classes->appendCollection([
			'navbar-brand',
		]);
	}



	/**
	 * compile the scss
	 */
	public function scss()
	{
		$this->SCSSPHP->showErrorsAsCSS(\WP_DEBUG);
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
	public function scripts()
	{
		$scripts = [
			[
				'handle' => 'html5shiv',
				'src' => WPBOOTSTRAP_NODE . '/html5shiv/src/html5shiv.js',
				'data' => [
					'key' => 'conditional',
					'value' => 'lt IE 9',
				]
			],
			[
				'handle' => 'respond',
				'src' => WPBOOTSTRAP_NODE . '/respond.js/dest/respond.matchmedia.addListener.src.js',
				'data' => [
					'key' => 'conditional',
					'value' => 'lt IE 9',
				]
			],
			[
				'handle' => 'skip-link-focus',
				'src' => WPBOOTSTRAP_NODE . '/skip-link-focus/skip-link-focus.js',
			],
			// [
			// 'handle' => 'polyfill',
			// 'src' => WPBOOTSTRAP_NODE . '/bootstrap.native/dist/polyfill.js',
			// ],
			[
				'handle' => 'bootstrap',
				'src' => WPBOOTSTRAP_NODE . '/bootstrap.native/dist/bootstrap-native-v4.js',
				// 'deps' => ['polyfill'],
			],
			/*
			 * if jquery is include (for ex. by other plugins) you can opt
			 * to include the official version instead of the js native one
			 */
			// [
			// 'handle' => 'bootstrap',
			// 'src' => WPBOOTSTRAP_BS . '/dist/js/bootstrap.js',
			// 'deps' => ['jquery'],
			// ],
			// [
			// 'handle' => 'wpbootstrap',
			// 'src' => WPBOOTSTRAP_JS . '/wpbootstrap.js',
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
	public function sidebars()
	{
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
				'description' => __('Add widgets here to appear in your footer.', I18N_TEXTDOMAIN),
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
	public function menus()
	{
		// array of handles names
		$this->WPActions->menus->appendCollection([
			'primary-menu' => __('Main Header Menu', I18N_TEXTDOMAIN),
		]);
	}



	/**
	 * create the custom post types
	 */
	public function cpt()
	{
		/*
		 * Use flush_rewrite_rules(), refresh the page once or twice and REMOVE IT IMMEDIATELY.
		 * You SHOULD NOT keep flush_rewrite_rules() unless under the provisions as in the codex.
		 * source: https://wordpress.stackexchange.com/questions/156978/custom-post-type-single-page-returns-404-error#156985
		 */
		// flush_rewrite_rules();

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
					'name'                   => _x('Post Types', I18N_TEXTDOMAIN),
					'singular_name'          => _x('Post Type', I18N_TEXTDOMAIN),
					'menu_name'              => __('Post Types', I18N_TEXTDOMAIN),
					'name_admin_bar'         => __('Post Type', I18N_TEXTDOMAIN),
					'archives'               => __('Item Archives', I18N_TEXTDOMAIN),
					'attributes'             => __('Item Attributes', I18N_TEXTDOMAIN),
					'parent_item_colon'      => __('Parent Item:', I18N_TEXTDOMAIN),
					'all_items'              => __('All Items', I18N_TEXTDOMAIN),
					'add_new_item'           => __('Add New Item', I18N_TEXTDOMAIN),
					'add_new'                => __('Add New', I18N_TEXTDOMAIN),
					'new_item'               => __('New Item', I18N_TEXTDOMAIN),
					'edit_item'              => __('Edit Item', I18N_TEXTDOMAIN),
					'update_item'            => __('Update Item', I18N_TEXTDOMAIN),
					'view_item'              => __('View Item', I18N_TEXTDOMAIN),
					'view_items'             => __('View Items', I18N_TEXTDOMAIN),
					'search_items'           => __('Search Item', I18N_TEXTDOMAIN),
					'not_found'              => __('Not found', I18N_TEXTDOMAIN),
					'not_found_in_trash'     => __('Not found in Trash', I18N_TEXTDOMAIN),
					'featured_image'         => __('Featured Image', I18N_TEXTDOMAIN),
					'set_featured_image'     => __('Set featured image', I18N_TEXTDOMAIN),
					'remove_featured_image'  => __('Remove featured image', I18N_TEXTDOMAIN),
					'use_featured_image'     => __('Use as featured image', I18N_TEXTDOMAIN),
					'insert_into_item'       => __('Insert into item', I18N_TEXTDOMAIN),
					'uploaded_to_this_item'  => __('Uploaded to this item', I18N_TEXTDOMAIN),
					'items_list'             => __('Items list', I18N_TEXTDOMAIN),
					'items_list_navigation'  => __('Items list navigation', I18N_TEXTDOMAIN),
					'filter_items_list'      => __('Filter items list', I18N_TEXTDOMAIN),
				],
				'label'                => __('Post Type', I18N_TEXTDOMAIN),
				'description'          => __('Post Type Description', I18N_TEXTDOMAIN),
				'taxonomies'           => [
					'category',
					'post_tag',
				],
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
				'show_in_rest'         => true,
				'capability_type'      => 'page',
				// 'menu_icon'            => get_stylesheet_directory_uri() . '/assets/imgs/cpt.png',
				'menu_icon'            => 'dashicons-products',
				'rewrite'              => [
					'slug' => 'slug-to-rewrite-here',
					'with_front' => false
				],
			],
		]);
	}



	/**
	 * print inline the styles
	 */
	public function inlineCSS()
	{
		// array of handles names
		$this->WPFilters->inline_styles->appendCollection([]);
	}



	/**
	 * defer the styles with a script
	 */
	public function deferCss()
	{
		// array of handles names
		$this->WPFilters->deferred_styles->appendCollection($this->styles_deferred);
	}



	/**
	 * defer the scripts with a async and defer attributes
	 * http://scottnelle.com/756/async-defer-enqueued-wordpress-scripts/
	 */
	public function asyncDeferScripts()
	{
		// array of handles names
		$this->WPFilters->scripts_async_deferred->appendCollection([]);
	}



	/**
	 * add buttons to the admin bar in the frontend when logged in
	 */
	public function adminBarBtns()
	{
		$btns = [
			[
				'id' => 'clear_cache',
				'title' => __('Clear the cache', I18N_TEXTDOMAIN),
				'parent' => false,
				'href' => '?' . WPBS_CLEARCACHE . '=1',
				'meta' => [
					'class' => 'clear-cache',
					'onclick' => 'if(!confirm("' . __('Are you sure?', I18N_TEXTDOMAIN) . '")) return false;',
				],
			],
		];

		$this->WPActions->admin_bar_btns->appendCollection($btns);
	}
}
