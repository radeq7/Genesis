<?php
namespace Genesis;

/**
 * Pobiera i przechowuje informacje o żądaniu od użytkownika.
 * 
 * @package Genesis
 */
class library_main_request {
	protected $default_controller_name;
	protected $default_action_name;
	protected $error_controller_name;
	protected $controller_name = NULL;
	protected $action_name = NULL;
	protected $parameters = array();
	
	function __construct($default_controller_name = 'Index', $default_action_name = 'index', $error_controller_name = 'Error') {
		$this->default_controller_name = $default_controller_name;
		$this->default_action_name = $default_action_name;
		$this->error_controller_name = $error_controller_name;
		$this->parse();
	}
	
	protected function parse() {

	}
	
	function get_controller_name() {
		if(empty($this->controller_name))
			return $this->default_controller_name . 'Controller';
		return $this->controller_name . 'Controller';
	}
	
	function get_action_name() {
		if(empty($this->action_name))
			return $this->default_action_name . 'Action';
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
		return BASE_PATH . 'controller/' . $controller_name . '.php';
	}
	
}