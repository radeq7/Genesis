<?php
namespace Genesis\library\main\auth;
use Genesis\library\main\appConfig;
use Genesis\library\main\application;

class user extends \Genesis\library\main\table{
	const NOREGISTER = 0;
	const NOACTIVATE = 1;
	const ACTIVATE = 2;
	const BANNED = 3;
	const BANTIMEMINUTES = 30;
	const ERROR = 1;
	const ERROR_INCORRECT_LOGIN = 2;
	const ERROR_INCORRECT_PASS = 3;
	const ERROR_LOGIN_EXIST = 4;
	const ERROR_INCORRECT_TOKEN = 5;
	const ERROR_WRONG_LOGIN_OR_PASS = 6;
	const ERROR_PASS_NOT_SAME = 7;
	const ERROR_LOGIN_NOT_EXIST = 8;
	const ERROR_LINK_EXPIRED = 9;
	const ERROR_USER_NOT_ACTIVE = 10;
	const ERROR_USER_IS_BAN = 11;
	
	protected $table_name = 'user';
	protected $db_login = '';	// varchar255
	protected $db_pass = '';	// char32
	protected $db_isLogged = 0;	// datetime
	protected $db_loginTime = '';	// datetime
	protected $db_loginToken = '';	// char32
	protected $db_loginTimeExpired = '';	// datetime
	protected $db_activateToken = '';	// char32
	protected $db_banTime = '';	// datetime
	protected $db_state = self::NOREGISTER;	//tinyint
	protected $db_registerTime = '';	// datetime
	protected $db_privilage = 0;	// int unsigned
	protected $db_changePassToken = '';	// char32
	protected $db_changePassTime = '';	// datetime
	protected $db_changeLogin = '';	// varchar255
	protected $db_changeLoginTime = '';	// datetime
	protected $db_loginWrong = 0; // tinyint
	
	protected $validateUserStrategy;
	protected $errorMessage = FALSE;

