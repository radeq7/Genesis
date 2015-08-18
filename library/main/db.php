<?php

/**
 * Tworzy obiekt PDO
 * Dane do utworzenia obiektu pobiera z konfiguracji aplikacji
 * 
 * @package Genesis
 */
class library_main_db {
	private static $instance;
	
	static public function getPdo() {
		if (empty(self::$instance)) {
			$adres = sprintf('mysql:host=%s;dbname=%s;charset=%s', 
					library_main_appConfig::getConfig('db_host'), 
					library_main_appConfig::getConfig('db_name'), 
					library_main_appConfig::getConfig('db_charset'));
			self::$instance = new PDO($adres, library_main_appConfig::getConfig('db_username'), library_main_appConfig::getConfig('db_pass'));
		}
		return self::$instance;
	}
}