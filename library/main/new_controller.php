<?php
// Dodaj kontroler
$controller = 'test';


// zmiana nazwy kontrolera pierwsza duża reszte z małej
$controller = ucfirst(strtolower($controller));

$kontroler_plik = '../../controller/' . $controller . 'Controller.php';
$widok_katalog = '../../view/' . $controller;
$widok_plik = '../../view/' . $controller . '/index.php';

mkdir($widok_katalog);

$plik = fopen($widok_plik, 'w+');
fclose($plik);

$plik = fopen($kontroler_plik, 'w+');
$string = "<?php

class " . $controller . "Controller extends library_main_controller {

	function init() {
		
	}
	
	function indexAction() {

	}
}";

fwrite($plik, $string);
fclose($plik);
echo "OK!";
?>