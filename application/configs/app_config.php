<?php

require_once BASE_PATH . 'library/main/app_config.php';
$config = config_app::getInstance();

// tryb testowy wyświetla błędy
$config->setConfig('app_production', 0);

// w jakim katalogu jest aplikacja
$config->setConfig('app_directory', '');

// nazwa aplikacji
$config->setConfig('app_name', 'Genesis Framework');

// adres bazy danych
$config->setConfig('db_adres', '');

// użytkownik bazy danych
$config->setConfig('db_user', '');

// użytkownik bazy danych
$config->setConfig('db_pass', '');

// strona do logowania
$config->setConfig('login_site', '');
