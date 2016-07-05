<?php
use Genesis\library\main\auth\auth;
class AuthController extends \Genesis\library\main\controller {
	
	function init(){	
	}
	
	function indexAction() {
	}
	
	function secretAction() {
		$this->needPrivilage();
	}
	
	// REJESTRACJA
	
	function registerAction() {
		$this->auth->register($this->view);
	}
	
	function registerOkAction() {}
	
	// AKTYWACJA
	
	function activateAction() {
		$this->auth->activate($this->parameters, $this->view);
	}
	
	function activateOkAction() {}
	
	// LOGOWANIE
	
	function loginAction(){
		$this->auth->login($this->view);
	}
	
	// WYLOGOWANIE
	
	function logoutAction() {
		$this->auth->logout();
	}
	
	// ZMIANA HASŁA
	
	function remindPassAction() {
		$this->auth->remind($this->view);
	}
	
	function remindOkAction(){}
	
	function changePassAction(){
		$this->auth->changePass($this->parameters, $this->view);
	}
	
	function changePassOkAction(){}
	
	// ZMIANA LOGINU
	
	function changeLoginAction(){
		$this->auth->changeLogin($this->parameters, $this->view);
	}
	
	function changeLoginSendAction(){}
	
	function changeLoginCheckAction(){
		$this->auth->changeLoginCheck($this->parameters, $this->view);
	}
	
	function changeLoginOkAction(){}
}