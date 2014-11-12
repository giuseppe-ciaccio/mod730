<?php

class Agenziaentrate_Model_Contratto {
	private $id;
	private $numero;
	private $serie;
	private $id_oggetto;
	private $dal;
	private $canone;
	
	public function __construct($id, $numero, $serie, $id_oggetto, $dal, $canone) {
		$this->id = $id;
		$this->numero = $numero;
		$this->serie = $serie;
		$this->id_oggetto = $id_oggetto;
		$this->dal = $dal;
		$this->canone = $canone;
	}
	
	public function toArray() {
		$array_values = array();
		
		$array_values['id'] = $this->id;
		$array_values['numero'] = $this->numero;
		$array_values['serie'] = $this->serie;
		$array_values['id_oggetto'] = $this->id_oggetto;
		$array_values['dal'] = $this->dal;
		$array_values['canone'] = $this->canone;
		
		return $array_values;
	}
	
	public function fromArray($array_values) {
		
	}
}

