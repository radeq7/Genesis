<?php
namespace Genesis\library\main\auth;

use Genesis\library\main\auth\email\activateUser;
use Genesis\library\main\auth\email\remindPass;
use Genesis\library\main\auth\email\changeLogin;
class auth{
	static private $user = false;
	static $loginSite = '../index/secret';
	static $activateSite = 'index/activate';
	static $remindSite = 'index/remindPass';
	static $changePassSite = 'index/changePass';
	static $changeLoginSite = 'index/changeLogin';
	static $changeLoginActivateSite = 'index/changeLoginCheck';
	static $registerOkSite = 'registerOk';
	static $activateOkSite = 'activateOk';
	static $remindOkSite = 'remindOk';
	static $changePassOkSite = 'changePassOk';
	static $changeLoginOk = 'changeLoginOk';
	static $changeLoginSendSite = 'changeLoginSend';
	static $remindMessage;
	static $changeLoginMessage;
	
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
	
	static function login($view){
		if (!isset($_POST['login']) || !isset($_POST['pass']))
			return;
		$user = userFactory::getUserByLogin($_POST['login']);
		if (!$user){
			self::showError($view, user::ERROR_WRONG_LOGIN_OR_PASS);
			return;
		}
		if ($user->login($_POST['pass'])){
			$_SESSION['userId'] = $user->get_id();
			self::$user = $user;
			\Genesis\library\main\router::redirect(self::$loginSite);
		}
		else 
			self::showError($view, user::ERROR_WRONG_LOGIN_OR_PASS);
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
	
	static function register($view){
		if (!isset($_POST['login']) || !isset($_POST['pass']))
			return;
		$user = new user();
		$user->createUser($_POST['login'], $_POST['pass']);
		if ($user->register()){
			$activateMessage = new activateUser($user->getEmail(), self::generateActivateLink($user));
			$activateMessage->send();
			\Genesis\library\main\router::redirect(self::$registerOkSite);
		}
		else 
			self::showError($view, $user->getErrorMessage());
	}
	
	static function generateActivateLink($user){
		$link = sprintf('http://%s/%s?login=%s&token=%s', $_SERVER['SERVER_NAME'], self::$activateSite, $user->getEmail(), $user->getActivateToken());
		return $link;
	}
	
	static function generateRemindLink(){
		return self::$remindSite;
	}
	
	static function generateChangeLoginLink(){
		$user = auth::getUser();
		$link = sprintf('%s?login=%s&token=%s', self::$changeLoginSite, $user->getEmail(), $user->generateChangeLoginToken());
		return $link;
	}
	
	static function generateChangeLoginActivateLink($user){
		$link = sprintf('http://%s/%s?login=%s&token=%s', $_SERVER['SERVER_NAME'], self::$changeLoginActivateSite, $user->getEmail(), $user->generateChangeLoginActivateToken());
		return $link;
	}
	
	static function generateChangePassLink($user){
		$link = sprintf('http://%s/%s?login=%s&token=%s', $_SERVER['SERVER_NAME'], self::$changePassSite, $user->getEmail(), $user->getChangePassToken());
		return $link;
	}
	
	static function showError($view, $errorNr){
		switch($errorNr){
			case user::ERROR:
				$view->add_view_before('Index/Info/error.php');
				break;
			case user::ERROR_INCORRECT_LOGIN:
				$view->add_view_before('Index/Info/incorrectLogin.php');
				break;
			case user::ERROR_INCORRECT_PASS:
				$view->add_view_before('Index/Info/incorrectPass.php');
				break;
			case user::ERROR_LOGIN_EXIST:
				$view->add_view_before('Index/Info/loginExist.php');
				break;
			case user::ERROR_LOGIN_NOT_EXIST:
				$view->add_view_before('Index/Info/loginNotExist.php');
				break;
			case user::ERROR_WRONG_LOGIN_OR_PASS:
				$view->add_view_before('Index/Info/wrongLoginOrPass.php');
				break;
			case user::ERROR_PASS_NOT_SAME:
				$view->add_view_before('Index/Info/passNotSame.php');
				break;
			case user::ERROR_INCORRECT_TOKEN:
				$view->add_view_before('Index/Info/incorrectToken.php');
				break;
			case user::ERROR_LINK_EXPIRED:
				$view->add_view_before('Index/Info/linkExpired.php');
				break;
			case user::ERROR_USER_NOT_ACTIVE:
				$view->add_view_before('Index/Info/userNotActive.php');
				break;
			default:
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
	
	static function remind($view){
		if (!isset($_POST['login']))
			return;
		$user = userFactory::getUserByLogin($_POST['login']);
		if (!$user){
			self::showError($view, user::ERROR_LOGIN_NOT_EXIST);
			return;
		}
		if ($user->remindPass()){
			$remindMessage = new remindPass($user->getEmail(), self::generateChangePassLink($user));
			$remindMessage->send();
			\Genesis\library\main\router::redirect(self::$remindOkSite);
		}
		else 
			self::showError($view, $user->getErrorMessage());
	}
	
	static function changePass($data, $view){
		if (!isset($_POST['pass']) || !isset($_POST['pass2']))
			return;
		if (!isset($data['login']) || !isset($data['token'])){
			self::showError($view, user::ERROR);
			return;
		}
		if ($_POST['pass'] != $_POST['pass2']){
			self::showError($view, user::ERROR_PASS_NOT_SAME);
			return;
		}
		$user = userFactory::getUserByLogin($data['login']);
		if (!$user){
			self::showError($view, user::ERROR);
			return;
		}
		if ($user->changePass($_POST['pass'], $data['token']))
			\Genesis\library\main\router::redirect(self::$changePassOkSite);
		else 
			self::showError($view, $user->getErrorMessage());
	}
	
	static function changeLogin($data, $view){
		if (!isset($_POST['login']))
			return;
		if (!isset($data['login']) || !isset($data['token'])){
			self::showError($view, user::ERROR);
			return;
		}
		$user = userFactory::getUserByLogin($data['login']);
		if (!$user){
			self::showError($view, user::ERROR);
			return;
		}
		if ($user->changeLogin($_POST['login'], $data['token'])){
			$changeLoginMessage = new changeLogin($user->getNewEmail(), self::generateChangeLoginActivateLink($user));
			$changeLoginMessage->send();
			\Genesis\library\main\router::redirect(self::$changeLoginSendSite);
		}
		else
			self::showError($view, $user->getErrorMessage());
	}
	
	static function changeLoginCheck($data, $view){
		if (!isset($data['login']) || !isset($data['token'])){
			self::showError($view, user::ERROR);
			return;
		}
		$user = userFactory::getUserByLogin($data['login']);
		if (!$user){
			self::showError($view, user::ERROR);
			return;
		}
		if ($user->changeLoginActivate($data['token']))
			\Genesis\library\main\router::redirect(self::$changeLoginOk);
		else 
			self::showError($view, $user->getErrorMessage());
	}
}