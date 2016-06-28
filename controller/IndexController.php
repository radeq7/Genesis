<?php
use Genesis\library\main\auth\auth;
class IndexController extends \Genesis\library\main\controller {
	
	function init(){	
	}
	
	function indexAction() {
	}
	
	function secretAction() {
		$this->needPrivilage();
	}
	
	// REJESTRACJA
	
	function registerAction() {
		auth::register($this->view);
	}
	
	function registerOkAction() {}
	
	// AKTYWACJA
	
	function activateAction() {
		auth::activate($this->parameters);
	}
	
	function activateOkAction() {}
	
	// LOGOWANIE
	
	function loginAction(){
		auth::login($this->view);
	}
	
	// WYLOGOWANIE
	
	function logoutAction() {
		auth::logout();
	}
	
	// ZMIANA HASŁA
	
	function remindPassAction() {
		auth::remind($this->view);
	}
	
	function remindOkAction(){}
	
	function changePassAction(){
		auth::changePass($this->parameters, $this->view);
	}
	
	function changePassOkAction(){}
	
	// ZMIANA LOGINU
	
	function changeLoginAction(){
		auth::changeLogin($this->parameters, $this->view);
	}
	
	function changeLoginSendAction(){}
	
	function changeLoginCheckAction(){
		auth::changeLoginCheck($this->parameters);
	}
	
	function changeLoginOkAction(){}
}