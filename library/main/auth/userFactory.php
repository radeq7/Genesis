<?php
namespace Genesis\library\main\auth;

class userFactory {
	static function getUserByLogin($login){
		$mapper = \Genesis\library\main\mapperFactory::getMapper();
		$where = sprintf("`login`='%s'", $login);
		$arrayUserId = $mapper->fetchAllAssoc('id', 'user', $where);
		if (empty($arrayUserId))
			return FALSE;
		$userId = current($arrayUserId);
		$user = user::load($userId['id']);
		return $user;
	}
	
	static function getUserById($id){
		$user = user::load($id);
		return $user;
	}
	
	static function getNewUser(){
		$user = new user();
		return $user;
	}
}