<?php

abstract class library_main_table {
	
	/**
	 * Nazwa tabeli w bazie danych
	 * @var string
	 */
	protected $table_name;
	/**
	 * Numer id w bazie danych
	 * @var int
	 */
	protected $id = 0;
	/**
	 * Nazwa domyślna kolumny 'id' w tabeli
	 * @var string
	 */
	protected $id_name = 'id';
	
	/**
	 * Deleguje pobranie wartości z tabeli bazy danych i zapisuje je do tablicy $dbValues
	 * @param int $id nr id w tabeli bazy dancyh
	 */
	function load($id){
		$this->id = $id;
		$this->load_variable(library_main_objectWatcher::get_model($this));
	}
	
	/**
	 * Wczytuje zmienne z tablicy i przypisuje je do właściwości obiektu z prefiksem db_
	 * @param array $var_list
	 */
	function load_variable(array $var_list){
		foreach ($var_list as $var_name => $value){
			$var_prefix_name = 'db_' . $var_name;
			$this->$var_prefix_name = $value;
		}
	}
	
	/**
	 * Oznacza obiekt do utworzenie nowego wiersza w tabeli bazy danych
	 */
	function markCreate(){
		library_main_objectWatcher::add_new($this);
	}
	
	/**
	 * Oznacza obiekt, aby nie został zaktualizowany w bazie danych
	 */
	function markClean(){
		library_main_objectWatcher::clean($this);
	}
	
	/**
	 * Oznacza obiekt, aby został usunięty z bazy danych
	 */
	function markDelete(){
		library_main_objectWatcher::add_delete($this);
	}
	
	function get_name(){
		return $this->table_name;
	}
	
	function get_id_name(){
		return $this->id_name;
	}
	
	function get_id(){
		return $this->id;
	}
	
	/**
	 * Wybiera wszystkie właściwości obiektu z prefiksem db_ i go usuwa
	 * @return array
	 */
	function get_change(){
		$db_var = get_object_vars($this);
		foreach ($db_var as $var_name => $value){
			if ((strpos($var_name, 'db_') === 0))
				$db_var_without_prefix[substr($var_name, 3)] = $value;
		}
		return $db_var_without_prefix;
	}
	
	/**
	 * Oznacza obiekt, jako do aktualizacji
	 */
	protected function markSave(){
		if ($this->id)
			library_main_objectWatcher::add_dirty($this);
	}
}