<?php
namespace Genesis;

/**
 * Pobiera i przechowuje informacje o żądaniu od użytkownika.
 * 
 * @package Genesis
 */
class library_main_request {
	private $default_controller_name;
	private $default_action_name;
	private $error_controller_name;
	private $controller_name = NULL;
	private $action_name = NULL;
	private $parameters = array();
	
	function __construct($default_controller_name = 'Index', $default_action_name = 'index', $error_controller_name = 'Error') {
		$this->default_controller_name = $default_controller_name;
		$this->default_action_name = $default_action_name;
		$this->error_controller_name = $error_controller_name;
		$this->parse();
	}
	
	protected function parse() {

	}
	
	function get_controller_name() {
		if (isset($this->controller_name))
			return $this->controller_name . 'Controller';
		else 
			return $this->default_controller_name . 'Controller';
	}
	
	function get_action_name() {
		if (isset($this->action_name))
			return $this->action_name . 'Action';
		else 
			return $this->default_action_name . 'Action';
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