<?php

class Resource_Model_RSetInfo {
	/**
	 * rset id
	 * @var string
	 */
	private $rset_id;
	private $name;
	private $rsuri;
	private $table;
	private $desc;
	private $type;
	private $colselect;


	public function __construct($id, $name, $uri, $table, $desc, $type, $colsel) {
		$this->rset_id = $id;
		$this->name = $name;
		$this->rsuri = $uri;
		$this->table = $table;
		$this->desc = $desc;
		$this->type = $type;
		$this->colselect = $colsel;
	}

	private static $PARAM_ID = 'rset_id';
	private static $PARAM_NAME = 'name';
	private static $PARAM_URI = 'uri';
	private static $PARAM_TABLE = 'table';
	private static $PARAM_DESC = 'description';
	private static $TYPE = 'type';
	private static $COLSELECT = 'colselect';


	public function toArray() {
		$array_values = array();
		$array_values[self::$PARAM_ID] = $this->rset_id;
		$array_values[self::$PARAM_NAME] = $this->name;
		$array_values[self::$PARAM_URI] = $this->rsuri;
		$array_values[self::$PARAM_TABLE] = $this->table;
		$array_values[self::$PARAM_DESC] = $this->desc;
		$array_values[self::$TYPE] = $this->type;
		$array_values[self::$COLSELECT] = $this->colselect;

		return $array_values;
	}

	public function fromArray($a) {

	}

	public function getRsetId(){
	   return $this->rset_id ;
	}

	public function getName(){
	   return $this->name;
	}

	public function getUri(){
	   return $this->rsuri;
	}

	public function getTable(){
	   return $this->table;
	}

	public function getDescr(){
	   return $this->desc;
	}

	public function getType(){
	   return $this->type;
	}

	public function getColSelect(){
	   return $this->colselect;
	}
}
