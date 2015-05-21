<?php
/*
class Agenziaterritorio_Mapper_Terreno extends Agenziaterritorio_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Agenziaterritorio_Model_DbTable_Titolare';
	}
	
	
	public function listaTerreni($titolare_id) {
		$select = new Zend_Db_Select($this->getDbTable()->getAdapter());
		$select->where('titolare_id = ?', $titolare_id);
		$rows = $this->getDbTable()->fetchAll($select);
		
		if ($rows == null)
			return array();
		
		$result = array();
		
		
		
	}
	
}
*/