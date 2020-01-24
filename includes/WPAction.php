<?php
/**
 * WPAction class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



abstract class WPAction extends WPCollection {
	
	
	
	abstract public function callback($collection = null);
	
	
	
	/**
	* initialize
	*/
	public function __construct($action_name) {
		
		add_action($action_name, [$this, '_callback']);
		
	}
	
	
	
	/*
	 * the action
	 */
	public function _callback() {
		
		// call_user_func([$this, 'callback'], $this->collection);
		$this->callback($this->collection);
		
	}
	
	
	
}
