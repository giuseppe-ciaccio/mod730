<?php

class IndexController extends Zend_Controller_Action
{

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
    	//add new parameter to database.... the resource server name        
        $si = new Server_Model_ServerInfo();
        $this->view->description = $si->getDescription();
    }


}

