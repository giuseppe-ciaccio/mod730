<?php

class ResourceServer_DecodeException extends Exception {}

abstract class ResourceServer_AbstractData {
	/*
	 * constants for json params
	 */
	protected static $PARAM_TYPE = 'type';
	
	/**
	 * @returns strings
	 */
	abstract static function getTypeValue();
	
	/**
	 * 
	 * @param string $raw_data
	 * @throws ResourceServer_DecodeException
	 */
	abstract public static function decode($raw_data);
	
	abstract public function encode();
	
	/**
	 * 
	 * @param string $raw_data
	 * @return NULL|string
	 */
	public static function getType($raw_data) {
		$array_value = json_decode($json, true);
		
		if (empty($array_value))
			return null;
		
		return $array_value[self::$PARAM_TYPE];
		
	}
	
}