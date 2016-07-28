<?php
namespace Genesis\library\main;

/** 
 * Klasa przechowuje dane konfiguracyjne całej aplikacji.
 * Dane przechowywane są w tablicy w postaci par: klucz - wartość.
 * @package Genesis
 */
class appConfig {

	static private $param = array();

	static function getConfig($key) {
		if (isset(self::$param[$key]))
			return self::$param[$key];
		throw new \Exception('<br>Plik: ' . __FILE__ . '<br>Linia: ' . __LINE__ . '<br>' ."Klucz $key w appConfig nie istnieje!");
	}

	static function setConfig($key, $value) {
		self::$param[$key] = $value;
	}
}