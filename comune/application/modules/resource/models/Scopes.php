<?php

class Resource_Model_Scopes {
	/**
		 * rset id
		 * @var string
		 */
		private $scope_id;
		private $name;
		private $uri;
		private $desc;


		public function __construct($id, $name, $uri, $desc) {
			$this->scope_id = $id;
			$this->name = $name;
			$this->uri = $uri;
			$this->desc = $desc;

		}


	public function getScopeId(){
	   return $this->scope_id;
	}

	public function getName(){
		   return $this->name;
	}


	public function getUri(){
		   return $this->uri;
	}

	public function getDescr(){
	   return $this->desc;
	}

}