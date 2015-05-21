<?php

class Agenziaentrate_Mapper_Contribuente extends Agenziaentrate_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Agenziaentrate_Model_DbTable_Contribuente';
	}

	public function dataOwnerExists($cf) {
		$result = $this->getDbTable();
		$result = $this->getDbTable()->find($cf);
		return count($result) != 0;
	}
	
	public function find($cf) {
		$result = $this->getDbTable()->find($cf);
		
		if (count($result) == 0)
			throw new Agenziaentrate_Model_DataNotFoundException();

		$c = $result->current();
		
		return new Agenziaentrate_Model_Contribuente($c->cf, $c->cf_sostituto_imposta);
	}
	
	
}
