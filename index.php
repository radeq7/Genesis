<?php
namespace Genesis;

// Zdefiniowanie ścieżki do całej aplikacji
define("BASE_PATH", dirname(__FILE__));

// Załadowanie autoloadera
require_once BASE_PATH . '/library/main/autoloader.php';

// uruchomienie aplikacji
try {
	$application = new library\main\application();
	$application->start();
}
catch (\Exception $error) {
	echo $error->getMessage();
}