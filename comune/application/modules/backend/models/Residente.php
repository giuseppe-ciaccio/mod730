<?php

class Backend_Model_ResidenteDecodeException extends Exception {}

class Backend_Model_Residente {	
	/**
	 * codice fiscale
	 * @var string
	 */
	public $cf;
	
	/**
	 * nome
	 * @var string
	 */
	public $nome;

	/**
	 * cognome
	 * @var string
	 */
	public $cognome;

	/**
	 * sesso - femmina o maschio
	 * @var string
	 */
	public $sesso;

	/**
	 *
	 * @var date
	 */
	public $data_nascita;

	/**
	 * comune di nascita
	 * @var string
	 */
	public $comune_nascita;

	/**
	 * provincia di nascita
	 * @var string
	 */
	public $provincia_nascita;
	
	/**
	 * 
	 * @var string
	 */
	public $stato_civile;

	
	/**
	 * 
	 * @var string
	 */
	public $comune_residenza;
	
	/**
	 *
	 * @var string
	 */
	public $provincia_residenza;
	
	/**
	 *
	 * @var int
	 */
	public $cap_residenza;
	
	/**
	 * via, viale, piazza, ecc.
	 * @var string
	 */
	public $tipologia_residenza;
	
	/**
	 *
	 * @var string
	 */
	public $indirizzo_residenza;
	
	/**
	 * numero civico che può includere lettere (??? si penso di si)
	 * @var string
	 */
	public $numcivico_residenza;
	
	/**
	 *
	 * @var string
	 */
	public $frazione_residenza;


	/**
	 *
	 * @var date
	 */
	public $ultima_variazione_residenza;
	
	/**
	 * 
	 * @var Backend_Model_NucleoFamiliare
	 */
	private $nucleo_familiare;
	
	/**
	 * 
	 * @param string $cf
	 * @param string $nome
	 * @param string $cognome
	 * @param string $sesso
	 * @param date $data_nascita
	 * @param string $comune_nascita
	 * @param string $provincia_nascita
	 * @param string $stato_civile
	 * @param string $comune_residenza
	 * @param string $provincia_residenza
	 * @param string $cap_residenza
	 * @param string $tipologia_residenza
	 * @param string $indirizzo_residenza
	 * @param string $numcivico_residenza
	 * @param string $frazione_residenza
	 * @param date $ultima_variazione_residenza
	 * @param Backend_Model_NucleoFamiliare $nucleo_familiare
	 */
	public function __construct($cf, $nome, $cognome, $sesso, $data_nascita, 
								$comune_nascita, $provincia_nascita, $stato_civile,
								$comune_residenza, $provincia_residenza, 
								$cap_residenza, $tipologia_residenza,
								$indirizzo_residenza, $numcivico_residenza,
								$frazione_residenza, $ultima_variazione_residenza,
								$nucleo_familiare) {
		$this->cf = $cf;
		$this->nome = $nome;
		$this->cognome = $cognome;
		$this->sesso = $sesso;
		$this->data_nascita = $data_nascita;
		$this->comune_nascita = $comune_nascita;
		$this->provincia_nascita = $provincia_nascita;
		$this->stato_civile = $stato_civile;
		$this->comune_residenza = $comune_residenza;
		$this->provincia_residenza = $provincia_residenza;
		$this->cap_residenza = $cap_residenza;
		$this->tipologia_residenza = $tipologia_residenza;
		$this->indirizzo_residenza = $indirizzo_residenza;
		$this->numcivico_residenza = $numcivico_residenza;
		$this->frazione_residenza = $frazione_residenza;
		$this->ultima_variazione_residenza = $ultima_variazione_residenza;
		$this->nucleo_familiare = $nucleo_familiare;
	}
	
	/*
	 * constants for json params
	*/
	
	private static $PARAM_CF = 'cf';
	private static $PARAM_NOME = 'nome';
	private static $PARAM_COGNOME = 'cognome';
	private static $PARAM_SESSO = 'sesso';
	private static $PARAM_DATA_NASCITA = 'data_nascita';
	private static $PARAM_COMUNE_NASCITA = 'comune_nascita';
	private static $PARAM_PROVINCIA_NASCITA = 'provincia_nascita';
	private static $PARAM_STATO_CIVILE = 'stato_civile';
	private static $PARAM_COMUNE_RESIDENZA = 'comune_residenza';
	private static $PARAM_PROVINCIA_RESIDENZA = 'provincia_residenza';
	private static $PARAM_CAP_RESIDENZA = 'cap_residenza';
	private static $PARAM_TIPOLOGIA_RESIDENZA = 'tipologia_residenza';
	private static $PARAM_INDIRIZZO_RESIDENZA = 'indirizzo_residenza';
	private static $PARAM_NUMCIVICO_RESIDENZA = 'numcivico_residenza';
	private static $PARAM_FRAZIONE_RESIDENZA = 'frazione_residenza';
	private static $PARAM_ULTIMA_VARIAZIONE_RESIDENZA = 'ultima_variazione_residenza';
	private static $PARAM_NUCLEO_FAMILIARE = 'nucleo_familiare';
	
