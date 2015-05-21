<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	protected function _initLogging()
	{
		$log = new Zend_Log(new Zend_Log_Writer_Stream('/tmp/mod730-RS-at.log'));
		Zend_Registry::set('log',$log);
	}

	protected function _initRestRoute()
	{
		$this->bootstrap("frontController");
		$frontController = Zend_Controller_Front::getInstance();
		$restRoute = new Zend_Rest_Route($frontController, array(), array(
				"server" => array("data"),
		));
		$frontController->getRouter()->addRoute("rest", $restRoute);
	}
}

