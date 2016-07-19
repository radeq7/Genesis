<?php
namespace Genesis\library\main;

class bootstrap{
	protected $resource = array();
	
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
		return new requestUrl($this->getResource('url'));
	}
	protected function initMapper(){
		return new mapper($this->getResource('pdo'));
	}
	protected function initPdo(){
		return db::getPdo();
	}
	protected function initAuth(){
		return new \Genesis\library\main\auth\auth($this->getResource('userFactory'));
	}
	protected function initObjectWatcher(){
		return new objectWatcher();
	}
	protected function initUserFactory(){
		return new \Genesis\library\main\auth\userFactory();
	}
	protected function initUrl(){
		return new url();
	}
}