<?php

class Backend_Mapper_ParametricQuery extends Backend_Mapper_Abstract {

	public function __construct($tabname) {
		parent::setDbTable($tabname);
	}

	public function find($table_name, $key_name, $key_value, array $cols) {
		$select = $this->getDbTable()->select();
		$select->from($table_name, $cols);
		$select->where($key_name . '= ?', $key_value);
		$rows = $this->getDbTable()->fetchAll($select);

		if ($rows == null)
			return array();

		$results = array();
		foreach ($rows as $r)
			$results[] = $r;

		return $results;
	}
}
