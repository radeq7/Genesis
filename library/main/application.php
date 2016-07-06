<?php
namespace Genesis\library\main;

/**
 * Główny rdzeń aplikacji.
 * Ładuje odpowiednie pliki aplikacji, 
 * 
 * @package Genesis
 */
class application {
	protected static $_instance = null;
	protected $bootstrap;
	
	protected function __construct(){}
 	static function getInstance(){
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
	function run() {
		$this->init();
		$this->begin();
		$this->end();
	}
	function getResource($resource = null){
		if ($resource === null)
			return $this->bootstrap;
		return $this->bootstrap->getResource($resource);
	}
	protected function init() {
		// wczytanie konfiguracji aplikacji
		require_once BASE_PATH . '/library/config.php';
		
		// TRYB pracy aplikacji
		$this->mode(\Genesis\library\PRODUCTION);
		
		// bootstrap
		$this->bootstrap = new \Genesis\library\bootstrap();
		
		// uruchomienie sesji
		session_start();
	}
	
	protected function begin() {
		$router = $this->getResource('router');
		$request = $this->getResource('request');
		
		// uruchomienie routera z przekazanym obiektem request
		$router->run($request);
	}
	
	function end() {
		$this->getResource('objectWatcher')->execute();
	}
	
	protected function mode($isProduction) {
		if ($isProduction)
			ini_set('display_errors', '0');
		else {
			ini_set('display_errors', '1');
			error_reporting(E_ALL);
		}
	}
}