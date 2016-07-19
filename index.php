<?php
namespace Genesis;

// Zdefiniowanie ścieżki do całej aplikacji
define("BASE_PATH", dirname(__FILE__));

// Zdefiniowanie adresu strony
define("SERVER_ADRESS", $_SERVER['SERVER_NAME']);
define("SITE_ADRESS", substr($_SERVER['SCRIPT_NAME'], 0, -10));

// Załadowanie autoloadera
require_once BASE_PATH . '/library/main/autoloader.php';

// uruchomienie aplikacji
try {
	$application = \Genesis\library\main\application::getInstance();
	$application->run();
}
catch (\Exception $error) {
	echo $error->getMessage();
}