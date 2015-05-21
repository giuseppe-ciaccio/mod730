<?php

class Resource_Mapper_ResourceSetTable extends Resource_Mapper_Abstract {
	public function __construct() {
		$this->table_name = 'Resource_Model_DbTable_RSetInfo';
	}

	/**
	 * trova i resource set del resource server con nome = $name
	 * @param string $cf_owner
	 * @return array[int]Resource_Model_DbTable_RSetInfo
	 */
	public function find($id) {
		$select = $this->getDbTable()->select();
		$select->where('rset_id = ?', $id);
		$rows = $this->getDbTable()->fetchAll($select);

		if ($rows == null)
			return array();

		$results = array();
		foreach ($rows as $r)
			$results[] = new Resource_Model_RSetInfo($r->rset_id, $r->name,
																  $r->uri,
																  $r->table,
																  $r->description,
																  $r->type,
																  $r->colselect);

		return $results;
	}



		public function save(Resource_Model_RSetInfo $rset) {
		        $data = array(
		            'rset_id' => $rset->getRsetId(),
		            'name' => $rset->getName(),
		            'uri' => $rset->getUri(),
		            'table' => $rset->getTable(),
		            'description' => $rset->getDescr(),
		            'type' => $rset->getType(),
		            'colselect' => $rset->getColSelect(),
		        );

		        $this->getDbTable()->insert($data);
		    }



	 /**
	     * Deletes a refresh token from the DB by code
	     *
	     * @param string $code
	     * @return int
	     */
	    public function delete($rset_id) {

	        $result = $this->getDbTable()->find($rset_id);
	        if (0 == count($result)) {
	            return;
	        }

	        $row = $result->current();
	        $row->delete();
    }


}
