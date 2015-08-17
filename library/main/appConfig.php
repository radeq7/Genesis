<?php

/** 
 * Klasa przechowuje dane konfiguracyjne całej aplikacji.
 * Dane przechowywane są w tablicy w postaci par: klucz - wartość.
 * @package Genesis
 */
class library_main_appConfig {

	static private $param = array();

	static function getConfig($key) {
		return self::$param[$key];
	}

	static function setConfig($key, $value) {
		self::$param[$key] = $value;
	}
}