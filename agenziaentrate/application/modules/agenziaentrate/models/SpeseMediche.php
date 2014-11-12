<?php

class Agenziaentrate_Model_SpeseMediche {
	private $array_spese;
	
	public function __construct() {
		$this->array_spese = array();
	}
	
	public function add($spesa) {
		$this->array_spese[] = $spesa;
	}
	
	public function toArray() {
		$spese = array();
	
		foreach ($this->array_spese as $s)
			$spese[] = $s->toArray();
		
		return $spese;
	}
	
	public function fromArray($spese) {
	
	}

}

