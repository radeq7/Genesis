<?php

abstract class Controller {
	
	protected $variable = array();
	protected $param = array();
	protected $view;
	
	function __construct($param, $view_path) {
		$this->param = $param;
		$this->view = new view($view_path);
	}
	
	function init() {
		
	}
		
	function __set($param, $value) {
		$this->variable[$param] = $value;
	}
	
	function __get($param) {
		return $this->variable[$param];
	}
		
	function post() {
		// wyświetlenie widoku
		$this->view->render_view();
	}
} 