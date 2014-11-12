<?php

class Agenziaterritorio_Model_Fabbricati {
	private $fabbricati;
	
	public function __construct() {
		$this->fabbricati = array();
	}
	
	public function add($fabbricato) {
		$this->fabbricati[] = $fabbricato;
	}
	
	public function toArray() {
		$array_values = array();
		
		foreach ($this->fabbricati as $f)
			$array_values[] = $f->toArray();
		
		return $array_values;
	}
	
	public function fromArray($array_values) {
		
	}

}

