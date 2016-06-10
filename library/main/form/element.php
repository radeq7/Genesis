<?php
namespace \Genesis\library\main\form;

abstract class element{
	protected $name = '';
	protected $parameters;
	function __construct($name='', $parameters = array()){
		$this->name = $name;
		$this->parameters = $parameters;
	}
	function __toString(){
		return $this->render();
	}
	function render(){
		return sprintf($this->format, $this->name, $this->showParameters());
	}
	protected function showParameters(){
		$separated = implode(" ", $this->parameters);
		return $separated;
	}
}