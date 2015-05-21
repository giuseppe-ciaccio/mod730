<?php

class Agenziaentrate_Mapper_Contratto extends Agenziaentrate_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Agenziaentrate_Model_DbTable_Contratto';
	}
	
	public function delContribuente($cf) {
		$select = $this->getDbTable()->select();
		$select->where('cf_app = ?', $cf);
		$rows = $this->getDbTable()->fetchAll($select);
		
		
		if ($rows == null || count($rows) == 0)
			throw new Agenziaentrate_Model_DataNotFoundException();
		
		
		$contratti = new Agenziaentrate_Model_Contratti();
		
		foreach ($rows as $r)
			$contratti->add(new Agenziaentrate_Model_Contratto($r->id, $r->numero, 
															   $r->serie, 
															   $r->id_oggetto, 
															   $r->dal, $r->canone));
		
		return $contratti;
	}
}