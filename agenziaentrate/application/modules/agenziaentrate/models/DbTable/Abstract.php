<?php

class Agenziaentrate_Model_DbTable_Abstract extends Zend_Db_Table_Abstract {
// 	protected $_rowClass = 'Agenziaentrate_Model_ModelRowAbstract';
	
	protected function _setupDatabaseAdapter() {
		$this->_db = Zend_Registry::get(Agenziaentrate_Bootstrap::DB_NAME);
	}
}
