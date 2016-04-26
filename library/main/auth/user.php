<?php
namespace Genesis\library\main\auth;

class user extends \Genesis\library\main\table {
	protected $table_name = 'user';
	
	protected $db_login; 			// varchar255
	protected $db_pass;				// char32
	protected $db_loginTime;		// timestamp 
	protected $db_loginToken;		// char32
	protected $db_loginTimeExpired;	// timestamp
	protected $db_privilages;		// bigint
	
	function login($token, $expiredTime){
		$this->db_loginToken = $token;
		$this->db_loginTime = date("Y-m-d H:i:s");
		$this->db_loginTimeExpired = $expiredTime;
		$this->markSave();
	}
	
	function logout(){
		$this->db_loginToken = '';
		$this->db_loginTimeExpired = '0000-00-00 00:00:00';
		$this->markSave();
	}
	
	function checkTokenAndTime($token){
		$date = new \DateTime();
		if ($this->db_loginToken == $token && $this->db_loginTimeExpired > $date->format('Y-m-d H:i:s')){
			return TRUE;
		}
		$this->logout();
		return FALSE;
	}
	
	function updateExpiredTime($expiredTime){
		$this->db_loginTimeExpired = $expiredTime;
		$this->markSave();
	}
	
	function checkPrivilage($privilage){
		return $this->db_privilages & $privilage;
	}
	
	function addPrivilage($privilage){
		$this->db_privilages |= $privilage;
		$this->markSave();
	}
	
	/**
	 * Usuwa przywilej usera
	 */
	function removePrivilage($privilage){
		$this->db_privilages &= ~$privilage;
		$this->markSave();
	}
}