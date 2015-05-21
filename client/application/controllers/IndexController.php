<?php


class IndexController extends Zend_Controller_Action {

    public static $SESSION_ID = 'oauth2client';

    /**
     * all client info (client id, client secret, scopes etc.)
     * @var Application_Model_ClientInfo
     *
     */
    private $client_info;

    /**
     * @var Oauth2_Model_Interact
     *
     */
    private $oauth2 = null;

    public function init() {
    	$redirect_endpoint = $this->view->serverUrl().$this->view->url(array(
		'module'     => 'default',
		'controller' => 'index',
		'action'     => 'process'), 'default');
    	$this->client_info = new Application_Model_ClientInfo($redirect_endpoint);
	$config = new Zend_Config_Ini(realpath(
		APPLICATION_PATH.'/configs/application.ini'),'production');
	$this->oauth2 = new Oauth2_Model_Interact($config->CAcertPath);
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('ajax', 'html')->initContext();
    }

    private function getSessionVariable() {
    	return new Zend_Session_Namespace(self::$SESSION_ID);
    }

    private function saveAuthCode($auth_code) {
    	$ns = $this->getSessionVariable();
    	$ns->code = $auth_code;
    }

    private function getAuthCode() {
    	$ns = $this->getSessionVariable();
    	return $ns->code;
    }

    private function saveFormData($form_data) {
    	$ns = $this->getSessionVariable();
    	$ns->form_data = $form_data;
    }

    private function getFormData() {
    	$ns = $this->getSessionVariable();
    	return $ns->form_data;
    }

    private function saveAccessToken($access_token) {
    	$ns = $this->getSessionVariable();
    	$ns->token = $access_token;
    }

    private function getAccessToken() {
    	$ns = $this->getSessionVariable();
    	return $ns->token;
    }


    public function indexAction() {
    	$this->view->form = new Application_Form_StartForm($this->client_info->getScopes());
    }


    public function getAction() {

    	$form = new Application_Form_StartForm($this->client_info->getScopes());
    	$req = $this->getRequest();

    	if (!$req->isPost() || !$form->isValid($req->getPost())) {
    		$this->view->form = $form;
    		$this->_helper->redirector('index');
    	}

	$selected_scopes = $form->getValue(Application_Form_StartForm::SCOPES);
    	if (empty($selected_scopes)) {
    		$form->setDescription('Bisogna scegliere almeno una voce. Riprovare.');
    		$this->view->form = $form;
    		return $this->render('index');
    	}

    	$state = "";

    	try {
    		$req = $this->oauth2->authCodeRequest(
			$this->client_info->getAsAuthEndpoint(),
			$this->client_info->getId(),
			$this->client_info->getRedirectEndpoint(),
			$selected_scopes, $state);
    	} catch (InvalidArgumentException $e) {
    		$form->setDescription('errore 1: '.$e->getMessage().'.');
    		$this->view->form = $form;
    		return $this->render('index');
    	}

	/*
	* Present this request to the user-agent
	* as a HTTP 302 redirect, so the user-agent contacts the
	* as_auth_endpoint.  As a result, the AS issues another HTTP 302
	* to the user-agent containing the redirect_uri, with the
	* auth. code in a query string.
	* The redirect_uri brings back to an endpoint of this app, namely,
	* processAction().
	*/
	$this->_helper->redirector->gotoUrl($req);

    }


    public function processAction() {

    	$request = $this->getRequest();

	// state is not used in this app
//	$state = $this->oauth2->getState($request);

    	try {
    		$auth_code = $this->oauth2->getAuthCodeFromResponse($request);
//     	} catch (Oauth2_Model_AccessDeniedException $e) {
//     		echo $e->getDescription();
//     	} catch (Oauth2_Model_InvalidRequestException $e) {
//     		echo $e->getDescription();
//     	} catch (Oauth2_Model_InvalidScopeException $e) {
//     		echo $e->getDescription();
//     	} catch (Oauth2ServerErrorException $e) {
//     		echo $e->getDescription();
//     	} catch (Oauth2TemporarilyUnavailableException $e) {
//     		echo $e->getDescription();
//     	} catch (Oauth2_Model_UnauthorizedClientException $e) {
//     		echo $e->getDescription();
//     	} catch (Oauth2_Model_UnsupportedResponseTypeException $e) {
//     		echo $e->getDescription();
    	} catch (Oauth2_Model_Exception $e) {
    		$this->view->error = 'errore 2: '.$e->getMessage().'.';
    		return;
    	}

	// no need to save the auth. code into session:
	// it is being spent immediately.
//     	$this->saveAuthCode($auth_code);

    	try {
    		$access_token = $this->oauth2->getAccessToken(
			$this->client_info->getAsTokenEndpoint(),
			$auth_code,
			$this->client_info->getRedirectEndpoint(),
			$this->client_info->getId(),
			$this->client_info->getSecret());
//     	} catch (Oauth2_Model_TokenException $e) {
//     	} catch (Oauth2_Model_TokenPartException $e) {
//     	} catch (Oauth2_Model_InvalidRequestException $e) {
//     	} catch (Oauth2_Model_InvalidClientException $e) {
//     	} catch (Oauth2_Model_InvalidGrantException $e) {
//     	} catch (Oauth2_Model_UnauthorizedClientException $e) {
//     	} catch (Oauth2_Model_UnsupportedGrantTypeException $e) {
//     	} catch (Oauth2_Model_InvalidScopeException $e) {
    	} catch (Oauth2_Model_Exception $e) {
    		$this->view->error = 'errore 3: '.$e->getMessage().'.';
    		return;
    	}

	// save access token into session, for subsequent resource requests
	// performed by fillAction()
    	$this->saveAccessToken($access_token);

    	$this->view->message = 'Autorizzazioni concesse...';

    }


    public function fillAction() {

    	if (!$this->getAccessToken()) {
    		$this->view->no_token = true;
    		return;
    	}

    	// request the resources to the various RS
    	try {
    		$received_data = $this->oauth2->getAllData($this->getAccessToken());
    	} catch (Oauth2_Model_Exception $e) {
    		$this->view->error_message = $e->getDescription();
    		return;
    	}

	// capture the errors, if any, for display in the form
    	$this->view->access_errors = array();
    	foreach ($received_data->getErrors() as $e) {
    		$scopes = Oauth2_Model_ReceivedData::getScopes($e);
    		$error_descr = Oauth2_Model_ReceivedData::getDescription($e);
    		$scope_descr = array();
    		foreach ($scopes as $scope_id)
    			$scope_descr[] = $this->client_info->getScopeDescription($scope_id);
    		$this->view->access_errors[] = array($error_descr,$scope_descr);
    	}

    	// fill in the annual tax return form
    	$user_data = new Application_Model_UserData($received_data->getData());
    	$this->view->form_data = new Application_Model_FormData($user_data);
    	$this->saveFormData($this->view->form_data);

    }


    public function ajaxAction() {
    	$this->view->richiesta = $this->getRequest()->getParam('richiesta', '');
    	switch ($this->view->richiesta) {
    		case 'spese_mediche':
    			$form_data = $this->getFormData();
    			if (!$form_data)
    				return 'No data';
    			$this->view->spese_mediche = $form_data->speseMediche();
    			break;
    	}
    }

}
