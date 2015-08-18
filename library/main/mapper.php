<?php

class library_main_mapper {
	static private $instance;
	protected $pdo;
	
	private function __construct() {
		$this->pdo = library_main_db::getPdo();
	}

	static function instance() {
		if (!self::$instance) 
			self::$instance = new library_main_mapper();
			
		return self::$instance;
	}
	
	function load($model) {
		$query = sprintf("SELECT * FROM `%s` WHERE `%s`='%d' LIMIT 1", $model->get_name(), $model->get_id_name(), $model->get_id());
		printf('<br>%s',$query); // TEST
		$result = $this->pdo->query($query);
		if ($result == false)
			throw new Exception(print_r($this->pdo->errorInfo()));
			// TUTAJ  $this->all[mapper::generete_name($model)] = $model;
		if (!($wynik = $result->fetch(PDO::FETCH_ASSOC)))
			throw new Exception(sprintf('Nie ma takiego rekordu (%s) w bazie danych!', $query));
		
		return $wynik;
	}
	
	function update($model) {
		$query1 = '';
		foreach ($model->get_change() as $key => $value) {
			$query1 .= sprintf("`%s` = '%s', ", $key, $value);
		}
		$query = sprintf("UPDATE `%s` SET %s WHERE `%s`='%d' LIMIT 1", $model->get_name(), rtrim($query1, ', '), $model->get_id_name(), $model->get_id());
		printf('<br>%s',$query); // TEST
		$this->pdo->exec($query);
	}
	
	function insert($model) {
		$query1 = '';
		$query2 = '';
		foreach ($model->get_change() as $key => $value) {
			if ($key != $model->get_id_name()) {
				$query1 .= sprintf("`%s`, ", $key);
				$query2 .= sprintf("'%s', ", $value);
			}
		}
		$query = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $model->get_name(), rtrim($query1, ', '), rtrim($query2, ', '));
		printf('<br>%s',$query); // TEST
		if (!($this->pdo->exec($query))) {
			$error = $this->pdo->errorInfo();
			throw new Exception($error[2]);
		}
		
		return $this->pdo->lastInsertId();
	}
	
	function delete($model) {
		$query = sprintf("DELETE FROM `%s` WHERE `%s`='%d' LIMIT 1", $model->get_name(), $model->get_id_name(), $model->get_id());
		printf('<br>%s',$query); // TEST
		$this->pdo->exec($query);
	}
}