<?php
namespace Genesis\library\main;

/**
 * Tworzy obiekt PDO
 * Dane do utworzenia obiektu pobiera z konfiguracji aplikacji
 * 
 * @package Genesis
 */
class db {
	private static $instance;
	
	static public function getPdo() {
		if (empty(self::$instance)) {
			$adres = sprintf('mysql:host=%s;dbname=%s;charset=%s', 
					appConfig::getConfig('db_host'), 
					appConfig::getConfig('db_name'), 
					appConfig::getConfig('db_charset'));
			self::$instance = new \PDO($adres, appConfig::getConfig('db_username'), appConfig::getConfig('db_pass'));
		}
		return self::$instance;
	}
}