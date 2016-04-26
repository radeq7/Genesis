<?php
namespace Genesis\library;
use Genesis\library\main\appConfig;

// adres strony
appConfig::setConfig('siteAdres', '');

// tytuł aplikacji
appConfig::setConfig('title', 'Genesis Framework');

// wyświetlanie błędów
appConfig::setConfig('error', true);

// dane do domyślnego połączenia z bazą dancyh
appConfig::setConfig('db_host', '');
appConfig::setConfig('db_name', '');
appConfig::setConfig('db_username', '');
appConfig::setConfig('db_pass', '');
appConfig::setConfig('db_charset', 'utf8');

// domyślna strona logowania
appConfig::setConfig('login_site', 'test');


// konfiguracja modułu autoryzacji
// -------------------------------------
$option = array();
appConfig::setConfig('auth', false);// włącza moduł autoryzacji
//$option['sessionLiveTime'] = ''; 	// czas trwania zalogowania w minutach
//$option['userDbTableName'] = ''; 	// nazwa tabeli danych usera
//$option['idDbName'] = ''; 		// nazwa pola id w tabeli bd
//$option['emailDbName'] = ''; 		// nazwa pola loginu w tabeli bd
//$option['passDbName'] = ''; 		// nazwa pola hasła w tabeli bd
//$option['salt'] = ''; 			// ciąg znaków do solenia hasła
appConfig::setConfig('option_auth', $option);
// -------------------------------------

// Ustawienie strefy czasowej dla aplikacji
date_default_timezone_set('Europe/Warsaw');