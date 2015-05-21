<?php

class Application_Mapper_Authserver extends Application_Mapper_Abstract {

	public function __construct() {
		$this->table_name = 'Application_Model_DbTable_Authserver';
	}

	public function get() {
		$current = $this->getDbTable()->fetchAll()->current();
		return new Application_Model_Authserver(
			$current->auth_endpoint,
			$current->token_endpoint);
	}

}
