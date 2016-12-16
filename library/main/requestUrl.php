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
		
		// remove 'index.php', signs '/' and siteAdres in url
		$path = substr($path, strlen($siteAdres));
		if (strpos($path, 'index.php') === 0)
			$path = trim (substr($path, 9), '/');
		
		$this->request = $path;
		
		// jeśli jest ustalona trasa wczytaj controller i action na podstawie trasy
		$this->checkRouteExist();
		// wczytaj controller i action na podstawie request
		$this->explodeRequest();
		
		// wczytaj parametry żądania
		if (isset($link['query']))
			$this->loadParameters($link['query']);
	}
	
	protected function explodeRequest(){
		$tablica = explode('/', $this->request);
		// odczyt tablicy
		if ($tablica[0] != '') {
			$this->controller_name = ucfirst($tablica[0]);
			if (isset($tablica[1])) {
				$this->action_name = $tablica[1];
			}
		}
	}
	
	protected function checkRouteExist(){
		$route = $this->url->checkRoute($this->request);
		if ($route){
			$this->request = $route;
			return TRUE;
		}
		return FALSE;
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