<?php


require_once dirname(__FILE__).'/DataControllerTestAbstract.php';
class DataControllerTestInvalidToken extends DataControllerTestAbstract {
	/**
	 * rfc 6750 section 3.1. Error codes
	 *
	 * When a request fails, the resource server responds using the appropiate
	 * HTTP status code (typically, 400, 401, 403, or 405) and includes one of
	 * the following error codes in the response:
	 *
	 * ....
	 * invalid_token
	 * 		The access token provided is expired, revoked, malformed, or
	 * 		invalid for other reasons. The resource server SHOULD respond
	 * 		with the HTTP 401 (Unauthorized) status code. The client MAY
	 * 		request a new access token and retry the protected resource
	 * 		request.
	 * ....
	 *
	 */
	protected function genericRequestWithInvalidTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array()) {
		$this->set_request_params($method, $rest_params, $query_params, $post_params);

		$this->getRequest()->setHeader(self::$REQUEST_HEADER, self::$AUTHENTICATION_SCHEME.' '.$token);
		$this->dispatch('/server/data');
		 
		$this->assertModule('server');
		$this->assertController('data');
		$this->assertAction('error');
		$this->assertResponseCode(self::$RESPONSE_ERROR_INVALID_TOKEN_HTTP_STATUS_CODE);
		$this->assertHeader(self::$RESPONSE_HEADER);
	
		$header_content = $this->getAllHeaders();
		$header_content = $header_content[self::$RESPONSE_HEADER];
		 
		$this->check_auth_scheme_populate_params($header_content);
	
		$this->assertEquals(1, $this->response_param_recieved[self::$RESPONSE_REALM_PARAM]['count'],
				'The header "'.self::$RESPONSE_REALM_PARAM.'" must be present.');
		//TODO must check the value of realm param
		//     	$this->assertEquals('expected parameter value', $this->response_param_recieved[self::$RESPONSE_REALM_PARAM]['value'],
		//     			'The header "'.self::$RESPONSE_REALM_PARAM.'" value must be...');
	
		$this->assertEquals(1, $this->response_param_recieved[self::$RESPONSE_ERROR_PARAM]['count'],
				'The header "'.self::$RESPONSE_ERROR_PARAM.'" must be present.');
		$this->assertEquals(self::$RESPONSE_ERROR_INVALID_TOKEN, $this->response_param_recieved[self::$RESPONSE_ERROR_PARAM]['value']);
		 
		/* there could be also an error description... but since this is programmatic use only... I skip it */
		$this->assertEquals(1, $this->response_param_recieved[self::$RESPONSE_ERROR_DESCRIPTION_PARAM]['count'],
				'The header "'.self::$RESPONSE_ERROR_DESCRIPTION_PARAM.'" must NOT be present.');
	}
	
	
	
	/*
	 * TODO
	* c'e la possibilità di fare descrizioni più belle usando annotazioni @testdox http://www.phpunit.de/manual/3.7/en/appendixes.annotations.html#appendixes.annotations.group
	* oppure fare una trasformazione xml: http://stackoverflow.com/questions/4733972/how-to-get-detailed-test-info-from-phpunit-testdox
	*/
}