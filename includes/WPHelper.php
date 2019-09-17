<?php
/**
 * WPHelper class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



class WPHelper {
	
	
	
	/**
	* enqueue a set of scripts
	*/
	public static function scripts($assets) {
		
		foreach ($assets as $args) {
			static::script($args);
		}
		
	}
	
	
	
	/**
	* extension of wp_enqueue_script, wp_localize_script, wp_script_add_data, wp_register_script
	*/
	public static function script($args) {
		
		$default = [
			'handle' => '',
			'src' => '',
			'deps' => [],
			'ver' => false,
			'in_footer' => false,
			'localize' => false,
			'data' => false,
		];
		
		$args = array_merge($default, $args);
		
		extract($args);
		
		
		if (WP_DEBUG && strlen($src) > 0 && !static::fileExists($src)) {
			wp_die(sprintf(__('%s script not found.'), $src));
		}
		
		wp_register_script($handle, $src, $deps, $ver, $in_footer);
		
		
		if ($localize) {
			
			$default = [
				'object_name' => '',
				'l10n' => '',
			];
			
			$localize = array_merge($default, $localize);
			
			extract($localize);
			
			wp_localize_script($handle, $object_name, $l10n);
			
		}
		
		
		if ($data) {
			
			$default = [
				'key' => '',
				'value' => '',
			];
			
			$data = array_merge($default, $data);
			
			extract($data);
			
			wp_script_add_data($handle, $key, $value);
			
		}
		
		
		wp_enqueue_script($handle);
		
	}
	
	
	
	/**
	* enqueue a set of styles
	*/
	public static function styles($assets) {
		
		foreach ($assets as $args) {
			static::style($args);
		}
		
	}
	
	
	
	/**
	* extension of wp_enqueue_style and wp_register_style
	*/
	public static function style($args) {
		
		$default = [
			'handle' => '',
			'src' => '',
			'deps' => [],
			'ver' => false,
			'media' => 'all',
		];
		
		$args = array_merge($default, $args);
		
		extract($args);
		
		if (WP_DEBUG && strlen($src) > 0 && !static::fileExists($src)) {
			wp_die(sprintf(__('%s style not found.'), $src));
		}
		
		wp_enqueue_style($handle, $src, $deps, $ver, $media);
		
	}
	
	
	
	/**
	* check if a script exists
	*
	public static function scriptExists($name) {
		
		global $wp_scripts;
		
		return static::assetExists($name, $wp_scripts);
		
	}
	
	
	
	/**
	* check if a style exists
	*
	public static function styleExists($name) {
		
		global $wp_styles;
		
		return static::assetExists($name, $wp_styles);
		
	}
	
	
	
	/**
	* check if an asset exists in a assets list
	*
	public static function assetExists($name, $assets) {
		
		if (!isset($assets->registered[$name])) {
			return false;
		}
		
		return static::fileExists($assets->registered[$name]->src);
		
	}*/
	
	
	
	/**
	* get a file from a url
	*/
	public static function getFile($url) {
		
		$content = '';
		$path = static::urlToPath($url);
		
		// NOTE: allow_url_fopen in php.ini may not be true
		if ($path) {
			
			$content = file_get_contents($path, true);
			
		}
		else {
			
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			$content = curl_exec($curl);
			curl_close($curl);
			
		}
		
		return $content;
		
	}
	
	
	
	/**
	* check if a file exists from a url
	*/
	public static function fileExists($url) {
		
		$exists = false;
		$path = static::urlToPath($url);
		
		// NOTE: allow_url_fopen in php.ini may not be true
		if ($path) {
			
			$exists = file_exists($path);
			
		}
		else {
			
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			curl_exec($curl);
			$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);
			
			$exists = ($code == 200);
			
		}
		
		return $exists;
		
	}
	
	
	
	/**
	* remove parameter(s) from url
	*/
	public static function stripOffUrl($url, $parameters = []) {

		$parsed = parse_url($url);
		$params = [];
		parse_str($parsed['query'], $params);
		
		foreach ($parameters as $parameter) {
			unset($params[$parameter]);
		}
		
		$url = $parsed['scheme'] . '://' . $parsed['host'] . $parsed['path'] . http_build_query($params, '', '&');
		
		return $url;
		
	}
	
	
	
	/**
	* delete all the files in a directory
	*/
	public static function emptyDirectory($path) {
		
		foreach (glob($path) as $file) {
			if(is_file($file)) {
				unlink($file);
			}
		}
		
	}
	
	
	
	/**
	* convert an url to a path (only if it is in the same wp instance)
	*/
	public static function urlToPath($url) {
		
		$path = false;
		$site_url = site_url('/');
		
		if (strpos($url, $site_url) !== false) {
			
			$url = preg_replace('/(.*?)[\?\#].*$/', '$1', $url);
			$path = str_replace($site_url, trailingslashit(ABSPATH), $url);
			
		}
		
		return $path;
		
	}
	
	
	
	/**
	* get the current url without the paging (es. https://site.web/post/page/3 )
	*/
	public static function getNopagingUrl($url) {
		
		$position = strpos($url , '/page/');
		$nopaging_url = ($position ? substr($url, 0, $position) : $url);
		
		return trailingslashit($nopaging_url);
		
	}
	
	
	
	/**
	* get the page navigation menu
	*/
	public static function pageNavi($echo = true) {
		
		global $wp, $wp_query;
		
		$posts_per_page = (int) $wp_query->get('posts_per_page');
		$tot_posts = max($posts_per_page, $wp_query->found_posts);
		$last_page = ceil($tot_posts / $posts_per_page);
		
		if ($last_page === 1) {
			return;
		}
		
		$current_page = max((int) $wp_query->get('paged'), 1);
		$current_url = home_url($wp->request);
		$current_url = static::getNopagingUrl($current_url) . 'page/';
		
		$pagenavi = [
			1 => false,
			$last_page => false,
		];
		
		if ($current_page > 1) {
			$pagenavi[($current_page - 1)] = false;
		}
		
		if ($current_page < $last_page) {
			$pagenavi[($current_page + 1)] = false;
		}
		
		$prev_dec = intval(($current_page - 2) / 10) * 10;
		
		if ($prev_dec > 0) {
			$pagenavi[$prev_dec] = false;
		}
		
		$next_dec = ceil(($current_page + 2) / 10) * 10;
		
		if ($next_dec < $last_page) {
			$pagenavi[$next_dec] = false;
		}
		
		/*
		for ($c = 1; $c < $last_page; $c++) {
			if ($c % 10 == 0) {
				$pagenavi[$c] = false;
			}
		}
		*/
		
		$pagenavi[$current_page] = true;
		ksort($pagenavi);
		$output = '<ul class="pagination pagination-centered">';
		
		foreach ($pagenavi as $page => $active) {
			$output .= '<li' . ($active ? ' class="active"' : '') . '><' . ($active ? 'span' : 'a href="' . esc_url(add_query_arg($_GET, $current_url . $page . '/')) . '"') . '>' . esc_html($page) . '</' . ($active ? 'span' : 'a') . '></li>';
		}
		
		$output .= '</ul>';
		
		if ($echo) {
			echo $output;
		}
		
		return $output;
		
	}
	
	
	
	/**
	* compress the css
	*/
	public static function compressCss($css) {
		
		$css = preg_replace('/[\r\n\t]/m', '', $css);
		$css = preg_replace('/[\s;]({|})/', '$1', $css);
		$css = preg_replace('/(:)\s/', '$1', $css);
		$css = preg_replace('/\/\*.*?\*\//', '', $css);
		
		return $css;
		
	}
	
	
	
	/**
	* Escaping for CSS names
	*/
	public static function esc_css($string) {
		
		setlocale(LC_CTYPE, 'en_US.UTF8');
		
		return preg_replace('/\W+/', '_', strtolower(iconv('utf-8', 'ascii//TRANSLIT', $string)));
		
	}
	
	
	
	/**
	* Escaping for CSS names
	*/
	public static function getPrivacyPermalink($echo = true) {
		
		$permalink = get_permalink(get_option('wp_page_for_privacy_policy'));
		
		if ($echo) {
			echo esc_url($permalink);
		}
		
		return $permalink;
		
	}
	
	
	
	/**
	* detect if is mobile
	*
	public static function isMobile() {
		
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		
		return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)));
		
	}*/
	
	
	
	/**
	* return the current requested url
	*/
	public static function getCurrentUrl($params = true) {
		
		$end = ($params ? strlen($_SERVER['REQUEST_URI']) : strpos($_SERVER['REQUEST_URI'], '?'));
		
		if ($end === false) {
			$end = strlen($_SERVER['REQUEST_URI']);
		}
		
		return 'http' . (is_ssl() ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . substr($_SERVER['REQUEST_URI'], 0, $end);
		
	}
	
	
	
}