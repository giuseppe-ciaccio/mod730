<?php

class Resource_Bootstrap extends Zend_Application_Module_Bootstrap {

	/**
	 * Adds factories and mappers as resource type, enabling it auto-loading
	 */
	protected function _initResourceLoader() {
		$this->_resourceLoader->addResourceType('mapper', 'models/Mapper', 'Mapper');
	}

	public function _initResource() {
		$route = new Zend_Controller_Router_Route('resource/:action',
			array('module'=>'resource','controller'=>'index'));
		$ctrl = Zend_Controller_Front::getInstance();
		$router = $ctrl->getRouter();
		$router->addRoute('resourceModuleRoute', $route);
	}

}
