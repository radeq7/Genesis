<?php

abstract class library_main_objectWatcher {
	static private $all = array();
	static private $dirty = array();
	static private $new = array();
	static private $delete = array();
	
	static function add_dirty(library_main_table $model) {
		$name = library_main_objectWatcher::generete_name($model);
		self::$dirty[$name] = $model;
	}
	
	static function add_new(library_main_table $model) {
		self::$new[] = $model;
	}
	
	static function add_delete(library_main_table $model) {
		$name = library_main_objectWatcher::generete_name($model);
		self::$delete[$name] = $model;
	}
	
	static function clean(library_main_table $model) {
		unset(self::$dirty[library_main_objectWatcher::generete_name($model)]);
		unset(self::$delete[library_main_objectWatcher::generete_name($model)]);
		$new_new = array();
		foreach (self::$new as $new) {
			if ($new != $model)
				$new_new[] = $new;
		}
		self::$new = $new_new;
	}
	
	static function get_model(library_main_table $model) {
		if (isset(self::$all[library_main_objectWatcher::generete_name($model)]))
			return self::$all[library_main_objectWatcher::generete_name($model)];
		else {
			$mapper = library_main_mapperFactory::getMapper();
			$data = $mapper->load($model);
			self::$all[library_main_objectWatcher::generete_name($model)] = $model;
			return $data;
		}
	}
	
	static private function generete_name(library_main_table $model) {
		return sprintf('%s%d', $model->get_name(), $model->get_id());
	}
	
	static function execute() {
		$mapper = library_main_mapperFactory::getMapper();
		foreach (self::$new as $model) {
			$mapper->insert($model);
		}
		foreach (self::$dirty as $model) {
			$mapper->update($model);
		}
		foreach (self::$delete as $model) {
			$mapper->delete($model);
		}
	}
}