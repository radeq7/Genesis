<?php

class library_main_controller {
	protected $parameters = array();
	protected $view;
	
	function __construct($parameters, $view) {
		$this->parameters = $parameters;
		$this->view = $view;
	}
	
	function init(){
	}
	
	function end(){
		$this->view->auto_render_view();
	}
}