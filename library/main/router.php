<?php

class router {
	
	private $url = '';
	private $controller_name = 'Index';
	private $action_name ='index';
	private $param = array();
	
	function __construct() {
		self::read_url();
		self::read_param();
	}
	
	private function read_url() {
		$this->url = parse_url($_SERVER['REQUEST_URI']);
		$config = config_app::getInstance();
		
		// odczytanie url i usunięcie znaków /
		$path = trim($this->url['path'], '/');
		
		// usunięcie index.php i znaków / jeśli występują w url
		$path = substr($path, strlen($config->getConfig('app_directory')));
		if (strpos($path, 'index.php') === 0)
			$path = trim (substr($path, 9), '/');
		
		// podzielenie url na odpowiednie części i przypisanie do tablicy
		$tablica = explode('/', $path);
		
		// odczyt tablicy
		if ($tablica[0] != '') {
			$this->controller_name = ucfirst($tablica[0]);
			if (isset($tablica[1])) {
				$this->action_name = $tablica[1];
			}
		}
	}
	
	private function read_param() {
		if (!isset($this->url['query']))
			return;
		$param = explode('&', $this->url['query']);	
		for ($i = 0; $i < count($param); $i++) {
			if (strpos($param[$i], '=') !== FALSE) {
				$parametr = explode('=', $param[$i]);
				$this->param[$parametr[0]] = $parametr[1];
			}
		}
	}
	
	function get_controller_name() {
		return $this->controller_name;
	}
	
	function get_action_name() {
		return $this->action_name;
	}

	function get_param() {
		return $this->param;
	}

	function get_controller_path() {
		return BASE_PATH . 'application/controller/' . $this->controller_name . 'Controller.php';
	}
	
	function get_view_path() {
		return BASE_PATH . 'application/view/' . $this->controller_name . '/' . $this->action_name . '.php';
	}
	
	function get_controller_name_class() {
		return $this->controller_name . 'Controller';
	}

	function get_action_name_class() {
		return $this->action_name . 'Action';
	}
	
	function set_controller_name($controller_name) {
		$this->controller_name = $controller_name;
	}

	function set_action_name($action_name) {
		$this->action_name = $action_name;
	}
}