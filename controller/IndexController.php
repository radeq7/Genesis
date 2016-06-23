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
	
	// ZMIANA HASŁA
	
	function remindPassAction() {
		auth::remind();
	}
	
	function remindOkAction(){}
	
	function changePassAction(){
		auth::changePass($this->parameters);
	}
	
	function changePassOkAction(){}
	
	// ZMIANA LOGINU
	
	function changeLoginAction(){
		auth::changeLogin($this->parameters);
	}
	
	function changeLoginSendAction(){}
	
	function changeLoginCheckAction(){
		auth::changeLoginCheck($this->parameters);
	}
	
	function changeLoginOkAction(){}
}