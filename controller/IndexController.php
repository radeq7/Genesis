<?php
use Genesis\library\main\auth\auth;
class IndexController extends \Genesis\library\main\controller {
	
	function indexAction() {
	}
	
	function registerAction() {
		auth::register();
	}
	
	function registerOkAction() {}
	
	function activateAction() {
		auth::activate($this->parameters);
	}
	
	function activateOkAction() {}
	
	function loginAction(){
		auth::login($this->parameters);
	}
	
	function logoutAction() {
		auth::logout();
	}
	
	function secretAction() {
		$this->needPrivilage();
	}
}