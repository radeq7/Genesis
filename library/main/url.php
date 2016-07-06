<?php
namespace Genesis\library\main;

class url{
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