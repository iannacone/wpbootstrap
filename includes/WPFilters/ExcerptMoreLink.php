<?php
/**
 * ExcerptMoreLink class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPFilters;

use WPBootstrap\WPFilter;



class ExcerptMoreLink extends WPFilter {
	
	
	
	/**
	* initialize
	*/
	public function __construct() {
		
		parent::__construct('the_excerpt', 10, 1);
		
	}
	
	
	
	/**
	* callback
	*/
	public function callback($value, $args = null) {

        $excerpt = $value;
        $args = $this->collection;
        $default = __('Read more …');

        if (isset($args[0]) && $args[0] !== false && $args[0] !== null) {
            $text = $args[0];
        }
        else {
            $text = $default;
        }
		
        $excerpt .= ' <a class="read-more" href="'. get_permalink() . '">' . $text . '</a>';

        return $excerpt;
		
	}
	
	
	
}
