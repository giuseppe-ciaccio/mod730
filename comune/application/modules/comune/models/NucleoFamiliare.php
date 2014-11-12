<?php

class Comune_Model_NucleoFamiliare {
	private $elements = array();
	
	public function __construct($elements) {
		$this->elements = $elements;
	}
	
	public function toArray() {
		$array_values = array();
		
		foreach ($this->elements as $e)
			$array_values[] = $e->toArray();
		
		return $array_values;
	}
	
	public function fromArray($a) {
		
	}
}