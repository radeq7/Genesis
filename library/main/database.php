<?php
class database {
	
	private static $instance;
	
	static public function getPdo() {
		if (empty(self::$instance)) {
			$config = config_app::getInstance();
			self::$instance = new PDO($config->getConfig('db_adres'), $config->getConfig('db_user'), $config->getConfig('db_pass'));
		}
		return self::$instance;
	}
}