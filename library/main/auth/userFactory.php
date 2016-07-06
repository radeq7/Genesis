<?php
namespace Genesis\library\main\auth;

class userFactory {
	protected $userClassName = 'user';
	function getUserByLogin($login){
		$mapper = \Genesis\library\main\application::getInstance()->getResource('mapper');
		$where = sprintf("`login`='%s'", $login);
		$arrayUserId = $mapper->fetchAllAssoc('id', 'user', $where);
		if (empty($arrayUserId))
			return FALSE;
		$userId = current($arrayUserId);
		$user = $this->userClassName::load($userId['id']);
		return $user;
	}
	
	function getUserById($id){
		$user = $this->userClassName::load($id);
		return $user;
	}
	
	function getNewUser(){
		$user = new $this->userClassName();
		return $user;
	}
	
	function setUserClassName($userClassName){
		$this->userClassName = $userClassName;
	}
}