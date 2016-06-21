<?php
namespace Genesis\library\main\auth;

class auth{
	static private $user = false;
	static $loginSite = '../index/secret';
	static $registerOkSite = 'registerOk';
	static $activateOkSite = 'activateOk';
	static $activateMessage;
	
	private function __construct(){}
	
	static function checkPrivilage($privilage = 0){
		if (self::isLogged() && self::$user->update())
			return self::$user->checkPrivilage($privilage);
		return FALSE;
	}
	
	static function isLogged(){
		if (!isset($_SESSION['userId']) || !$_SESSION['userId'])
			return FALSE;
		if (!self::$user)
			self::$user = user::load($_SESSION['userId']);
		if (!self::$user)
			return FALSE;
		return TRUE;
	}
	
	static function login(){
		if (!isset($_POST['login']) || !isset($_POST['pass']))
				return;
		$user = userFactory::getUserByLogin($_POST['login']);
		if (!$user)
			return;
		if ($user->login($_POST['pass'])){
			$_SESSION['userId'] = $user->get_id();
			self::$user = $user;
			\Genesis\library\main\router::redirect(self::$loginSite);
		}
	}
	
	static function logout(){
		if (self::isLogged())
			self::$user->logout();
		self::$user = false;
		$_SESSION['userId'] = 0;
	}
	
	static function getUser(){
		if (self::isLogged())
			return self::$user;
		return FALSE;
	}
	
	static function getIdUser(){
		if (self::isLogged())
			return self::$user->get_id();
		return FALSE;
	}
	
	static function register(){
		if (!isset($_POST['login']) || !isset($_POST['pass']))
			return;
		$user = new user();
		$user->createUser($_POST['login'], $_POST['pass']);
		if ($user->register()){
			//$this->activateMessage->send();
			\Genesis\library\main\router::redirect(self::$registerOkSite);
		}
	}
	
	static function activate($data){
		if (!isset($data['login']) || !isset($data['token']))
			return;
		$user = userFactory::getUserByLogin($data['login']);
		if (!$user)
			return;
		if ($user->activate($data['token']))
			\Genesis\library\main\router::redirect(self::$activateOkSite);
	}
}