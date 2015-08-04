<?php
abstract class model {
	private $id = 0;
	protected $id_name = '';
	protected $name = '';
	protected $table = array();
	protected $change = array();

	function __construct($id = 0) {
		if ($id) {
			$this->id = $id;
			mapper::get_model($this);
		}
		else
			$this->add_new();
	}

	function doCreate() {
		$this->id = mapper::create($this);
	}
	
	function doLoad() {
		$this->table = mapper::load($this);
	}
	
	function get_id() {
		return $this->id;
	}

	function get_name() {
		return $this->name;
	}

	function get_id_name() {
		return $this->id_name;
	}

	function get_table() {
		return $this->table;
	}
	
	function get_change() {
		$tmp = array();
		foreach ($this->change as $change) {
			$tmp[$change] = $this->table[$change];
		}
		print_r($tmp); //TEST
		return $tmp;
	}

	protected function set_var($var, $value) {
		$this->table[$var] = $value;
		$this->change[] = $var;
		if ($this->id)
			$this->add_dirty();
	}

	function get_var($var) {
		return $this->table[$var];
	}

	protected function add_dirty() {
		mapper::add_dirty($this);
	}

	private function add_new() {
		mapper::add_new($this);
	}

	function add_delete() {
		mapper::add_delete($this);
	}

	function clean() {
		mapper::clean($this);
	}
}