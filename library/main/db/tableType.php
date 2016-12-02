<?php
namespace Genesis\library\main\db;

class tableType extends table{
	protected $tableName = '';
	protected $typeName = 'type';
	protected $type = array();
	
	function getObjectNameByType($type){
		if (isset($this->type[$type]))
			return $this->type[$type];
			throw new \Exception('<br>Plik: ' . __FILE__ . '<br>Linia: ' . __LINE__ . '<br>' ."Nie zdefiniowany podtyp objektu [{$type}]");
	}
	function getTypeName(){
		return $this->typeName;
	}
}