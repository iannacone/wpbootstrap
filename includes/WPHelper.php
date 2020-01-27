<?php
/**
 * WPHelper class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



class WPHelper {
	
	
	
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