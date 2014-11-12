<?php

class Agenziaentrate_Model_Contratti {
	private $array_contratti;
	
	public function __construct() {
		$this->array_contratti = array();
	}
	
	public function add($contratto) {
		$this->array_contratti[] = $contratto;
	}
	
	public function toArray() {
		$contratti = array();
		
		foreach ($this->array_contratti as $cti)
			$contratti[] = $cti->toArray();
		
		return $contratti;
	}
	
	public function fromArray($contratti) {
		
	}


}

