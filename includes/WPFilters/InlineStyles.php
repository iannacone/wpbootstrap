<?php
/**
 * InlineStyles class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPFilters;

use WPBootstrap\WPFilter;
use WPBootstrap\WPHelper;



class InlineStyles extends WPFilter {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('style_loader_tag', 10, 4);
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback($value, $args = null) {

        $html = $value;
        list($handle, $href, $media) = $args;
		
        if (in_array($handle, $this->collection)) {
            
            $css = WPHelper::getFile($href);
            $css = WPHelper::compressCss($css);
            $html = '<style type="text/css">' . $css . '</style>' . "\n";
            
        }
        
        return $html;
		
	}
	
	
	
}
