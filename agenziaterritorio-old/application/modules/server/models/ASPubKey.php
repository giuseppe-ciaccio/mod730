<?php

class Server_Model_ASPubKey {
	/**
	 * the id of the Authorization Server as seen in the issuer 'iss' parameter of JWT
	 * @var string
	 */
	private $auth_server_id;
	
	/**
	 * the filename of the current authorization server public key
	 * @var string
	 */
	private $pub_key_file;
	
	public function __construct($auth_server_id, $pub_key_file) {
		$this->auth_server_id = $auth_server_id;
		$this->pub_key_file = $pub_key_file;
	}
	
	public function getAuthServerId() {
		return $this->auth_server_id;
	}
	
	public function getPubKeyFile() {
		return $this->pub_key_file;
	}
}

