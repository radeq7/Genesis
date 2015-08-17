<?php

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
		//załadowanie autoloadera;
		require_once BASE_PATH . 'library/main/autoloader.php';
		
		// wczytanie konfiguracji aplikacji
		ini_set('display_errors', '1');
		require_once BASE_PATH . 'library/config.php';
		
		// WYŚWIETLANIE BŁĘDÓW
		$this->error_switch(library_main_appConfig::getConfig('error'));
		
		
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
	
	function error_switch($error) {
		if ($error){
			ini_set('display_errors', '1');
			error_reporting(E_ALL);
		}
		else 
			ini_set('display_errors', '0');
	}
}