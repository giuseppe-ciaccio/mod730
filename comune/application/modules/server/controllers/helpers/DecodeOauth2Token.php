<?php

class IncorrectSignatureException extends Exception {}
class JWEException extends Exception {}
class JWSException extends Exception {}
class JWTException extends Exception {}
class CannotCheckSignatureException extends Exception {}


class Server_Controller_Action_Helper_DecodeOauth2Token extends Zend_Controller_Action_Helper_Abstract {

	private static $ENCODED_CHUNKS_SEPARATOR = '.';

	/*
	 * JWE CONSTANTS
	 */
	//JWE chunks
	private static $JWE_COMPONENTS_COUNT = 3;
	private static $JWE_HEADER_INDEX = 0;
	private static $JWE_ENCRYPTED_KEY_INDEX = 1;
	private static $JWE_CIPHERTEXT_INDEX = 2;
	//in this specific implementation the key chunk is not used
	private static $JWE_ENCRYPTED_KEY = '';

	//JWE header fields
	private static $JWE_HEADER_COMPONENTS_COUNT = 4;
	private static $JWE_HEADER_ALGORITHM_PARAM = 'alg';
	private static $JWE_HEADER_ALGORITHM_PARAM_VALUE = 'dir';
	private static $JWE_HEADER_ENCRYPTION_PARAM = 'enc';
	private static $JWE_HEADER_ENCRYPTION_PARAM_VALUE = 'A256CBC';
	private static $JWE_HEADER_TYPE_PARAM = 'typ';
	private static $JWE_HEADER_TYPE_PARAM_VALUE = 'JWT';
	private static $JWE_HEADER_IV_PARAM = 'iv';


	/*
	 * JWS CONSTANTS
	 */
	//JWS chunks
	private static $JWS_COMPONENTS_COUNT = 3;
	private static $JWS_HEADER_INDEX = 0;
	private static $JWS_PAYLOAD_INDEX = 1;
	private static $JWS_SIGNATURE_INDEX = 2;
	
	//JWS header fields
	private static $JWS_HEADER_COMPONENTS_COUNT = 2;
	private static $JWS_HEADER_TYPE_PARAM = 'typ';
	private static $JWS_HEADER_TYPE_PARAM_VALUE = 'JWT';
	private static $JWS_HEADER_ALGORITHM_PARAM = 'alg';	
	private static $JWS_HEADER_ALGORITHM_PARAM_VALUE = 'RS256';


	/*
	 * JWT CONSTANTS
	 */
	//fields of the OAuthwo access token assertions
	private static $JWT_COMPONENTS_COUNT = 4;
	private static $JWT_ISSUER_PARAM = 'iss';
	private static $JWT_EXPIRATION_TIME_PARAM = 'exp';
	private static $JWT_SUBJECT_PARAM = 'prn';
	private static $JWT_SCOPE_PARAM = 'scope';

	private static $SCOPE_SEPARATOR_OAUTHWO = ' ';
	
	
	/**
	 * check the jws header
	 * @param array of strings $header
	 * @return boolean true if the $header is correct, false otherwise
	 */
	private static function is_valid_jws_header($header) {
		if (!is_array($header)
		|| count($header) != self::$JWS_HEADER_COMPONENTS_COUNT)
			return false;
		
		if (!array_key_exists(self::$JWS_HEADER_TYPE_PARAM, $header)
		|| $header[self::$JWS_HEADER_TYPE_PARAM] != self::$JWS_HEADER_TYPE_PARAM_VALUE)
			return false;
		
		if (!array_key_exists(self::$JWS_HEADER_ALGORITHM_PARAM, $header)
		|| $header[self::$JWS_HEADER_ALGORITHM_PARAM] != self::$JWS_HEADER_ALGORITHM_PARAM_VALUE)
			return false;
		
		return true;
	}
	
	/**
	 * check the jwe header
	 * @param array of strings $header
	 * @return boolean true if the $header is correct, false otherwise
	 */
	private static function is_valid_jwe_header($header) {
		if (!is_array($header)
		|| count($header) != self::$JWE_HEADER_COMPONENTS_COUNT)
			return false;
		
		if (!array_key_exists(self::$JWE_HEADER_ALGORITHM_PARAM, $header)
		|| $header[self::$JWE_HEADER_ALGORITHM_PARAM] != self::$JWE_HEADER_ALGORITHM_PARAM_VALUE)
			return false;
		
		if (!array_key_exists(self::$JWE_HEADER_ENCRYPTION_PARAM, $header)
		|| $header[self::$JWE_HEADER_ENCRYPTION_PARAM] != self::$JWE_HEADER_ENCRYPTION_PARAM_VALUE)
			return false;
		
		if (!array_key_exists(self::$JWE_HEADER_TYPE_PARAM, $header)
		|| $header[self::$JWE_HEADER_TYPE_PARAM] != self::$JWE_HEADER_TYPE_PARAM_VALUE)
			return false;
		
		/* the initialization vector must be a non-empty string */;

		if (!array_key_exists(self::$JWE_HEADER_IV_PARAM, $header))
			return false;
		$iv = trim($header[self::$JWE_HEADER_IV_PARAM]);
		if (empty($iv))
			return false;
		
		return true;
	}
	
