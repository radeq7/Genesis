<?php
namespace Genesis\library\main\db;
use Genesis\library\main\application;

abstract class table{
	protected $tableName;
	protected $idName = 'id';
	protected $db_id = 0;
	protected $adapter;
	
	function setAdapter($adapter){
		$this->adapter = $adapter;
	}
	function loadDefaultAdapter(){
		$this->adapter = application::getInstance()->getResource('dbAdapter');
	}
	function __initLoad(){}
	function load($id){
		$this->db_id = $id;
		$this->getAdapter()->load($this);
		$this->__initLoad();
	}
	function loadCollection($where){
		$collection = $this->getAdapter()->loadCollection($this, $where);
		foreach ($collection as $element){
			$element->__initLoad();
		}
		return $collection;
	}
	function loadCollectionByType($where, tableType $typeSellection){
		$collection = $this->getAdapter()->loadCollectionByType($where, $typeSellection);
		foreach ($collection as $element){
			$element->__initLoad();
		}
		return $collection;
	}
	function save(){
		$this->getAdapter()->save($this);
	}
	function delete(){
		$this->getAdapter()->delete($this);
	}
	function setId($id){
		$this->db_id = $id;
	}
	function setDbVar(array $varList){
		foreach ($varList as $var_name => $value){
			$var_prefix_name = 'db_' . $var_name;
			$this->$var_prefix_name = $value;
		}
	}
	function getDbVar(){
		$db_var = get_object_vars($this);
		foreach ($db_var as $var_name => $value){
			if ((strpos($var_name, 'db_') === 0))
				$db_var_without_prefix[substr($var_name, 3)] = $value;
		}
		return $db_var_without_prefix;
	}
	function getId(){
		return $this->db_id;
	}
	function getIdName(){
		return $this->idName;
	}
	function getTableName(){
		return $this->tableName;
	}
	protected function getAdapter(){
		if (!$this->adapter)
			$this->loadDefaultAdapter();
			return $this->adapter;
	}
}