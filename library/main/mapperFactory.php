<?php
class library_main_mapperFactory extends library_main_mapper{
	
	static function getMapper(){
		return new library_main_mapper(library_main_db::getPdo());
	}
}