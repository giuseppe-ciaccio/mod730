<?php

class Agenziaterritorio_Model_Fabbricato {
	private $id;
	private $rendita;
	private $possesso_perc;
	private $possesso_giorni;
	private $codice_comune;
	
	public function __construct($id, $rendita, $possesso_perc, $possesso_giorni,
								$codice_comune) {
		$this->id = $id;
		$this->rendita = $rendita;
		$this->possesso_perc = $possesso_perc;
		$this->possesso_giorni = $possesso_giorni;
		$this->codice_comune = $codice_comune;
	}

	public function toArray() {
		$array_values = array();
		
		$array_values['id'] = $this->id;
		$array_values['rendita'] = $this->rendita;
		$array_values['possesso_perc'] = $this->possesso_perc;
		$array_values['possesso_giorni'] = $this->possesso_giorni;
		$array_values['codice_comune'] = $this->codice_comune;
		
		return $array_values;
		
	}
	
	public function fromArray($array_values) {
		
	}
}

