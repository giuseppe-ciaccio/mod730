<?php

class Application_Model_Client {
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
	 * the endpoint to which the authorization 
	 * server will redirect after auth. approval or denial
	 * @var string
	 */
	private $redirect_endpoint;
	
	/**
	 * the endpoint to which this client will ask authorization codes
	 * @var string
	 */
	private $as_auth_endpoint;
	/**
	 * the endpoint to which this client will ask access tokens
	 * @var string
	 */
	private $as_token_endpoint;
	
	public function __construct($id, $secret, $as_auth_endpoint, $as_token_endpoint) {
		$this->id = $id;
		$this->secret = $secret;
		$this->as_auth_endpoint = $as_auth_endpoint;
		$this->as_token_endpoint = $as_token_endpoint;
	}
	
	/**
	 * the redirect endpoint is not stored on the db - it is setted
	 * by controller later
	 * @param string $redirect_endpoint
	 */
	public function setRedirectEndpoint($redirect_endpoint) {
		$this->redirect_endpoint = $redirect_endpoint;
	}
	
	/**
	 * client id
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * client secret
	 * @return string
	 */
	public function getSecret() {
		return $this->secret;
	}
	/**
	 * client redirect endpoint
	 * @return string
	 */
	public function getRedirectEndpoint() {
		return $this->redirect_endpoint;
	}
	
	/**
	 * Authorization Server Authorization Endpoint
	 * @return string
	 */
	public function getAsAuthEndpoint() {
		return $this->as_auth_endpoint;
	}
	/**
	 * Authorization Server Token Endpoint
	 * @return string
	 */
	public function getAsTokenEndpoint() {
		return $this->as_token_endpoint;
	}
	


}

