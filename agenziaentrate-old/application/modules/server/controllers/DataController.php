<?php

class Server_DataController extends Zend_Rest_Controller
{
	private static $DEBUG = 1;
	private static $SKIP_ERROR_CONTROL = false;
	
	
	/*
	 * Authorization Header constants
	 */
	/**
	 * Authentication header and authentication scheme 
	 * as def. by rfc 6750 section 2.1. Authorization Request Header Field
	 * the header $this::$AUTH_HEADER must contain 
	 * $this::$AUTH_HEADER_COMPONENTS_COUNT components
	 * @var int
	 */
	private static $AUTH_HEADER_COMPONENTS_COUNT = 2;
	/**
	 * @var string
	 */
    private static $AUTH_HEADER = 'Authorization';
    /**
     * @var string
     */
    private static $AUTH_TOKEN_TYPE = 'Bearer';
    /*
     * ************************************************************************
     */
    
    
    /*
     * The Authorization Response Header constants
     */
    /**
     * The header containing error response as specified by 
     * rfc 6750 sec. 3. The WWW-Authenticate Response Header Field
     * @var string
     */
    private static $AUTH_HEADER_ERROR_RESPONSE = 'WWW-Authenticate';
    /**
     * realm parameter as specified by rfc 6750 sec. 3.
     * @var string
     */
    private static $AUTH_HEADER_RESPONSE_REALM_PARAM_STRING = 'realm';
    /**
     * rfc 6750 sec. 3.
     * this parameter is included in the response if the request had a
     * valid token but with inssuficient scopes - in this case this param
     * should contain the necessary scopes (separated by a %x20 character)
     * to access the requested resource.
     * @var string
     */
    private static $AUTH_HEADER_RESPONSE_SCOPE_PARAM_STRING = 'scope';
    
    /**
     * error codes and error params as specified
     * by rfc 6750 section 3.1 Error Codes
     */
    private static $ERROR_PARAM_STRING = 'error';
    private static $ERROR_DESCRIPTION_PARAM_STRING = 'error_description';
    private static $ERROR_URI_PARAM_STRING = 'error_uri';
    
    private static $ERROR_INVALID_REQUEST = 'invalid_request';
    private static $ERROR_INVALID_REQUEST_HTTP_STATUS_CODE = 400; /* Bad Request*/
    private static $ERROR_INVALID_TOKEN = 'invalid_token';
    private static $ERROR_INVALID_TOKEN_HTTP_STATUS_CODE = 401; /* Unauthorized */
    private static $ERROR_INSUFFICIENT_SCOPE = 'insufficient_scope';
    private static $ERROR_INSUFFICIENT_SCOPE_HTTP_STATUS_CODE = 403; /* Forbidden */
    
    private static $ERROR_HTTP_STATUS_CODE_PARAM_STRING = 'http_status_code';
    /*
     * ************************************************************************
     */
    
    
    /*
     * Error codes
     */
    /**
     * @var array
     * int => array(string => string, string => string, string => string, string => int)
     * contains the error codes and corresponding
     * error types, error descriptions and error uri
     */
    private static $ERROR_DESCRIPTIONS = array();
    
    /**
     * @var int
     *
     * rfc 6750 section 3. The WWW-Authenticate Response Header Field
     * request without authentication...
     * - no $this::$AUTH_HEADER header is present in the request; or
     * - the $this::$AUTH_HEADER header is present but
     *   the value does not contain $this::$AUTH_HEADER_COMPONENTS_COUNT
     *   components, that is does not contain as first component the
     *   value $this::$AUTH_TOKEN_TYPE ad as the second component
     *   a not empty string. (the base64 encoding of the access token)
     *
     * For example, in response to a protected resource
     * request without authentication:
     * HTTP /1.1 401 Unauthorized
     * WWW-Authenticate: Bearer realm="example"
     *
     * -------
     * No error params are included in the response like written in
     * rfc 6750 section 3.1. Error Codes:
     * If the request lacks any authentication information (e.g., the
     * client was unaware that authentication is necessary or attempted
     * using an unsupported authentication method), the resource server
     * SHOULD NOT include an error code or other error information.
     *
     * @var int
     */
    private static $AUTH_HEADER_ERROR = 1;
    
