<?php
class mapper {
	static private $instance;
	private $all = array();
	private $dirty = array();
	private $new = array();
	private $delete = array();
	private $pdo;

	private function __construct() {
		$this->pdo = database::getPdo();
	}

	static function instance() {
		if (!self::$instance) 
			self::$instance = new mapper();
			
		return self::$instance;
	}
	
	static function add_dirty(model $model) {
		$self = mapper::instance();
		$name = mapper::generete_name($model);
		$self->dirty[$name] = $model;
	}

	static function add_new(model $model) {
		$self = mapper::instance();
		$self->new[] = $model;
	}

	static function add_delete(model $model) {
		$self = mapper::instance();
		$name = mapper::generete_name($model);
		$self->delete[$name] = $model;
	}

	static function clean(model $model) { 
		$self = mapper::instance();
		unset($self->dirty[mapper::generete_name($model)]);
		unset($self->delete[mapper::generete_name($model)]);
		$new_new = array();
		foreach ($self->new as $new) {
			if ($new != $model)
				$new_new[] = $new;
		}
		$self->new = $new_new;
	}
	
	static function get_model(model $model) {
		$self = mapper::instance();
		if (isset($self->all[mapper::generete_name($model)])) 
			return $self->all[mapper::generete_name($model)];
		else 
			return $model->doLoad();
	}

	static private function generete_name(model $model) {
		return sprintf('%s%d', $model->get_name(), $model->get_id());
	}

	static function execute() {
		if (!self::$instance)
			return;
		$self = mapper::instance();
		foreach ($self->new as $model) {
			$model->doCreate();
		}
		foreach ($self->dirty as $model) {
			$self->save($model);
		}
		foreach ($self->delete as $model) {
			$self->delete($model);
		}
	}

	static function load(model $model) {
		$self = mapper::instance();
		$query = sprintf("SELECT * FROM `%s` WHERE `%s`='%d' LIMIT 1", $model->get_name(), $model->get_id_name(), $model->get_id());
		printf('<br>%s',$query); // TEST
		$result = $self->pdo->query($query);
		$self->all[mapper::generete_name($model)] = $model;
		if (!($wynik = $result->fetch(PDO::FETCH_ASSOC))) 
			throw new Exception(sprintf('Nie ma takiego rekordu (%s) w bazie danych!', $query));
		
		return $wynik;
	}

	static function create(model $model) {
		$self = mapper::instance();
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
		if (!($self->pdo->exec($query))) {
			$error = $self->pdo->errorInfo();
			throw new Exception($error[2]);
		}
		
		return $self->pdo->lastInsertId();
	}

	/**
	 * Zwraca tablicę wyszukiwanych dancyh w podanej tabeli.
	 * 
	 * @return array:
	 */
	static function select_by_where($table, $where, $select) {
		
		$self = mapper::instance();
		$query = sprintf("SELECT %s FROM `%s` WHERE %s", $select, $table, $where);
		$result = $self->pdo->query($query);
		if ($result == FALSE) {
			$error_message = $self->pdo->errorInfo();
			throw new Exception($error_message[2]);
		}
		$wynik = $result->fetchAll(PDO::FETCH_ASSOC);	
		return $wynik;
	}
	
	private function delete(model $model) {
		$query = sprintf("DELETE FROM `%s` WHERE `%s`='%d' LIMIT 1", $model->get_name(), $model->get_id_name(), $model->get_id());
		printf('<br>%s',$query); // TEST
		$this->pdo->exec($query);
	}

	private function save(model $model) {
		$query1 = '';
		foreach ($model->get_change() as $key => $value) {
			$query1 .= sprintf("`%s` = '%s', ", $key, $value);
		}
		$query = sprintf("UPDATE `%s` SET %s WHERE `%s`='%d' LIMIT 1", $model->get_name(), rtrim($query1, ', '), $model->get_id_name(), $model->get_id());
		printf('<br>%s',$query); // TEST
		$this->pdo->exec($query);
	}
}
