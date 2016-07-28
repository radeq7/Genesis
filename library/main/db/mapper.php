<?php
namespace Genesis\library\main\db;

class mapper{
	protected $countQuery = 0;
	protected $pdo;
	function __construct(\PDO $pdo){
		$this->pdo = $pdo;
	}
	function update(table $table){
		$query1 = '';
		foreach ($table->getDbVar() as $key => $value) {
			$query1 .= sprintf("`%s` = '%s', ", $key, $value);
		}
		$query = sprintf("UPDATE `%s` SET %s WHERE `%s`='%d' LIMIT 1", $table->getTableName(), rtrim($query1, ', '), $table->getIdName(), $table->getId());
		$this->pdo_exec_or_error($query);
	}
	function delete(table $table){
		$query = sprintf("DELETE FROM `%s` WHERE `%s`='%d' LIMIT 1", $table->getTableName(), $table->getIdName(), $table->getId());
		$this->pdo_exec_or_error($query);;
	}
	function insert(table $table){
		$query1 = '';
		$query2 = '';
		foreach ($table->getDbVar() as $key => $value) {
			if ($key != $table->getIdName()) {
				$query1 .= sprintf("`%s`, ", $key);
				$query2 .= sprintf("'%s', ", $value);
			}
		}
		$query = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $table->getTableName(), rtrim($query1, ', '), rtrim($query2, ', '));
		$this->pdo_exec_or_error($query);
		$table->setId($this->pdo->lastInsertId());
	}
	function load(table $table){
		$query = sprintf("SELECT * FROM `%s` WHERE `%s`='%d' LIMIT 1", $table->getTableName(), $table->getIdName(), $table->getId());
		$result = $this->pdo_query_or_error($query);
		
		if (!($wynik = $result->fetch(\PDO::FETCH_ASSOC)))
			throw new \Exception(sprintf('Nie ma takiego rekordu (%s) w bazie danych!', $query));
		
		$table->setDbVar($wynik);
	}
	function loadCollection(table $table, $where){
		$collection = array();
		$className = get_class($table);
		$data = $this->fetchAllAssoc('*', $table->getTableName(), $where);
		foreach ($data as $element){
			$newObject = new $className;
			$newObject->setDbVar($element);
			$collection[] = $newObject; 
		}
		return $collection;
	}
	function fetchAllAssoc($select, $table, $where){
		$query = sprintf("SELECT %s FROM `%s` WHERE %s", $select, $table, $where);
		$result = $this->pdo_query_or_error($query);

		$wynik = $result->fetchAll(\PDO::FETCH_ASSOC);
		return $wynik;
	}
	function getCountQuery(){
		return $this->countQuery;
	}
	protected function pdo_exec_or_error($query){
		$this->countQuery++;
		if (!($this->pdo->exec($query))) {
			$error = $this->pdo->errorInfo();
			throw new \Exception($error[2]);
		}
	}
	protected function pdo_query_or_error($query){
		$result = $this->pdo->query($query);
		
		if ($result == false)
			throw new \Exception(print_r($this->pdo->errorInfo()));
		
		if ($result == FALSE) {
			$error_message = $this->pdo->errorInfo();
			throw new \Exception($error_message[2]);
		}
		$this->countQuery++;
		return $result;
	}
}