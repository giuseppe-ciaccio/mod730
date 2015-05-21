<?php


/*
 * This class represents the config infos of the Resource Server (RS),
 * coming from .ini files as well as db tables (via Mappers/DbTables):
 *
 * -) id., description and shared secret of the RS,
 * -) pubkeys of known Authorization Servers,
 * -) available resource sets and scopes (TODO).
 */

class Server_Model_ServerInfo {

	/**
	 * Resource server name.
	 * @var string
	 */
	private $name;
	
	/**
	 * Encryption key shared with the AS.
	 * Tokens are encrypted with this.
	 * @var string
	 */
	private $shared_secret_key;
	
	/**
	 * Resource server description.
	 * @var string
	 */
	private $description;

	/**
	 * id of the AS recognized by this RS,
	 * to be expected in the 'iss' field of access token (in JWT format)
	 * @var string
	 */
	private $as_name;

	/**
	 * Where to find the AS public key
	 * @var string
	 */
	private $as_pubkey_path;

	
	public function __construct() {
		$config = new Zend_Config_Ini(realpath(
			APPLICATION_PATH . '/configs/application.ini'),
			'production');
		$this->name = $config->rs->name;
		$this->shared_secret_key =
			pack('H*',$config->rs->sharedsecret);
		$this->description = $config->rs->description;
		$this->as_name = $config->as->name;
		$this->as_pubkey_path = $config->as->pubkey->path;
	}
	
	public function getId() {
		return $this->name;
	}

	public function getSharedSecretKey() {
		return $this->shared_secret_key;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getAS() {
		return $this->as_name;
	}

	/**
	 * 
	 * @param string $as the AS identifier
	 * @return NULL|string the full path to the public key of that AS
	 * TODO: per ora un solo AS ma in generale si prevede piu' di uno,
	 * ecco perche' esiste questa funzione di mapping name->pubkey
	 */
	public function getPubKeyFile($as) {
		if ($this->as_name == $as)
			return $this->as_pubkey_path;
		return null;
	}

}
