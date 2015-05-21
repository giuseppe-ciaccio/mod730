<?php

class Agenziaentrate_Model_DbTable_Contribuente extends Agenziaentrate_Model_DbTable_Abstract {
    protected $_name = 'contribuente';
    protected $_primary = 'cf';
    protected $_dependentTables = array('Contratto', 'Cud', 'SpesaMedica');
    
    protected $_referenceMap = array(
    		'SostitutoImposta' => array(
    				'columns'		=>	array('cf_sostituto_imposta'),
    				'refTableClass' =>	'SostitutoImposta',
    				'refColumns' 	=>	array('cf'))
    		);
}

