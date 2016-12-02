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
		$this->bufor[$this->generateIdName($table)] = $this->mapper->load($table);
	}
	function loadCollection(table $table,string $where): array{
		$collection = $this->mapper->loadCollection($table, $where);
		$collection = $this->buforCollection($collection);
		return $collection;
	}
	function loadCollectionByType($where, $typeSellection){
		$collection = $this->mapper->loadCollectionByType($where, $typeSellection);
		$collection = $this->buforCollection($collection);
		return $collection;
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
	protected function buforCollection($collection){
		$newCollection = array();
		foreach ($collection as $table){
			if (isset($this->bufor[$this->generateIdName($table)]))
				$newCollection[] = $this->bufor[$this->generateIdName($table)];
			else {
				$this->bufor[$this->generateIdName($table)] = $table;
				$newCollection[] = $table;
			}
		}
		return $newCollection;
	}
	protected function generateIdName(table $table){
		return sprintf('%s%d', $table->getTableName(), $table->getId());
	}
}