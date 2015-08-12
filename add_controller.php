<?php
// Dodaj kontroler
$controller = 'Test';


// zmiana nazwy kontrolera pierwsza duża reszte z małej
$controller = ucfirst(strtolower($controller));

$kontroler_plik = 'application/controller/' . $controller . 'Controller.php';
$widok_katalog = 'application/view/' . $controller;
$widok_plik = 'application/view/' . $controller . '/index.php';

mkdir($widok_katalog);

$plik = fopen($widok_plik, 'w+');
fclose($plik);

$plik = fopen($kontroler_plik, 'w+');
$string = "<?php

class " . $controller . "Controller extends Controller {

	function init() {
		
	}
	
	function indexAction() {

	}
}";

fwrite($plik, $string);
fclose($plik);
echo "OK!";
?>