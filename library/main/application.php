<?php

class application {
	
	static private $instance;
	private $request;
	
	private function __construct() {	
	}
	
	static function instance() {
		if (!self::$instance)
			self::$instance = new application();
			
		return self::$instance;
	}
	
	function init() {
		session_start();
		require_once BASE_PATH . 'library/main/autoloader.php';
		require_once BASE_PATH . 'library/main/router.php';
		require_once BASE_PATH . 'library/main/controller.php';
		require_once BASE_PATH . 'library/main/view.php';
		require_once BASE_PATH . 'library/main/mapper.php';
		require_once BASE_PATH . 'library/main/database.php';
		require_once BASE_PATH . 'application/configs/app_config.php';
	}
	
	function run() {
		
		// inicjalizacja aplikacji
		$this->init();
		
		// rozpoznanie żądania po adresie url
		$this->request = new router();
		
		// stworzenie kontrolera na podstawie żądania
		$controller = $this->getController();
		
		// wykonanie polecenia
		$this->execute($controller);		
		
		// wykonanie aktualizacji bazy danych
		mapper::execute();
		
	}
	
	function execute(Controller $controller) {
		
		// inicjalizacja kontrolera
		$controller->init();
		
		// uruchomienie akcji kontrolera
		$action_name = $this->request->get_action_name_class();
		$controller->$action_name();
		
		// uruchomienie zakmnięcia kontrolera
		$controller->post();
	}
	
	function getController() {
				
		// Sprawdzenie czy podany controler istnieje
		if (!file_exists($this->request->get_controller_path())) 
			$this->request->set_controller_name('Error');				
		
		// załadowanie pliku controlera
		require_once $this->request->get_controller_path();
		
		// Sprawdzenie czy podana akcja istnieje
		if (!method_exists($this->request->get_controller_name_class(), $this->request->get_action_name_class())) 		
			$this->request->set_action_name('index');
							
		$view_path = BASE_PATH . 'application/view/' . $this->request->get_controller_name() . '/' . $this->request->get_action_name() . '.php';
		$controller_name = $this->request->get_controller_name_class();
		$controller = new $controller_name($this->request->get_param(), $view_path);
		return $controller;
	}
	
	static function redirect($redirect, $type=NULL) {
		if ($type == 'LOGIN') {
			$config = config_app::getInstance();
			$redirect = $config->getConfig('login_site');
		}
		printf('<meta http-equiv="refresh" content="0;url=%s">', $redirect);
	}
}