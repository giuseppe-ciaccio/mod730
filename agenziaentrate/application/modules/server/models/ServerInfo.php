<?php

class Server_Model_ServerInfo {
	/**
	 * 
	 * @var Server_Model_RSInfo
	 */
	private $rs_info;
	
	/**
	 * array of Server_Model_Scope
	 * @var array
	 */
	private $available_scopes;
	
	/**
	 * array of Server_Model_ASPubKey
	 * @var array
	 */
	private $as_pubkeys;
	
	public function __construct() {
		$rs_info_mapper = new Server_Mapper_RSInfo();
		$this->rs_info = $rs_info_mapper->getCurrentRSInfo();
		$as_pubkey_mapper = new Server_Mapper_ASPubKey();
		$this->as_pubkeys = $as_pubkey_mapper->fetchAll();
	}
	
	/**
	 * returns the key to deciphre the JWE
	 * @return string|null
	 */
	public function getSharedSecretKey() {
		return $this->rs_info == null ? null : $this->rs_info->getSharedSecredKey();
	}
	
	/**
	 * 
	 * @return NULL|string current server id
	 */
	public function getId() {
		return $this->rs_info == null ? null : $this->rs_info->getId();
	}
	
// 	/**
// 	 * 
// 	 * @return array of Server_Model_Scope
// 	 */
// 	public function getScopes() {
// 		return $this->available_scopes;
// 	}
	
// 	/**
// 	 * 
// 	 * @param string $scope
// 	 * @return boolean
// 	 */
// 	public function hasScope($scope) {
// 		foreach ($this->available_scopes as $s)
// 			if ($s->getScope() == $scope)
// 				return true;
// 		return false;
// 	}
	
	/**
	 * array of Server_ModelASPubKey
	 * @return array
	 */
	public function getASPubKeys() {
		return $this->as_pubkeys;
	}
	
	/**
	 * 
	 * @param string $as the authorization server identifier
	 * @return NULL|string the path to the publik key file
	 * (relative path or absolute path)
	 */
	public function getPubKeyFile($as) {
		foreach ($this->as_pubkeys as $as_pubkey)
			if ($as_pubkey->getAuthServerId() == $as)
				return $as_pubkey->getPubKeyFile();
		return null;
	}
	
	public function getDescription() {
		return $this->rs_info->getDescription();
	}


}
