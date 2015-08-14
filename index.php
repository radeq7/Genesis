<?php
namespace Genesis;

define("BASE_PATH", dirname(__FILE__) . '/');
require_once 'library/main/application.php';

// uruchomienie aplikacji
try {
	$application = new application();
	$application->start();
}
catch (\Exception $error) {
	echo $error->getMessage();
}