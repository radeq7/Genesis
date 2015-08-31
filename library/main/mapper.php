<?php

/**
 * Klasa operuje na obiektach klasy library_main_table
 * Zapisuje, tworzy nowe, aktualizuje i usuwa wiersze w bazie danych, dany wiersz reprezentowany jest w postaci obiektu library_main_table
 * @author Radeq
 */
class library_main_mapper {

	/**
	 * Połączenie z bazą danych
	 * @var PDO
	 */
	protected $pdo;
	
	protected function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}
	
	/**
	 * Wczytuje z bazy danych wiersz i zwraca w postaci tabeli
	 * @param library_main_table $model
	 * @throws Exception Jeśli nie ma takiego wiersza w tabeli
	 * @return array pola tabeli w bazie danych
	 */
	function load(library_main_table $model) {
		$query = sprintf("SELECT * FROM `%s` WHERE `%s`='%d' LIMIT 1", $model->get_name(), $model->get_id_name(), $model->get_id());
		$result = $this->pdo->query($query);
		if ($result == false)
			throw new Exception(print_r($this->pdo->errorInfo()));
		
		if (!($wynik = $result->fetch(PDO::FETCH_ASSOC)))
			throw new Exception(sprintf('Nie ma takiego rekordu (%s) w bazie danych!', $query));
		
		return $wynik;
	}
	
	/**
	 * Aktualizuje wiersz w bazie danych
	 * @param library_main_table $model
	 */
	function update(library_main_table $model) {
		$query1 = '';
		foreach ($model->get_change() as $key => $value) {
			$query1 .= sprintf("`%s` = '%s', ", $key, $value);
		}
		$query = sprintf("UPDATE `%s` SET %s WHERE `%s`='%d' LIMIT 1", $model->get_name(), rtrim($query1, ', '), $model->get_id_name(), $model->get_id());
		$this->pdo->exec($query);
	}
	
	/**
	 * Dodaje nowy wiersz do bazy danych
	 * @param library_main_table $model
	 * @throws Exception
	 * @return string zwraca id zapisanego wiersza
	 */
	function insert(library_main_table $model) {
		$query1 = '';
		$query2 = '';
		foreach ($model->get_change() as $key => $value) {
			if ($key != $model->get_id_name()) {
				$query1 .= sprintf("`%s`, ", $key);
				$query2 .= sprintf("'%s', ", $value);
			}
		}
		$query = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $model->get_name(), rtrim($query1, ', '), rtrim($query2, ', '));
		if (!($this->pdo->exec($query))) {
			$error = $this->pdo->errorInfo();
			throw new Exception($error[2]);
		}
		
		return $this->pdo->lastInsertId();
	}
	
	/**
	 * Usuwa wiersz z bazy danych
	 * @param library_main_table $model
	 */
	function delete(library_main_table $model) {
		$query = sprintf("DELETE FROM `%s` WHERE `%s`='%d' LIMIT 1", $model->get_name(), $model->get_id_name(), $model->get_id());
		$this->pdo->exec($query);
	}
}