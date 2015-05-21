<?php

// TODO: questa dovrebbe sparire -- vedi appresso
class Server_Model_DataServerInstantiationException extends Exception {
	
}

class Server_Model_DataServer {
	
	/**
	 * this array contains the association between the 
	 * resource server identifier and the actual module 
	 * to instantiate
	 * @var array
	 */
// TODO: cos'e' sta schifezza qui?
// lo id. del RS (che dev'essere lo stesso noto ad AS)
// e' gia' definito in scripts/rs.data.mysql.sql
// l'associazione tra questo e il modello dati dello specifico RS
// dovrebbe essere definita in config.ini
	private static $SERVER_TYPES = array('comune_rs_id' => 'Comune_Model_Dati',
										 'agenziaentrate_rs_id' => 'Agenziaentrate_Model_Dati',
										 'agterritorio_rs_id' => 'Agenziaterritorio_Model_Dati');
	
	public function __construct() {
		
	}
	
	/**
	 * 
	 * @param array $scopes strings representing required data scopes
	 * @param string $subj id. of the resource owner as known in this RS
	 * @return Server_DataServer_ServerInterface
	 * @throws SubjectNotPresentException if resource owner unknown in RS
	 * @throws InvalidScopeException if some scopes are not supported in RS
	 * @throws Server_Model_DataServerInstantiationException
	 */
	public static function getCurrentDataServer($scopes, $subj) {
		$s = new Server_Model_ServerInfo();
// TODO: questo controllo dovrebbe sparire, o quantomeno essere modificato.
// l'associazione tra lo id. del RS e il modello dati del RS
// dovrebbe essere definita in config.ini
		if (!array_key_exists($s->getId(), self::$SERVER_TYPES))
			throw new Server_Model_DataServerInstantiationException();
		return new self::$SERVER_TYPES[$s->getId()]($scopes, $subj);
	}
}
