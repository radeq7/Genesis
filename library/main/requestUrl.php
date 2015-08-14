<?php
namespace Genesis;

/**
 * Pobiera żądanie od użytkownika poprzez adres url
 * 
 * @package Genesis
 */
class library_main_requestUrl extends library_main_request {
	
	protected function parse() {
		$url = parse_url($_SERVER['REQUEST_URI']);
		//$config = config_app::getInstance();
		$config = ''; // W TO MIEJSCE NALEŻY ZAŁADOWAĆ Z KONFIGURACJI APP_DIRECTORY
		
		// read url and remove white signs
		$path = trim($url['path'], '/');
		
		// remove 'index.php' and signs '/' in url
		$path = substr($path, strlen($config));
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
		
		// read parameter
		if (!isset($url['query']))
			return;
		$param = explode('&', $url['query']);
		for ($i = 0; $i < count($param); $i++) {
			if (strpos($param[$i], '=') !== FALSE) {
				$parametr = explode('=', $param[$i]);
				$this->parameters[$parametr[0]] = $parametr[1];
			}
		}
	}
}