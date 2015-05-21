<?php

class Agenziaterritorio_Mapper_Titolare extends Agenziaterritorio_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Agenziaterritorio_Model_DbTable_Titolare';
	}
	
	public function dataOwnerExists($id) {
		$result = $this->getDbTable()->find($id);
		return count($result) != 0;
	}
}