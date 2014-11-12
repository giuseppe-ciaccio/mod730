<?php



class IndexController extends Zend_Controller_Action
{

    public static $SESSION_ID = 'oauth2client';

    /**
     * all client info (client id, client secret, scopes etc.)
     * @var Application_Model_ClientInfo
     *
     */
    private $client_info = null;

    /**
     * @var Oauth2_Model_Interact
     *
     */
    private $oauth2 = null;

    public function init() {
    	$redirect_endpoint = $this->view->serverUrl().
    							$this->view->url(array(
			'module'     => 'default',
			'controller' => 'index',
			'action'     => 'process'), 'default');
    	$this->client_info = new Application_Model_ClientInfo($redirect_endpoint);

    	//'/etc/ssl/certs/my-ca.crt' for the test host
    	//'/etc/apache2/ssl/cert.crt' for the dione host
//    	$this->oauth2 = new Oauth2_Model_Interact('/etc/apache2/ssl/cert.crt');
	// G. Ciaccio: now the constructor uses the CA certificates directory.
    	$this->oauth2 = new Oauth2_Model_Interact('/etc/ssl/certs');
    	
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('ajax', 'html')
        			->initContext();
    }

    /**
     * @return Zend_Session_Namespace
     *
     */
    private function getSessionVariable() {
    	return new Zend_Session_Namespace(self::$SESSION_ID);
    }

    private function saveAuthCode($auth_code) {
    	$ns = $this->getSessionVariable();
    	$ns->code = $auth_code;
    }

    /**
     * @return string
     *
     */
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
    /**
     * @param Oauth2_Model_Token $access_token
     *
     */
    private function saveAccessToken($access_token) {
    	$ns = $this->getSessionVariable();
    	$ns->token = $access_token;
    }

    /**
     * @return Oauth2_Model_Token
     *
     */
    private function getAccessToken() {
    	$ns = $this->getSessionVariable();
    	return $ns->token;
    }

    public function indexAction() {
//     	$pdf = Zend_Pdf::load('new.pdf');
    	
//     	$pdf->setChField('sesso', 'F');
// //     	$pdf->setTextField('sesso', 'F');
//     	$this->_helper->layout->disableLayout();
//     	$this->_helper->viewRenderer->setNoRender();
//     	header ('Content-Type:', 'application/pdf');
//     	header ('Content-Disposition:', 'inline;');
//     	echo $pdf->render();
//     	$pdf->save('outputfile.pdf');
//     	return;
    	$this->view->options_form = new Application_Form_StartForm($this->client_info->getSopes());
    }

    public function getAction()
    {
    	$options_form = new Application_Form_StartForm($this->client_info->getSopes());
    	$req = $this->getRequest();
    	
    	if (!$req->isPost() || !$options_form->isValid($this->getRequest()->getPost())) {
    		$this->view->options_form = $options_form;
    		$this->_helper->redirector('index');
    	}
    	
    	if ($options_form->getValue(Application_Form_StartForm::SUBMIT_BUTTON_ID)) {
    		$selected_scopes = $options_form->getValue(Application_Form_StartForm::SCOPES);
    		if (empty($selected_scopes)) {
    			$options_form->setDescription('Bisogna scegliere almeno una voce. Riprovare.');
    			$this->view->options_form = $options_form;
    			return $this->render('index');
    		}
    		$state = "";
    		try {
	    		$this->oauth2->getAuthCode($this, $this->client_info->getAsAuthEndpoint(), 
	    								$this->client_info->getId(),
	    								$this->client_info->getRedirectEndpoint(),
	    								$selected_scopes, $state);
    		} catch (InvalidArgumentException $e) {
    			$options_form->setDescription('errore 1: '.$e->getMessage().'.');
    			$this->view->options_form = $options_form;
    			return $this->render('index');
    		}
    	} else
    		$this->_helper->redirector('index');
    }

    public function processAction()
    {
    	$request = $this->getRequest();
    	
    	$state = Oauth2_Model_Interact::getState($request);
    	//use the state if it is not null
    	
    	try {
    		//TODO remove this comment
    		$auth_code = Oauth2_Model_Interact::getAuthCodeResponse($request);
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
    		//gestire l'errore opportunatamente
    		$this->view->error = 'errore 2: '.$e->getMessage().'.';
    		return;
    	}
    	
    	//save the code.. if there is the need
//     	$this->saveAuthCode($auth_code);
    	
    	try {
    		$access_token = Oauth2_Model_Interact::getAccessToken(
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
    	
    	$this->saveAccessToken($access_token);
    	
    	$this->view->message = 'Autorizzazioni concesse...';
    }

   
    public function fillAction() {
    	if (!$this->getAccessToken()) {
    		$this->view->no_token = true;
    		return;
    	}
    	
    	//richiesta dei dati...
    	try {
    		$received_data = Oauth2_Model_Interact::getAllData($this->getAccessToken());
    	} catch (Oauth2_Model_Exception $e) {
    		$this->view->error_message = $e->getDescription();
    		return;
    	}
    	   	
    	$this->view->access_errors = array();
    	foreach ($received_data->getErrors() as $e) {
    		$scopes = Oauth2_Model_ReceivedData::getScopes($e);
    		$error_descr = Oauth2_Model_ReceivedData::getDescription($e);
    		
    		$scope_descr = array();
    		foreach ($scopes as $scope_id)
    			$scope_descr[] = $this->client_info->getScopeDescription($scope_id);
    		
    		/*
    		 * to retrieve from view by accessing on each element the 
    		 * array[0] the description of the error, the array[1] 
    		 * the array of scope descriptions.
    		 */
    		$this->view->access_errors[] = array($error_descr,$scope_descr);
    	}
    	//use user data to fill in the annual income declaration
//     	var_dump($received_data);
    	$user_data = new Application_Model_UserData($received_data->getData());
    	$this->view->form_data = new Application_Model_FormData($user_data);
    	$this->saveFormData($this->view->form_data);
//     	var_dump($user_data->agenziaentrate);
    }
    
    public function ajaxAction() {
//     	$this->_helper->layout()->disableLayout();
    	
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
