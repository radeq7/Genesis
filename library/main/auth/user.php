<?php
namespace Genesis\library\main\auth;
use Genesis\library\main\appConfig;

class user extends \Genesis\library\main\table{
	const NOREGISTER = 0;
	const NOACTIVATE = 1;
	const ACTIVATE = 2;
	const BANNED = 3;
	const BANTIMEMINUTES = 30;
	
	protected $table_name = 'user';
	protected $db_login = '';	// varchar255
	protected $db_pass = '';	// char32
	protected $db_isLogged = 0;	// tinyint
	protected $db_loginTime = '';	// timestamp
	protected $db_loginToken = '';	// char32
	protected $db_loginTimeExpired = '';	// timestamp
	protected $db_loginWrong = 0;	// tinyint
	protected $db_activateToken = '';	// char32
	protected $db_banTime = '';	// timestamp
	protected $db_state = self::NOREGISTER;	//tinyint
	protected $db_registerTime = '';	// timestamp
	protected $db_privilage = 0;	// int unsigned
	
	protected $validateUserStrategy;
	protected $errorMessage = FALSE;

	function __construct($id=0){
		parent::__construct($id);
		$this->validateUserStrategy = new userValidate();
	}
	function login($pass){
		if ($this->db_state != self::ACTIVATE)
			return FALSE;
			if ($this->db_pass != $this->generateHashPass($pass)){
				$this->wrongLogin();
				return FALSE;
			}
			$this->correctLogin();
			return TRUE;
	}
	function ban($minutesBan){
		$this->db_state = self::BANNED;
		// zapamiętaj datę wygaśnięcia bana
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
	function changePass($newPass){
		$this->db_pass = $this->generateHashPass($pass);
	}
	function changeLogin($newLogin){
		$this->db_login = $newLogin;
	}
	function setValidateUserStrategy(userValidate $strategy){
		$this->validateUserStrategy = $strategy;
	}
	function getErrorMessage(){
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
	protected function updateExpiredTime(){
		$this->db_loginTimeExpired = $this->generateTimeExpired();
		$this->markSave();
	}
	protected function activateUser(){
		$this->db_state = self::ACTIVATE;
		$this->db_activateToken = '';
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
		if (!$this->validateUserStrategy->checkLogin($this->db_login))
			return FALSE;
			if (!$this->validateUserStrategy->checkPass($this->db_pass))
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
	protected function generateActivateToken(){
		return md5($this->nowDate() . appConfig::getConfig('salt'));
	}
	protected function nowDate(){
		return date("Y-m-d H:i:s");
	}
}