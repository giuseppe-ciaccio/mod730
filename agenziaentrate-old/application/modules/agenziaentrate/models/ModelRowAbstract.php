<?php
/* use it if you want to map the sql datatype to php datatype... 
 * set in the Db_Table protected $_rowClass = 'Agenziaentrate_Model_ModelRowAbstract'
 */
class Agenziaentrate_Model_ModelRowAbstract extends Zend_Db_Table_Row {
	protected $_dataTypes = array(
			'bit' => 'int',
			'tinyint' => 'int',
			'bool' => 'bool',
			'boolean' => 'bool',
			'smallint' => 'int',
			'mediumint' => 'int',
			'int' => 'int',
			'integer' => 'int',
			'bigint' => 'float',
			'serial' => 'int',
			'float' => 'float',
			'real' => 'float',
			'numeric' => 'float',
			'money' => 'float',
			'double' => 'float',
			'double precision' => 'float',
			'decimal' => 'float',
			'dec' => 'float',
			'fixed' => 'float',
			'year' => 'int'
	);

	/**
	 * Initialize object
	 *
	 * Called from {@link __construct()} as final step of object instantiation.
	 *
	 * @return void
	*/
	public function init() {
		$table = $this->getTable();
		if ($table) {
			$cols = $table->info(Zend_Db_Table_Abstract::METADATA);
			foreach ($cols as $name => $col) {
				$dataType = strtolower($col['DATA_TYPE']);
				if (array_key_exists($dataType, $this->_dataTypes)) {
					settype($this->_data[$name], $this->_dataTypes[$dataType]);
				}
			}
		}
	}
}
