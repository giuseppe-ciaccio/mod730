<?php

class Resource_Mapper_ScopesTable extends Resource_Mapper_Abstract {

	public function __construct() {
		$this->table_name = 'Resource_Model_DbTable_Scopes';
	}

	/**
	 * trova gli scope di un resource server
	 * @param string $cf_owner
	 * @return array[int]Resource_Model_DbTable_RSetInfo
	 */
	public function findAll() {
		$select = $this->getDbTable()->select();
		$rows = $this->getDbTable()->fetchAll($select);

		if ($rows == null)
			return array();

		$results = array();
		foreach ($rows as $r)
			$results[] = new Resource_Model_Scopes(
				$r->scope_id, $r->name, $r->uri,
				$r->description);

		return $results;
	}

	/**
	 * trova lo scope resource set per nome
	 * @param string $name
	 * @return array[int]Resource_Model_DbTable_RSetInfo
	 */
	public function find($name) {
		$select = $this->getDbTable()->select();
		$select->where('name = ?', $name);
		$rows = $this->getDbTable()->fetchAll($select);

		if ($rows == null)
			return array();

		$results = array();
		foreach ($rows as $r)
			$results[] = new Resource_Model_Scopes(
				$r->scope_id, $r->name, $r->uri,
				$r->description);

		return $results;
	}

}
