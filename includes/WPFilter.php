<?php
/**
 * WPFilter class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



abstract class WPFilter extends WPCollection {
	
	
	
	abstract public function callback($value, $args = null);
	
	
	
	/**
	* initialize
	*/
	public function __construct($filter_name, $priority = 10, $args_n = 1) {
		
		add_filter($filter_name, [$this, '_callback'], $priority, $args_n);
		
	}
	
	
	
	/*
	 * the filter
	 */
	public function _callback($value) {
        
        $args = func_get_args();

		return $this->callback($value, $args);
		
	}
	
	
	
}