	/**
	 * check the jwt and if valid return the data
	 * wrapped in Server_Model_Token
	 * @param array $jwt
	 * @return NULL|Server_Model_Token
	 */
	private static function get_token($jwt) {
		if (!is_array($jwt)
		|| count($jwt) != self::$JWT_COMPONENTS_COUNT)
			return null;
		
		if (!array_key_exists(self::$JWT_ISSUER_PARAM, $jwt)
		|| !array_key_exists(self::$JWT_EXPIRATION_TIME_PARAM, $jwt)
		|| !array_key_exists(self::$JWT_SUBJECT_PARAM, $jwt)
		|| !array_key_exists(self::$JWT_SCOPE_PARAM, $jwt))
			return null;
		
		$scopes = explode(self::$SCOPE_SEPARATOR_OAUTHWO, $jwt[self::$JWT_SCOPE_PARAM]);
		return new Server_Model_Token($jwt[self::$JWT_ISSUER_PARAM],
			  $jwt[self::$JWT_EXPIRATION_TIME_PARAM], 
			  $jwt[self::$JWT_SUBJECT_PARAM],
			  $scopes);
	}
	
	/**
	 * 
	 * @param string $content the content to check the signature
	 * @param string $content_signature the signature of $content
	 * @param string $cert_location the path to the certificate file with which to sign the $content
	 * @return 1 if $content_signature is the signature of $content with certificate $cert_location;
	 * 	  0 if the $content_signature is NOT the signature of $content with certificate $cert_location;
	 * 	 -1 if there was an error during the check of signature.
	 */
	private static function check_signature($content, $content_signature, $cert_location) {
		$fp = fopen($cert_location, "r");
		
		if ($fp == false)
			return -1;
		
		$pub_key = fread($fp, 8192);
		
		if ($pub_key == false || fclose($fp) == false)
			return -1;
		
		$pubkeyid = openssl_get_publickey($pub_key);
		$ok = openssl_verify($content, $content_signature, $pubkeyid, "sha256");
		openssl_free_key($pubkeyid);
		
		return $ok;
	}
	
	
	/**
	 * Take in input a string encoding a JWE. If the 
	 * token contained in JWE is authentic and valid this
	 * function returns the token.
	 * @param string $base64token input string encoding the JWE as defined 
	 * by http://tools.ietf.org/html/draft-ietf-jose-json-web-encryption-08
	 * @param Server_Model_ServerInfo $server_info this RS information
	 * @throws JWEException if there's something not conformant to
	 * http://tools.ietf.org/html/draft-ietf-jose-json-web-encryption-08
	 * @throws JWSException if there's something not conformant to
	 * http://tools.ietf.org/html/draft-ietf-jose-json-web-signature-08
	 * @throws JWTException if there's something not conformant to
	 * http://tools.ietf.org/html/draft-ietf-oauth-json-web-token-06
	 * @throws IncorrectSignatureException if the token is not authentic
	 * @throws CannotCheckSignatureException if there occured an error during the check of signature.
	 * error like the certificate file does not exists, etc.
	 * @return Server_Model_Token
	 */

	function direct($raw_token_data, $server_info) {

		/*
		 * JSON Web Encryption checks
		 */

		$jwe = explode(self::$ENCODED_CHUNKS_SEPARATOR, $raw_token_data);
		if (count($jwe) != self::$JWE_COMPONENTS_COUNT)
			throw new JWEException();
		
		$jwe_header = json_decode(base64_decode($jwe[self::$JWE_HEADER_INDEX]), true);
		if ($jwe_header == null)
			throw new JWEException();

		$jwe_key = $jwe[self::$JWE_ENCRYPTED_KEY_INDEX];
		if ($jwe_key != self::$JWE_ENCRYPTED_KEY)
			throw new JWEException();
		
		$jwe_ciphertext = base64_decode($jwe[self::$JWE_CIPHERTEXT_INDEX]);
		if ($jwe_ciphertext == false)
			throw new JWEException();
		
		if (!self::is_valid_jwe_header($jwe_header))
			throw new JWEException();		
		
		/*
		 * JSON Web Signature checks
		 */

		$iv = base64_decode($jwe_header[self::$JWE_HEADER_IV_PARAM]);
		$encoded_jws = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $server_info->getSharedSecretKey(), $jwe_ciphertext, MCRYPT_MODE_CBC, $iv);
		
		$jws = explode(self::$ENCODED_CHUNKS_SEPARATOR, $encoded_jws);
		
		if (count($jws) != self::$JWS_COMPONENTS_COUNT)
			throw new JWSException();
		
		$jws_header = json_decode(base64_decode($jws[self::$JWS_HEADER_INDEX]), true);
		if ($jws_header == null)
			throw new JWSException();
		
		if (!self::is_valid_jws_header($jws_header))
			throw new JWSException();
		
		$jws_payload = json_decode(base64_decode($jws[self::$JWS_PAYLOAD_INDEX]), true);
		if ($jws_payload == null)
			throw new JWSException();
		
		$jws_signature = base64_decode($jws[self::$JWS_SIGNATURE_INDEX]);
		if ($jws_signature == false)
			throw new JWSException();

		$token = self::get_token($jws_payload);
		if ($token == null)
			throw new JWTException();
		
		$signature_result = self::check_signature(
			$jws[self::$JWS_HEADER_INDEX]
			. self::$ENCODED_CHUNKS_SEPARATOR
			. $jws[self::$JWS_PAYLOAD_INDEX],
			$jws_signature,
			$server_info->getPubKeyFile($token->get_issuer())
		);
		if ($signature_result == 0)
			throw new IncorrectSignatureException();
		if ($signature_result == -1)
			throw new CannotCheckSignatureException();
		
		return $token;

	}

}
