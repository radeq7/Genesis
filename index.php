<?php
namespace Genesis;

use Genesis\library\main\application;
// Zdefiniowanie ścieżki do całej aplikacji
define("BASE_PATH", dirname(__FILE__));

// Załadowanie autoloadera
require_once BASE_PATH . '/library/main/autoloader.php';

// uruchomienie aplikacji
try {
	$application = application::getInstance();
	$application->run();
}
catch (\Exception $error) {
	echo $error->getMessage();
}