<?php

class Backend_Model_DbTable_Abstract extends Zend_Db_Table_Abstract {
	protected function _setupDatabaseAdapter() {
		$conf = new Zend_Config_Ini(realpath(
			Backend_Bootstrap::MODULE_PATH.'/configs/config.ini'));
		$this->_db = Zend_Db::factory($conf->resources->db);
	}
}
