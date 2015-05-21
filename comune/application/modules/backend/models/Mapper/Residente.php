<?php

class ResidenteDataNotFoundException extends Exception {}
class ResidenteQueryParameterNotFoundException extends Exception {}


class Backend_Mapper_Residente extends Backend_Mapper_Abstract {
	private static $PARAM_MAPPER = array(
		'cf' => 'cf', 'nome' => 'nome', 'cognome' => 'cognome',
		'sesso' => 'sesso', 'data_nascita' => 'data_nascita',
		'comune_nascita' => 'comune_nascita',
		'provincia_nascita' => 'provincia_nascita',
		'stato_civile' => 'stato_civile',
		'comune_residenza' => 'comune_residenza',
		'provincia_residenza' => 'provincia_residenza',
		'cap_residenza' => 'cap_residenza',
		'tipologia_residenza' => 'tipologia_residenza',
		'indirizzo_residenza' => 'indirizzo_residenza',
		'numcivico_residenza' => 'numcivico_residenza',
		'frazione_residenza' => 'frazione_residenza',
		'ultima_variazione_residenza' => 'ultima_variazione_residenza');
	
	public function __construct() {
		$this->table_name = 'Backend_Model_DbTable_Residente';
	}


//http://framework.zend.com/manual/1.12/en/zend.db.table.html
// 			$table = new Bugs();
// 			$data = array(
// 					'updated_on'      => '2007-03-23',
// 					'bug_status'      => 'FIXED'
// 			);
// 			$where = $table->getAdapter()->quoteInto('bug_id = ?', 1234);
// 			$table->update($data, $where);
// 			$this->getDbTable()->getAdapter()->qu
	
	/**
	 * 
	 * @param string $cf
	 * @param array $params
	 * @throws ResidenteQueryParameterNotFoundException
	 * @throws ResidenteDataNotFoundException
	 * @return Backend_Model_Residente
	 */
	public function find($cf, $params = array()) {
		if (count(array_intersect_key($params, self::$PARAM_MAPPER)) != count($params))
			throw new ResidenteQueryParameterNotFoundException();
		
		$select = $this->getDbTable()->select();
		
		$select->where('cf = ?', $cf);
		foreach ($params as $k => $v)
			$select->where(self::$PARAM_MAPPER[$k].' = ?', $v);
		
		$row = $this->getDbTable()->fetchRow($select);
		
		
		if ($row == null)
			throw new ResidenteDataNotFoundException();

		$nucleo_familiare_mapper = new Backend_Mapper_NucleoFamiliareElemento();
		$nucleo_familiare = new Backend_Model_NucleoFamiliare($nucleo_familiare_mapper->find($row->cf));
		return new Backend_Model_Residente(
			$row->cf, $row->nome, $row->cognome,
			$row->sesso, $row->data_nascita, $row->comune_nascita,
			$row->provincia_nascita, $row->stato_civile,
			$row->comune_residenza, $row->provincia_residenza,
			$row->cap_residenza, $row->tipologia_residenza,
			$row->indirizzo_residenza, $row->numcivico_residenza,
			$row->frazione_residenza,
			$row->ultima_variazione_residenza, $nucleo_familiare);
	}
	
	
	public function dataOwnerExists($cf) {
		$result = $this->getDbTable()->find($cf);
		return count($result) != 0;
	}
}
