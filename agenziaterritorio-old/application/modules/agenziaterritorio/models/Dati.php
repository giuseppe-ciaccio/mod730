<?php

class Agenziaterritorio_Model_Dati implements Server_DataServer_ServerInterface {
	/**
	 * contains all available scopes for this instance of dataserver
	 * @var array
	 */
	public static $AVAILABLE_SCOPES = array('lettura_dati_fabbricati');
	
	private static $PARAM_TYPE_VALUE = 'agenziaterritorio';
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
	
		$mapper = new Agenziaterritorio_Mapper_Titolare();
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
	
	private function encode($array_data) {
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

		$array_data = array();
		
		foreach ($this->cur_scopes as $s) {

			switch ($s) {
				case 'lettura_dati_fabbricati':
					$fabbricato_mapper = new Agenziaterritorio_Mapper_Fabbricato();
					
					try {
						$data = $fabbricato_mapper->delTitolare($this->cur_subj);
// 					} catch (QueryParameterNotFoundException $e) {
// 						throw new QueryParameterNotFoundException();
					} catch (Agenziaterritorio_Model_DataNotFoundException $e) {
						throw new DataNotFoundException();
					}
						
					$array_data['fabbricati'] = $data->toArray();
						
					break;
				default:
					throw new InvalidScopeException();
			}
		}

		if (count($array_data) == 0)
			throw new InsufficientScopeException();
		
		return $this->encode($array_data);
	}
	
	/*
	 * TODO
	 */
	public function update($current, $updated) {
		$request_scopes = array('aggiornamento_dati_agenziaterritorio');
		$this->check_for_request_scopes($request_scopes);
		
		$current_decoded = null;
		$updated_decoded = null;
		
		try {
			$current_decoded = $this->decode($current);
			$updated_decoded = $this->decode($updated);
		} catch (Exception $e) {
			throw new InvalidDataException();
		}
		
		//check $current_decoded
		//check $updated_decoded
		
		//update the data on server
	
	}
	
	/*
	 * TODO
	 */
	public function delete($data) {
		$request_scopes = array('cancellazione_dati_agenziaterritorio');
		$this->check_for_request_scopes($request_scopes);
	
		try {
			$to_del = $this->decode($data);
		} catch (Exception $e) {
			throw new InvalidDataException();
		}
	
		//check $to_del
		//check if this can be deleted
	
		//delete
	}

	/*
	 * TODO
	 */
	public function write($data) {
		$request_scopes = array('scrittura_dati_agenziaterritorio');
		$this->check_for_request_scopes($request_scopes);
	
		try {
			$to_write = $this->decode($data);
		} catch (Exception $e) {
			throw new InvalidDataException();
		}
		//check $to_write
		//check if this can be writed
	
		//write
	}
}

