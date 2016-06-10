<?php
namespace \Genesis\library\main\form;

class form{
	protected $method = 'post';
	protected $action = '';
	protected $name = '';
	protected $id = '';
	protected $target = '';
	protected $autocomplete = true;
	protected $elements = array();
	
	function __construct($action = ''){
		$this->action = $action;
	}
	function __toString(){
		return $this->render();
	}
	function addElement(Element $element){
		$this->elements[] = $element;
	}
	function setMethodGet(){
		$this->method = 'get';
	}
	function setMethodPost(){
		$this->method = 'post';
	}
	function autocompleteOff(){
		$this->autocomplete = false;
	}
	function autocompleteOn(){
		$this->autocomplete = true;
	}
	function setAction($action){
		$this->action = $action;
	}
	function setName($name){
		$this->name = $name;
	}
	function setId($id){
		$this->id = $id;
	}
	function setTarget($target){
		$this->target = $target;
	}	
	function render(){
		$txt = '<form method="%s" action="%s"%s%s%s%s>%s</form>';
		return sprintf($txt, $this->method, $this->action, $this->showName(), $this->showId(), $this->showTarget(), $this->showAutocomplete(), $this->showBody());
	}
	protected function showBody(){
		$body = '';
		foreach ($this->elements as $element){
			$body .= $element->render();
		}
		return $body;
	}
	protected function showName(){
		$name = '';
		if ($this->name)
			$name = sprintf(' name="%s"', $this->name);
		return $name;
	}
	protected function showId(){
		$id = '';
		if ($this->id)
			$id = sprintf(' id="%s"', $this->id);
			return $id;
	}
	protected function showTarget(){
		$target = '';
		if ($this->target)
			$target = sprintf(' target="%s"', $this->target);
			return $target;
	}
	protected function showAutocomplete(){
		$auto = '';
		if (!$this->autocomplete)
			$auto = ' autocomplete="off"';
		return $auto;
	}
}