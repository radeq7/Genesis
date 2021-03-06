<?php
namespace Genesis\library\main;

class url{
	protected $sites = array();
	function externalUrl($controller, $action = null, $parameters = array()){
		$url = 'http://';
		$url .= SERVER_ADRESS . SITE_ADRESS;
		$url .= '/' . $controller;
		if (!empty($action))
			$url .= '/' . $action;
		$url .= $this->generateParameters($parameters);
		
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
	function addSite($siteName, $siteAdress, $controller, $action){
		$this->sites[$siteName] = array('adress' => $siteAdress, 'controller' => $controller, 'action' => $action);
	}
	function link($site, $parameters = array()){
		if (isset($this->sites[$site]))
			return $this->generateLink($site, $parameters);
		return $site;
	}
	function checkAdress($adress){
		foreach ($this->sites as $site){
			if ($site['adress'] == $adress)
				return array('controller' => $site['controller'], 'action' => $site['action']);
		}
		return FALSE;
	}
	function isActual($site){
		$request = application::getInstance()->getResource('request');
		if (isset($this->sites[$site])){
			if ($this->sites[$site]['adress'] == $request->get_request())
				return TRUE;
		}
		else{
			if ($site == $request->get_request())
				return TRUE;
		}
		return FALSE;
	}
	protected function generateLink($site, $parameters){
		$link = $this->externalUrl($this->sites[$site]['adress'], '', $parameters);
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