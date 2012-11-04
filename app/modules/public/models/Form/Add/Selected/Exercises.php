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
class Public_Model_Form_Add_Selected_Exercises extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormAddSelectedExercises');
    	
    	$this->setAttrib('class', 'form');    	
    	   	
    	$this->addElements(array(
    		new vkNgine_Form_Element_Hidden('exerciseIds'),
    		new vkNgine_Form_Element_Select('workoutId',
	    			array('label' 	=> null,
    					  'class' 	=> 'select setdays',
    					  'escape'  => false,
    					  'desc' 	=> Zend_Registry::get('t')->_('Choose a workout to add selected exercises')),
    				array(),
    				true),
    		new vkNgine_Form_Element_Select('day',
    				array('label' 	=> null,
    					  'class' 	=> 'select',
    					  'style'   => 'width:100%',
    					  'escape'  => false,
   						  'desc' 	=> Zend_Registry::get('t')->_('Choose the day you want to add these')),
   					array(),
   					true),
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
    	$element = $this->getElement('day');
    	
    	for($i=1; $i<=$value; $i++){
    		$element->addMultiOption($i, $i);
    	}
    }
    
    public function setHidden($value)
    {
    	$this->getElement('exerciseIds')->setValue($value);
    }    
}