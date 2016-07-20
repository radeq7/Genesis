<?php
namespace Genesis\library\main\db;

abstract class dbAdapter{
	protected $mapper;
	function __construct(mapper $mapper){
		$this->mapper = $mapper;
	}
	abstract function save(table $table);
	abstract function load(table $table);
	abstract function loadCollection(table $table, string $where): array;
	abstract function delete(table $table);
}