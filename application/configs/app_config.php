<?php

require_once BASE_PATH . 'library/main/app_config.php';
$config = config_app::getInstance();

// tryb testowy wyświetla błędy jeśli false
$config->setConfig('app_production', 0);

// w jakim katalogu jest aplikacja
$config->setConfig('app_directory', '');

// nazwa aplikacji
$config->setConfig('app_name', 'Genix3');

// adres bazy danych
$config->setConfig('db_adres', 'mysql:host=s8.masternet.pl;dbname=radeq-g3test;charset=UTF8');

// użytkownik bazy danych
$config->setConfig('db_user', 'radeq');

// hasło bazy danych
$config->setConfig('db_pass', 'LcLTzRFIbc31Xkiy4YvA');

// strona do logowania
$config->setConfig('login_site', '/');
