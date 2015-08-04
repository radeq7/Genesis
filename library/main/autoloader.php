<?php

function __autoload($classname)  {
	$classname = strtolower($classname);
	$path = BASE_PATH . str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
	//echo $path; 
	include_once $path;
}