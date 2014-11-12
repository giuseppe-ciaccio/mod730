<?php

class Agenziaterritorio_Model_DbTable_Abstract extends Zend_Db_Table_Abstract {
	protected function _setupDatabaseAdapter() {
		$this->_db = Zend_Registry::get(Agenziaterritorio_Bootstrap::DB_NAME);
	}
}
