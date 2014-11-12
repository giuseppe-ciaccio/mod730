<?php

require_once 'Zend/Application.php';
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

abstract class DataControllerTestAbstract extends Zend_Test_PHPUnit_ControllerTestCase {
	protected static $REQUEST_HEADER = 'Authorization';
	/**
	 * Constants defined by rfc 6750
	 * section 3. The WWW-Authenticate Response Header Field
	 */
	protected static $RESPONSE_HEADER = 'WWW-Authenticate';
	protected static $AUTHENTICATION_SCHEME = 'Bearer';
	
	/**
	 * parameter name that holds the tokenn
	 * constant defined in rfc 6750
	 * section 2.2. Form-Encoded Body Parameter
	 * section 2.3. URI Query Parameter
	 * @var string
	 */
	protected static $ACCESS_TOKEN_PARAM = 'access_token';
	
	protected static $RESPONSE_REALM_PARAM = 'realm';
	protected static $RESPONSE_ERROR_PARAM = 'error';
	protected static $RESPONSE_ERROR_DESCRIPTION_PARAM = 'error_description';
	protected static $RESPONSE_ERROR_URI_PARAM = 'error_uri';
	
	protected static $RESPONSE_ERROR_INVALID_REQUEST = 'invalid_request';
	protected static $RESPONSE_ERROR_INVALID_REQUEST_HTTP_STATUS_CODE = 400; /* Bad Request*/
	protected static $RESPONSE_ERROR_INVALID_TOKEN = 'invalid_token';
	protected static $RESPONSE_ERROR_INVALID_TOKEN_HTTP_STATUS_CODE = 401; /* Unauthorized */
	protected static $RESPONSE_ERROR_INSUFFICIENT_SCOPE = 'insufficient_scope';
	protected static $RESPONSE_ERROR_INSUFFICIENT_SCOPE_HTTP_STATUS_CODE = 403; /* Forbidden */
	
	/**
	 * other constants
	 */
	protected static $PARAM_VALUE_ASSIGN_CHAR = '=';
	protected static $PARAM_VALUE_QUOTATION_CHAR = '"';
	
	protected $response_param_recieved;
	
	const SHARED_SECRET_KEY="b497477a761bb3d154ce8612d92caz";
	
	protected static $PRIVATE_KEYS;
	
	
	public function setUp() {
		$this->bootstrap = array($this, 'appBootstrap');
		 
		$this->response_param_recieved = array(self::$RESPONSE_ERROR_PARAM =>
				array('count' => 0, 'value' => ''),
				self::$RESPONSE_ERROR_DESCRIPTION_PARAM =>
				array('count' => 0, 'value' => ''),
				self::$RESPONSE_ERROR_URI_PARAM =>
				array('count' => 0, 'value' => ''),
				self::$RESPONSE_REALM_PARAM =>
				array('count' => 0, 'value' => ''));
		 
		 
		$priv_keys_path = APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.
				DIRECTORY_SEPARATOR.'tests'.
				DIRECTORY_SEPARATOR.'library'.
				DIRECTORY_SEPARATOR.'keys'.
				DIRECTORY_SEPARATOR;
		self::$PRIVATE_KEYS = array('AS_1' => $priv_keys_path.'as1_priv.pem',
				'AS_2' => $priv_keys_path.'as2_priv.pem',
				'AS_3' => $priv_keys_path.'as3_priv.pem',
				'AS_4' => $priv_keys_path.'as4_priv.pem',
				'AS_5' => $priv_keys_path.'as5_priv.pem',);
				 
		parent::setUp();
		 
	}
	
	public function tearDown() {
		$this->resetRequest()
			 ->resetResponse();
		Zend_Controller_Front::getInstance()->resetInstance();
		 
		$this->response_param_recieved = null;
	}
	
	public function appBootstrap() {
		$this->application = new Zend_Application(APPLICATION_ENV,
				APPLICATION_PATH.'/configs/application.ini');
		$this->application->bootstrap();
		 
		/**
		 * Fix for ZF-8193
		 * http://framework.zend.com/issues/browse/ZF-8193
		 * Zend_Controller_Action->getInvokeArg('bootstrap') doesn't work
		 * under the unit testing environment.
		*/
		$front = Zend_Controller_Front::getInstance();
		if($front->getParam('bootstrap') === null) {
			$front->setParam('bootstrap', $this->application->getBootstrap());
		}
	}
	
	
	/**
	 * extracts from the current response all headers -
	 * merging the getHeaders and getRawHeaders
	 * @return array
	 */
	public function getAllHeaders() {
		$all_headers = array();
		foreach ($this->getResponse()->getRawHeaders() as $str) {
			preg_match('/([^:]+): (.+)/m', $str, $components);
			$all_headers[$components[1]] = trim($components[2]);
		}
	
		foreach ($this->getResponse()->getHeaders() as $h)
			$all_headers[$h['name']] = $h['value'];
		 
		return $all_headers;
	}
	
