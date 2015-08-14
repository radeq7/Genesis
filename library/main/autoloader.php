<?php

function __autoload($classname) {
	if ($cut_lenght = strrpos($classname, "\\"))
		$cut_lenght++;
	else 
		$cut_lenght = 0;
	$classname = substr($classname, $cut_lenght);
	$path = BASE_PATH . str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php'; 
	include_once $path;
}