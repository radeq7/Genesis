<?php
namespace Genesis\library\main\db;
use Genesis\library\main\application;

abstract class table{
	protected $tableName;
	protected $idName = 'id';
	protected $db_id = 0;
	protected $adapter;
	
	final function __construct(){
		$this->adapter = application::getInstance()->getResource('dbAdapter');
	}
	function load($id){
		$this->db_id = $id;
		$this->adapter->load($this);
	}
	function loadCollection($where){
		return $this->adapter->loadCollection($this, $where);
	}
	function save(){
		$this->adapter->save($this);
	}
	function delete(){
		$this->adapter->delete($this);
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
}