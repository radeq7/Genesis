<?php
namespace Genesis\library\main;

class controller {
	protected $appResource = array();
	protected $parameters = array();
	protected $view;
	
	function __construct(array $parameters, view $view) {
		$aplication = application::getInstance();
		$this->appResource = $aplication->getResource();
		$this->parameters = $parameters;
		$this->view = $view;
	}
	
	function init(){
	}
	
	function end(){
		$this->view->auto_render_view();
	}

	function needPrivilage($privilage = 0){
		$auth = $this->appResource->getResource('auth');
		$router = $this->appResource->getResource('router');
		
		if ($auth->checkPrivilage($privilage))
			return TRUE;
		$router->redirect('', 'LOGIN');
		return FALSE;
	}
	
}