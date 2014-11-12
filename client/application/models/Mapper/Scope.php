<?php

class Application_Mapper_Scope extends Application_Mapper_Abstract {
	
	public function __construct() {
		$this->table_name = 'Application_Model_DbTable_Scope';
	}
	
	public function fetchAll() {
		$resultSet = $this->getDbTable()->fetchAll();
		$entries = array();
		foreach ($resultSet as $row)
			$entries[] = new Application_Model_Scope($row->id, $row->description);
		
		return $entries;
	}
}