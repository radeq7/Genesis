<?php

spl_autoload_register(function ($class) {
	if (substr($class, 0, 8) !== 'Genesis\\') {
		return;
	}
	$class = substr($class, 8);
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

	$path = BASE_PATH . '/' . $class. '.php';
	if (is_readable($path)) {
		require_once $path;
	}

	
});


