<?php

class Comune_Model_Dati implements Server_DataServer_ServerInterface {
	/**
	 * contains all available scopes for this instance of dataserver
	 * @var array
	 */
	public static $AVAILABLE_SCOPES = array('lettura_dati_anagrafici', 
											'aggiornamento_dati_anagrafici', 
											'cancellazione_dati_anagrafici', 
											'scrittura_dati_anagrafici');	

	private static $PARAM_TYPE_VALUE = 'comune';
	private static $PARAM_TYPE = 'type';
	
	/**
	 * the current data owner
	 * @var string
	 */
	private $cur_subj;
	
	/**
	 * the current scopes granted
	 * @var array of string
	 */
	private $cur_scopes;
	
	public function __construct($scopes, $subj) {
		if (!is_array($scopes) || count(array_intersect($scopes, self::$AVAILABLE_SCOPES)) != count($scopes))
			throw new InvalidScopeException();
		
		$mapper = new Comune_Mapper_Residente();
		if (!$mapper->dataOwnerExists($subj))
			throw new SubjectNotPresentException();

		$this->cur_subj = $subj;
		$this->cur_scopes = array_merge($scopes);
	}
	
	/*
	 * private functions
	 */
	
	/**
	 * 
	 * @param array $request_scopes array of string representing the scope 
	 * necessary to execute an action (get, update, delete, create)
	 * @throws InsufficientScopeException
	 */
	private function check_for_request_scopes($request_scopes) {
		if (count(array_intersect($request_scopes, $this->cur_scopes)) != count($request_scopes))
			throw new InsufficientScopeException();
	}
	
	private function encode($data) {
		$array_data = $data->toArray();
		$array_data[self::$PARAM_TYPE] = self::$PARAM_TYPE_VALUE;
		
		return base64_encode(json_encode($array_data));
	}
	
	private function decode($data) {
		$json = base64_decode($data);
		$array_data = json_decode($json);
		
		if ($array_data == false)
			throw new Exception();
		
		return $array_data;
	}
	
	
	/*
	 * public methods - implementation of interface methods
	 */
		
	public function get($params) {
// TODO we should use $params to make the actual query, after checking
// compatibility wrt the set of scopes (else throw InsufficientScopeException).
// For now we assume a 1-1 mapping between each scope and a query.
// Method $this->check_for_request_scopes() might be used for this,
// but it is still skeletal.

		$mapper = new Comune_Mapper_Residente();
		
		try {
			$data = $mapper->find($this->cur_subj, $params);
		} catch (ResidenteQueryParameterNotFoundException $e) {
			throw new QueryParameterNotFoundException();
		} catch (ResidenteDataNotFoundException $e) {
			throw new DataNotFoundException();
		}
				
		return $this->encode($data);
	}
	
	public function update($current, $updated) {
		$request_scopes = array('aggiornamento_dati_anagrafici');
		$this->check_for_request_scopes($request_scopes);
		
		$current_residente = null;
		$updated_residente = null;
		
		try {
			$current_residente = $this->decode($current);
			$updated_residente = $this->decode($updated);
		} catch (Exception $e) {
			throw new InvalidDataException();
		} 
		
		//check $current_residente
		//check $updated_residente
		
		//update the data on server
		
	}
	
	public function delete($data) {
		$request_scopes = array('cancellazione_dati_anagrafici');
		$this->check_for_request_scopes($request_scopes);
	
		try {
			$residente_to_del = $this->decode($data);
		} catch (Exception $e) {
			throw new InvalidDataException();
		}
		
		//check $residente_to_del
		//check if this can be deleted
		
		//delete
		
	}
	
	public function write($data) {
		$request_scopes = array('scrittura_dati_anagrafici');
		$this->check_for_request_scopes($request_scopes);
		
		try {
			$residente_to_write = $this->decode($data);
		} catch (Exception $e) {
			throw new InvalidDataException();
		}
		//check $residente_to_write
		//check if this can be writed
		
		//write
	}
}

