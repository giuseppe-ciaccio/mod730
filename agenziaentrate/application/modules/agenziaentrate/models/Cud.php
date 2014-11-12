<?php

class Agenziaentrate_Model_Cud {
	private $id;
	private $reddito;
	private $tipologia_reddito;
	private $periodo_lavoro;
	private $rit_irpef;
	private $rit_add_reg;
	private $rit_acc_add_com_prec;
	private $rit_sal_add_com_prec;
	private $rit_acc_add_com_cur;
	
	public function __construct($id, $reddito, $tipologia_reddito, $periodo_lavoro,
								$rit_irpef, $rit_add_reg, $rit_acc_add_com_prec,
								$rit_sal_add_com_prec, $rit_acc_add_com_cur) {
		$this->id = $id;
		$this->reddito = $reddito;
		$this->tipologia_reddito = $tipologia_reddito;
		$this->periodo_lavoro = $periodo_lavoro;
		$this->rit_irpef = $rit_irpef;
		$this->rit_add_reg = $rit_add_reg;
		$this->rit_acc_add_com_prec = $rit_acc_add_com_prec;
		$this->rit_sal_add_com_prec = $rit_sal_add_com_prec;
		$this->rit_acc_add_com_cur = $rit_acc_add_com_cur;
	}
	
	public function toArray() {
		$array_values = array();
	
		$array_values['id'] = $this->id;
		$array_values['reddito'] = $this->reddito;
		$array_values['tipologia_reddito'] = $this->tipologia_reddito;
		$array_values['periodo_lavoro'] = $this->periodo_lavoro;
		$array_values['rit_irpef'] = $this->rit_irpef;
		$array_values['rit_add_reg'] = $this->rit_add_reg;
		$array_values['rit_acc_add_com_prec'] = $this->rit_acc_add_com_prec;
		$array_values['rit_sal_add_com_prec'] = $this->rit_sal_add_com_prec;
		$array_values['rit_acc_add_com_cur'] = $this->rit_acc_add_com_cur;
		
	
		return $array_values;
	}
	
	public function fromArray($array_values) {
	
	}
}

