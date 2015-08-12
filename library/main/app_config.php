<?php

/** 
 * Klasa przechowuje dane konfiguracyjne całej aplikacji.
 * Dane przechowywane są w tablicy w postaci par: klucz - wartość.
 * @package Genesis
 */
class config_app {

	/**
	 * Instancja tej klasy.
	 * @var config_app
	 */
	static private $instance;
	/**
	 * @var array Zawiera wszystkie zapisane wartości.
	 */
	private $param = array();

	private function __construct() {
	}

	
	/**
	 * Singleton - zwraca jedyną instancję tej klasy.
	 * @return config_app zwraca instancję tej klasy.
	 */
	static public function getInstance() {
		if (empty(self::$instance))
			self::$instance = new config_app();
		return self::$instance;
	}

	/**
	 * Pobiera daną wartość na podstawie klucza.
	 * @param string $key klucz na podstawie którego zostanie zwrócona zapisana wcześniej wartość
	 * @return multitype: mixed
	 */
	function getConfig($key) {
		return $this->param[$key];
	}

	/**
	 * Ustawia daną wartość.
	 * @param string $key klucz
	 * @param string $value wartość
	 */
	function setConfig($key, $value) {
		$this->param[$key] = $value;
	}
}