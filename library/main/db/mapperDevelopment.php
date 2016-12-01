<?php
namespace Genesis\library\main\db;

class mapperDevelopment extends mapper{
	protected function pdo_exec_or_error($query){
		parent::pdo_exec_or_error($query);
		$this->logQuery($query);
	}
	protected function pdo_query_or_error($query){
		$result = parent::pdo_query_or_error($query);
		$this->logQuery($query);
		return $result;
	}
	protected function logQuery($query){
		$log = new \Genesis\library\main\standard\log('log\query.html');
		$log->logMessage($log->formatMessage(sprintf(" [ %s ] ", $query)));
	}
}