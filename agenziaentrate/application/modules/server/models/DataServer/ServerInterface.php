<?php

class SubjectNotPresentException extends Exception {}
class InvalidScopeException extends Exception {}
class InsufficientScopeException extends Exception {}

class QueryParameterNotFoundException extends Exception {}
class DataNotFoundException extends Exception {}

class InvalidDataException extends Exception {}

interface Server_DataServer_ServerInterface {	
	/**
	 * 
	 * @param array $scopes array of string
	 * @param string $subj data owner
	 * 
	 * 
	 * @throws SubjectNotPresentException
	 * @throws InvalidScopeException
	 */
	public function __construct($scopes, $subj);
	
	/**
	 * 
	 * @param array $params key => value parameters
	 * 
	 * @return string representation of requested data
	 * 
	 * 
	 * @throws InsufficientScopeException
	 * @throws QueryParameterNotFoundException
	 * @throws DataNotFoundException
	 * @throws InvalidScopeException
	 */
	public function get($params);
	
	/**
	 * 
	 * @param string $current representation of data to update
	 * @param string $updated representation of updated data
	 * 
	 * 
	 * @throws InsufficientScopeException
	 * @throws InvalidDataException
	 */
	public function update($current, $updated);
	
	/**
	 *
	 * @param string $data representation of data to delete
	 * 
	 * 
	 * @throws InsufficientScopeException
	 * @throws InvalidDataException
	 */
	public function delete($data);
	
	/**
	 * 
	 * @param string $data representation of data to delete
	 * 
	 * 
	 * @throws InsufficientScopeException
	 * @throws InvalidDataException
	 */
	public function write($data);
		
}