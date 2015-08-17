<?php
namespace Genesis;

/**
 * Główny rdzeń aplikacji.
 * Ładuje odpowiednie pliki aplikacji, 
 * 
 * @package Genesis
 */
class application {
	
	function start() {
		$this->init();
		$this->run();
		$this->end();
	}
	
	function init() {
		// WYŚWIETLANIE BŁĘDÓW
		ini_set('display_errors', '1');
		error_reporting(E_ALL);
		
		//echo __NAMESPACE__;
		require_once BASE_PATH . 'library/main/autoloader.php';
		
		// wczytanie konfiguracji aplikacji
		require_once BASE_PATH . 'library/config.php';

	}
	
	function run() {
		
		$request = new library_main_requestUrl();
		
		// uruchomienie routera z przekazanym obiektem request
		$router = new library_main_router();
		$router->run($request);
	}
	
	function end() {
		// czynności końcowe aplikacji
	}
}