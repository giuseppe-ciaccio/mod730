<?php

class Server_Mapper_RSInfo extends Server_Mapper_Abstract {
	
	public function __construct() {
		$this->table_name = 'Server_Model_DbTable_RSInfo';
	}
	
	
	public function find($id) {
		$result = $this->getDbTable()->find($id);
		if (count($result) == 0)
			return null;
	
		$row = $result->current();
	
		return new Server_Model_RSInfo($row->id, $row->shared_secred_key, $this->description);
	}
	
	public function getCurrentRSInfo() {
		$resultSet = $this->getDbTable()->fetchAll();
		
		if (count($resultSet) != 1)
			return null;
		
		$row = $resultSet[0];
		
		return new Server_Model_RSInfo($row->id, $row->shared_secret_key, $row->description);
	}
	
}
