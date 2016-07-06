<?php
namespace Genesis\library\main;

/**
 * Buforuje obiekty odczytane z bazy danych 
 * @author Radeq
 */
class objectWatcher {
	protected $all = array();
	protected $dirty = array();
	protected $new = array();
	protected $delete = array();
	
	/**
	 * Dodaje do tabeli jako do aktualizacji
	 * @param table $table
	 */
	function add_dirty(table $table) {
		$name = $this->generete_name($table);
		$this->dirty[$name] = $table;
	}
	
	/**
	 * Dodaje do tabeli obiekty do inserta bd
	 * @param table $table
	 */
	function add_new(table $table) {
		$this->new[] = $table;
	}
	
	/**
	 * Dodaje do tabeli do skasowania
	 * @param table $table
	 */
	function add_delete(table $table) {
		$name = $this->generete_name($table);
		$this->delete[$name] = $table;
	}
	
	/**
	 * Usuwa obiekt z tabel: aktualizacji, skasowania, stworzenia nowego
	 * @param table $table
	 */
	function clean(table $table) {
		unset($this->dirty[$this->generete_name($table)]);
		unset($this->delete[$this->generete_name($table)]);
		$new_new = array();
		foreach ($this->new as $new) {
			if ($new != $table)
				$new_new[] = $new;
		}
		$this->new = $new_new;
	}
	
	/**
	 * Odczytuje obiekt z tabeli jeśli był już wcześniej odczytany lub odczytuje teraz
	 * @param library_main_table $table
	 * @return table
	 */
	function get_model(table $table) {
		if (isset($this->all[$this->generete_name($table)]))
			return $this->all[$this->generete_name($table)];
		else {
			return $this->get_model_from_db($table);
		}
	}
	
	/**
	 * Odczytuje obiekt z bazy danych
	 * @param library_main_table $table
	 * @return table
	 */
	private function get_model_from_db(table $table){
		$mapper = $this->getMapper();
		$table->load_variable($mapper->load($table));
		$this->all[$this->generete_name($table)] = $table;
		return $table;
	}
	
	/**
	 * Tworzy unikatową nazwę obiektu do identyfikacji
	 * @param table $table
	 * @return string
	 */
	private function generete_name(table $table) {
		return sprintf('%s%d', get_class($table), $table->get_id());
	}
	
	/**
	 * Wykonuje wszystkie operacje zaplanowane na bazie danych
	 */
	function execute() {
		if(empty($this->new) && empty($this->dirty) && empty($this->delete))
			return false;
		$mapper = $this->getMapper();
		foreach ($this->new as $table) {
			$mapper->insert($table);
		}
		foreach ($this->dirty as $table) {
			$mapper->update($table);
		}
		foreach ($this->delete as $table) {
			$mapper->delete($table);
		}
	}
	function getMapper(){
		return application::getInstance()->getResource('mapper');
	}
}