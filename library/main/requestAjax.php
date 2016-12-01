<?php
namespace Genesis\library\main;

class requestAjax extends requestUrl{
	function get_action_name() {
		return $this->action_name . 'Ajax';
	}
	function getView($controller_name, $action_name){	
		$view_name = substr($controller_name, 0, -10) . '/' . substr($action_name, 0, -4) . '.php';
		$view = new view($view_name);
		$view->layout_render_switch(false);
		return $view;
	}
}