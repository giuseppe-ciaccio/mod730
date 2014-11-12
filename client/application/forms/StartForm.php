<?php

class Application_Form_StartForm extends Zend_Form
{
	const SCOPES = "scopes";
	const SUBMIT_BUTTON_ID = 'get';
	
	/**
	 * the scopes to display
	 * @var array[int]Application_Model_Scope
	 */
	private $available_scopes;
	
	/**
	 * 
	 * @param array[int]Application_Model_Scope $available_scopes
	 */
	public function __construct(array $available_scopes){
		$this->available_scopes = $available_scopes;
		parent::__construct();
	}
	
    public function init() {
    	if (empty($this->available_scopes)) {	
    		$this->setDescription("Al momento non vi è alcuna sorgente dei dati.");
    		$this->addElement('submit', self::SUBMIT_BUTTON_ID, array('required' => true,
								    				'ignore' => false,
								    				'label' => 'Procedi',
								    				'attribs' => array('disabled' => 'disabled')));
    	} else {
    		$this->setAction($this->getView()->url(array('module' => '',
									    				'controller' => 'index',
									    				'action' => 'get')));
    		
    		$scopes = new Zend_Form_Element_MultiCheckbox($this::SCOPES);
    		$scopes->setLabel("Scegliere i dati da scaricare:");
    		
    		foreach ($this->available_scopes as $s)
    			$scopes->addMultiOption($s->getId(), $s->getDescription().';');
    		 
    		$this->addElement($scopes);
    		$this->addElement('submit', self::SUBMIT_BUTTON_ID, array('required' => true,
								    				'ignore' => false,
								    				'label' => 'Procedi'));
    	}
    	
    	$this->setDecorators(array('FormElements',
    			array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
    			array('Description', array('placement' => 'prepend','escape' => false)),
    			'Form'));
    	
    	//CSRF protection
    	$this->addElement('hash', 'csrf', array('ignore' => true,));
    	
    	
    }
    
    public function checkAllScopes() {
    	$defaultChecked = array();
    	foreach ($this->available_scopes as $s)
    		$defaultChecked[] = $s->getId();
    	$this->setDefaults(array(self::SCOPES => $defaultChecked));    	
    	
    }
}