	public function toArray() {
		$array_values = array();
		$array_values[self::$PARAM_CF] = $this->cf;
		$array_values[self::$PARAM_NOME] = $this->nome;
		$array_values[self::$PARAM_COGNOME] = $this->cognome;
		$array_values[self::$PARAM_SESSO] = $this->sesso;
		$array_values[self::$PARAM_DATA_NASCITA] = $this->data_nascita;
		$array_values[self::$PARAM_COMUNE_NASCITA] = $this->comune_nascita;
		$array_values[self::$PARAM_PROVINCIA_NASCITA] = $this->provincia_nascita;
		$array_values[self::$PARAM_STATO_CIVILE] = $this->stato_civile;
		$array_values[self::$PARAM_COMUNE_RESIDENZA] = $this->comune_residenza;
		$array_values[self::$PARAM_PROVINCIA_RESIDENZA] = $this->provincia_residenza;
		$array_values[self::$PARAM_CAP_RESIDENZA] = $this->cap_residenza;
		$array_values[self::$PARAM_TIPOLOGIA_RESIDENZA] = $this->tipologia_residenza;
		$array_values[self::$PARAM_INDIRIZZO_RESIDENZA] = $this->indirizzo_residenza;
		$array_values[self::$PARAM_NUMCIVICO_RESIDENZA] = $this->numcivico_residenza;
		$array_values[self::$PARAM_FRAZIONE_RESIDENZA] = $this->frazione_residenza;
		$array_values[self::$PARAM_ULTIMA_VARIAZIONE_RESIDENZA] = $this->ultima_variazione_residenza;
		$array_values[self::$PARAM_NUCLEO_FAMILIARE] = $this->nucleo_familiare->toArray();
		
		return $array_values;
	}

