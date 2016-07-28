<?php
namespace Genesis\library\main;

/**
 * Sprawdza czy istnieje i uruchamia odpowiednią akcję kontrolera.
 * Do działania trzeba przekazać obiekt typu request(żadanie) na podstawie którego tworzy i uruchamia odpowiedni kontroler.
 * 
 * @package Genesis
 */
class router {
	
	function __construct() {
	}
	
	function run(request $request) {
		$this->run_request($request);
	}
	
	protected function run_request(request $request) {

		$controller_name = $this->get_controller_name($request);
		
		// załadowanie pliku z kontrolerem
		$this->load_controller_file($request->get_controller_path_by_name($controller_name));

		// sprawdź czy klasa kontrolera istnieje w podanym pliku
		if (!class_exists($controller_name, false))
			throw new \Exception('<br>Plik: ' . __FILE__ . '<br>Linia: ' . __LINE__ . '<br>' ."Klasa kontrolera nie została zdefiniowana w pliku kontrolera!");
		
		// sprawdź czy akcja kontrolera istnieje i zwróć jej nazwę
		$action_name = $this->get_action_name($controller_name, $request);
				
		// utworzenie widoku
		$view = $this->create_view($controller_name, $action_name);
		
		// utworzenie obiektu controller
		$controller = $this->create_controller($controller_name, $request->get_parameters(), $view);
		
		// uruchomienie akcji controllera
		$this->run_controller($controller, $action_name);
	}

	
	/**
	 * Sprawdza czy plik z kontrolerem istnieje
	 * Jeśli plik z żądanym kontrolerem, ani plik z kontrolerem błedu nie istnieje zrzuca wyjątek
	 * @param request $request
	 * @throws \Exception
	 * @return string nazwa istniejącego kontrolera
	 */
	protected function get_controller_name(request $request) { 
		
		// sprawdź czy plik kontrolera istnieje
		if (file_exists($request->get_controller_path_by_name($request->get_controller_name())))
			$controller_name = $request->get_controller_name();
		
		else {
			if (file_exists($request->get_controller_path_by_name($request->get_error_controller_name())))
				$controller_name = $request->get_error_controller_name();
			else
				throw new \Exception('<br>Plik: ' . __FILE__ . '<br>Linia: ' . __LINE__ . '<br>' ."Kontroler błędu nie istnieje!");
		}
		return $controller_name;
	}
	
	protected function get_action_name($controller_name, request $request) {

		if (method_exists($controller_name, $request->get_action_name()))
			$action_name = $request->get_action_name();
		else {
			if (method_exists($controller_name, $request->get_default_action_name()))
				$action_name = $request->get_default_action_name();
			else
				throw new \Exception('<br>Plik: ' . __FILE__ . '<br>Linia: ' . __LINE__ . '<br>' ."Domyślna akcja kontrolera: '$controller_name' nie istnieje!");
		}
		return $action_name;
	}
	
	protected function create_controller($controller_name, $paremeters, $view_name) {
		$controller = new $controller_name($paremeters, $view_name);
		return $controller;
	}
	
	protected function create_view($controller_name, $action_name) {
		$view_name = substr($controller_name, 0, -10) . '/' . substr($action_name, 0, -6) . '.php';  
		$view = new view($view_name);
		return $view;
	}
	
	protected function load_controller_file($controller_path) {
		require_once $controller_path; 		
	}
	
	protected function run_controller(controller $controller, $action_name) {
		$controller->init();
		$controller->$action_name();
		$controller->end();
	}
	
	function redirect($redirect, $type=NULL) {
		if ($type == 'LOGIN') {
			$redirect = appConfig::getConfig('login_site');
		}
		application::getInstance()->end();
		header('Location: '. application::getInstance()->getResource('url')->internalUrl($redirect));
		exit();
	}
}