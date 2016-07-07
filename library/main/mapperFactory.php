<?php
namespace Genesis\library\main;

class mapperFactory extends mapper{
	
	static function getMapper(){
		return new mapper(db::getPdo());
	}
}