<?php
/**
 * WPCollection class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



class WPCollection {
	
	
	
	/**
	* array
	*/
	protected $collection = [];
	
	
	
	/**
	* append the collection
	*/
	public function appendCollection($collection = []) {
		
		$this->collection = array_merge($this->collection, $collection);
		
	}
	
	
	
	/**
	* append the element
	*/
	public function append($element) {
		
		$this->collection[] = $element;
		
	}
	
	
	
}
