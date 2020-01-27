<?php
/**
 * Scripts class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPActions;

use WPBootstrap\WPAction;
use WPBootstrap\WPHelper;



class Scripts extends WPAction {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('wp_enqueue_scripts');
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback($scripts = null) {
		
        /**
        * extension of wp_enqueue_script, wp_localize_script, wp_script_add_data, wp_register_script
        */

		foreach ($scripts as $args) {
			
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
            
            
            if (WP_DEBUG && strlen($src) > 0 && !WPHelper::fileExists($src)) {
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
	}
	
	
	
}
