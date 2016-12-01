<?php
namespace Genesis\library\main\db;

class dbWatcher extends dbAdapter{
	/**
	 * Wczytane już obiekty
	 */
	protected $bufor = array();
	/**
	 * Rekordy do zaktualizowania
	 */
	protected $update = array();
	/**
	 * Rekordy do utworzenia
	 */
	protected $create = array();
	/**
	 * Rekordy do skasowania
	 */
	protected $delete = array();

	function load(table $table){
		if (isset($this->bufor[$this->generateIdName($table)])){
			$table = $this->bufor[$this->generateIdName($table)];
			return;
		}
		$this->mapper->load($table);
	}
	function loadCollection(table $table,string $where): array{
		return $this->mapper->loadCollection($table, $where);
	}
	function loadCollectionByType($where, $typeSellection){
		return $this->mapper->loadCollectionByType($where, $typeSellection);
	}
	function save(table $table){
		if ($table->getId()){
			$this->update[$this->generateIdName($table)] = $table;
			return TRUE;
		}
		$this->create[] = $table;
	}
	function delete(table $table){
		$this->delete[$this->generateIdName($table)] = $table;
	}
	function clean(table $table){
		unset($this->delete[$this->generateIdName($table)]);
		unset($this->update[$this->generateIdName($table)]);
		$new_array = array();
		foreach ($this->create as $new) {
			if ($new != $table)
				$new_array[] = $new;
		}
		$this->new = $new_array;
	}
	function exec(){
		foreach ($this->update as $update){
			$this->mapper->update($update);
		}
		foreach ($this->create as $create){
			$this->mapper->insert($create);
		}
		foreach ($this->delete as $delete){
			$this->mapper->delete($delete);
		}
		$this->update = array();
		$this->create = array();
		$this->delete = array();
	}
	protected function generateIdName(table $table){
		return sprintf('%s%d', $table->getTableName(), $table->getId());
	}
}