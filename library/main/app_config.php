<?php

class config_app {

	static private $instance;
	private $param = array();

	private function __construct() {
	}

	static public function getInstance() {
		if (empty(self::$instance))
			self::$instance = new config_app();
		return self::$instance;
	}

	function getConfig($key) {
		return $this->param[$key];
	}

	function setConfig($key, $value) {
		$this->param[$key] = $value;
	}
}