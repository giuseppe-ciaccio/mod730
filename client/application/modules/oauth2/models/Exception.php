<?php
class Oauth2_Model_Exception extends Exception {
	private $description;
	private $uri;
	public function __construct($description = '', $uri = '') {
		$this->description = $description;
		$this->uri = $uri;
		$this->message = get_class($this).': '.$this->description;
	}
	public function getDescription() {
		return $this->description;
	}
	public function getUri() {
		return $this->uri;
	}
}