<?php
namespace Genesis\library\main\auth;

use Genesis\library\main\auth\email\activateUser;
class auth{
	protected $userFactory;
	protected $user = false;
	protected $loginSite = '../auth/secret';
	protected $activateSite = 'auth/activate';
	protected $remindSite = 'auth/remindPass';
	protected $changePassSite = 'auth/changePass';
	protected $changeLoginSite = 'auth/changeLogin';
	protected $changeLoginActivateSite = 'auth/changeLoginCheck';
	protected $registerOkSite = 'registerOk';
	protected $activateOkSite = 'activateOk';
	protected $remindOkSite = 'remindOk';
	protected $changePassOkSite = 'changePassOk';
	protected $changeLoginOk = 'changeLoginOk';
	protected $changeLoginSendSite = 'changeLoginSend';
	
	function __construct(){
		$this->userFactory = new userFactory();
	}
	function checkPrivilage($privilage = 0){
		if ($this->isLogged() && $this->user->update())
			return $this->user->checkPrivilage($privilage);
		return FALSE;
	}
	function isLogged(){
		if (!isset($_SESSION['userId']) || !$_SESSION['userId'])
			return FALSE;
		if (!$this->user)
			$this->user = $this->userFactory->getUserById($_SESSION['userId']);
		if (!$this->user)
			return FALSE;
		return TRUE;
	}
	function login($view){
		if (!isset($_POST['login']) || !isset($_POST['pass']))
			return;
	
			if (!$user = $this->loadUser($_POST['login'], user::ERROR_WRONG_LOGIN_OR_PASS, $view))
				return;
	
				if ($user->login($_POST['pass'])){
					$_SESSION['userId'] = $user->get_id();
					$this->user = $user;
					$this->getRouter()->redirect($this->loginSite);
				}
				else
					$this->showError($view, user::ERROR_WRONG_LOGIN_OR_PASS);
	}
	function logout(){
		if ($this->isLogged())
			$this->user->logout();
		$this->user = false;
		$_SESSION['userId'] = 0;
	}	
	function getUser(){
		if ($this->isLogged())
			return $this->user;
		return FALSE;
	}	
	function getIdUser(){
		if ($this->isLogged())
			return $this->user->get_id();
		return FALSE;
	}	
	function generateActivateLink($user){
		$link = sprintf('http://%s/%s?login=%s&token=%s', $_SERVER['SERVER_NAME'], $this->activateSite, $user->getEmail(), $user->getActivateToken());
		return $link;
	}	
	function generateRemindLink(){
		return $this->remindSite;
	}	
	function generateChangeLoginLink(){
		$user = $this->getUser();
		$link = sprintf('%s?login=%s&token=%s', $this->changeLoginSite, $user->getEmail(), $user->generateChangeLoginToken());
		return $link;
	}	
	function generateChangeLoginActivateLink($user){
		$link = sprintf('http://%s/%s?login=%s&token=%s', $_SERVER['SERVER_NAME'], $this->changeLoginActivateSite, $user->getEmail(), $user->generateChangeLoginActivateToken());
		return $link;
	}
	function generateChangePassLink($user){
		$link = sprintf('http://%s/%s?login=%s&token=%s', $_SERVER['SERVER_NAME'], $this->changePassSite, $user->getEmail(), $user->getChangePassToken());
		return $link;
	}
	
