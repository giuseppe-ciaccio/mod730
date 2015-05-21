<?php

class Oauth2_Model_TokenPartException extends Oauth2_Model_Exception {}

class Oauth2_Model_TokenPart {
	/*
	 * CONSTANTS to decode token parts ==================================
	 */
	
	/**
	 * oauthwo params
	 * @var string
	 */
	private static $SCOPES_PARAM = 'scopes';
	/**
	 * 
	 * @var string
	 */
	private static $TOKEN_PORTION_PARAM = 'token_portion';
	/**
	 * 
	 * @var string
	 */
	private static $SCOPES_DELIMITER = ' ';
	
	/*
	 * ===================================================================
	 */
	
	/**
	 * the endpoint where to contact the resource server
	 * @var string
	 */
	private $rs_uri;
	
	/**
	 * the scopes granted by this token
	 * @var array[int]string
	 */
	private $scopes;
	
	/**
	 * the token which must be presented to the resource server uri
	 * @var string
	 */
	private $token_part;
	
	
	/*
	 * Constructors ======================================================
	 */
	
	/**
	 * parse $access_data to populate the object
	 * @param string $rs_uri
	 *	the uri where to spend the $access_data
	 * @param array $access_data
	 *	array of information to be used at resource server with $rs_uri
	 * @throws Oauth2_Model_TokenPartException
	 *	if some parameter does not exist or its value is empty
	 */
	public function __construct($rs_uri, $access_data) {
		if (empty($rs_uri) || !is_array($access_data))
			throw new Oauth2_Model_TokenPartException('the params are not valid');
	
		if (!key_exists(self::$SCOPES_PARAM, $access_data) ||
			empty($access_data[self::$SCOPES_PARAM]) ||
			!key_exists(self::$TOKEN_PORTION_PARAM, $access_data) ||
			empty($access_data[self::$TOKEN_PORTION_PARAM]))
			throw new Oauth2_Model_TokenPartException('the params does not exist or the values are empty');
	
		$this->rs_uri = $rs_uri;
		$this->scopes = explode(self::$SCOPES_DELIMITER, $access_data[self::$SCOPES_PARAM]);
		$this->token_part = $access_data[self::$TOKEN_PORTION_PARAM];
	}
	
	/*
	 * Getters ===========================================================
	 */
	
	/**
	 * the uri to contact to get the information
	 * @return string
	 */
	public function getContactUri() {
		return $this->rs_uri;
	}
	
	/**
	 * the scopes granted by this token part
	 * @return array[int]string
	 */
	public function getScopes() {
		return $this->scopes;
	}
	
	/**
	 * the token that can be spent at resource server
	 * @return string
	 */
	public function getTokenPart() {
		return $this->token_part;
	}
	
	/*
	 * ===================================================================
	 */

	/**
	 * 
	 * @param string $str
	 *	base64 encoded string representing the token
	 * @throws Oauth2_Model_TokenPartException
	 *	if the $str does not represent valid token parts.
	 * @return array[int]Oauth2_Model_TokenPart
	 *	the array of all tokens packed in the $str
	 */
	public static function getTokenParts($str) {
		$tokenparts = array();
		
		$content = json_decode(base64_decode($str), true);
		if ($content == null || !is_array($content))
			throw new Oauth2_Model_TokenPartException('cannot decode the token part');
		
		foreach ($content as $rs_uri => $access_data)
			$tokenparts[] = new Oauth2_Model_TokenPart($rs_uri, $access_data);
		
		return $tokenparts;
		
	}
}

