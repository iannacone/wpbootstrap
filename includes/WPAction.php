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
		add_action($action_name, [$this, 'callback']);
		
	}
	
	
	
	/*
	 * the action
	 */
	public function callback() {
		
		if ($this->collection) {
			$this->callback($this->collection);
		}
		else {
			$this->callback();
		}
		
	}
	
	
	
}
