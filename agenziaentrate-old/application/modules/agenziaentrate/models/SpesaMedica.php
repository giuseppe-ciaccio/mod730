<?php

class Agenziaentrate_Model_SpesaMedica {
	private $id;
	private $importo;
	private $prestatore;
	private $indirizzo_prestatore;
	private $data_acquisto;
	private $aliquota_iva;
	private $descrizione;
	
	public function __construct($id, $importo, $prestatore, $indirizzo_prestatore,
								$data_acquisto, $aliquota_iva, $descrizione) {
		$this->id = $id;
		$this->importo = $importo;
		$this->prestatore = $prestatore;
		$this->indirizzo_prestatore = $indirizzo_prestatore;
		$this->data_acquisto = $data_acquisto;
		$this->aliquota_iva = $aliquota_iva;
		$this->descrizione = $descrizione;
		
	}
	
	public function toArray() {
		$array_values = array();
	
		$array_values['id'] = $this->id;
		$array_values['importo'] = $this->importo;
		$array_values['prestatore'] = $this->prestatore;
		$array_values['indirizzo_prestatore'] = $this->indirizzo_prestatore;
		$array_values['data_acquisto'] = date('d/m/Y', strtotime($this->data_acquisto));
		$array_values['aliquota_iva'] = $this->aliquota_iva;
		$array_values['descrizione'] = $this->descrizione;
		
		return $array_values;
	}
	
	public function fromArray($array_values) {
	
	}

}

