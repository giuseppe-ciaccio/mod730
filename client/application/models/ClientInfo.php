<?php

class Application_Model_ClientInfo {

	/**
	 * client id
	 * @var string
	 */
	private $id;

	/**
	 * client secret
	 * @var string
	 */
	private $secret;

	/**
	 * the application endpoint to which the authorization 
	 * server will redirect after auth. approval or denial
	 * @var string
	 */
	private $redirect_endpoint;

	/**
	 * info about the authorization server (auth. endpoint, token endpoint)
	 * @var Application_Model_Client
	 */
	private $authserver;

	/**
	 * the set of scopes known by this application.
	 * @var array[int]Application_Model_Scope
	 */
	private $scopes;

	public function __construct($redirect_endpoint) {
		$config = new Zend_Config_Ini(realpath(
			APPLICATION_PATH.'/configs/application.ini'),
			'production');
		$this->id = $config->client->id;
		$this->secret = $config->client->secret;
		$this->redirect_endpoint = $redirect_endpoint;
		$am = new Application_Mapper_Authserver();
		$sm = new Application_Mapper_Scope();
		$this->authserver = $am->get();
		$this->scopes = $sm->get();
	}

	public function getId() {
		return $this->id;
	}

	public function getSecret() {
		return $this->secret;
	}

	public function getRedirectEndpoint() {
		return $this->redirect_endpoint;
	}

	public function getAsAuthEndpoint() {
		return $this->authserver->getAsAuthEndpoint();
	}

	public function getAsTokenEndpoint() {
		return $this->authserver->getAsTokenEndpoint();
	}

	public function getScopes() {
		return $this->scopes;
	}

	public function getScopeDescription($scope_id) {
		if (empty($scope_id))
			return null;

		foreach ($this->scopes as $s)
			if ($s->getId() == $scope_id)
				return $s->getDescription();

		return null;
	}

}
