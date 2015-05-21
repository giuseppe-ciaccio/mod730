<?php

class Server_Model_RSInfo {
	/**
	 * the current resource server id.
	 * depending on this id there will be instantiated the 
	 * specific module that will deal with data
	 * @var string
	 */
	private $id;
	
	/**
	 * the key shared with all the Authorization Servers. 
	 * The token is ciphred using this key.
	 * @var string
	 */
	private $shared_secret_key;
	
	/**
	 * the current resource server description. actually it is not used anywhere
	 * @var string
	 */
	private $description;
	
	public function __construct($id, $shared_secred_key, $description) {
		$this->id = $id;
		$this->shared_secret_key = $shared_secred_key;
		$this->description = $description;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getSharedSecredKey() {
		return $this->shared_secret_key;
	}
}

