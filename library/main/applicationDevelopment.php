<?php
namespace Genesis\library\main;

class applicationDevelopment extends \Genesis\library\main\application{
	protected $start;
	protected $end;
	
	protected function init(){
		// start time
		$this->start = microtime();	
		parent::init();
	}
	function end(){
		
		parent::end();
		$this->end = microtime();
		
		// podsumowanie aplikacji w trybie testowym
		echo '<p>Liczba zapytań do bazy danych: ' . $this->getResource('mapper')->getCountQuery() . '</p>';
		$time = $this->end - $this->start;
		$time = sprintf("%1.3f", $time);
		echo '<p>Czas wykonywanie skryptu: ' . $time .  's</p>';
		$memory = (int) (memory_get_usage() / 1024);
		echo '<p>Pamięć wykorzystana podczas skryptu: ' . $memory .  'KB</p>';
	}
	protected function mode(){
		ini_set('display_errors', '1');
		error_reporting(E_ALL);
	}
	
}