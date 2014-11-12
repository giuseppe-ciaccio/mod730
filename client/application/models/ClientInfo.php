<?php

class Application_Model_ClientInfo {
	/**
	 * 
	 * @var Application_Model_Client
	 */
	private $client;
	/**
	 * 
	 * @var array[int]Application_Model_Scope
	 */
	private $scopes;
	
	
	public function __construct($redirect_endpoint) {
		$cm = new Application_Mapper_Client();
		$sm = new Application_Mapper_Scope();
		
		$this->client = $cm->getClient();
		$this->scopes = $sm->fetchAll();
		
		$this->client->setRedirectEndpoint($redirect_endpoint);
	}
	
	/**
	 * this application client id
	 * @return string
	 */
	public function getId() {
		return $this->client->getId();
	}
	/**
	 * this application client secret
	 * @return string
	 */
	public function getSecret() {
		return $this->client->getSecret();
	}
	/**
	 * this application redirect uri
	 * @return string
	 */
	public function getRedirectEndpoint() {
		return $this->client->getRedirectEndpoint();
	}
	/**
	 * the authorization endpoint
	 * @return string
	 */
	public function getAsAuthEndpoint() {
		return $this->client->getAsAuthEndpoint();
	}
	/**
	 * the token endpoint
	 * @return string
	 */
	public function getAsTokenEndpoint() {
		return $this->client->getAsTokenEndpoint();
	}
	/**
	 * 
	 * @return array[int]Application_Model_Scope
	 */
	public function getSopes() {
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

