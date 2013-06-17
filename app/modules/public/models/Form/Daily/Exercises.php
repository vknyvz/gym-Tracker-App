<?php
/**
 * vkNgine3 Admin System
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the new BSD license.
 *
 * @category    core
 * @package     vkNgine3
 * @copyright   Copyright (c) 2011 Volkan Yavuz (http://www.vknyvz.com)
 */
class Public_Model_Form_Daily_Exercises extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormDailyExercises');
    	   	
    	$this->addElements(array(
    		new vkNgine_Form_Element_Hidden('date'),
    		new vkNgine_Form_Element_Hidden('forward'),
    		new vkNgine_Form_Element_Select('workoutId',
	    			array('label' 	=> null,
    					  'class' 	=> 'input-large setdays',
    					  'escape'  => false,
    					  'desc' 	=> null),
    				array(),
    				false),
    		new vkNgine_Form_Element_Select('workoutDay',
    				array('label' 	=> Zend_Registry::get('t')->_('Choose a workout day'),
    					  'class' 	=> 'input-mini',
	    				  'style'   => 'none', 
    					  'escape'  => false),
    				array(),
    				false),
    		new vkNgine_Form_Element_Text('activity',
    				array('label' 	=> null,
    		 			  'class' 	=> 'input-xlarge',
    					  'placeholder' => Zend_Registry::get('t')->_('If nothing from the above list')),
    				false),
   			new vkNgine_Form_Element_Textarea('moreDetails',
   					array('label' 	=> null,
   					  	  'class' 	=> 'input-xlarge',
    					  'escape'  => false,   
   						  'style'   => 'height: 100px;',					  
   						  'placeholder' => Zend_Registry::get('t')->_('More details for this')),
    				false),
    		new vkNgine_Form_Element_Select('type',
	    			array('label' 	=> null,
    					  'class' 	=> 'input-large',
	    				  'escape'  => false,
    					  'desc' 	=> null),
    				array('' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Choose One')),
    					  'Cycling' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Cycling')),
    					  'Rope Jumping' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Rope Jumping')),
    					  'Football' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Football')),
    					  'Running' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Running')),
					  	  'Swimming' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Swimming')),
    					  'Weight Lifting' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Weight Lifting'))),
    				false),
    	));
    }
    
	public function setWorkouts($workouts)
    {
    	$element = $this->getElement('workoutId');
    	$element->addMultiOption(null, $this->convertText2Turkish(Zend_Registry::get('t')->_('Choose One')));
    	
    	foreach ($workouts as $workout) {
    		$element->addMultiOption($workout['workoutId'], $workout['name']);
    	}
    }
    
    public function setDay($value)
    {
    	$element = $this->getElement('workoutDay');
    	 
    	for($i=1; $i<=$value; $i++){
    		$element->addMultiOption($i, $i);
    	}
    }
    
    public function setHidden($value, $action)
    {
    	$this->getElement('date')->setValue($value);
    	$this->getElement('forward')->setValue($action);
    }    
}