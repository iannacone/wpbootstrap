<?php
	
	
	
	define('WPBOOTSTRAP', get_template_directory_uri() . '/');
	define('WPBOOTSTRAP_ABS', dirname(__FILE__) . '/');
	define('WPBOOTSTRAP_BS', WPBOOTSTRAP . 'bootstrap/');
	define('WPBOOTSTRAP_JS', WPBOOTSTRAP . 'js/');
	define('WPBOOTSTRAP_CSS', WPBOOTSTRAP . 'css/');
	define('WPBOOTSTRAP_IMG', WPBOOTSTRAP . 'img/');
	define('WPBOOTSTRAP_EXTRA', WPBOOTSTRAP . 'extra/');
	if (!defined('ajaxurl'))
		define('ajaxurl', admin_url('admin-ajax.php'));
	
	
	
	// check if the https protocol is now active
	function is_https() {
	  return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443);
	}
	
	
	
	
	function get_current_url($params = true) {
		$end = ($params ? strlen($_SERVER['REQUEST_URI']) : strpos($_SERVER['REQUEST_URI'], '?'));
		if($end === false) $end = strlen($_SERVER['REQUEST_URI']);
		return 'http' . (is_https() ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . substr($_SERVER['REQUEST_URI'], 0, $end);
	}
	
	
	
	
	// detect if is mobile
	function is_mobile() {
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)));
	}
	
	
	
	
	// remove wp version param from any enqueued scripts
	function remove_ver_css_js($src) {
		if (strpos($src, 'ver='))
			$src = remove_query_arg('ver', $src);
		return $src;
	}
	add_filter('style_loader_src', 'remove_ver_css_js', 10);
	add_filter('script_loader_src', 'remove_ver_css_js', 10);
	
	
	

	function wp_file_exists($url) {
		return true;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return ($code == 200);
	}
	
	
	
	
	function style_exists($style_name) {
		global $wp_styles;
		if (!isset($wp_styles->registered[$style_name])) return false;
		return wp_file_exists($wp_styles->registered[$style_name]->src);
	}
	
	
	
	
	
	function bs_enqueue_style($style_name) {
		if (WP_DEBUG && !style_exists($style_name))
			wp_die(sprintf(__('%s  style not found.'), $style_name));
		wp_enqueue_style($style_name);
		return;
	}
	
	
	
	
	// jq_migrate is annying me with browser console messages, but it's required for some scripts
	// function remove_jq_migrate($scripts) {
		// if (!empty($scripts->registered['jquery'])) {
			// $jquery_dependencies = $scripts->registered['jquery']->deps;
			// $scripts->registered['jquery']->deps = array_diff($jquery_dependencies, array('jquery-migrate'));
		// }
	// }
	// add_action('wp_default_scripts', 'remove_jq_migrate');
	
	
	
	
	function register_enqueue_styles() {
		// bootstrap
		wp_register_style('bootstrap', WPBOOTSTRAP_BS . 'css/bootstrap.min.css');
		wp_register_style('bootstrap-theme', WPBOOTSTRAP_BS . 'css/bootstrap-theme.min.css', array('bootstrap'));
		// bootstrap plugins
		// customs, fixes and adjustments
		wp_register_style('jquery-ui', WPBOOTSTRAP_CSS . 'jquery-ui/jquery-ui.css', array('bootstrap-theme'));
		// wp_register_style('fontawesome', 'http' . (is_https() ? 's' : '') . '://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		wp_register_style('custom', WPBOOTSTRAP_CSS . 'custom.css', array('jquery-ui'));
		//bootstrap
		bs_enqueue_style('bootstrap');
		bs_enqueue_style('bootstrap-theme');
		// bootstrap plugins
		// customs, fixes and adjustments
		bs_enqueue_style('jquery-ui');
		// bs_enqueue_style('fontawesome');
		bs_enqueue_style('custom');
	}
	add_action('wp_enqueue_scripts', 'register_enqueue_styles');
	
	
	
	
	function script_exists($script_name) {
		global $wp_scripts;
		if (!isset($wp_scripts->registered[$script_name])) return false;
		return wp_file_exists($wp_scripts->registered[$script_name]->src);
	}
	
	
	
	
	function bs_enqueue_script($script_name) {
		if (WP_DEBUG && !script_exists($script_name))
			wp_die(sprintf(__('%s  script not found.'), $style_name));
		wp_enqueue_script($script_name);
	}
	
	
	
	
	// register and enqueue the scripts
	function register_enqueue_scripts() {
		// customs, fixes and adjustments
		wp_register_script('e-touch-punch', WPBOOTSTRAP_JS . 'touch-punch.min.js', array('jquery', 'jquery-ui-sortable'));
		wp_register_script('graphic-code-start', WPBOOTSTRAP_JS . 'graphic-code-start.js', array('e-touch-punch'));
		// bootstrap
		wp_register_script('bootstrap', WPBOOTSTRAP_BS . 'js/bootstrap.min.js', array('graphic-code-start'));
		// bootstrap plugins
		wp_register_script('graphic-code-end', WPBOOTSTRAP_JS . 'graphic-code-end.js', array('bootstrap'));
		// localize
		// $global_scripts_params = array(
			// 'ajaxurl' => ajaxurl,
			// 'user_lang' => USER_LANG
		// );
		// wp_localize_script($page, 'q_global_data', $global_scripts_params);
		
		// customs, fixes and adjustments
		bs_enqueue_script('e-touch-punch');
		bs_enqueue_script('graphic-code-start');
		// bootstrap
		bs_enqueue_script('bootstrap');
		// bootstrap plugins
		bs_enqueue_script('graphic-code-end');
		
	}
	add_action('wp_enqueue_scripts', 'register_enqueue_scripts');
	
	
	
	
	// Add async attributes to enqueued scripts where needed.
	// http://scottnelle.com/756/async-defer-enqueued-wordpress-scripts/
	$sync_scripts = array(
		'jquery-core',
		'jquery-ui-mouse',
		'jquery-ui-widget',
	);
	function async_scripts($tag, $handle, $src) {
		global $sync_scripts;
		$async = !in_array($handle, $sync_scripts);
		$defer = $async && strpos($src, get_site_url()) !== false;
		if (!is_admin())
			$tag = '<script type="text/javascript" src="' . $src . '"' . ($async ? ' async="async"' : '') . ($defer ? ' defer="defer"' : '') . '></script>' . "\n";
		return $tag;
	}
	add_filter('script_loader_tag', 'async_scripts', 10, 3);
	
	
	
	
	function inline_css($html, $handle, $href, $media) {
		$site_url = site_url('/');
		if (strpos($href, $site_url) === false) return $html;
		$href = str_replace($site_url, ABSPATH, preg_replace('/(.*?)\?.*$/', '$1', $href));
		$css = file_get_contents($href, true);
		$css = preg_replace('/[\r\n\t]/m', '', $css);
		$css = preg_replace('/[\s;]({|})/', '$1', $css);
		$css = preg_replace('/(:)\s/', '$1', $css);
		$html = '<style type="text/css">' . $css . '</style>' . "\n";
		return $html;
	}
	add_filter('style_loader_tag', 'inline_css', 10, 4);
	
	
	
	
	function bs_theme_supports() {
		add_theme_support('custom-logo');
		add_theme_support('custom-background');
		add_theme_support('custom-header');
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		// set_post_thumbnail_size(250, 9999);
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));
		register_nav_menu('main-header-menu', __('Main Header Menu'));
	}
	add_action('after_setup_theme', 'bs_theme_supports');
	
	
	

	/*
	// register the main menu
	moved in after_setup_theme action
	function register_my_menu() {
	  register_nav_menu('main-header-menu', __('Main Header Menu'));
	}
	add_action('init', 'register_my_menu');
	*/
	
	
	

	// register the sidebar
	function bootstrap_widgets_init() {
		register_sidebar(array(
			'id' => 'bs-widget-side',
			'name' => 'Side Widget',
			'description' => 'Side Sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
		register_sidebar(array(
			'id' => 'bs-widget-footer',
			'name' => 'Bootstrap footer widget',
			'description' => 'Footer Sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	}
	add_action('widgets_init', 'bootstrap_widgets_init');
	
	
	
	
	function sidebar($id) {
		if(is_active_sidebar($id))
			dynamic_sidebar($id);
	}
	
	
	
	
	function bootstrap_alert_before($type = 'info') {
		return '<div class="alert alert-' . $type . ' fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	}
	
	
	
	
	function bootstrap_alert_after() {
		return '</div>';
	}
	
	
	
	
	// set the display of message popup to bootstrap
	function bootstrap_alert($message, $type = '', $strip_tags = true, $echo = false) {
		$output = '';
		if (empty($type)) $type = (strpos($message, 'class="error"') > 0 ? 'warning' : 'info');
		if ($strip_tags) $message = strip_tags($message, '<br>');
		if (empty($message)) return $message;
		if (strpos($message, '<br />') > 0) {
			$messages = explode('<br />', $message);
			foreach ($messages as $tmp_msg)
				if ($echo) bootstrap_alert(trim($tmp_msg), $type, $strip_tags, true);
				else $output .= bootstrap_alert(trim($tmp_msg), $type, $strip_tags, false);
			return $output;
		}
		$output = bootstrap_alert_before($type) . $message . bootstrap_alert_after();
		if ($echo) echo $output;
		else return $output;
	}
	
	
	
	
	function get_nopaging_url() {
		global $wp;
		$current_url = home_url($wp->request);
		$position = strpos($current_url , '/page/');
		$nopaging_url = ($position ? substr($current_url, 0, $position) : $current_url);
		return trailingslashit($nopaging_url);
	}
	
	
	
	
	function wpbs_pagenavi($echo = true) {
		global $wp_query;
		$posts_per_page = (int) $wp_query->get('posts_per_page');
		$tot_posts = max($posts_per_page, $wp_query->found_posts);
		$last_page = ceil($tot_posts / $posts_per_page);
		if ($last_page == 1) return;
		$current_page = max((int) $wp_query->get('paged'), 1);
		$current_url = get_nopaging_url() . 'page/';
		$pagenavi = array(
			1 => false,
			$last_page => false,
		);
		if ($current_page > 1)
			$pagenavi[($current_page - 1)] = false;
		if ($current_page < $last_page)
			$pagenavi[($current_page + 1)] = false;
		$prev_dec = intval(($current_page - 2) / 10) * 10;
		if ($prev_dec > 0)
			$pagenavi[$prev_dec] = false;
		$next_dec = ceil(($current_page + 2) / 10) * 10;
		if ($next_dec < $last_page)
			$pagenavi[$next_dec] = false;
		// for ($c = 1; $c < $last_page; $c++)
			// if ($c % 10 == 0)
				// $pagenavi[$c] = false;
		$pagenavi[$current_page] = true;
		ksort($pagenavi);
		$output = '<ul class="pagination pagination-centered">';
		foreach ($pagenavi as $page => $active) {
			$output .= '<li' . ($active ? ' class="active"' : '') . '><' . ($active ? 'span' : 'a href="' . esc_url(add_query_arg($_GET, $current_url . $page . '/')) . '"') . '>' . esc_html($page) . '</' . ($active ? 'span' : 'a') . '></li>';
		}
		$output .= '</ul>';
		if ($echo) echo $output;
		return $output;
	}
	
	
	
	
	function page_not_found() {
		echo '<br /><br /><br /><br /><br /><h1 class="text-center">' . __('Sorry, this page does not exist.') . '</h1>';
	}
	
	
	
	
	function remove_admin_login_header() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	}
	add_action('get_header', 'remove_admin_login_header');
	
	
	
	
	require_once('navwalker.php');
	
	
	
?>