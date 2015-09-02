<?php

abstract class library_main_table {
	/**
	 * Nazwa tabeli w bazie danych
	 * @var string
	 */
	protected $table_name;
	protected $id = 0;
	protected $id_name = 'id';
	protected $dbValues = array();
	protected $change = array();
	
	/**Deleguje pobranie wartości z tabeli bazy danych i zapisuje je do tablicy $dbValues
	 * @param int $id nr id w tabeli bazy dancyh
	 */
	function load($id){
		$this->id = $id;
		$this->dbValues = library_main_objectWatcher::get_model($this);
	}
	
	/**Deleguje utworzenie nowego wiersza w tabeli bazy danych
	 * 
	 */
	function create(){
		library_main_objectWatcher::add_new($this);
	}
	
	/**Ustawia parametr z wartością do zapisu w tabeli bazy danych
	 * @param string $var nazwa parametru
	 * @param mixed $value wartość parametru
	 */
	protected function set_var($var, $value){
		$this->dbValues[$var] = $value;
		$this->change[$var] = $value;
		if ($this->id)
			$this->dirty();
	}
	
	/**Pobiera wartość parametru o podanej nazwie 
	 * @param string $var
	 * @return mixed
	 */
	function get_var($var){
		return $this->dbValues[$var];
	}
	
	/**Oznacza obiekt, aby nie został zaktualizowany w bazie danych
	 * 
	 */
	function clean(){
		library_main_objectWatcher::clean($this);
	}
	
	/**Oznacza obiekt, aby został usunięty z bazy danych
	 * 
	 */
	function delete(){
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
	
	function get_change(){
		return $this->change;
	}
	
	protected function dirty(){
		library_main_objectWatcher::add_dirty($this);
	}
}