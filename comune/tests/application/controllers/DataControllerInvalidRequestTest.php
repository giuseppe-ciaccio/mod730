<?php


require_once dirname(__FILE__).'/DataControllerTestAbstract.php';

class DataControllerInvalidRequestTest extends DataControllerTestAbstract {

	/**
	 * When a request fails, the resource server responds using the appropriate
	 * HTTP status code (typically, 400, 401, 403, or 405) and includes one of
	 * the following error codes in the response:
	 *
	 * ...
	 * invalid_request
	 * 		The request is missing a required parameter, includes an unsupported
	 * 		parameter, uses more than one method for including an access token,
	 * 		or it is otherwise malformed (NOTE: I understand that the request
	 * 		is malformed)
	 * ...
	 *
	 * @param string $method
	 * @param string $token
	 * @param array $rest_params
	 * @param array $query_params
	 * @param array $post_params
	 */
	private function genericRequestWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array()) {
		$this->set_request_params($method, $rest_params, $query_params, $post_params);
		
		$this->getRequest()->setHeader(self::$REQUEST_HEADER, self::$AUTHENTICATION_SCHEME.' '.$token);

		$this->dispatch('/server/data');
		
		$this->assertModule('server');
		$this->assertController('data');
		$this->assertAction('error');
		
		$this->assertResponseCode(self::$RESPONSE_ERROR_INVALID_REQUEST_HTTP_STATUS_CODE);
		$this->assertHeader(self::$RESPONSE_HEADER);
		
		$header_content = $this->getAllHeaders();
		$header_content = $header_content[self::$RESPONSE_HEADER];

		$this->check_auth_scheme_populate_params($header_content);
		
		$this->assertEquals(1, $this->response_param_recieved[self::$RESPONSE_REALM_PARAM]['count'],
				'The header "'.self::$RESPONSE_REALM_PARAM.'" must be present.');
//     	$this->assertEquals('expected parameter value', $this->response_param_recieved[self::$RESPONSE_REALM_PARAM]['value'],
//     			'The header "'.self::$RESPONSE_REALM_PARAM.'" value must be...');
		
		$this->assertEquals(1, $this->response_param_recieved[self::$RESPONSE_ERROR_PARAM]['count'],
				'The header "'.self::$RESPONSE_ERROR_PARAM.'" must be present.');
		$this->assertEquals(self::$RESPONSE_ERROR_INVALID_REQUEST, $this->response_param_recieved[self::$RESPONSE_ERROR_PARAM]['value']);

		/* there could be also an error description... but since this is programmatic use only... I skip it */
		$this->assertEquals(1, $this->response_param_recieved[self::$RESPONSE_ERROR_DESCRIPTION_PARAM]['count'],
				'The header "'.self::$RESPONSE_ERROR_DESCRIPTION_PARAM.'" must NOT be present.');
	
	}

	/**
	 * see doc of private function genericRequestWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * asserting the error that the token was included in more than once
	 * @param unknown_type $method
	 * @param unknown_type $token
	 * @param unknown_type $rest_params
	 * @param unknown_type $query_params
	 * @param unknown_type $post_params
	 */
	private function genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array()) {
		$this->genericRequestWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params, $query_params, $post_params);
		
		$this->assertRegExp('/E1/', $this->response_param_recieved[self::$RESPONSE_ERROR_DESCRIPTION_PARAM]['value']);
	}
	
	/**
	 * see doc of genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method and using the Authorization Header and Query Param to
	 * include the token, no other parameters included
	 */
	public function testRequestWithGetMethodWithoutParametersAndUsingAuthHeaderAndQueryParamToIncludeTokenReturnsInvalidRequestError() {
		$token = 'itDoesNotMatterWhatTokenToPut';
		$rest_params = array();
		$query_params = array(self::$ACCESS_TOKEN_PARAM => $token);
		$post_params = array();

		$this->genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError(Zend_Http_Client::GET,
				$token,
				$rest_params,
				$query_params,
				$post_params);
	}
	
	/**
	 * see doc of genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method and using the Authorization Header and Query Param to
	 * include the token, no other parameters included
	 */
	public function testRequestWithPostMethodWithoutParametersAndUsingAuthHeaderAndQueryParamToIncludeTokenReturnsInvalidRequestError() {
		$token = 'itDoesNotMatterWhatTokenToPut';
		$rest_params = array();
		$query_params = array(self::$ACCESS_TOKEN_PARAM => $token);
		$post_params = array();
	
		$this->genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError(Zend_Http_Client::POST,
				$token,
				$rest_params,
				$query_params,
				$post_params);
	}
	
	/**
	 * see doc of genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method and using the Authorization Header and Query Param to
	 * include the token, no other parameters included
	 */
	public function testRequestWithPutMethodWithoutParametersAndUsingAuthHeaderAndQueryParamToIncludeTokenReturnsInvalidRequestError() {
		$token = 'itDoesNotMatterWhatTokenToPut';
		$rest_params = array();
		$query_params = array(self::$ACCESS_TOKEN_PARAM => $token);
		$post_params = array();
	
		$this->genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError(Zend_Http_Client::PUT,
				$token,
				$rest_params,
				$query_params,
				$post_params);
	}
	
	/**
	 * see doc of genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method and using the Authorization Header and Query Param to
	 * include the token, no other parameters included
	 */
	public function testRequestWithDeleteMethodWithoutParametersAndUsingAuthHeaderAndQueryParamToIncludeTokenReturnsInvalidRequestError() {
		$token = 'itDoesNotMatterWhatTokenToPut';
		$rest_params = array();
		$query_params = array(self::$ACCESS_TOKEN_PARAM => $token);
		$post_params = array();
	
		$this->genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError(Zend_Http_Client::DELETE,
				$token,
				$rest_params,
				$query_params,
				$post_params);
	}
	
	/**
	 * see doc of genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method and using the Authorization Header and Body Param to
	 * include the token, no other parameters included
	 */
	public function testRequestWithGetMethodWithoutParametersAndUsingAuthHeaderAndBodyParamToIncludeTokenReturnsInvalidRequestError() {
		$token = 'itDoesNotMatterWhatTokenToPut';
		$rest_params = array();
		$query_params = array();
		$post_params = array(self::$ACCESS_TOKEN_PARAM => $token);
	
		$this->genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError(Zend_Http_Client::GET,
				$token,
				$rest_params,
				$query_params,
				$post_params);
	}
	
	/**
	 * see doc of genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method and using the Authorization Header and Body Param to
	 * include the token, no other parameters included
	 */
	public function testRequestWithPostMethodWithoutParametersAndUsingAuthHeaderAndBodyParamToIncludeTokenReturnsInvalidRequestError() {
		$token = 'itDoesNotMatterWhatTokenToPut';
		$rest_params = array();
		$query_params = array();
		$post_params = array(self::$ACCESS_TOKEN_PARAM => $token);
	
		$this->genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError(Zend_Http_Client::POST,
				$token,
				$rest_params,
				$query_params,
				$post_params);
	}
	
	/**
	 * see doc of genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method and using the Authorization Header and Body Param to
	 * include the token, no other parameters included
	 */
	public function testRequestWithPutMethodWithoutParametersAndUsingAuthHeaderAndBodyParamToIncludeTokenReturnsInvalidRequestError() {
		$token = 'itDoesNotMatterWhatTokenToPut';
		$rest_params = array();
		$query_params = array();
		$post_params = array(self::$ACCESS_TOKEN_PARAM => $token);
	
		$this->genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError(Zend_Http_Client::PUT,
				$token,
				$rest_params,
				$query_params,
				$post_params);
	}
	
	/**
	 * see doc of genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method and using the Authorization Header and Body Param to
	 * include the token, no other parameters included
	 */
	public function testRequestWithDeleteMethodWithoutParametersAndUsingAuthHeaderAndBodyParamToIncludeTokenReturnsInvalidRequestError() {
		$token = 'itDoesNotMatterWhatTokenToPut';
		$rest_params = array();
		$query_params = array();
		$post_params = array(self::$ACCESS_TOKEN_PARAM => $token);
	
		$this->genericRequestIncludingTokenWithMultipleMethodsReturnsInvalidRequestError(Zend_Http_Client::DELETE,
				$token,
				$rest_params,
				$query_params,
				$post_params);
	}

	/*
	 * TODO testRequestWithMETHODMethodWITHParametersAndUsingAuthHeaderAndBODY/QUERYParamToIncludeTokenReturnsInvalidRequestError
	* e variazioni sul tema
	*/

	/*
	 * TODO
	* c'e la possibilità di fare descrizioni più belle usando annotazioni @testdox http://www.phpunit.de/manual/3.7/en/appendixes.annotations.html#appendixes.annotations.group
	* oppure fare una trasformazione xml: http://stackoverflow.com/questions/4733972/how-to-get-detailed-test-info-from-phpunit-testdox
	*/
	
}