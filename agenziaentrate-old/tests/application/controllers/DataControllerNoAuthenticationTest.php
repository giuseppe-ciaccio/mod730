<?php

require_once dirname(__FILE__).'/DataControllerTestAbstract.php';

class DataControllerNoAuthenticationTest extends DataControllerTestAbstract {
	/**
	 * as of rfc 6750 section 3. The WWW-Authenticate Response Header Field
	 *
	 * If the protected resource request does not include authentication
	 * credentials... the resource server MUST include the
	 * HTTP "WWW-Authenticate" ....
	 *
	 * and from rfc 6750 section 3.1. Error Codes
	 *
	 * If the request lacks any authentication information
	 * (e.g., the client was unaware that authentication is necessary
	 * or attempted using an unsupported authentication method), the
	 * resource server SHOULD NOT include an error code or other error
	 * information.
	 */
	public function genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array()) {
    	$this->set_request_params($method, $rest_params, $query_params, $post_params);
    	
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
    	//     	$this->assertEquals('expected parameter value', $this->response_param_recieved[self::$RESPONSE_REALM_PARAM]['value'],
    	//     			'The header "'.self::$RESPONSE_REALM_PARAM.'" value must be...');
    	 
    	$this->assertEquals(0, $this->response_param_recieved[self::$RESPONSE_ERROR_PARAM]['count'],
    			'The header "'.self::$RESPONSE_ERROR_PARAM.'" must NOT be present.');
    	$this->assertEquals(0, $this->response_param_recieved[self::$RESPONSE_ERROR_DESCRIPTION_PARAM]['count'],
    			'The header "'.self::$RESPONSE_ERROR_DESCRIPTION_PARAM.'" must NOT be present.');
    	$this->assertEquals(0, $this->response_param_recieved[self::$RESPONSE_ERROR_URI_PARAM]['count'],
    			'The header "'.self::$RESPONSE_ERROR_URI_PARAM.'" must NOT be present.');
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the GET http method with no parameters
     */
    public function testRequestWithGetMethodWithoutAuthenticationAndWithoutRestParametersReturnsGenericError()
    {
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::GET);    	
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the POST http method with no parameters
     */
    public function testRequestWithPostMethodWithoutAuthenticationAndWithoutRestParametersReturnsGenericError()
    {
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::POST);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the PUT http method with no parameters
     */
    public function testRequestWithPutMethodWithoutAuthenticationAndWithoutRestParametersReturnsGenericError()
    {
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::PUT);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the DELETE http method with no parameters
     */    
    public function testRequestWithDeleteMethodWithoutAuthenticationAndWithoutRestParametersReturnsGenericError()
    {
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::DELETE);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the GET http method with rest style parameters
     */
    public function testRequestWithGetMethodAndWithRestParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array('par1' => 'val_par1',
    						'par2' => 'val_par2');
    	$query_params = array();
    	$post_params = array();
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::GET, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the POST http method with rest style parameters
     */
    public function testRequestWithPostMethodAndWithRestParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array('par1' => 'val_par1',
    						'par2' => 'val_par2');
    	$query_params = array();
    	$post_params = array();
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::POST, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the PUT http method with rest style parameters
     */
    public function testRequestWithPutMethodAndWithRestParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array('par1' => 'val_par1',
    						'par2' => 'val_par2');
    	$query_params = array();
    	$post_params = array();
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::PUT, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the DELETE http method with rest style parameters
     */
    public function testRequestWithDeleteMethodAndWithRestParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array('par1' => 'val_par1',
    						'par2' => 'val_par2');
    	$query_params = array();
    	$post_params = array();
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::DELETE, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the GET http method with query parameters
     */
    public function testRequestWithGetMethodAndWithQueryParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array();
    	$query_params = array('par1' => 'val_par1',
    			'par2' => 'val_par2');
    	$post_params = array();
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::GET, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the POST http method with query parameters
     */
    public function testRequestWithPostMethodAndWithQueryParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array();
    	$query_params = array('par1' => 'val_par1',
    			'par2' => 'val_par2');
    	$post_params = array();
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::POST, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the PUT http method with query parameters
     */
    public function testRequestWithPutMethodAndWithQueryParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array();
    	$query_params = array('par1' => 'val_par1',
    			'par2' => 'val_par2');
    	$post_params = array();
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::PUT, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the DELETE http method with query parameters
     */
    public function testRequestWithDeleteMethodAndWithQueryParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array();
    	$query_params = array('par1' => 'val_par1',
    			'par2' => 'val_par2');
    	$post_params = array();
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::DELETE, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the GET http method with post parameters
     */
    public function testRequestWithGetMethodAndWithPostParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array();
    	$query_params = array();
    	$post_params = array('par1' => 'val_par1',
    			'par2' => 'val_par2');
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::GET, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the POST http method with post parameters
     */
    public function testRequestWithPostMethodAndWithPostParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array();
    	$query_params = array();
    	$post_params = array('par1' => 'val_par1',
    			'par2' => 'val_par2');
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::POST, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the PUT http method with post parameters
     */
    public function testRequestWithPutMethodAndWithPostParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array();
    	$query_params = array();
    	$post_params = array('par1' => 'val_par1',
    			'par2' => 'val_par2');
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::PUT, $rest_params, $query_params, $post_params);
    }
    
    /**
     * what is said in the documentation of genericRequestWithoutAuthenticationReturnsGenericError($method, $rest_params = array(), $query_params = array(), $post_params = array())
     * using the DELETE http method with post parameters
     */
    public function testRequestWithDeleteMethodAndWithPostParametersWithoutAuthenticationReturnsGenericError()
    {
    	$rest_params = array();
    	$query_params = array();
    	$post_params = array('par1' => 'val_par1',
    			'par2' => 'val_par2');
    	$this->genericRequestWithoutAuthenticationReturnsGenericError(Zend_Http_Client::DELETE, $rest_params, $query_params, $post_params);
    }
    
    /*
     * TODO
     * c'e la possibilità di fare descrizioni più belle usando annotazioni @testdox http://www.phpunit.de/manual/3.7/en/appendixes.annotations.html#appendixes.annotations.group
     * oppure fare una trasformazione xml: http://stackoverflow.com/questions/4733972/how-to-get-detailed-test-info-from-phpunit-testdox
     */
}