    /**
     * represents the error situation when more than one
     * method for including an access token is used
     * @var int
     */
    private static $INVALID_REQUEST_TWO_AUTH_METHOD_USED_ERROR = 2;
    private static $INVALID_REQUEST_INVALID_PARAMETER_ERROR = 3;
    private static $INVALID_REQUEST_DATA_NOT_FOUND = 4;
    
    private static $INVALID_TOKEN_JWE_ERROR = 5;
    private static $INVALID_TOKEN_JWS_ERROR = 6;
    private static $INVALID_TOKEN_JWT_ERROR = 7;
    private static $INVALID_TOKEN_INCORRECT_SIGNATURE_ERROR = 8;
    private static $INVALID_TOKEN_SIGNATURE_CHECK_ERROR = 9;
    private static $INVALID_TOKEN_EXPIRED_ERROR = 10;
    private static $INVALID_TOKEN_GENERIC_ERROR = 11;
    
    private static $INVALID_TOKEN_INEXISTENT_ROWNER_ERROR = 12;
    private static $INVALID_TOKEN_INVALID_SCOPE_ERROR = 13;
    private static $NO_ERROR = 0;
    
    private static $INSUFFICIENT_SCOPE_ERROR = 14;
    
    private static $SERVER_INSTANTIATION_ERROR = 15;
    /*
     * ************************************************************************
     */
    
    
    /**
     * the param name used to pass the access token as 
     * Form-Encoded Body Parameter (section 2.2 rfc 6750)
     * or as URI Query Parameter (section 2.3 rfc 6750)
     * @var string
     */
    private static $ACCESS_TOKEN_PARAM_STRING = 'access_token';
    
    /**
     * @var array
     * by default in the current request there are also the 
     * params related to the current module, action and 
     * controller. These params are not of interest of the
     * current REST api.
     */
    private static $REST_IGNORED_PARAMS = array(
        'module' => '*',
        'action' => '*',
        'controller' => '*'
        );

    
    /**
     * @var int
     * represents the current detected error.
     * The 0 value represents no error. 
     * The value V (other than 0) represents an
     * error with error type, error description and
     * error uri contained in $this::$ERROR_DESCRIPTIONS[V].
    */
    private $error = 0;
    
    /**
     * if the current request fails because of 
     * inssuficient scope provided by the token then 
     * this array will contain the necessary scopes to 
     * make a successful access
     * @var array
     */
    private $cur_request_necessary_scopes;
    
    /**
     * @var array of string representing the rest parameters.
     * 						Parameters like par1=val1, par2=val2 in the link
     * 						http://resource/par1/val1/par2/val2
     */
    private $restRequestParams = null;
    
    /**
     * @var array of string representing the parameters passed in the 
     * 						query string of the link.
     * 						Parameters like par1=val1, par2=val2 in the link
     * 						http://resource?par1=val1&par2=val2	
     */
    private $queryRequestParams = null;
    
    /**
     * @var array of string representing the parameters passed in the
     * 						request body.
     */
    private $postRequestParams = null;

    /**
     * @var string representing the raw token sent by the client.
     * 				In this specific implementation this is a base64 string
     * 				encoding the Json Web Encriptyon (http://tools.ietf.org/html/draft-ietf-jose-json-web-encryption-08)
     * 				having as payload a Json Web Signature (http://tools.ietf.org/html/draft-ietf-jose-json-web-signature-08)
     * 				having as payload a Json Web Token (http://tools.ietf.org/html/draft-ietf-oauth-json-web-token-06)
     */
    private $base64EncToken = null;
    
    /**
     * 
     * @var Server_Model_Token
     */
    private $token;
    
    /**
     * 
     * @var Server_Model_ServerInfo
     */
    private $server_info;
    
    /**
     * 
     * @var Server_DataServer_ServerInterface
     */
    private $data_server;

