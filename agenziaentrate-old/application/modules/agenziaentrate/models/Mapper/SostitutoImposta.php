<?php

class Agenziaentrate_Mapper_SostitutoImposta extends Agenziaentrate_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Agenziaentrate_Model_DbTable_SostitutoImposta';
	}
	
	public function delContribuente($cf) {
		$mc = new Agenziaentrate_Mapper_Contribuente();
		$c = $mc->find($cf);
		
		$select = $this->getDbTable()->select();
		$select->where('cf = ?', $c->cfSostitutoImposta());
		$row = $this->getDbTable()->fetchRow($select);
		
		if ($row == null || count($row) == 0)
			throw new Agenziaentrate_Model_DataNotFoundException();
		
		return new Agenziaentrate_Model_SostitutoImposta($row->cf, 
														 $row->denominazione, 
														 $row->comune, 
														 $row->provincia, 
														 $row->tipologia_indirizzo, 
														 $row->indirizzo, 
														 $row->num_civico, 
														 $row->cap, 
														 $row->frazione, 
														 $row->telfax, 
														 $row->email, 
														 $row->codice_sede);
	}
}