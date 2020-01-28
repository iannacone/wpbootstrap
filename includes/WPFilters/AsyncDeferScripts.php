<?php
/**
 * AsyncDeferScripts class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPFilters;

use WPBootstrap\WPFilter;



class AsyncDeferScripts extends WPFilter {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('script_loader_tag', 10, 3);
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback($value, $args = null) {

        $tag = $value;
        list($handle, $src) = $args;
		
        if (in_array($handle, $this->collection)) {
            $tag = '<script type="text/javascript" src="' . $src . '" async="async" defer="defer"></script>' . "\n";
        }
        
        return $tag;
		
	}
	
	
	
}
