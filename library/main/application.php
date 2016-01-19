<?php
namespace Genesis\library\main;

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
		session_start();
		
		// wczytanie konfiguracji aplikacji
		ini_set('display_errors', '1');
		require_once BASE_PATH . '/library/config.php';
		
		// WYŚWIETLANIE BŁĘDÓW
		$this->error_switch(appConfig::getConfig('error'));
		
		
	}
	
	function run() {
		
		$request = new requestUrl();
		
		// uruchomienie routera z przekazanym obiektem request
		$router = new router();
		$router->run($request);
	}
	
	static function end() {
		// czynności końcowe aplikacji
		objectWatcher::execute();
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