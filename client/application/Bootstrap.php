<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {	

	protected function _initLogging()
	{
		$log = new Zend_Log(new Zend_Log_Writer_Stream('/tmp/mod730-CLIENT.log'));
		Zend_Registry::set('log',$log);
	}

	protected function _initViewHelpers() {
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		
		$view = $layout->getView();
		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
		ZendX_JQuery::enableView($view);
		
// 		$view->jQuery()->enable();//enable jquery ; ->setCdnSsl(true) if need to load from ssl location
// 							->setVersion('1.5')//jQuery version, automatically 1.5 = 1.5.latest
// 							->setUiVersion('1.8')//jQuery UI version, automatically 1.8 = 1.8.latest
// 							->addStylesheet('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css')//add the css
// 							->uiEnable();//enable ui
	}
	
	/**
	 * Adds factories and  mappers as resource type, enabling it auto-loading
	 */
	protected function _initResourceLoader() {
		$this->_resourceLoader->addResourceType('mapper', 'models/Mapper', 'Mapper');
	}

}

