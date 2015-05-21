<?php

class Oauth2_Model_TokenException extends Oauth2_Model_Exception {}

class Oauth2_Model_Token {
	/*
	 * TOKEN RESPONSE CONSTANTS
	 */
	
	/**
	 * rfc 6749 section 5.1. Successful Response
	 * @var string
	 */
	private static $EXPIRES_IN_PARAM = 'expires_in';
	/**
	 * rfc 6749 section 5.1. Successful Response
	 * @var string
	 */
	private static $REFRESH_TOKEN_PARAM = 'refresh_token';
	/**
	 * rfc 6749 section 5.1. Successful Response
	 * @var string
	 */
	private static $ACCESS_TOKEN_PARAM = 'access_token';
	/**
	 * rfc 6749 section 5.1. Successful Response
	 * @var string
	 */
	private static $TOKEN_TYPE_PARAM = 'token_type';
	/**
	 * rfc 6749 section 5.1. Successful Response
	 * @var string
	 */
	private static $SCOPE_PARAM = 'scope';
	
	
	private static $TOKEN_TYPE_VALUE = 'bearer';
	
	/*
	 * ===================================================================
	 */
	
	/**
	 * rfc 6749 section 5.1. Successful Response
	 * the lifetime in seconds of the access token.
	 * for example, the value 3600 denotes that the access
	 * token will expire in one hour from the time 
	 * the response was generated.
	 * @var int
	 */
	private $expires_in;
	
	/**
	 * rfc 6749 section 5.1. Successful Response
	 * the refresh token, which can be used to obtain new 
	 * access tokens using the same authorization grant as 
	 * described in Section 6.
	 * @var string
	 */
	private $refresh_token;
	
	/**
	 * unix timestamp when the token was issued
	 * @var int
	 */
	private $issued_time;
	
	/**
	 * 
	 * @var array[int]Oauth2_Model_TokenPart
	 */
	private $token_parts;
	
	/**
	 * the authorization server's uri that issued the current token
	 * @var string
	 */
	private $issuer_uri;
	
	
	/*
	 * CONSTRUCTORS ======================================================
	 */
	
	/**
	 * parse the string to extract a token issued by Oauthwo AS.
	 * @param string $str the base64 encoded string representing the token
	 * @throws Oauth2_Model_TokenException
	 *	if some params are not present or invalid
	 * @throws Oauth2_Model_TokenPartException
	 *	if some token part is malformed
	 */
	public function __construct($issuer_uri, $str) {
		$content = json_decode($str, true);
		
		if ($content == null || !is_array($content))
			throw new Oauth2_Model_TokenException('json cannot decode');
		
		if (!array_key_exists(self::$ACCESS_TOKEN_PARAM, $content) ||
			!array_key_exists(self::$TOKEN_TYPE_PARAM, $content) ||
			!array_key_exists(self::$EXPIRES_IN_PARAM, $content) ||
			!array_key_exists(self::$REFRESH_TOKEN_PARAM, $content))
			throw new Oauth2_Model_TokenException('some params are not present');
		
		if ($content[self::$TOKEN_TYPE_PARAM] != self::$TOKEN_TYPE_VALUE)
			throw new Oauth2_Model_TokenException('the token type is not bearer');
		
		$this->expires_in = $content[self::$EXPIRES_IN_PARAM];
		$this->refresh_token = $content[self::$REFRESH_TOKEN_PARAM];
		$this->issued_time = time();
		$this->issuer_uri = $issuer_uri;
		
		$this->token_parts = Oauth2_Model_TokenPart::getTokenParts($content[self::$ACCESS_TOKEN_PARAM]);
	}
	
	/*
	 * ===================================================================
	 */
	
	/**
	 * 
	 * @return boolean true if the token is expired, false otherwise
	 */
	public function isExpired() {
		return time() - $this->issued_time > $this->expires_in;
	}
	
	/**
	 * the token to be spent to the authorization server to get a new token
	 * @return string
	 */
	public function getRefreshToken() {
		return $this->refresh_token;
	}
	
	/**
	 * the authorization server uri that issued the current token
	 * @return string
	 */
	public function getIssuerTokenEndpointUri() {
		return $this->issuer_uri;
	}
	
	/**
	 * 
	 * @return array[int]Oauth2_Model_TokenPart the current token parts
	 */
	public function getTokenParts() {
		return $this->token_parts;
	}
	
	/**
	 * 
	 * @param string $scope
	 * @return NULL|Oauth2_Model_TokenPart
	 */
	public function getTokenPart($scope) {
		if (empty($scope) || !is_string($scope))
			return null;
		
		foreach ($this->token_parts as $tp)
			if (array_search($scope, $tp->getScopes()))
				return $tp;
		
		return null;
	}

}