	function init(){
		$this->validateUserStrategy = new userValidate();
	}
	function login($pass){
		if ($this->db_state == self::BANNED)
			$this->checkBanEnd();
		if ($this->db_state != self::ACTIVATE){
			if ($this->db_state != self::BANNED)
				$this->errorMessage = self::ERROR_USER_NOT_ACTIVE;
			return FALSE;
		}
		if ($this->db_pass != $this->generateHashPass($pass)){
			$this->wrongLogin();
			return FALSE;
		}
		$this->correctLogin();
		return TRUE;
	}
	function ban($minutesBan){
		$this->db_state = self::BANNED;
		$this->addBanTime($minutesBan);
		$this->markSave();
	}
	function logout(){
		$this->db_loginToken = '';
		$this->db_loginTimeExpired = '0000-00-00 00:00:00';
		$this->db_isLogged = 0;
		$this->markSave();
	}
	function createUser($login, $pass){
		if($this->db_state != self::NOREGISTER)
			return FALSE;
			$this->db_login = $login;
			$this->db_pass = $pass;
			$this->db_registerTime = $this->nowDate();
	}
	function register(){
		if ($this->db_state != self::NOREGISTER)
			return FALSE;
		if ($this->validateUser()){
			$this->registerUser();
			return TRUE;
		}
		return FALSE;
	}
	function activate($token){
		if ($this->db_state != self::NOACTIVATE)
			return FALSE;
		if ($this->db_activateToken != $token)
			return FALSE;
		$this->activateUser();
		return TRUE;
	}
	function update(){
		if ($this->db_loginToken == $this->generateLoginToken() && $this->db_loginTimeExpired > $this->nowDate()){
			$this->updateExpiredTime();
			return TRUE;
		}
		$this->logout();
		return FALSE;
	}
	/**
	 * Zwraca token i ustawia login do zmiany i czas ważności zmiany, jeśli token się zgadza 
	 */
	function changeLogin($newLogin, $token){
		if ($token != $this->generateChangeLoginToken()){
			$this->errorMessage = self::ERROR_INCORRECT_TOKEN;
			return FALSE;
		}
		if (!$this->checkLoginExist($newLogin)){
			$this->errorMessage = self::ERROR_LOGIN_EXIST;
			return FALSE;
		}
		if (!$this->validateUserStrategy->checkLogin($newLogin)){
			$this->errorMessage = self::ERROR_INCORRECT_LOGIN;
			return FALSE;
		}
		
		$this->db_changeLogin = $newLogin;
		$this->db_changeLoginTime = $this->datePlus24h();
		$this->markSave();
		return $this->generateChangeLoginActivateToken();
	}
	/**
	 * Zmienia login, jeśli token i czas jego ważności się zgadza
	 */
	function changeLoginActivate($token){
		if ($this->generateChangeLoginActivateToken() != $token){
			$this->errorMessage = self::ERROR_INCORRECT_TOKEN;
			return FALSE;
		}
		if ($this->db_changeLoginTime < $this->nowDate()){
			$this->errorMessage = self::ERROR_LINK_EXPIRED;
			return FALSE;
		}
		$this->db_login = $this->db_changeLogin;
		$this->db_changeLogin = '';
		$this->db_changeLoginTime = '0000-00-00 00:00:00';
		$this->markSave();
		return TRUE;
		
	}
	function setValidateUserStrategy(userValidate $strategy){
		$this->validateUserStrategy = $strategy;
	}
	function getErrorMessage(){
		return $this->errorMessage;
	}
	function addPrivilage($privilage){
		$bit = new \Genesis\library\main\standard\bit($this->db_privilage);
		$bit->setBit($privilage);
		$this->db_privilage = $bit->getInt();
		$this->markSave();
	}
	function removePrivilage($privilage){
		$bit = new \Genesis\library\main\standard\bit($this->db_privilage);
		$bit->removeBit($privilage);
		$this->db_privilage = $bit->getInt();
		$this->markSave();
	}
	function checkPrivilage($privilage){
		if ($privilage == 0)
			return TRUE;
		$bit = new \Genesis\library\main\standard\bit($this->db_privilage);
		return $bit->getBit($privilage);
	}
	function remindPass(){
		if ($this->db_state != self::ACTIVATE){
			$this->errorMessage = self::ERROR_USER_NOT_ACTIVE;
			return FALSE;
		}
		$this->db_changePassToken = $this->generateActivateToken();
		$this->db_changePassTime = $this->datePlus24h();
		$this->markSave();
		return TRUE;
	}
	function changePass($newPass, $token){
		if ($this->db_changePassToken != $token){
			$this->errorMessage = self::ERROR_INCORRECT_TOKEN;
			return FALSE;
		}
		if ($this->db_changePassTime < $this->nowDate()){
			$this->errorMessage = self::ERROR_LINK_EXPIRED;
			return FALSE;
		}
		if (!$this->validateUserStrategy->checkPass($newPass)){
			$this->errorMessage = self::ERROR_INCORRECT_PASS;
			return FALSE;
		}
		$this->db_pass = $this->generateHashPass($newPass);
		$this->db_changePassToken = '';
		$this->db_changePassTime = '0000-00-00 00:00:00';
		$this->markSave();
		return TRUE;
	}
	function generateActivateToken(){
		return md5($this->nowDate() . appConfig::getConfig('salt'));
	}
	function generateChangeLoginToken(){
		return md5($this->db_login . $this->db_id . appConfig::getConfig('salt'));
	}
	function generateChangeLoginActivateToken(){
		return md5($this->db_changeLogin . $this->db_changeLoginTime . appConfig::getConfig('salt'));
	}
	function getEmail(){
		return $this->db_login;
	}
	function getNewEmail(){
		return $this->db_changeLogin;
	}
	function getActivateToken(){
		return $this->db_activateToken;
	}
	function getChangePassToken(){
		return $this->db_changePassToken;
	}
	function getBanTime(){
		return $this->db_banTime;
	}
	function initActivate();
	protected function updateExpiredTime(){
		$this->db_loginTimeExpired = $this->generateTimeExpired();
		$this->markSave();
	}
	protected function activateUser(){
		$this->db_state = self::ACTIVATE;
		$this->db_activateToken = '';
		$this->initActivate();
		$this->markSave();
	}
	protected function registerUser(){
		$this->db_state = self::NOACTIVATE;
		$this->db_activateToken = $this->generateActivateToken();
		$this->db_pass = $this->generateHashPass($this->db_pass);
		$this->markSave();
	}
	protected function correctLogin() {
		$this->db_loginToken = $this->generateLoginToken();
		$this->db_loginTime = $this->nowDate();
		$this->db_loginTimeExpired = $this->generateTimeExpired();
		$this->db_loginWrong = 0;
		$this->db_isLogged = true;
		$this->markSave();
	}
	protected function wrongLogin(){
		$this->db_loginWrong++;
		if ($this->db_loginWrong >= 5)
			$this->ban(self::BANTIMEMINUTES);
		$this->errorMessage = self::ERROR_WRONG_LOGIN_OR_PASS;
		$this->markSave();
	}
	protected function checkTokenAndTime($token){
		if ($this->db_loginToken == $token && $this->db_loginTimeExpired > $this->nowDate()){
			return TRUE;
		}
		$this->logout();
		return FALSE;
	}
	protected function validateUser(){
		if (!$this->checkLoginExist($this->db_login)){
			$this->errorMessage = self::ERROR_LOGIN_EXIST;
			return FALSE;
		}
		if (!$this->validateUserStrategy->checkLogin($this->db_login)){
			$this->errorMessage = self::ERROR_INCORRECT_LOGIN;
			return FALSE;
		}
		if (!$this->validateUserStrategy->checkPass($this->db_pass)){
			$this->errorMessage = self::ERROR_INCORRECT_PASS;
			return FALSE;
		}
		return TRUE;
	}
	protected function checkLoginExist($login){
		$user = application::getInstance()->getResource('userFactory')->getUserByLogin($login);
		if ($user)
			return FALSE;
		return TRUE;
	}
	protected function generateTimeExpired(){
		$date = new \DateTime();
		$timeChange = sprintf("PT%dM", appConfig::getConfig('sessionLiveTime'));
		$date->add(new \DateInterval($timeChange));
		return $date->format('Y-m-d H:i:s');
	}
	protected function generateHashPass($pass){
		return md5($pass . appConfig::getConfig('salt'));
	}
	protected function generateLoginToken(){
		return md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . appConfig::getConfig('salt'));
	}
	protected function nowDate(){
		return date("Y-m-d H:i:s");
	}
	protected function addBanTime($minute){
		$time = new \Genesis\library\main\standard\time($this->nowDate());
		$time->modifyMinute($minute);
		$this->db_banTime = $time;
	}
	protected function datePlus24h(){
		$time = new \Genesis\library\main\standard\time($this->nowDate());
		$time->modifyHour(24);
		return $time;
	}
	protected function checkBanEnd(){
		if ($this->db_banTime < $this->nowDate()){
			$this->db_state = self::ACTIVATE;
			$this->db_banTime = '';
			$this->db_loginWrong = 0;
		}
		else 
			$this->errorMessage = self::ERROR_USER_IS_BAN;
	}
}