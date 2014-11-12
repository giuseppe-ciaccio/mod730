<?php

class Application_Mapper_Client extends Application_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Application_Model_DbTable_Client';
	}
	
	
	public function getClient() {
		$current = $this->getDbTable()->fetchAll()->current();
		
		return new Application_Model_Client($current->id, $current->secret, 
											$current->as_auth_endpoint, $current->as_token_endpoint);
	}
}