    public function init() {
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->server_info = new Server_Model_ServerInfo();
        
        /*
         * initialize the static variable since 
         * it cannot be made in declaration point
         */
        self::$ERROR_DESCRIPTIONS = array(
        	self::$AUTH_HEADER_ERROR => 
        		array(self::$ERROR_PARAM_STRING => '',
        				self::$ERROR_DESCRIPTION_PARAM_STRING => '',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
        	
        	self::$INVALID_REQUEST_TWO_AUTH_METHOD_USED_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_REQUEST,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E1: more than one method for including an access token is used',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_REQUEST_HTTP_STATUS_CODE),
        	self::$INVALID_REQUEST_INVALID_PARAMETER_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_REQUEST,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E12: invalid parameters provided when making the request',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_REQUEST_HTTP_STATUS_CODE),
        	/* it is not an invalid request... but it is not a invalid token nor insufficient scope */
        	self::$INVALID_REQUEST_DATA_NOT_FOUND =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_REQUEST,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E13: no data found :(',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_REQUEST_HTTP_STATUS_CODE),
        	
        	self::$INVALID_TOKEN_INCORRECT_SIGNATURE_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_TOKEN,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E2: the token is not authentic',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
        	self::$INVALID_TOKEN_JWE_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_TOKEN,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E3: the string representing the Json Web Encryption is not conformant to the specification',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
    		self::$INVALID_TOKEN_JWS_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_TOKEN,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E4: the string representing the Json Web Signature is not conformant to the specification or the shared key was incorrect',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
    		self::$INVALID_TOKEN_JWT_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_TOKEN,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E5: the string representing the Json Web Token is not conformant to the specification',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
    		self::$INVALID_TOKEN_SIGNATURE_CHECK_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_TOKEN,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E6: occured an error checking the signature. this resource server may not have the correct certificate to check the signature or the certificate cannot be read',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
    		self::$INVALID_TOKEN_EXPIRED_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_TOKEN,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E7: the provided token is expired',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
        	self::$INVALID_TOKEN_GENERIC_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_TOKEN,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E8: a generic error occured checking the token (certificate file can be read?)',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
        	self::$INVALID_TOKEN_INEXISTENT_ROWNER_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_TOKEN,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E9: the resource owner of the resources granted by the token provided does not exist on this server',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
    		self::$INVALID_TOKEN_INVALID_SCOPE_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INVALID_TOKEN,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E10: at least one scope granted by the current token is not valid on this server',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INVALID_TOKEN_HTTP_STATUS_CODE),
        	self::$INSUFFICIENT_SCOPE_ERROR =>
        		array(self::$ERROR_PARAM_STRING => self::$ERROR_INSUFFICIENT_SCOPE,
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'E11: insufficient scope to complete the request',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => self::$ERROR_INSUFFICIENT_SCOPE_HTTP_STATUS_CODE),
        	self::$SERVER_INSTANTIATION_ERROR =>
        		array(self::$ERROR_PARAM_STRING => 'EMPTY',
        				self::$ERROR_DESCRIPTION_PARAM_STRING => 'EMPTY',
        				self::$ERROR_URI_PARAM_STRING => '',
        				self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING => 500)
    		);
        
        
    }
    
    /*
     * returns false if currently there is no error, true otherwise.
     */
    private function error() {
    	return $this->error != $this::$NO_ERROR;
    }
    
    /**
     * extracts authorization header parameters parameters and 
     * validate them as specified by rfc 6750 section 2.1 
     * Authorization Request Header Field.
     */
    private function check_extract_auth_header() {
    	$curRequest = $this->getRequest();
    	 
    	/* check the authorization header */
    	$authHeader = $curRequest->getHeader($this::$AUTH_HEADER);
    	if (empty($authHeader)) 
    		return $this::$AUTH_HEADER_ERROR;
    	
    	$authHeaderComponents = explode(' ', $authHeader);
    	if (empty($authHeaderComponents) 
    			||	count($authHeaderComponents) != $this::$AUTH_HEADER_COMPONENTS_COUNT) 
    		return $this::$AUTH_HEADER_ERROR;
    	
    	$curTokenType = trim($authHeaderComponents[0]);
    	if ($curTokenType != $this::$AUTH_TOKEN_TYPE) 
    		return $this::$AUTH_HEADER_ERROR;
    	
    	$this->base64EncToken = trim($authHeaderComponents[1]);
    	if (empty($this->base64EncToken)) 
    		return $this::$AUTH_HEADER_ERROR;
    	
    	return $this::$NO_ERROR;
    }
    
    /**
     * rfc 6750 section 3.1. Error codes
     * The request is invalid when the request
     * - is missing a required parameter;
     * - includes an unsuported parameter or parameter value;
     * - repeates the same parameter;
     * - uses more than one method for including an 
     *   access token, or is otherwise malformed.
     * 
     * @return error number
     */
    private function check_if_invalid_request() {
    	/*
    	 * if there is a required parameter (as query string 
    	 * parameter or as a request body parameter)
    	 * then must check in the $this->restRequestParams,
    	 * $this->queryRequestParams, $this->postRequestParams arrays
    	 */
    	
    	/*
    	 * if there is an unsuported parameter or parameter value
    	 * then must check in the params arrays defined as class variables
    	 */
    	
    	/*
    	 * there are not issues with repeated params... 
    	 * only the one the first occurence of the param is valid
    	 */
    	
    	if (array_key_exists(self::$ACCESS_TOKEN_PARAM_STRING, 
    						$this->queryRequestParams))
    		return self::$INVALID_REQUEST_TWO_AUTH_METHOD_USED_ERROR;
    	
    	if (array_key_exists(self::$ACCESS_TOKEN_PARAM_STRING, 
    						$this->postRequestParams))
    		return self::$INVALID_REQUEST_TWO_AUTH_METHOD_USED_ERROR;
    	
    	return $this::$NO_ERROR;
    }
    
    
    /**
     * rfc 6750 section 3.1. Error Codes
     * The token is invalid if:
     * - the token is expired;
     * - the token is revoked;
     * - the token is malformed;
     * - invalid for other reasons
     * 
     * @return error number
     */
    private function check_if_invalid_token() {
    	/*
    	 * the token variable is setted for sure...
    	 * so the check if the token is not null is not necessary
    	 */
    	
    	if ($this->token->get_exp_timestamp() <= time())
    		return self::$INVALID_TOKEN_EXPIRED_ERROR;
    	
    	/*
    	 * since in this implementation the token is bearer token the
    	 * check if the token is revoked cannot be made.
    	 * In this implementation the token is revoked if it is expired.
    	 */
    	    	
    	return $this::$NO_ERROR;
    }

    public function preDispatch() {
    	/* avoid the loop: http://framework.zend.com/issues/browse/ZF-11571 */
    	if ($this->getRequest()->getActionName() == 'error')
    		return;
    	
    	//TODO remove later this
    	if (self::$SKIP_ERROR_CONTROL)
    		return;
    	
     	$this->error = $this->check_extract_auth_header();
     	
    	if ($this->error())
    		return $this->handleErrors();
    	
    	$this->queryRequestParams = $this->getRequest()->getQuery();
    	$this->postRequestParams = $this->getRequest()->getPost();
    	$this->restRequestParams = array_diff_key($this->getRequest()->getUserParams(),
									    			Server_DataController::$REST_IGNORED_PARAMS/*, 
									    			$this->queryRequestParams, 
									    			$this->postRequestParams*/);
    	
    	$this->error = $this->check_if_invalid_request();
    	if ($this->error())
    		return $this->handleErrors();
    	
    	/* decode the token and handle possible invalid token errors */
    	try {
    		$this->token = $this->_helper->DecodeOauth2Token($this->base64EncToken, $this->server_info);
    	} catch (JWEException $e) {
    		$this->error = self::$INVALID_TOKEN_JWE_ERROR;
    	} catch (JWSException $e) {
    		$this->error = self::$INVALID_TOKEN_JWS_ERROR;
    	} catch (JWTException $e) {
    		$this->error = self::$INVALID_TOKEN_JWT_ERROR;
    	} catch (IncorrectSignatureException $e) {
    		$this->error = self::$INVALID_TOKEN_INCORRECT_SIGNATURE_ERROR;
    	} catch (CannotCheckSignatureException $e) {
    		$this->error = self::$INVALID_TOKEN_SIGNATURE_CHECK_ERROR;
    	} catch (Exception $e) {
    		$this->error = self::$INVALID_TOKEN_GENERIC_ERROR;
    	}
    	if ($this->error())
    		return $this->handleErrors();
    	    	
    	$this->error = $this->check_if_invalid_token();
    	if ($this->error())
    		return $this->handleErrors();
    
    	try {
    		$this->data_server = Server_Model_DataServer::getCurrentDataServer($this->token->get_scopes(), $this->token->get_subject());
    	} catch (SubjectNotPresentException $e) {
    		$this->error = self::$INVALID_TOKEN_INEXISTENT_ROWNER_ERROR;
    	} catch (InvalidScopeException $e) {
    		$this->error = self::$INVALID_TOKEN_INVALID_SCOPE_ERROR;
    	} catch (Server_Model_DataServerInstantiationException $e) {
    		$this->error = self::$SERVER_INSTANTIATION_ERROR;
    	}
    	
    	if ($this->error())
    		return $this->handleErrors();
    }
    
    private function handleErrors() {
    	if (!$this->error())
    		return;
    	
    	$cur_error = self::$ERROR_DESCRIPTIONS[$this->error];
    	$str_format = '%s="%s"';
    	
    	$response = array();
    	
    	/* TODO what is the value of realm param */
    	$response[] = sprintf($str_format, 
    							self::$AUTH_HEADER_RESPONSE_REALM_PARAM_STRING, 
    							'TODO');
    	
    	/* error=value if value is not empty */
    	if (!empty($cur_error[self::$ERROR_PARAM_STRING]))
    		$response[] = sprintf($str_format, 
    									self::$ERROR_PARAM_STRING, 
    									$cur_error[self::$ERROR_PARAM_STRING]);
    	/* error_description=value if value is not empty */
    	if (!empty($cur_error[self::$ERROR_DESCRIPTION_PARAM_STRING]))
    		$response[] = sprintf($str_format, 
    									self::$ERROR_DESCRIPTION_PARAM_STRING, 
    									$cur_error[self::$ERROR_DESCRIPTION_PARAM_STRING]);
    	/* error_uri=value if value is not empty */
    	if (!empty($cur_error[self::$ERROR_URI_PARAM_STRING]))
    		$response[] = sprintf($str_format, 
    									self::$ERROR_URI_PARAM_STRING, 
    									$cur_error[self::$ERROR_URI_PARAM_STRING]);
    	
    	if (!empty($this->cur_request_necessary_scopes))
    		$response[] = sprintf($str_format, 
    									self::$AUTH_HEADER_RESPONSE_SCOPE_PARAM_STRING, 
    									implode(' ', $this->cur_request_necessary_scopes));
    	
    	/* 
    	 * if use $this->getResponse->setHeader(HEADER, HEADER_VALUE) 
    	 * I get the Header with only first capital letter... strange behavior
    	 * RFC 6750 section 3. The WWW-Authenticate Response Header Field
    	 * 
    	 * example:
    	 * HTTP/1.1 401 Unauthorized
    	 * WWW-Authenticate: Bearer realm="example", error="d"
    	 */
    	$this->getResponse()
    			->setRawHeader(sprintf("%s: %s %s", self::$AUTH_HEADER_ERROR_RESPONSE,
    												self::$AUTH_TOKEN_TYPE,
    												implode(', ', $response)));
    	
    	$this->getResponse()
    			->setHttpResponseCode($cur_error[self::$ERROR_HTTP_STATUS_CODE_PARAM_STRING]);
    	
    	//I cannot strip out the Vary, Content-Length, Content-Type headers...
    	//they are set by apache
    	
    	return $this->_forward('error');
    }

    /*
     * dummy action....
     */
    public function errorAction() {
    	
    }

    
    /* http request handles */
    public function indexAction() {        
        
        $params = array_merge($this->restRequestParams, $this->queryRequestParams);
        $data_representation;
        try {
        	$data_representation = $this->data_server->get($params);
        } catch (InvalidScopeException $e) {
        	$this->error = self::$INVALID_TOKEN_INVALID_SCOPE_ERROR;
       	} catch (InsufficientScopeException $e) {
       		$this->error = self::$INSUFFICIENT_SCOPE_ERROR;
       	} catch (QueryParameterNotFoundException $e) {
        	$this->error = self::$INVALID_REQUEST_INVALID_PARAMETER_ERROR;
        } catch (DataNotFoundException $e) {
        	$this->error = self::$INVALID_REQUEST_DATA_NOT_FOUND;
        }
        
        if ($this->error())
        	return $this->handleErrors();

        $this->getResponse()->setHeader(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');

//$log = Zend_Registry::get('log');
//$log->log("ciao0 ".serialize(json_decode(base64_decode($data_representation))),0);

        $this->getResponse()->setBody($data_representation);
        $this->getResponse()->setHttpResponseCode(200);
        return;
    }

    public function getAction() {
	$params = array_merge($this->restRequestParams, $this->queryRequestParams);
         
        $data_representation;
        try {
        	$data_representation = $this->data_server->get($params);
        } catch (InvalidScopeException $e) {
        	$this->error = self::$INVALID_TOKEN_INVALID_SCOPE_ERROR;
       	} catch (InsufficientScopeException $e) {
       		$this->error = self::$INSUFFICIENT_SCOPE_ERROR;
       	} catch (QueryParameterNotFoundException $e) {
        	$this->error = self::$INVALID_REQUEST_INVALID_PARAMETER_ERROR;
        } catch (DataNotFoundException $e) {
        	$this->error = self::$INVALID_REQUEST_DATA_NOT_FOUND;
        }
        
        if ($this->error())
        	return $this->handleErrors();

        $this->getResponse()->setHeader(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');
        $this->getResponse()->setBody($data_representation);
        $this->getResponse()->setHttpResponseCode(200);
        return;    	
    }

    //TODO not implemented
    public function postAction() {
    	return $this->getResponse()->setHttpResponseCode(405);
    	
    	$current; //the decode data
    	$updated; //the decode data
    	
    	try {
    		$this->data_server->update($current, $updated);
    	} catch (InsufficientScopeException $e) {
    		$this->error = self::$INSUFFICIENT_SCOPE_ERROR;
    	} catch (InvalidDataException $e) {
    		//set appropriate error code
    	}
    	
    	//se il subj del token è diverso  da quello specificato nel current e updated?
    	if ($this->error())
    		return $this->handleErrors();
    	
    	//send an appropriate http response
    }

    //TODO not implemented
    public function putAction() {
    	return $this->getResponse()->setHttpResponseCode(405);
    	
    	$data;//retrieve the data and decode it
    	
    	try {
    		$this->data_server->write($data);
    	} catch (InsufficientScopeException $e) {
    		$this->error = self::$INSUFFICIENT_SCOPE_ERROR;
    	} catch (InvalidDataException $e) {
    		//set appropriate error code
    	}
    	//se il subj del token è diferso  da quello specificato nel e data?
    	if ($this->error())
    		return $this->handleErrors();
    	
    	//send an appropriate http response
    }

    //TODO not implemented
    public function deleteAction() {
    	return $this->getResponse()->setHttpResponseCode(405);
    	
    	$data;//retrieve the data and decode it
    	 
    	try {
    		$this->data_server->delete($data);
    	} catch (InsufficientScopeException $e) {
    		$this->error = self::$INSUFFICIENT_SCOPE_ERROR;
    	} catch (InvalidDataException $e) {
    		//set appropriate error code
    	}
    	//se il subj del token è diferso  da quello specificato nel e data?
    	if ($this->error())
    		return $this->handleErrors();
    	 
    	//send an appropriate http response
    }

    
    public function headAction() {
    	return $this->getResponse()->setHttpResponseCode(405);
    }
    public function optionsAction() {
        $this->getResponse()->setBody(null);
        $this->getResponse()->setHeader("Allow", "OPTIONS, INDEX, GET");
    }
    
    
}
