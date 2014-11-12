<?php

class Comune_Mapper_NucleoFamiliareElemento extends Comune_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Comune_Model_DbTable_NucleoFamiliareElemento';
	}
	
	/**
	 * trova i familiari del residente con codice fiscale = $cf_owner
	 * @param string $cf_owner
	 * @return array[int]Comune_Model_NucleoFamiliareElemento
	 */
	public function find($cf_owner) {
		$select = $this->getDbTable()->select();
		$select->where('cf_app = ?', $cf_owner);
		$rows = $this->getDbTable()->fetchAll($select);

		if ($rows == null)
			return array();
		
		$results = array();
		foreach ($rows as $r)
			$results[] = new Comune_Model_NucleoFamiliareElemento($r->id, $r->cf, 
																  $r->tipo,
																  $r->minore_tre_anni);
																	
		return $results;
	}
}
