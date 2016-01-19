<?php
namespace Genesis\library;

// adres strony
main\appConfig::setConfig('siteAdres', 'my-site/Eclipse/GenesisFramework/');

// tytuł aplikacji
main\appConfig::setConfig('title', 'Genesis Framework');

// wyświetlanie błędów
main\appConfig::setConfig('error', true);

// dane do domyślnego połączenia z bazą dancyh
main\appConfig::setConfig('db_host', 's8.masternet.pl');
main\appConfig::setConfig('db_name', 'radeq');
main\appConfig::setConfig('db_username', 'radeq');
main\appConfig::setConfig('db_pass', 'LcLTzRFIbc31Xkiy4YvA');
main\appConfig::setConfig('db_charset', 'utf8');

// domyślna strona logowania
main\appConfig::setConfig('login_site', '');