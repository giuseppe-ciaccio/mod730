<?php

class Backend_Model_NucleoFamiliareElemento {	
	/**
	 * codice fiscale
	 * @var string
	 */
	private $cf;
	
	public $id;
	
	private $tipo;
	/**
	 * 
	 * @var bool
	 */
	public $minore_tre_anni;
	
	
	public function __construct($id, $cf, $tipo, $minore_tre_anni) {
		$this->id = $id;
		$this->cf = $cf;
		$this->tipo = $tipo;
		$this->minore_tre_anni = $minore_tre_anni;
		
	}
	
	private static $PARAM_ID = 'id';
	private static $PARAM_CF = 'cf';
	private static $PARAM_TIPO = 'tipo';
	private static $PARAM_MINORE_TRE_ANNI = 'minore_tre_anni';	
	
	public function toArray() {
		$array_values = array();
		$array_values[self::$PARAM_ID] = $this->id;
		$array_values[self::$PARAM_CF] = $this->cf;
		$array_values[self::$PARAM_TIPO] = $this->tipo;
		$array_values[self::$PARAM_MINORE_TRE_ANNI] = $this->minore_tre_anni;
				
		return $array_values;
	}
	
	public function fromArray($a) {
		
	}
	
}

