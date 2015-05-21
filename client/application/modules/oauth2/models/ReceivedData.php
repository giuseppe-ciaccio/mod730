<?php


class Oauth2_Model_ReceivedData {

	/**
	 * 
	 * @var array[int]array[int]string
	 */
	private $data;

	/**
	 *
	 * @var array[int]array[int]Oauth2_Model_TokenPart|string
	 */
	private $error;

	public function __construct() {
		$this->data = array();
		$this->error = array();
	}

	public function addData(Oauth2_Model_TokenPart $t, $str) {
//$log = Zend_Registry::get('log');
//$log->log("ciao recvd ".$str,0);
		$this->data[] = array($t->getContactUri(), $str);
	}

	public function addError(Oauth2_Model_TokenPart $t, $str) {
		$this->error[] = array($t, $str);
	}

	/**
	 * 
	 * @return array[int]array[int]Oauth2_Model_TokenPart|string
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * 
	 * @return array[int]array[int]Oauth2_Model_TokenPart|string
	 */
	public function getErrors() {
		return $this->error;
	}

	/**
	 * 
	 * @param array $a
	 * @return NULL|string
	 */
	public static function getDescription(array $a) {
		if (!is_array($a) || count($a) != 2)
			return null;
		return $a[1];
	}

	/**
	 * 
	 * @param array $a
	 * @return NULL|array[int]scopes
	 */
	public static function getScopes(array $a) {
		$tp = Oauth2_Model_ReceivedData::getTokenPart($a);
		if ($tp == null)
			return null;
		return $tp->getScopes();
	}

	/**
	 *
	 * @param array $a
	 * @return NULL|Oauth2_Model_TokenPart
	 */
	private static function getTokenPart(array $a) {
		if (!is_array($a) || count($a) != 2)
			return null;
		return $a[0];
	}

}
