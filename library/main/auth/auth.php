<?php
namespace Genesis\library\main\auth;

class auth{
	protected $pdo;
	protected $user;
	protected $sessionLiveTime = 20;
	
	protected $userDbTableName = 'user';
	protected $idDbName = 'id';
	protected $emailDbName = 'login';
	protected $passDbName = 'pass';
	
	protected $salt = '8h';
	
	function __construct($pdo, array $option = array()){
		$this->pdo = $pdo;
		if (isset($option['sessionLiveTime']))
			$this->userDbTableName = $option['sessionLiveTime'];
		if (isset($option['userDbTableName']))
			$this->userDbTableName = $option['userDbTableName'];
		if (isset($option['idDbName']))
			$this->idDbName = $option['idDbName'];
		if (isset($option['emailDbName']))
			$this->emailDbName = $option['emailDbName'];
		if (isset($option['passDbName']))
			$this->passDbName = $option['passDbName'];
		if (isset($option['salt']))
			$this->salt = $option['salt'];
		if (isset($_SESSION['auth_id']))
			$this->user = user::load($_SESSION['auth_id']);
	}
	
	/**
	 * Zalogowuje usera
	 */
	function login($login, $pass){
		$idUser = $this->getIdUser($login, $pass);
		if ($idUser){
			$this->user = user::load($idUser);
			$this->user->login($this->generateToken(), $this->generateExpiredTime());
			$_SESSION['auth_id'] = $idUser;
			return TRUE;
		}
		$this->logout();
		return FALSE;
	}
	
	/**
	 * Wylogowuje usera
	 */
	function logout(){
		if ($this->user){
			$this->user->logout();
			$this->user = FALSE;
		}
		unset ($_SESSION['auth_id']);
		return TRUE;
	}
	
	/**
	 * Sprawdza czy użytkownik jest zalogowany i posiada uprawnienia
	 * Wartość 0 oznacza że nie potrzeba żadnych uprawnień, wystarczy zalogowany user
	 * @return bool
	 */
	function checkPrivilage($privilage){
		if ($this->user && $this->user->checkTokenAndTime($this->generateToken())){
			$this->user->updateExpiredTime($this->generateExpiredTime());
			if ($privilage == 0)
				return TRUE;
			return $this->user->checkPrivilage($privilage);
		}
		return FALSE;
	}
	
	/**
	 * Zwraca obiekt usera jeśli jest lub false
	 */
	function getUser(){
		if ($this->user)
			return $this->user;
		return FALSE;
	}
	
	/**
	 * Zwraca id użytkownika jeśli zalogowany, lub false jeśli nie
	 */
	function getId(){
		if ($this->user)
			return $this->user->get_id();
		return FALSE;
	}
	
	/**
	 * Generuje token
	 */
	protected function generateToken(){
		return md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $this->salt);
	}
	
	/**
	 * Generuje czas wygaśnięcia sesji
	 */
	protected function generateExpiredTime(){
		$date = new \DateTime();
		$timeChange = sprintf("PT%dM", $this->sessionLiveTime);
		$date->add(new \DateInterval($timeChange));
		return $date->format('Y-m-d H:i:s');
	}
	
	/**
	 * Hashuje i soli hasło
	 */
	protected function generateHash($pass){
		return md5($pass . $this->salt);
	}
	
	/**
	 * Zwraca id użytkownika
	 * Jeśli istnieje użytkonik o podanym loginie i haśle, zwraca jego id, jeśli nie zwraca false.
	 */
	protected function getIdUser($login, $pass){
		$pass = $this->generateHash($pass);
		$query = sprintf("SELECT %s FROM `%s` WHERE `%s`='%s' AND `%s`='%s'", $this->idDbName, $this->userDbTableName, $this->emailDbName, $login, $this->passDbName, $pass);
		$result = $this->pdo->query($query);
		if ($result == FALSE) {
			$error_message = $this->pdo->errorInfo();
			throw new \Exception($error_message[2]);
		}
		$wynik = $result->fetchAll(\PDO::FETCH_ASSOC);
		if (count($wynik))
			return $wynik[0][$this->idDbName];
		return false;	
	}
}