<?php

class Application_Model_FormData {
	/**
	 * 
	 * @var Application_Model_UserData
	 */
	private $user_data;
	
	/**
	 * 
	 * @param Application_Model_UserData $user_data
	 */
	public function __construct($user_data) {
		$this->user_data = $user_data;
		
	}
	
	public function cf() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['cf'];
		return '';
	}
	public function nome() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['nome'];
		return '';
	}
	public function cognome() {	
		if ($this->user_data->comune != null)
			return $this->user_data->comune['cognome'];
		return '';
	}
	public function sesso() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['sesso'];
		return '';
	}
	public function dataNascita() {
		if ($this->user_data->comune == null)
			return '';
		$sql_date = $this->user_data->comune['data_nascita'];
		if (empty($sql_date))
			return '';
		$phpdate = strtotime($sql_date);
		
		return date('d/m/Y', $phpdate);
	}
	public function comuneNascita() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['comune_nascita'];
		return '';
	}
	public function provinciaNascita() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['provincia_nascita'];
		return '';
		
	}
	public function statoCivile() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['stato_civile'];
		return '';
	}
	public function comuneResidenza() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['comune_residenza'];
		return '';
	}
	public function provinciaResidenza() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['provincia_residenza'];
		return '';
	}
	public function indirizzoTipologia() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['tipologia_residenza'];
		return '';
	}
	public function indirizzoResidenza() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['indirizzo_residenza'];
		return '';
	}
	public function numcivicoResidenza() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['numcivico_residenza'];
		return '';
	}
	public function frazioneResidenza() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['frazione_residenza'];
		return '';
	}
	public function capResidenza() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['cap_residenza'];
		return '';
	}
	public function ultimaVariazioneResidenza() {
		if ($this->user_data->comune == null)
			return '';
		$sql_date = $this->user_data->comune['ultima_variazione_residenza'];
		if (empty($sql_date))
			return '';
		$phpdate = strtotime($sql_date);
		
		return date('d/m/Y', $phpdate);
	}
	public function nucleoFamiliare() {
		if ($this->user_data->comune != null)
			return $this->user_data->comune['nucleo_familiare'];
		return array();
	}
	
	public function coniuge() {
		foreach ($this->nucleoFamiliare() as $el)
			if ($el['tipo'] == 'coniuge')
				return $el;
		null;
	}
	public function primoFiglio() {
		foreach ($this->nucleoFamiliare() as $el)
			if ($el['tipo'] == 'primo_figlio')
				return $el;
		return null;
	}
	public function altriFigli() {
		$altri = array();
		foreach ($this->nucleoFamiliare() as $el)
			if ($el['tipo'] != 'primo_figlio' && $el['tipo'] != 'coniuge')
				$altri[] = $el;
		
		return $altri;	
	}
	
	
	/*
	 * agenzia entrate
	 */
	
	public function sostitutoImpostaDenominazione() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['denominazione'];
	}
	public function sostitutoImpostaCf() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['cf'];
	}
	public function sostitutoImpostaComune() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['comune'];
	}
	public function sostitutoImpostaProvincia() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['provincia'];
	}
	public function sostitutoImpostaTipologiaIndirizzo() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['tipologia_indirizzo'];
	}
	public function sostitutoImpostaIndirizzo() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['indirizzo'];
	}
	public function sostitutoImpostaNumCivico() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['num_civico'];
	}
	public function sostitutoImpostaCap() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['cap'];
	}
	public function sostitutoImpostaFrazione() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['frazione'];
	}
	public function sostitutoImpostaTelefono() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['telfax'];
	}
	public function sostitutoImpostaEmail() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['email'];
	}
	public function sostitutoImpostaCodiceSede() {
		if (!isset($this->user_data->agenziaentrate['sostituto_imposta']))
			return '';
		return $this->user_data->agenziaentrate['sostituto_imposta']['codice_sede'];
	}
	
	/*
	 * CUD
	 */
	public function reddito() {
		if (!isset($this->user_data->agenziaentrate['cud']))
			return '';
		return $this->user_data->agenziaentrate['cud']['reddito'];
	}
	public function tipologiaReddito() {
		if (!isset($this->user_data->agenziaentrate['cud']))
			return '';
		return $this->user_data->agenziaentrate['cud']['tipologia_reddito'];
	}
	public function periodoLavoro() {
		if (!isset($this->user_data->agenziaentrate['cud']))
			return '';
		return $this->user_data->agenziaentrate['cud']['periodo_lavoro'];
	}
	public function ritIrpef() {
		if (!isset($this->user_data->agenziaentrate['cud']))
			return '';
		return $this->user_data->agenziaentrate['cud']['rit_irpef'];
	}
	public function ritAddReg() {
		if (!isset($this->user_data->agenziaentrate['cud']))
			return '';
		return $this->user_data->agenziaentrate['cud']['rit_add_reg'];
	}
	public function ritAccAddComPrec() {
		if (!isset($this->user_data->agenziaentrate['cud']))
			return '';
		return $this->user_data->agenziaentrate['cud']['rit_acc_add_com_prec'];
	}
	public function ritSalAddComPrec() {
		if (!isset($this->user_data->agenziaentrate['cud']))
			return '';
		return $this->user_data->agenziaentrate['cud']['rit_sal_add_com_prec'];
	}
	public function ritAccAddComCur() {
		if (!isset($this->user_data->agenziaentrate['cud']))
			return '';
		return $this->user_data->agenziaentrate['cud']['rit_acc_add_com_cur'];
	}
	
	
	
	public function speseMedicheTotale() {
		if (!isset($this->user_data->agenziaentrate['spese_mediche']))
			return '';
		$somma = 0;
		
		foreach ($this->user_data->agenziaentrate['spese_mediche'] as $s)
			$somma += $s['importo'];
		
		return $somma;
	}
	
	public function speseMediche() {
		if (!isset($this->user_data->agenziaentrate['spese_mediche']))
			return array();
		return $this->user_data->agenziaentrate['spese_mediche'];
	}
	
	
	
	public function fabbricati() {
		if (!isset($this->user_data->agenziaterritorio['fabbricati']))
			return array();
		$locazione = array();
		if (isset($this->user_data->agenziaentrate['contratti_locazione_fabbricati']))
			$locazioni = $this->user_data->agenziaentrate['contratti_locazione_fabbricati'];
		else
			$locazioni = array();
		
		$fabricati = $this->user_data->agenziaterritorio['fabbricati'];
		
		$data = array();
		foreach ($fabricati as $f) {
			$d = array();
			$d['id'] = $f['id'];
			$d['rendita'] = $f['rendita'];
			$d['possesso_perc'] = $f['possesso_perc'];
			$d['possesso_giorni'] = $f['possesso_giorni'];
			$d['codice_comune'] = $f['codice_comune'];
			$d['contratti'] = array();
			
			foreach ($locazioni as $l)
				if ($l['id_oggetto'] == $d['id']) {
					$dl = array();
					$dl['id'] = $l['id'];
					$dl['numero'] = $l['numero'];
					$dl['serie'] = $l['serie'];
					$dl['dal'] = date('d/m/y', strtotime($l['dal']));
					$dl['canone'] = $l['canone'];
					$d['contratti'][] = $dl;
				}
			$data[] = $d;
		}
		
		return $data;
	}
	
// 	public function 
//TODO
	public function interessiMutui() {
		return '';
	}
	//TODO altri campi
	

}

