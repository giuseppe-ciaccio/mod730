<?php

class Server_Model_DataServerInstantiationException extends Exception {
	
}

class Server_Model_DataServer {
	
	/**
	 * this array contains the association between the 
	 * resource server identifier and the actual module 
	 * to instantiate
	 * @var array
	 */
	private static $SERVER_TYPES = array('comune_rs_id' => 'Comune_Model_Dati',
										 'agenziaentrate_rs_id' => 'Agenziaentrate_Model_Dati',
										 'agterritorio_rs_id' => 'Agenziaterritorio_Model_Dati');
	
	public function __construct() {
		
	}
	
	/**
	 * 
	 * @param array $scopes array of string representing the current granted scopes
	 * @param string $subj representing the owner of data to deal with
	 * 
	 * @return Server_DataServer_ServerInterface
	 * 
	 * @throws SubjectNotPresentException if the subj is not present in the current server
	 * @throws InvalidScopeException if the $scopes contains scopes tha are not present in the current instace
	 * @throws Server_Model_DataServerInstantiationException
	 */
	public static function getCurrentDataServer($scopes, $subj) {
		$s = new Server_Model_ServerInfo();
		
		if (!array_key_exists($s->getId(), self::$SERVER_TYPES))
			throw new Server_Model_DataServerInstantiationException();
		
		return new self::$SERVER_TYPES[$s->getId()]($scopes, $subj);
	}
}

