<?php

class Agenziaterritorio_Bootstrap extends Zend_Application_Module_Bootstrap {
	const DB_NAME = 'agterritorio';
	
	protected function _initDB() {
		$conf = new Zend_Config_Ini(dirname(__FILE__).'/configs/config.ini');
		$db = Zend_Db::factory($conf->resources->db);
		Zend_Registry::set(self::DB_NAME, $db);
	}
	/**
	 * Adds factories and  mappers as resource type, enabling it auto-loading
	 */
	protected function _initResourceLoader() {
		// 		$this->_resourceLoader->addResourceType('builder', 'models/Builder', 'Builder');
		$this->_resourceLoader->addResourceType('mapper', 'models/Mapper', 'Mapper');
		// 		$this->_resourceLoader->addResourceType('request', 'models/Request', 'Request');
	}
}
