<?php
namespace Genesis\library\main;

class bootstrap{
	protected $resource = array();
	
	function init(){}
	function end(){}
	function getResource($resourceName = null){
		if (!isset($this->resource[$resourceName]))
			$this->initResource($resourceName);
		return $this->resource[$resourceName];
	}
	protected function initResource($resourceName){
		$methodName = $this->generateMethodName($resourceName);
		if (method_exists($this, $methodName)){
			$this->resource[$resourceName] = $this->$methodName();
			return;
		}
		throw \Exception("Nie ma metody o nazwie '{$methodName}' do utworzenia zasobu {$resourceName}! - bootstrap");
	}
	protected function generateMethodName($resourceName){
		$methodName = ucfirst($resourceName);
		$methodName = sprintf('init%s', $methodName);
		return $methodName;
	}
	protected function initRouter(){
		return new router();
	}
	protected function initRequest(){
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
			return new requestAjax($this->getResource('url'));
		return new requestUrl($this->getResource('url'));
	}
	protected function initDbAdapter(){
		return new db\dbStandard($this->getResource('mapper'));
	}
	protected function initMapper(){
		return new db\mapper($this->getResource('pdo'));
	}
	protected function initPdo(){
		return db\db::getPdo();
	}
	protected function initAuth(){
		return new \Genesis\library\main\auth\auth($this->getResource('userFactory'));
	}
	protected function initUserFactory(){
		return new \Genesis\library\main\auth\userFactory();
	}
	protected function initUrl(){
		return new url();
	}
}