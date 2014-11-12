<?php

class Agenziaterritorio_Mapper_Fabbricato extends Agenziaterritorio_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Agenziaterritorio_Model_DbTable_Fabbricato';
	}
	
	public function delTitolare($cf) {
		$select = $this->getDbTable()->select();
		$select->where('cf_app = ?', $cf);
		$rows = $this->getDbTable()->fetchAll($select);
	
	
		if ($rows == null || count($rows) == 0)
			throw new Agenziaterritorio_Model_DataNotFoundException();
	
	
		$fabbricati = new Agenziaterritorio_Model_Fabbricati();
		
		foreach ($rows as $r)
			$fabbricati->add(new Agenziaterritorio_Model_Fabbricato($r->id, 
																	$r->rendita, 
																	$r->possesso_perc, 
																	$r->possesso_giorni, 
																	$r->codice_comune));
		
		return $fabbricati;
	}
}