<?php
namespace Genesis\library;
use Genesis\library\main\appConfig;

// tryb aplikacji
const PRODUCTION = false;

// tytuł aplikacji
appConfig::setConfig('title', 'Genesis Framework');

// adres email strony
appConfig::setConfig('email', 'email@genesisframework.pl');

// dane do domyślnego połączenia z bazą dancyh
appConfig::setConfig('db_host', '');
appConfig::setConfig('db_name', '');
appConfig::setConfig('db_username', '');
appConfig::setConfig('db_pass', '');
appConfig::setConfig('db_charset', '');

// domyślna strona logowania
appConfig::setConfig('login_site', 'index');

// czas trwania zalogowania w minutach
appConfig::setConfig('sessionLiveTime', 30);

// Sól: dowolny ciąg znaków do szyfrowania haseł
appConfig::setConfig('salt', 's8h');

// Uprawnienia
const ADMIN = 1;

// Ustawienie strefy czasowej dla aplikacji
date_default_timezone_set('Europe/Warsaw');