<?php

class Server_Mapper_ASPubKey extends Server_Mapper_Abstract {
	
	public function __construct() {
		$this->table_name = 'Server_Model_DbTable_ASPubKey';
	}
	
	/**
	 * Retrieves an the path to the public key given the Authorization Server id
	 *
	 * @param string $id the issuer of the token as specified by iss parameter
	 * @return Server_Model_ASPubKey|null
	 */
	public function find($id) {
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) 
			return null;
		
		$row = $result->current();
		
		return new Server_Model_ASPubKey($row->id, $row->path);
	}
	
	/**
	 * gets array of all ASPubKey
	 * @return array
	 */
	public function fetchAll() {
		$resultSet = $this->getDbTable()->fetchAll();
		$entries   = array();
		foreach ($resultSet as $row)
			$entries[] = new Server_Model_ASPubKey($row->id, $row->path);
		
		return $entries;
	}
	


}

