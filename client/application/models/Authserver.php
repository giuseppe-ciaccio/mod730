<?php

class Application_Model_Authserver {
	
	/**
	 * authorization endpoint uri
	 * @var string
	 */
	private $auth_endpoint;

	/**
	 * token endpoint uri
	 * @var string
	 */
	private $token_endpoint;
	
	public function __construct($auth_endpoint, $token_endpoint) {
		$this->auth_endpoint = $auth_endpoint;
		$this->token_endpoint = $token_endpoint;
	}
	
	public function getAsAuthEndpoint() {
		return $this->auth_endpoint;
	}

	public function getAsTokenEndpoint() {
		return $this->token_endpoint;
	}

}
