<?php
namespace Genesis\library\main;
use Genesis\library\main\auth\auth;

class controller {
	protected $parameters = array();
	protected $view;
	
	function __construct(array $parameters, view $view) {
		$this->parameters = $parameters;
		$this->view = $view;
	}
	
	function init(){
	}
	
	function end(){
		$this->view->auto_render_view();
	}

	function needPrivilage($privilage = 0){
		if (auth::checkPrivilage($privilage))
			return TRUE;
		router::redirect('', 'LOGIN');
		return FALSE;
	}
	
}