<?php
namespace Genesis\library\main\db;

class dbStandard extends dbAdapter{
	function load(table $table){
		$this->mapper->load($table);
	}
	function loadCollection(table $table,string $where): array{
		return $this->mapper->loadCollection($table, $where);
	}
	function save(table $table){
		$this->mapper->create($table);
	}
	function delete(table $table){
		$this->mapper->delete($table);
	}
}