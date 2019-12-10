<?php
/**
 * Handlebars class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



class Handlebars {
	
	
	
	public function __construct() {
		
		
		
	}
	
	
	
	public function lzb_handlebars_object() {
		
		add_action('lzb_handlebars_object', [$this, 'registerHelpers']);
		
	}
	
	
	public function registerHelpers($handlebars) {
		
		$helpers = [
			'retrieve_meta',
			'debug',
			'rgba',
			'font_size', // deprecated in bootstrap 4
			'img',
			'__',
			'get_site_url',
			'esc_css',
			'esc_url',
			'esc_attr',
			'html_decode',
			'text_color',
			'privacy_permalink',
			'email',
		];
		
		foreach ($helpers as $helper) {
			$handlebars->registerHelper($helper, [$this, $helper]);
		}
		
	}
	
	
	
	// push a object into the context
	private function pushContent($var_name, $object, $options = null) {
		
		if (isset($options['context']) && method_exists($options['context'], 'push')) {
			$options['context']->push([$var_name => $object]);
		}
		else if (WP_DEBUG) {
			throw new Exception('Handlebars: context not found.');
		}
		
	}
	
	
	
	// push a meta in the context
	// {{retrieve_meta 'meta_id'}}
	public function retrieve_meta($id, $options = null) {
		
		$meta = get_lzb_meta($id);
		$this->pushContent($id, $meta, $options);
		
	}
	
	
	
	// {{debug variable}}
	public function debug($variable) {
		
		return print_r($variable, true);
		
	}
	
	
	
	// {{rgba '#ff00ff' 0.8}}
	public function rgba($hex, $alpha) {
		
		// if ($hex[0] === '#')
			// $hex = substr($hex, 1);
		
		list($r, $g, $b) = sscanf($hex, '#%02x%02x%02x');
		
		return "rgba($r,$g,$b,$alpha)";
		
	}
	
	
	
	// convert the pixel to the rem unit
	// {{font_size 14}}
	// deprecated in bootstrap 4
	public function font_size($px) {
		
		throw new Exception('font_size function is deprecated in wpbootstrap with bootstrap v.4');
		// return round($px / FONT_SIZE_BASE, 4) . 'rem';
		
	}
	
	
	
	// {{{img image_array 'medium'}}}
	public function img($img, $size) {
		
		if (!isset($img['id'])) {
			return;
		}
		
		if (gettype($size) !== 'string') {
			$size = 'medium';
		}
		
		return wp_get_attachment_image($img['id'], $size);
		
	}
	
	
	
	// {{get_site_url}}
	public function get_site_url() {
		
		return get_site_url();
		
	}
	
	
	
	// {{__ 'text'}}
	public function __($text) {
		
		return __($text);
		
	}
	
	
	
	// {{esc_css 'css class'}}
	public function esc_css($css) {
		
		return WPHelper::esc_css($css);
		
	}
	
	
	
	// {{esc_url 'http://www.url.com'}}
	public function esc_url($url) {
		
		return esc_url($url);
		
	}
	
	
	
	// {{esc_attr 'attribute to escape'}}
	public function esc_attr($attr) {
		
		return esc_attr($attr);
		
	}
	
	
	
	// {{html_decode 'string to html_entity_decode'}}
	public function html_decode($html) {
		
		return html_entity_decode($html);
		
	}
	
	
	
	// return the opposit color of $hex
	// {{text_color '#f0f0f0'}}
	public function text_color($hex) {
		
		list($r, $g, $b) = sscanf($hex, '#%02x%02x%02x');
		
		return '#' . ($r * 0.299 + $g * 0.587 + $b * 0.114 > 186
			? '000000'
			: 'FFFFFF');
		
	}
	
	
	
	// {{privacy_permalink}}
	public function privacy_permalink() {
		
		return WPHelper::getPrivacyPermalink(false);
		
	}
	
	
	
	// send an email to $email
	// useful for creating a contact form
	// $_REQUEST has the additional info
	// {{email 'example@email.com'}}
	public function email($email) {
		
		$html = '';
		
		if (isset($_REQUEST['email_submit'])) {
			
			$html = '<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="' . __('Close') . '"><span aria-hidden="true">&times;</span></button>
					' . __('Thank you for your message. It has been sent.') . '
				</div>';
			
			// honeypot
			if (!isset($_REQUEST['email']) || empty($_REQUEST['email_submit'])) {
				
				$domain = gethostname();
				// $domain = get_site_url();
				// $domain = str_replace('http://www.', '', $domain);
				// $domain = strstr($domain, '/', true);
				$to = $email;
				$subject = sprintf(__('Contact from %s'), $domain);
				$message = $_REQUEST['email_message'];
				$headers = [
					'Content-Type: text/html; charset=UTF-8',
					'From: ' . $domain . ' <wordpress@' . $domain . '>',
					'Reply-To: ' . $_REQUEST['email_name'] . ' <' . $_REQUEST['email_email'] . '>',
				];
				
				wp_mail($to, $subject, $message, $headers);
				
			}
			
		}
		
		return $html;
		
	}
	
	
	
}
