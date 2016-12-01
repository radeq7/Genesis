<?php
namespace Genesis\library\main;

class bootstrapDevelopment extends \Genesis\library\bootstrap{
	protected function initMapper(){
		return new db\mapperDevelopment($this->getResource('pdo'));
	}
}