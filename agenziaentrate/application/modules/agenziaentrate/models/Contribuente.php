<?php
//non è oggetto di interesse mi sa...
class Agenziaentrate_Model_Contribuente {
	private $cf;
	private $cf_sostituto_imposta;
	
	public function __construct($cf, $cf_sostituto_imposta) {
		$this->cf = $cf;
		$this->cf_sostituto_imposta = $cf_sostituto_imposta;
	}
	
	public function toArray() {
		$array_values = array();
		
		$array_values['cf'] = $this->cf;
		$array_values['cf_sostituto_imposta'] = $this->cf_sostituto_imposta;
		
		return $array_values;
	}
	
	public function fromArray($array_values) {
		
	}
	
	public function cfSostitutoImposta() {
		return $this->cf_sostituto_imposta;
	}
}