	/**
	 * overloaded because of issue described in
	 * http://stackoverflow.com/questions/16020629/assertheader-in-zend-test-phpunit-controllertestcase-not-working(non-PHPdoc)
	 * @see Zend_Test_PHPUnit_ControllerTestCase::assertHeader()
	 */
	public function assertHeader($header, $message='') {
		if (array_key_exists($header, $this->getAllHeaders()))
			return $this->assertTrue(true, $message);
	
		$this->fail('no header with name: '.$header);
	}
	
	protected static function getOauthwoToken($iss, $duration, $prn, $scope) {
		$jwt = array('iss' => $iss,
				'exp' => time() + $duration,
				'prn' => $prn,
				'scope' => implode(' ', $scope));
		
		$jweBuilder = new Oauth_Builder_JWS(self::$PRIVATE_KEYS[$iss]);
		$jwe = $jweBuilder->get_token(json_encode($jwt));
	
		$jwsBuilder = new Oauth_Builder_JWE();
		$jwsBuilder->set_key(self::SHARED_SECRET_KEY);
		$jws = $jwsBuilder->get_token($jwe);
	
		return $jws;
	}
	
	/**
	 * given a header it controls if it is like 'Bearer realm="value", par1="val1", par2="val2"'
	 * @param string $header_content
	 */
	protected function check_auth_scheme_populate_params($header_content) {
		$this->assertTrue(preg_match('/([^=]+) (.+)/m', $header_content, $match) == 1);
		$this->assertEquals(3, count($match), 'extracting the authorization scheme');
	
		$auth_scheme = trim($match[1]);
		$this->assertEquals($auth_scheme, self::$AUTHENTICATION_SCHEME,
				'The header "'.self::$RESPONSE_HEADER.'" value first\'s component must equal to '.
				self::$AUTHENTICATION_SCHEME);
		 
		$remaining_params = trim($match[2]);
		while ($remaining_params != '') {
			if(preg_match('/([^=]+)=("[^"]++"), (.+)/m', $remaining_params, $match)) {
				if (count($match) != 4)
					$this->fail();
				 
				$this->populate_and_check_parameter($match[1], $match[2]);
				$remaining_params = $match[3];
			} else {
				if (preg_match('/([^=]+)=("[^"]++")/m', $remaining_params, $match)) {
					if (count($match) != 3)
						$this->fail();
	
					$this->populate_and_check_parameter($match[1], $match[2]);
					$remaining_params = "";
				} else
					$this->fail();
			}
		}
	}
	
	/**
	 * sanitize the $rawname and $rawvalue. checks if the param is a valid parameter
	 * @param string $rawname
	 * @param string $rawvalue
	 */
	private function populate_and_check_parameter($rawname, $rawvalue) {
		$par = array('name' => trim($rawname), 'value' => trim($rawvalue));
	
		$this->assertTrue(array_key_exists($par['name'], $this->response_param_recieved),
				'The param "'.$par['name'].'" is not recognized');
		$this->assertEquals(0, $this->response_param_recieved[$par['name']]['count'],
				'The param "'.$par['name'].'" is present more than once in the response');
	
		$this->response_param_recieved[$par['name']]['count'] = 1;
	
		$this->assertGreaterThan(2, strlen($par['value']),
				'The param '.$par['name'].' value must be a double quoted not empty string (1)');
		$this->assertEquals($par['value']{0}, self::$PARAM_VALUE_QUOTATION_CHAR,
		'The param '.$par['name'].' value must be a double quoted not empty string (2)');
		$this->assertEquals($par['value']{strlen($par['value'])-1}, self::$PARAM_VALUE_QUOTATION_CHAR,
		'The param '.$par['name'].' value must be a double quoted not empty string (2)');
	
		$this->response_param_recieved[$par['name']]['value'] = trim($par['value'], self::$PARAM_VALUE_QUOTATION_CHAR);
	}
	
	
	protected function set_request_params($method, $rest_params, $query_params, $post_params) {
		$this->getRequest()->setMethod($method);
		 
		foreach ($rest_params as $k => $v)
			$this->getRequest()->setParam($k, $v);
		$this->getRequest()->setQuery($query_params);
		$this->getRequest()->setPost($post_params);
	}
}