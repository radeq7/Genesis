<?php
namespace Genesis\library;
use Genesis\library\main\appConfig;

// adres strony
appConfig::setConfig('siteAdres', 'my-site/Eclipse/GenesisFramework/');

// tytuł aplikacji
appConfig::setConfig('title', 'Genesis Framework');

// wyświetlanie błędów
appConfig::setConfig('error', true);

// dane do domyślnego połączenia z bazą dancyh
appConfig::setConfig('db_host', 's8.masternet.pl');
appConfig::setConfig('db_name', 'radeq');
appConfig::setConfig('db_username', 'radeq');
appConfig::setConfig('db_pass', 'LcLTzRFIbc31Xkiy4YvA');
appConfig::setConfig('db_charset', 'utf8');

// domyślna strona logowania
appConfig::setConfig('login_site', '');