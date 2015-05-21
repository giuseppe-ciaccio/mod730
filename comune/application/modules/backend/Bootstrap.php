<?php

class Backend_Bootstrap extends Zend_Application_Module_Bootstrap {

	/**
	 * This is for loading $PWD/configs/config.ini from
	 * models/DbTable/Abstract.php...
	 */
	const MODULE_PATH = __DIR__;
	
	/**
	 * Adds factories and mappers as resource type, enabling it auto-loading
	 */
	protected function _initResourceLoader() {
		$this->_resourceLoader->addResourceType('mapper', 'models/Mapper', 'Mapper');
	}
}
