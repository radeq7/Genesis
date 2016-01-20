<?php
namespace Genesis\library\main;

/**
 * Klasa operuje na obiektach klasy library_main_table
 * Zapisuje, tworzy nowe, aktualizuje i usuwa wiersze w bazie danych, dany wiersz reprezentowany jest w postaci obiektu library_main_table
 * @author Radeq
 */
class mapper {

	/**
	 * Połączenie z bazą danych
	 * @var PDO
	 */
	protected $pdo;
	
	protected function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}
	
	/**
	 * Wczytuje z bazy danych wiersz i zwraca w postaci tabeli
	 * @param library_main_table $model
	 * @throws Exception Jeśli nie ma takiego wiersza w tabeli
	 * @return array pola tabeli w bazie danych
	 */
	function load(table $model) {
		$query = sprintf("SELECT * FROM `%s` WHERE `%s`='%d' LIMIT 1", $model->get_name(), $model->get_id_name(), $model->get_id());
		$result = $this->pdo->query($query);
		if ($result == false)
			throw new \Exception(print_r($this->pdo->errorInfo()));
		
		if (!($wynik = $result->fetch(\PDO::FETCH_ASSOC)))
			throw new \Exception(sprintf('Nie ma takiego rekordu (%s) w bazie danych!', $query));
		
		return $wynik;
	}
	
	/**
	 * Wykonuje polecenie sql lub zrzuca wyjątek z błedem sql
	 * @param string $query
	 * @throws Exception błąd bazy danych
	 */
	protected function pdo_exec_or_error($query){
		if (!($this->pdo->exec($query))) {
			$error = $this->pdo->errorInfo();
			throw new \Exception($error[2]);
		}
	}
	
	/**
	 * Aktualizuje wiersz w bazie danych
	 * @param library_main_table $model
	 */
	function update(table $model) {
		$query1 = '';
		foreach ($model->get_change() as $key => $value) {
			$query1 .= sprintf("`%s` = '%s', ", $key, $value);
		}
		$query = sprintf("UPDATE `%s` SET %s WHERE `%s`='%d' LIMIT 1", $model->get_name(), rtrim($query1, ', '), $model->get_id_name(), $model->get_id());
		$this->pdo_exec_or_error($query);
	}
	
	/**
	 * Dodaje nowy wiersz do bazy danych
	 * @param library_main_table $model
	 * @throws Exception
	 * @return string zwraca id zapisanego wiersza
	 */
	function insert(table $model) {
		$query1 = '';
		$query2 = '';
		foreach ($model->get_change() as $key => $value) {
			if ($key != $model->get_id_name()) {
				$query1 .= sprintf("`%s`, ", $key);
				$query2 .= sprintf("'%s', ", $value);
			}
		}
		$query = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $model->get_name(), rtrim($query1, ', '), rtrim($query2, ', '));
		$this->pdo_exec_or_error($query);
		
		return $this->pdo->lastInsertId();
	}
	
	/**
	 * Usuwa wiersz z bazy danych
	 * @param library_main_table $model
	 */
	function delete(table $model) {
		$query = sprintf("DELETE FROM `%s` WHERE `%s`='%d' LIMIT 1", $model->get_name(), $model->get_id_name(), $model->get_id());
		$this->pdo_exec_or_error($query);;
	}
	
	/**
	 * Zapytanie do bazy danych
	 * @param string $select
	 * @param string $table
	 * @param string $where
	 * @throws Exception Gdy błąd bazy danych
	 * @return array tablice z wynikami
	 */
	function fetchAllAssoc($select, $table, $where){
		$query = sprintf("SELECT %s FROM `%s` WHERE %s", $select, $table, $where);
		$result = $this->pdo->query($query);
		if ($result == FALSE) {
			$error_message = $this->pdo->errorInfo();
			throw new \Exception($error_message[2]);
		}
		$wynik = $result->fetchAll(\PDO::FETCH_ASSOC);
		return $wynik;
	}
}