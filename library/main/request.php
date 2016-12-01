<?php
namespace Genesis\library\main;

/**
 * Pobiera i przechowuje informacje o żądaniu od użytkownika.
 * 
 * @package Genesis
 */
class request {
	protected $default_controller_name = 'Index';
	protected $default_action_name = 'index';
	protected $error_controller_name = 'Error';
	protected $controller_name = NULL;
	protected $action_name = NULL;
	protected $parameters = array();
	protected $request = null;
	protected $url;
	
	function __construct($url) {
		$this->url = $url;
		$this->parse();
		if(empty($this->controller_name))
			$this->controller_name = $this->default_controller_name;
		if(empty($this->action_name))
			$this->action_name = $this->default_action_name;
	}
	
	protected function parse() {
	}
	
	function getAction(){
		return $this->action_name;
	}
	function getController(){
		return $this->controller_name;
	}
	
	function get_controller_name() {
		return $this->controller_name . 'Controller';
	}
	
	function get_action_name() {
		return $this->action_name . 'Action';
	}
	
	function get_default_action_name() {
		return $this->default_action_name . 'Action';
	}
	
	function get_parameters() {
		return $this->parameters;
	}
	
	function get_error_controller_name() {
		return $this->error_controller_name . 'Controller';
	}
	
	function get_controller_path_by_name($controller_name) {
		return BASE_PATH . '/controller/' . $controller_name . '.php';
	}
	
	function get_request(){
		return $this->request;
	}
	
	function getView($controller_name, $action_name){
		$view_name = substr($controller_name, 0, -10) . '/' . substr($action_name, 0, -6) . '.php';
		$view = new view($view_name);
		return $view;
	}
}