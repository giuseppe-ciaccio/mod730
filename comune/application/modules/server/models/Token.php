<?php

class Server_Model_Token {
	/**
	 * the name of authorization server that issued the token
	 * @var string
	 */
	private $tokenIssuer;
	/**
	 * the expiration time stamp, in sense that the token is not valid before this expiration time stamp.
	 * @var int
	 */
	private $expirationTimeStamp;
	/**
	 * the onwer of the resources being accesed using the current token
	 * @var string
	 */
	private $resourceOwner;
	/**
	 * the scopes granted by the current token.
	 * @var array of string
	 */
	private $scopes;
	
	/**
	 * 
	 * @param string $tokenIssuer represents the token issuer 
	 * @param number $expirationTimeStamp represents the validity timestamp in the sens that the token is valid until $expirationTimeStamp
	 * @param string $resourceOwner the owner of resources that can be released by presenting this token
	 * @param array_of_strings $scopes the specific resources that can be released
	 */
	function __construct($tokenIssuer, $expirationTimeStamp, $resourceOwner, $scopes) {
		$this->tokenIssuer = $tokenIssuer;
		$this->expirationTimeStamp = $expirationTimeStamp;
		$this->resourceOwner = $resourceOwner;
		$this->scopes = array_merge($scopes);
	}
	
	/**
	 * @return string representing the authorization 
	 * 					server issued the token
	 */
	public function get_issuer() {
		return $this->tokenIssuer;
	}
	
	/**
	 * @return number representing the time before the 
	 * 					token is not valid anymore
	 */
	public function get_exp_timestamp() {
		return $this->expirationTimeStamp;
	}
	
	/**
	 * @return string representing the owner of resources 
	 * 					that can be accessed by the current token
	 */
	public function get_subject() {
		return $this->resourceOwner;
	}
	
	/**
	 * 
	 * @return array of string representing the scopes granted by 
	 * 							the current token
	 */
	public function get_scopes() {
		return $this->scopes;
	}
}