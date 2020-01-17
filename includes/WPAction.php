<?php
/**
 * WPAction class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



class WPAction extends WPCollection {
	
	
	
	/**
	* function
	*/
	private $callback;
	
	
	
	/**
	* initialize
	*/
	public function __construct($action_name, $callback) {
		
		$this->callback = $callback;
		add_action($action_name, [$this, '_callback']);
		
	}
	
	
	
	/*
	 * the action
	 */
	public function _callback() {
		
		call_user_func($this->callback, $this->collection);
		
	}
	
	
	
}
