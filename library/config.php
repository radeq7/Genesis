<?php
namespace Genesis\library;
use Genesis\library\main\appConfig;

// tryb aplikacji
const PRODUCTION = false;

// adres strony
appConfig::setConfig('siteAdres', 'my-site/EclipseWorkspace/GenesisFramework/');

// tytuł aplikacji
appConfig::setConfig('title', 'Genesis Framework');

// adres email strony
appConfig::setConfig('email', 'email@genesisframework.pl');

// wyświetlanie błędów
appConfig::setConfig('error', true);

// dane do domyślnego połączenia z bazą dancyh
appConfig::setConfig('db_host', '23112.m.tld.pl');
appConfig::setConfig('db_name', 'baza23112_system_genix3');
appConfig::setConfig('db_username', 'admin23112_system_genix3');
appConfig::setConfig('db_pass', 'cqBomu4ayG3UzMQslV6n');
appConfig::setConfig('db_charset', 'utf8');

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