	function register($view){
		if (!isset($_POST['login']) || !isset($_POST['pass']))
			return;
			$user = $this->userFactory->getNewUser();
			$user->createUser($_POST['login'], $_POST['pass']);
			if ($user->register()){
				$activateMessage = new activateUser($user->getEmail(), $this->generateActivateLink($user));
				$activateMessage->send();
				$this->getRouter()->redirect($this->registerOkSite);
			}
			else
				$this->showError($view, $user->getErrorMessage());
	}	
	function activate($data, $view){
		if (!isset($data['login']) || !isset($data['token']))
			return;
		
		if (!$user = $this->loadUser($data['login'], user::ERROR_INCORRECT_LOGIN, $view))
			return;
		
		if ($user->activate($data['token']))
			$this->getRouter()->redirect($this->activateOkSite);
	}	
	function remind($view){
		if (!isset($_POST['login']))
			return;
		
		if (!$user = $this->loadUser($_POST['login'], user::ERROR_LOGIN_NOT_EXIST, $view))
			return;
		
		if ($user->remindPass()){
			$remindMessage = new remindPass($user->getEmail(), $this->generateChangePassLink($user));
			$remindMessage->send();
			$this->getRouter()->redirect($this->remindOkSite);
		}
		else 
			$this->showError($view, $user->getErrorMessage());
	}	
	function changePass($data, $view){
		if (!isset($_POST['pass']) || !isset($_POST['pass2']))
			return;
		if (!isset($data['login']) || !isset($data['token'])){
			$this->showError($view, user::ERROR);
			return;
		}
		if ($_POST['pass'] != $_POST['pass2']){
			$this->showError($view, user::ERROR_PASS_NOT_SAME);
			return;
		}
		
		if (!$user = $this->loadUser($data['login'], user::ERROR, $view))
			return;
		
		if ($user->changePass($_POST['pass'], $data['token']))
			$this->getRouter()->redirect($this->changePassOkSite);
		else 
			$this->showError($view, $user->getErrorMessage());
	}	
	function changeLogin($data, $view){
		if (!isset($_POST['login']))
			return;
		if (!isset($data['login']) || !isset($data['token'])){
			$this->showError($view, user::ERROR);
			return;
		}
		
		if (!$user = $this->loadUser($data['login'], user::ERROR, $view))
			return;
		
		if ($user->changeLogin($_POST['login'], $data['token'])){
			$changeLoginMessage = new changeLogin($user->getNewEmail(), $this->generateChangeLoginActivateLink($user));
			$changeLoginMessage->send();
			$this->getRouter()->redirect($this->changeLoginSendSite);
		}
		else
			$this->showError($view, $user->getErrorMessage());
	}	
	function changeLoginCheck($data, $view){
		if (!isset($data['login']) || !isset($data['token'])){
			$this->showError($view, user::ERROR);
			return;
		}
		
		if (!$user = $this->loadUser($data['login'], user::ERROR, $view))
			return;
		
		if ($user->changeLoginActivate($data['token']))
			$this->getRouter()->redirect($this->changeLoginOk);
		else 
			$this->showError($view, $user->getErrorMessage());
	}
	protected function showError($view, $errorNr){
		switch($errorNr){
			case user::ERROR:
				$view->add_view_before('Auth/Info/error.php');
				break;
			case user::ERROR_INCORRECT_LOGIN:
				$view->add_view_before('Auth/Info/incorrectLogin.php');
				break;
			case user::ERROR_INCORRECT_PASS:
				$view->add_view_before('Auth/Info/incorrectPass.php');
				break;
			case user::ERROR_LOGIN_EXIST:
				$view->add_view_before('Auth/Info/loginExist.php');
				break;
			case user::ERROR_LOGIN_NOT_EXIST:
				$view->add_view_before('Auth/Info/loginNotExist.php');
				break;
			case user::ERROR_WRONG_LOGIN_OR_PASS:
				$view->add_view_before('Auth/Info/wrongLoginOrPass.php');
				break;
			case user::ERROR_PASS_NOT_SAME:
				$view->add_view_before('Auth/Info/passNotSame.php');
				break;
			case user::ERROR_INCORRECT_TOKEN:
				$view->add_view_before('Auth/Info/incorrectToken.php');
				break;
			case user::ERROR_LINK_EXPIRED:
				$view->add_view_before('Auth/Info/linkExpired.php');
				break;
			case user::ERROR_USER_NOT_ACTIVE:
				$view->add_view_before('Auth/Info/userNotActive.php');
				break;
			default:
		}
	}
	protected function loadUser($login, $error, $view){
		$user = $this->userFactory->getUserByLogin($login);
		if (!$user){
			$this->showError($view, $error);
			return FALSE;
		}
		return $user;
	}
	
	function getRouter(){
		$application = \Genesis\library\main\application::getInstance();
		return $application->getResource('router');
	
	}
}