<?php

class Agenziaentrate_Mapper_SpesaMedica extends Agenziaentrate_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Agenziaentrate_Model_DbTable_SpesaMedica';
	}
	
	public function delContribuente($cf) {
		$select = $this->getDbTable()->select();
		$select->where('cf_app = ?', $cf);
		$rows = $this->getDbTable()->fetchAll($select);
		
		
		if ($rows == null || count($rows) == 0)
			throw new Agenziaentrate_Model_DataNotFoundException();
		
		
		$spese = new Agenziaentrate_Model_SpeseMediche();
		
		foreach ($rows as $r)
			$spese->add(new Agenziaentrate_Model_SpesaMedica($r->id, $r->importo, 
															 $r->prestatore, 
															 $r->indirizzo_prestatore, 
															 $r->data_acquisto, 
															 $r->aliquota_iva, 
															 $r->descrizione));
		
		
		return $spese;
	}
}