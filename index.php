<?php
define("BASE_PATH", dirname(__FILE__) . '/') ; 
require_once 'library/main/application.php';

// uruchomienie aplikacji
try {
	$application = application::instance();
	$application->run();
}
catch (Exception $error) {
	echo $error->getMessage();
}