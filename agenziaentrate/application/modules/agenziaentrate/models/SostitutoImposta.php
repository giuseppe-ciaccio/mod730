<?php

class Agenziaentrate_Model_SostitutoImposta {
	private $cf;
	private $denominazione;
	private $comune;
	private $provincia;
	private $tipologia_indirizzo;
	private $indirizzo;
	private $num_civico;
	private $cap;
	private $frazione;
	private $telfax;
	private $email;
	private $codice_sede;
	
	public function __construct($cf, $denominazione, $comune, $provincia,
								$tipologia_indirizzo, $indirizzo, $num_civico,
								$cap, $frazione, $telfax, $email, $codice_sede) {
		$this->cf = $cf;
		$this->denominazione = $denominazione;
		$this->comune = $comune;
		$this->provincia = $provincia;
		$this->tipologia_indirizzo = $tipologia_indirizzo;
		$this->indirizzo = $indirizzo;
		$this->num_civico = $num_civico;
		$this->cap = $cap;
		$this->frazione = $frazione;
		$this->telfax = $telfax;
		$this->email = $email;
		$this->codice_sede = $codice_sede;
	}
	
	public function toArray() {
		$array_values = array();
	
		$array_values['cf'] = $this->cf;
		$array_values['denominazione'] = $this->denominazione;
		$array_values['comune'] = $this->comune;
		$array_values['provincia'] = $this->provincia;
		$array_values['tipologia_indirizzo'] = $this->tipologia_indirizzo;
		$array_values['indirizzo'] = $this->indirizzo;
		$array_values['num_civico'] = $this->num_civico;
		$array_values['cap'] = $this->cap;
		$array_values['frazione'] = $this->frazione;
		$array_values['telfax'] = $this->telfax;
		$array_values['email'] = $this->email;
		$array_values['codice_sede'] = $this->codice_sede;
		
		return $array_values;
	}
	
	public function fromArray($array_values) {
	
	}
	


}

