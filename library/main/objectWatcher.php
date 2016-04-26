<?php
namespace Genesis\library\main;

/**
 * Buforuje obiekty odczytane z bazy danych 
 * @author Radeq
 */
abstract class objectWatcher {
	static private $all = array();
	static private $dirty = array();
	static private $new = array();
	static private $delete = array();
	
	/**
	 * Dodaje do tabeli jako do aktualizacji
	 * @param table $table
	 */
	static function add_dirty(table $table) {
		$name = objectWatcher::generete_name($table);
		self::$dirty[$name] = $table;
	}
	
	/**
	 * Dodaje do tabeli obiekty do inserta bd
	 * @param table $table
	 */
	static function add_new(table $table) {
		self::$new[] = $table;
	}
	
	/**
	 * Dodaje do tabeli do skasowania
	 * @param table $table
	 */
	static function add_delete(table $table) {
		$name = objectWatcher::generete_name($table);
		self::$delete[$name] = $table;
	}
	
	/**
	 * Usuwa obiekt z tabel: aktualizacji, skasowania, stworzenia nowego
	 * @param table $table
	 */
	static function clean(table $table) {
		unset(self::$dirty[objectWatcher::generete_name($table)]);
		unset(self::$delete[objectWatcher::generete_name($table)]);
		$new_new = array();
		foreach (self::$new as $new) {
			if ($new != $table)
				$new_new[] = $new;
		}
		self::$new = $new_new;
	}
	
	/**
	 * Odczytuje obiekt z tabeli jeśli był już wcześniej odczytany lub odczytuje teraz
	 * @param library_main_table $table
	 * @return table
	 */
	static function get_model(table $table) {
		if (isset(self::$all[objectWatcher::generete_name($table)]))
			return self::$all[objectWatcher::generete_name($table)];
		else {
			return self::get_model_from_db($table);
		}
	}
	
	/**
	 * Odczytuje obiekt z bazy danych
	 * @param library_main_table $table
	 * @return table
	 */
	static private function get_model_from_db(table $table){
		$mapper = mapperFactory::getMapper();
		$table->load_variable($mapper->load($table));
		self::$all[objectWatcher::generete_name($table)] = $table;
		return $table;
	}
	
	/**
	 * Tworzy unikatową nazwę obiektu do identyfikacji
	 * @param table $table
	 * @return string
	 */
	static private function generete_name(table $table) {
		return sprintf('%s%d', get_class($table), $table->get_id());
	}
	
	/**
	 * Wykonuje wszystkie operacje zaplanowane na bazie danych
	 */
	static function execute() {
		if(empty(self::$new) && empty(self::$dirty) && empty(self::$delete))
			return false;
		$mapper = mapperFactory::getMapper();
		foreach (self::$new as $table) {
			$mapper->insert($table);
		}
		foreach (self::$dirty as $table) {
			$mapper->update($table);
		}
		foreach (self::$delete as $table) {
			$mapper->delete($table);
		}
	}
}