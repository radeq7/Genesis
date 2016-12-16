<?php
namespace Genesis\library\main;

class url{
	protected $routes = array();
	function externalUrl($controller, $action = null, $parameters = array()){
		$url = 'http://';
		$url .= SERVER_ADRESS;
		$url .= $this->internalUrl($controller, $action, $parameters);
		return $url;
	}
	function internalUrl($controller, $action = null, $parameters = array()){
		$url = SITE_ADRESS . '/' . $controller;
		if (!empty($action))
			$url .= '/' . $action;
		$url .= $this->generateParameters($parameters);		
		return $url;
	}
	function publicUrl($url){
		$url = SITE_ADRESS . '/public/' . $url;
		return $url;
	}
	
	function addRoute($siteName, $siteAdress, $controller, $action){
		$this->routes[$siteName] = array('adress' => $siteAdress, 'controller' => $controller, 'action' => $action);
	}
	function routeUrl($site, $parameters = array()){
		if (isset($this->routes[$site]))
			return $this->generateLink($site, $parameters);
		return $site;
	}
	function checkRoute($route){
		foreach ($this->routes as $site){
			if ($site['adress'] == $route)
				return sprintf('%s/%s', $site['controller'], $site['action']);
		}
		return FALSE;
	}
	function isActual($site){
		$request = application::getInstance()->getResource('request');
		if (isset($this->routes[$site])){
			if ($this->routes[$site]['adress'] == $request->get_request())
				return TRUE;
		}
		else{
			if ($site == $request->get_request())
				return TRUE;
		}
		return FALSE;
	}
	protected function generateLink($site, $parameters){
		$link = $this->externalUrl($this->routes[$site]['adress'], '', $parameters);
		return $link;
	}
	protected function generateParameters($parameters = array()){
		if (empty($parameters))
			return false;
		$str = '?';
		foreach ($parameters as $key => $value){
			$str .= $key . '=' . $value . '&';
		}
		$str = rtrim($str, '&');
		return $str;
	}
}