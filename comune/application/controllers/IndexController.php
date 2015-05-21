<?php

class IndexController extends Zend_Controller_Action
{

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
    	// show a description of this RS
        $si = new Server_Model_ServerInfo();
        $this->view->description = $si->getDescription();
    }

}
