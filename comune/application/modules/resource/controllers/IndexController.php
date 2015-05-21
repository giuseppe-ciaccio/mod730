<?php

class Resource_IndexController extends Zend_Controller_Action
{

	protected $val = NULL;

	public function init() { }
	public function indexAction() { }

	// display static views
	public function readscopeAction()
	{
		$scopemodel = new Resource_Mapper_ScopesTable();
		$results[] = $scopemodel->find('read');
		$description = $results[0];
		//$fielddescr = $description->getDescr();
		$this->view->description = $description;
	}

	public function writescopeAction()
	{
		$scopemodel = new Resource_Mapper_ScopesTable();
		$results[] = $scopemodel->find('write');
		$description = $results[0];
		//$fielddescr = $description->getDescr();
		$this->view->description = $description;
	}

	public function updatescopeAction()
	{
		$scopemodel = new Resource_Mapper_ScopesTable();
		$results[] = $scopemodel->find('update');
		$description = $results[0];
		//$fielddescr = $description->getDescr();
		$this->view->description = $description;
	}

	public function deletescopeAction()
	{
		$scopemodel = new Resource_Mapper_ScopesTable();
		$results[] = $scopemodel->find('delete');
		$description = $results[0];
		//$fielddescr = $description->getDescr();
		$this->view->description = $description;
	}

	public function scopesAction()
	{
		$scopemodel = new Resource_Mapper_ScopesTable();
		$results = $scopemodel->findAll();
		$description = $results;
		//$fielddescr = $description->getDescr();
		$this->view->description = $description;
	}

	public function formAction()
	{
		$form = new Resource_Form_RSetRegistration();
		$this->view->form = $form;
		$request = $this->getRequest();
		if ($request->isPost()) {
			if (!$form->isValid($request->getPost())) {
				$this->view->messages = $request->getPost()->getMessages();
				$this->_helper->redirector('resource', 'resource', 'form');
			}
		}
	}

	public function createAction()
	{
		$request = $this->getRequest();
// TODO sanity: non e' detto che i parametri ci siano
		if ($request->isPost()) {
			$values = $request->getPost();
		}
// TODO sanity: e se la richiesta non e' Post?

		$name = $values['name'];
		$scopes = $values['scope'];
		$defscope = "";
		foreach($scopes as $s) {
			if($defscope != "")
				$defscope = $defscope . "," . $s;
			else
				$defscope = $s;
		}

		$values['defscope'] = $defscope;

		$description = $values['description'];
		$fields = $values['fields'];
		$deffield = "";
		foreach($fields as $f) {
			if($deffield != "")
				$deffield = $deffield . "," . $f;
			else
				$deffield = $f;
		}

		$type = $values['type'];

		$composinghash = hash('md5', $name . $defscope . $description . $type . $deffield);
// TODO sanity: verificare che non e' un duplicato di qualcosa che gia' esiste

// TODO: URL base degli rset dovrebbe essere in config.ini
		$url_nuovo = "https://localhost/comune/resource/endpoint?id=" . $composinghash;

		$values['id'] = $composinghash;
		$values['endpoint'] = $url_nuovo;

		$config = new Zend_Config_Ini(realpath(
			APPLICATION_PATH . '/configs/application.ini',
			'production'));
		// create https client request
// TODO: la richiesta dovrebbe essere firmata da RS
// mediante il segreto condiviso tra RS e AS oppure con chiave privata di RS.
		$url = $config->as->rset->creation->endpoint;
		$client =  new Zend_Http_Client($url);

		// embed json object into request body

		$valuesData = json_encode($values);

		$response = $client->setRawData($valuesData)->setEncType('application/json')->request('POST');

		if(!($response->getMessage() == "OK")){
			$this->view->endp = "REGISTRATION FAILED: authorization server says: ".$response->getMessage();
//			$this->render();
			return;
		}

		foreach($scopes as $sc){
			$sr = new Resource_Model_RSetScopes($sc,$values['id']);
			$srs = new Resource_Mapper_RSetScopesTable();
			$srs->save($sr);
		}

		$rset_nuovo = new Resource_Model_RSetInfo($values['id'], $name, $url_nuovo, "rset_info", $description, $type, $deffield);
		$rset_info = new Resource_Mapper_ResourceSetTable();
		$rset_info->save($rset_nuovo);

		$this->view->endp = $url_nuovo;
//		$this->render();

	}

	public function endpointAction(){

//TODO sanity: non e' detto che i parametri ci siano
		$request_id = $this->getRequest()->getParam('id');
		$endp = new Resource_Mapper_ResourceSetTable();
		$endpoint = $endp->find($request_id);

		$scopeD = new Resource_Mapper_RSetScopesTable();
		$scopeAll = $scopeD->findRset($request_id);

		if(null == $this->getRequest()->getParam('scope')){
			$this->_helper->viewRenderer->setNoRender();
			$this->view->rsetid = $endpoint[0]->getRsetId();
			$this->view->rsetname = $endpoint[0]->getName();
			$this->view->rsetde = $endpoint[0]->getDescr();
			$this->view->rsettab = $endpoint[0]->getTable();
			$this->view->rsettype = $endpoint[0]->getType();

			$this->view->allsco = $scopeAll;

			$this->view->display = true;

			$this->render();
		}
		else //there are other params
		{
			$datas = array();
			$datas['rset_id'] = $endpoint[0]->getRSetId();
			$datas['rset_name'] = $endpoint[0]->getName();
			$datas['rset_descr'] = $endpoint[0]->getDescr();
			$datas['rset_table'] = $endpoint[0]->getTable();
			$datas['rset_type'] = $endpoint[0]->getType();

			$collapse_scopes = "";
			foreach($scopeAll as $sco){
				if($collapse_scopes != ""){
				   $collapse_scopes = $collapse_scopes. "," .$sco->getScopeUri();
				}
				else{
					$collapse_scopes = $sco->getScopeUri();
				}
			}

			$datas['scopes'] = $collapse_scopes;

			$this->view->display = false;

			$this->view->obj = json_encode($datas);
			$this->render();
		}
	}

}
