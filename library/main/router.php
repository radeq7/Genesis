<?php
namespace Genesis;

/**
 * Sprawdza czy istnieje i uruchamia odpowiednią akcję kontrolera.
 * Do działania trzeba przekazać obiekt typu request(żadanie) na podstawie którego tworzy i uruchamia odpowiedni kontroler.
 * 
 * @package Genesis
 */
class library_main_router {
	
	function __construct() {
	}
	
	function run(library_main_request $request) {
		$this->run_request($request);
	}
	
	protected function run_request(library_main_request $request) {

		$controller_name = $this->get_controller_name($request);
		
		// załadowanie pliku z kontrolerem
		$this->load_controller_file($request->get_controller_path_by_name($controller_name));
		
		// sprawdź czy klasa kontrolera istnieje w podanym pliku
		if (!class_exists($controller_name, false))
			throw new \Exception("Klasa kontrolera nie została zdefiniowana w pliku kontrolera!");
		
		// sprawdź czy akcja kontrolera istnieje i zwróć jej nazwę
		$action_name = $this->get_action_name($controller_name, $request);
				
		// utworzenie obiektu controller
		$controller = $this->create_controller($controller_name, $request->get_parameters());
		
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
	protected function get_controller_name(library_main_request $request) { 
		
		// sprawdź czy kontroler istnieje
		if (file_exists($request->get_controller_path_by_name($request->get_controller_name())))
			$controller_name = $request->get_controller_name();
		
		else {
			if (file_exists($request->get_controller_path_by_name($request->get_error_controller_name())))
				$controller_name = $request->get_error_controller_name();
			else
				throw new \Exception("Kontroler błędu nie istnieje!");
		}
		return $controller_name;
	}
	
	protected function get_action_name($controller_name, library_main_request $request) {
		if (method_exists($controller_name, $request->get_action_name()))
			$action_name = $request->get_action_name();
		else {
			if (method_exists($controller_name, $request->get_default_action_name()))
				$action_name = $request->get_default_action_name();
			else
				throw new \Exception("Domyślna akcja kontrolera: '$controller_name' nie istnieje!");
		}
		return $action_name;
	}
	
	protected function create_controller($controller_name, $paremeters) {
		$controller = new $controller_name($paremeters);
		return $controller;
	}
	
	protected function load_controller_file($controller_path) {
		require_once $controller_path; 		
	}
	
	protected function run_controller(\library_main_controller $controller, $action_name) {
		$controller->init();
		$controller->$action_name();
		$controller->end();
	}
	
}