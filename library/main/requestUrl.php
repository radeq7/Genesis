<?php
namespace Genesis\library\main;

/**
 * Pobiera żądanie od użytkownika poprzez adres url
 * 
 * @package Genesis
 */
class requestUrl extends request {
	
	protected function parse() {
		$link = parse_url($_SERVER['REQUEST_URI']);
		$siteAdres = SITE_ADRESS;
		
		// read url and remove white signs
		$path = trim($link['path'], '/');
		
		// remove 'index.php' and signs '/' in url
		$path = substr($path, strlen($siteAdres));
		if (strpos($path, 'index.php') === 0)
			$path = trim (substr($path, 9), '/');
		
		
		// sprawdź czy jest utworzony route
		$route = $this->url->checkAdress($path);
		if ($route){
			$this->controller_name = ucfirst($route['controller']);
			$this->action_name = $route['action'];
			if (isset($link['query']))
				$this->loadParameters($link['query']);
			return TRUE;
		}
			
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
		if (isset($link['query']))
			$this->loadParameters($link['query']);
	}
	
	protected function loadParameters($query){
		if (empty($query))
			return;
		$param = explode('&', $query);
		for ($i = 0; $i < count($param); $i++) {
			if (strpos($param[$i], '=') !== FALSE) {
				$parametr = explode('=', $param[$i]);
				$this->parameters[$parametr[0]] = $parametr[1];
			}
		}
	}
}