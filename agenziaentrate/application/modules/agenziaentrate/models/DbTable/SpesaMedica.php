<?php

class Agenziaentrate_Model_DbTable_SpesaMedica extends Agenziaentrate_Model_DbTable_Abstract {
    protected $_name = 'spesa_medica';
    protected $_primary = 'id';
    
    protected $_referenceMap = array(
    		'Contribuente' => array(
    				'columns'		=>	array('cf_app'),
    				'refTableClass' =>	'Contribuente',
    				'refColumns' 	=>	array('cf'))
    );

}

