<?php

class Agenziaentrate_Mapper_Cud extends Agenziaentrate_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Agenziaentrate_Model_DbTable_Cud';
	}
	
	public function delContribuente($cf) {
		$select = $this->getDbTable()->select();
		$select->where('cf_app = ?', $cf);
		$row = $this->getDbTable()->fetchRow($select);
	
	
		if ($row == null || count($row) == 0)
			throw new Agenziaentrate_Model_DataNotFoundException();
		
		return new Agenziaentrate_Model_Cud($row->id, $row->reddito, 
											$row->tipologia_reddito, 
											$row->periodo_lavoro, 
											$row->rit_irpef, 
											$row->rit_add_reg, 
											$row->rit_acc_add_com_prec, 
											$row->rit_sal_add_com_prec, 
											$row->rit_acc_add_com_cur);
	}
}