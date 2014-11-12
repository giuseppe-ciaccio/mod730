<?php

class Application_Model_Scope {
	/**
	 * the scope string that will be passed to the authorization server
	 * @var string
	 */
	private $id;
	/**
	 * description of this scope
	 * @var string
	 */
	private $description;
	
	/**
	 * 
	 * @param string $id
	 * @param string $description
	 */
	public function __construct($id, $description) {
		$this->id = $id;
		$this->description = $description;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
}

