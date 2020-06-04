<?php

/**
 * WPAction class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



abstract class WPAction extends WPCollection
{



	abstract public function callback();



	/**
	 * initialize
	 */
	public function __construct($action_name)
	{
		add_action($action_name, [$this, '_callback']);
	}



	/*
	 * the action
	 */
	public function _callback()
	{
		$this->callback();
	}
}
