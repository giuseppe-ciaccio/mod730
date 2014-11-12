<?php

class Comune_Model_DbTable_Abstract extends Zend_Db_Table_Abstract {
	protected function _setupDatabaseAdapter() {
		$this->_db = Zend_Registry::get(Comune_Bootstrap::DB_NAME);
	}
}