	public function fromArray($a) {
	
	}
// 	/*
// 	 * getters
// 	 */
	
// 	public function getCodiceFiscale() {
// 		return $this->cf;
// 	}
	
// 	public function getNome() {
// 		return $this->nome;
// 	}
	
// 	public function getCognome() {
// 		return $this->cognome;
// 	}
	
// 	public function getSesso() {
// 		return $this->sesso;
// 	}
	
// 	public function getDataNascita() {
// 		return $this->data_nascita;
// 	}
	
// 	public function getBackendNascita() {
// 		return $this->comune_nascita;
// 	}
	
// 	public function getProvinciaNascita() {
// 		return $this->provincia_nascita;
// 	}
	
// 	public function getBackendResidenza() {
// 		return $this->comune_residenza;
// 	}
	
// 	public function getProvinciaResidenza() {
// 		return $this->provincia_residenza;
// 	}
	
// 	public function getCapResidenza() {
// 		return $this->cap_residenza;
// 	}
	
// 	public function getTipologiaResidenza() {
// 		return $this->tipologia_residenza;
// 	}
	
// 	public function getIndirizzoResidenza() {
// 		return $this->indirizzo_residenza;
// 	}
	
// 	public function getNumcivicoResidenza() {
// 		return $this->numcivico_residenza;
// 	}
	
// 	public function getFrazioneResidenza() {
// 		return $this->frazione_residenza;
// 	}
	
// 	public function getUltimaVariazioneResidenza() {
// 		return $this->ultima_variazione_residenza;
// 	}
	
// 	public function getIdentifier() {
// 		return $this->identifier;
// 	}
	
// 	public function getNucleoFamiliare() {
// 		return $this->nucleo_familiare;
// 	}
	
	
// 	/*
// 	 * setters TODO devo fare i controlli
// 	 */
	
// 	public function setCodiceFiscale($cf) {
// 		$this->cf = cf;
// 		return $this;
// 	}
	
// 	public function setNome($nome) {
// 		$this->nome = $nome;
// 		return $this;
// 	}
	
// 	public function setCognome($cognome) {
// 		$this->cognome = $cognome;
// 		return $this;
// 	}
	
// 	public function setSesso($sesso) {
// 		$this->sesso = $sesso;
// 		return $this;
// 	}
	
// 	public function setDataNascita($data_nascita) {
// 		$this->data_nascita = $data_nascita;
// 		return $this;
// 	}
	
// 	public function setBackendNascita($comune_nascita) {
// 		$this->comune_nascita = $comune_nascita;
// 		return $this;
// 	}
	
// 	public function setProvinciaNascita($provincia_nascita) {
// 		$this->provincia_nascita = $provincia_nascita;
// 		return $this;
// 	}
	
// 	public function setBackendResidenza($comune_residenza) {
// 		$this->comune_residenza = $comune_residenza;
// 		return $this;
// 	}
	
// 	public function setProvinciaResidenza($provincia_residenza) {
// 		$this->provincia_residenza = $provincia_residenza;
// 		return $this;
// 	}
	
// 	public function setCapResidenza($cap_residenza) {
// 		$this->cap_residenza = cap_residenza;
// 		return $this;
// 	}
	
// 	public function setTipologiaResidenza($tipologia_residenza) {
// 		$this->tipologia_residenza = $tipologia_residenza;
// 		return $this;
// 	}
	
// 	public function setIndirizzoResidenza($indirizzo_residenza) {
// 		$this->indirizzo_residenza = $indirizzo_residenza;
// 		return $this;
// 	}
	
// 	public function setNumcivicoResidenza($numcivico_residenza) {
// 		$this->numcivico_residenza = $numcivico_residenza;
// 		return $this;
// 	}
	
// 	public function setFrazioneResidenza($frazione_residenza) {
// 		$this->frazione_residenza = $frazione_residenza;
// 		return $this;
// 	}
	
// 	public function setUltimaVariazioneResidenza($ultima_variazione_residenza) {
// 		$this->ultima_variazione_residenza = $ultima_variazione_residenza;
// 		return $this;
// 	}	
	
	
// 	/**
// 	 * 
// 	 * @param string $raw_data
// 	 * @throws Backend_Model_ResidenteDecodeException
// 	 * @return Backend_Model_Residente
// 	 */
// 	public static function decode($raw_data) {
// 		$array_values = json_decode($raw_data, true);
		
// 		if ($array_values == null || ! is_array($array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
		
// 		if (!array_key_exists(self::$PARAM_TYPE, $array_values) || 
// 				$array_values[self::$PARAM_TYPE] != self::$PARAM_TYPE_VALUE)
// 			throw new Backend_Model_ResidenteDecodeException();
		
		
// 		if (!array_key_exists(self::$PARAM_CF, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$cf = $array_values[self::$PARAM_CF];
		
// 		if (!array_key_exists(self::$PARAM_NOME, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$nome = $array_values[self::$PARAM_NOME];
		
// 		if (!array_key_exists(self::$PARAM_COGNOME, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$cognome = $array_values[self::$PARAM_COGNOME];
		
// 		if (!array_key_exists(self::$PARAM_SESSO, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$sesso = $array_values[self::$PARAM_SESSO];
		
// 		if (!array_key_exists(self::$PARAM_DATA_NASCITA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$data_nascita = $array_values[self::$PARAM_DATA_NASCITA];
		
// 		if (!array_key_exists(self::$PARAM_COMUNE_NASCITA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$comune_nascita = $array_values[self::$PARAM_COMUNE_NASCITA];
		
// 		if (!array_key_exists(self::$PARAM_PROVINCIA_NASCITA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$provincia_nascita = $array_values[self::$PARAM_PROVINCIA_NASCITA];
		
// 		if (!array_key_exists(self::$PARAM_COMUNE_RESIDENZA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$comune_residenza = $array_values[self::$PARAM_COMUNE_RESIDENZA];
		
// 		if (!array_key_exists(self::$PARAM_PROVINCIA_RESIDENZA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$provincia_residenza = $array_values[self::$PARAM_PROVINCIA_RESIDENZA];
		
// 		if (!array_key_exists(self::$PARAM_CAP_RESIDENZA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$cap_residenza = $array_values[self::$PARAM_CAP_RESIDENZA];
		
// 		if (!array_key_exists(self::$PARAM_TIPOLOGIA_RESIDENZA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$tipologia_residenza = $array_values[self::$PARAM_TIPOLOGIA_RESIDENZA];
		
// 		if (!array_key_exists(self::$PARAM_INDIRIZZO_RESIDENZA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$indirizzo_residenza = $array_values[self::$PARAM_INDIRIZZO_RESIDENZA];
		
// 		if (!array_key_exists(self::$PARAM_NUMCIVICO_RESIDENZA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$numcivico_residenza = $array_values[self::$PARAM_NUMCIVICO_RESIDENZA];
		
// 		if (!array_key_exists(self::$PARAM_FRAZIONE_RESIDENZA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$frazione_residenza = $array_values[self::$PARAM_FRAZIONE_RESIDENZA];
		
// 		if (!array_key_exists(self::$PARAM_ULTIMA_VARIAZIONE_RESIDENZA, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$ultima_variazione_residenza = $array_values[self::$PARAM_ULTIMA_VARIAZIONE_RESIDENZA];
		
// 		if (!array_key_exists(self::$PARAM_IDENTIFIER, $array_values))
// 			throw new Backend_Model_ResidenteDecodeException();
// 		$identifier = $array_values[self::$PARAM_IDENTIFIER];
		
		
// 		return new Backend_Model_Residente($cf, $nome, $cognome, $sesso, $data_nascita, 
// 											$comune_nascita, $provincia_nascita, $comune_residenza, 
// 											$provincia_residenza, $cap_residenza, 
// 											$tipologia_residenza, $indirizzo_residenza, 
// 											$numcivico_residenza, $frazione_residenza, 
// 											$ultima_variazione_residenza, $identifier);
		
// 	}
	
	
// 	public static function getTypeValue() {
// 		return self::$PARAM_TYPE_VALUE;
// 	}

}

