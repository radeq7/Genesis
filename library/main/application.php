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
	
	protected function __construct(){
		// bootstrap
		$this->bootstrap = new \Genesis\library\bootstrap();	
	}
 	static function getInstance(){
        if (null === self::$_instance) {
            self::$_instance = new static();
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
		$this->mode();
		
		// uruchomienie sesji
		session_start();
		
		// funkcje użytkownika
		$this->bootstrap->init();
	}
	
	protected function begin() {
		$router = $this->getResource('router');
		$request = $this->getResource('request');
		
		// uruchomienie routera z przekazanym obiektem request
		$router->run($request);
	}
	function errorReaction(\Exception $error){
		$message = $error->getMessage();
		$log = new \Genesis\library\main\standard\log('log/error.html');
		$log->logMessage($log->formatMessage($message));
		echo '<P class="error">WYSTĄPIŁ BŁĄD !</P>';
	}
	function end() {
		// funckcje użytkownika
		$this->bootstrap->end();
	}
	
	protected function mode() {
		ini_set('display_errors', '0');
	}
}