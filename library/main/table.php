<?php

abstract class library_main_table {
	protected $table_name;
	protected $id = 0;
	protected $id_name = 'id';
	protected $values = array();
	protected $change = array();
	
	function __construct($id = 0) {
		if ($id == 0)
			$this->add_new();
		else {
			$this->id = $id;
			$this->values = library_main_objectWatcher::get_model($this);
		}
	}
	
	function set_var($var, $value){
		$this->values[$var] = $value;
		$this->change[$var] = $value;
		if ($this->id)
			$this->dirty();
	}
	
	function get_var($var){
		return $this->values[$var];
	}
	
	function clean(){
		library_main_objectWatcher::clean($this);
	}
	
	function delete(){
		library_main_objectWatcher::add_delete($this);
	}
	
	protected function add_new(){
		library_main_objectWatcher::add_new($this);
	}
	
	protected function dirty(){
		library_main_objectWatcher::add_dirty($this);
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
}