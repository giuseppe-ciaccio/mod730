<?php

require_once dirname(__FILE__).'/DataControllerTestInvalidToken.php';

class DataControllerInvalidTokenJWETest extends DataControllerTestInvalidToken {
	/**
	 * see doc of genericRequestWithInvalidTokenReturnsInvalidTokenError($method, $token, $params = array(), $query_params = array(), $post_params = array())
	 * asserting finally that there was Jwe error - E3 code
	 */
	private function genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array()) {
		$this->genericRequestWithInvalidTokenReturnsInvalidTokenError($method, $token, $rest_params, $query_params, $post_params);
			
		$this->assertRegExp('/E3/', $this->response_param_recieved[self::$RESPONSE_ERROR_DESCRIPTION_PARAM]['value']);
	}
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method with no parameters
	 */
	public function testRequestWithGetMethodWithoutParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array();
		$post_params = array();
			
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::GET,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method with no parameters
	 */
	public function testRequestWithPostMethodWithoutParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::POST,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method with no parameters
	 */
	public function testRequestWithPutMethodWithoutParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::POST,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method with no parameters
	 */
	public function testRequestWithDeleteMethodWithoutParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::DELETE,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method with rest parameters
	 */
	public function testRequestWithGetMethodWithRestParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::GET,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method with rest parameters
	 */
	public function testRequestWithPostMethodWithRestParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::POST,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method with rest parameters
	 */
	public function testRequestWithPutMethodWithRestParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::PUT,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method with rest parameters
	 */
	public function testRequestWithDeleteMethodWithRestParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::DELETE,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method with query parameters
	 */
	public function testRequestWithGetMethodWithQueryParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::GET,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method with query parameters
	 */
	public function testRequestWithPostMethodWithQueryParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::POST,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method with query parameters
	 */
	public function testRequestWithPutMethodWithQueryParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::PUT,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method with query parameters
	 */
	public function testRequestWithDeleteMethodWithQueryParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
		$post_params = array();
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::DELETE,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method with post parameters
	 */
	public function testRequestWithGetMethodWithPostParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::GET,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method with post parameters
	 */
	public function testRequestWithPostMethodWithPostParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::POST,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method with post parameters
	 */
	public function testRequestWithPutMethodWithPostParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::PUT,
				$token, $rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithInvalidJweReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method with post parameters
	 */
	public function testRequestWithDeleteMethodWithPostParametersWithInvalidJweReturnsInvalidTokenError() {
		$token = 'falsetoken';
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val_par1',
				'par2' => 'val_par2');
	
		$this->genericRequestWithInvalidJweReturnsInvalidTokenError(Zend_Http_Client::DELETE,
				$token, $rest_params, $query_params, $post_params);
	}
}