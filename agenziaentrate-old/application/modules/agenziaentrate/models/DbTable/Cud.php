<?php

class Agenziaentrate_Model_DbTable_Cud extends Agenziaentrate_Model_DbTable_Abstract {
    protected $_name = 'cud';
    protected $_primary = 'id';
    
    protected $_referenceMap = array(
    		'Contribuente' => array(
    				'columns'		=>	array('cf_app'),
    				'refTableClass' =>	'Contribuente',
    				'refColumns' 	=>	array('cf'))
    );
}

