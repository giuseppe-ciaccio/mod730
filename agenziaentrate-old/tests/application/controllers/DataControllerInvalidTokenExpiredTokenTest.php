<?php

require_once dirname(__FILE__).'/DataControllerTestInvalidToken.php';

class DataControllerInvalidTokenExpiredTokenTest extends DataControllerTestInvalidToken {
	/**
	 * see doc of genericRequestWithInvalidTokenReturnsInvalidTokenError($method, $token, $params = array(), $query_params = array(), $post_params = array())
	 * asserting finally that there was Expired Token error - E7 code
	 */
	private function genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array()) {
		$this->genericRequestWithInvalidTokenReturnsInvalidTokenError($method, $token, $rest_params, $query_params, $post_params);
			
		$this->assertRegExp('/E7/', $this->response_param_recieved[self::$RESPONSE_ERROR_DESCRIPTION_PARAM]['value']);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method without params
	 */
	public function testRequestWithGetMethodWithoutParametersWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array();
		
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::GET, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method without params
	 */
	public function testRequestWithPostMethodWithoutParametersWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::POST, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method without params
	 */
	public function testRequestWithPutMethodWithoutParametersWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::PUT, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method without params
	 */
	public function testRequestWithDeleteMethodWithoutParametersWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::DELETE, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method with rest style params
	 */
	public function testRequestWithGetMethodWithRestParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array('par1' => 'val1',
							'par2' => 'val2');
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::GET, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method with rest style params
	 */
	public function testRequestWithPostMethodWithRestParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array('par1' => 'val1',
							'par2' => 'val2');
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::POST, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method with rest style params
	 */
	public function testRequestWithPutMethodWithRestParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array('par1' => 'val1',
							'par2' => 'val2');
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::PUT, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method with rest style params
	 */
	public function testRequestWithDeleteMethodWithRestParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array('par1' => 'val1',
							'par2' => 'val2');
		$query_params = array();
		$post_params = array();
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::DELETE, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method with query params
	 */
	public function testRequestWithGetMethodWithQueryParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val1',
				'par2' => 'val2');
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::GET, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method with query params
	 */
	public function testRequestWithPostMethodWithQueryParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val1',
				'par2' => 'val2');
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::POST, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method with query params
	 */
	public function testRequestWithPutMethodWithQueryParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val1',
				'par2' => 'val2');
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::PUT, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method with query params
	 */
	public function testRequestWithDeleteMethodWithQueryParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val1',
				'par2' => 'val2');
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::DELETE, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using GET method with post params
	 */
	public function testRequestWithGetMethodWithPostParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val1',
				'par2' => 'val2');
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::GET, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using POST method with post params
	 */
	public function testRequestWithPostMethodWithPostParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val1',
				'par2' => 'val2');
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::POST, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using PUT method with post params
	 */
	public function testRequestWithPutMethodWithPostParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val1',
				'par2' => 'val2');
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::PUT, $token,
				$rest_params, $query_params, $post_params);
	}
	
	/**
	 * see doc of genericRequestWithExpiredTokenReturnsInvalidTokenError($method, $token, $rest_params = array(), $query_params = array(), $post_params = array())
	 * using DELETE method with post params
	 */
	public function testRequestWithDeleteMethodWithPostParamsWithExpiredTokenReturnsInvalidTokenError() {
		$token = self::getOauthwoToken('AS_2', -60*60, 'sample_subj', array('ciao', 'ciao1', 'ciao2'));
		$rest_params = array();
		$query_params = array();
		$post_params = array('par1' => 'val1',
				'par2' => 'val2');
	
		$this->genericRequestWithExpiredTokenReturnsInvalidTokenError(Zend_Http_Client::DELETE, $token,
				$rest_params, $query_params, $post_params);
	}
}